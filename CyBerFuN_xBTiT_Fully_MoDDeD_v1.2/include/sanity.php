<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Sanity
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xList.ro/
// Modified By cybernet2u

/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2007  Btiteam
//
//    This file is part of xbtit.
//
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
//   1. Redistributions of source code must retain the above copyright notice,
//      this list of conditions and the following disclaimer.
//   2. Redistributions in binary form must reproduce the above copyright notice,
//      this list of conditions and the following disclaimer in the documentation
//      and/or other materials provided with the distribution.
//   3. The name of the author may not be used to endorse or promote products
//      derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED
// WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
// MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
// IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
// SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
// TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
// PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
// LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
// NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
// EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
//
////////////////////////////////////////////////////////////////////////////////////

function do_sanity() {

         global $clean_interval, $XBTT_USE, $PRIVATE_ANNOUNCE, $TORRENTSDIR, $CURRENTPATH, $LIVESTATS, $LOG_HISTORY, $TABLE_PREFIX;

if ($XBTT_USE) {
 $res = do_sqlquery("SELECT uid FROM xbt_files_users as u INNER JOIN xbt_files as x ON u.fid=x.fid WHERE u.left = '0' AND x.flags='0' AND u.active='1'");
   if (mysql_num_rows($res) > 0)
   {
       while ($arr = mysql_fetch_assoc($res))
       {
       $x = $arr["uid"];
       quickQuery("UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus+".$GLOBALS["bonus"]."*".$clean_interval."/3600 WHERE id = '$x'");
       }
   } }else
   {
 $res = do_sqlquery("SELECT pid FROM {$TABLE_PREFIX}peers WHERE status = 'seeder'");
   if (mysql_num_rows($res) > 0)
   {
       while ($arr = mysql_fetch_assoc($res))
       {
       $x = $arr['pid'];
       quickQuery("UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus+".$GLOBALS["bonus"]."*".$clean_interval."/3600 WHERE pid = '$x'");
       }
   } }
         // SANITY FOR TORRENTS
         $results = do_sqlquery("SELECT info_hash, seeds, leechers, dlbytes, filename FROM {$TABLE_PREFIX}files WHERE external='no'");
         $i = 0;
         while ($row = mysql_fetch_row($results))
         {
             list($hash, $seeders, $leechers, $bytes, $filename) = $row;

         $timeout = time() - (intval($GLOBALS["report_interval"] * 2));

         // for testing purpose -- begin
         $resupd = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}peers where lastupdate < ".$timeout ." AND infohash='$hash'");
         if (mysql_num_rows($resupd) > 0)
            {
            while ($resupdate = mysql_fetch_array($resupd))
              {
                  $uploaded = max(0, $resupdate["uploaded"]);
                  $downloaded = max(0, $resupdate["downloaded"]);
                  $pid = $resupdate["pid"];
                  $ip = $resupdate["ip"];
                  // update user->peer stats only if not livestat
                  if (!$LIVESTATS)
                    {
                      if ($PRIVATE_ANNOUNCE)
                         quickQuery("UPDATE {$TABLE_PREFIX}users SET uploaded=uploaded+$uploaded, downloaded=downloaded+$downloaded WHERE pid='$pid' AND id>1 LIMIT 1");
                      else // ip
                          quickQuery("UPDATE {$TABLE_PREFIX}users SET uploaded=uploaded+$uploaded, downloaded=downloaded+$downloaded WHERE cip='$ip' AND id>1 LIMIT 1");
                     }

                  // update dead peer to non active in history table
                  if ($LOG_HISTORY)
                     {
                          $resuser = do_sqlquery("SELECT id FROM {$TABLE_PREFIX}users WHERE ".($PRIVATE_ANNOUNCE?"pid='$pid'":"cip='$ip'")." ORDER BY lastconnect DESC LIMIT 1");
                          $curu = @mysql_fetch_row($resuser);
                          quickquery("UPDATE {$TABLE_PREFIX}history SET active='no' WHERE uid=$curu[0] AND infohash='$hash'");
                     }

            }
         }
         // for testing purpose -- end

            quickQuery("DELETE FROM {$TABLE_PREFIX}peers where lastupdate < ".$timeout." AND infohash='$hash'");
            quickQuery("UPDATE {$TABLE_PREFIX}files SET lastcycle='".time()."' WHERE info_hash='$hash'");

             $results2 = do_sqlquery("SELECT status, COUNT(status) from {$TABLE_PREFIX}peers WHERE infohash='$hash' GROUP BY status");
             $counts = array();
             while ($row = mysql_fetch_row($results2))
                 $counts[$row[0]] = 0 + $row[1];

             quickQuery("UPDATE {$TABLE_PREFIX}files SET leechers=".(isset($counts["leecher"])?$counts["leecher"]:0).",seeds=".(isset($counts["seeder"])?$counts["seeder"]:0)." WHERE info_hash=\"$hash\"");
             if ($bytes < 0)
             {
                 quickQuery("UPDATE {$TABLE_PREFIX}files SET dlbytes=0 WHERE info_hash=\"$hash\"");
             }

         }
         // END TORRENT'S SANITY

         //  optimize peers table
         quickQuery("OPTIMIZE TABLE {$TABLE_PREFIX}peers");

         // delete readposts when topic don't exist or deleted  *** should be done by delete, just in case
         quickQuery("DELETE readposts FROM {$TABLE_PREFIX}readposts LEFT JOIN topics ON readposts.topicid = topics.id WHERE topics.id IS NULL");
         
         // delete readposts when users was deleted *** should be done by delete, just in case
         quickQuery("DELETE readposts FROM {$TABLE_PREFIX}readposts LEFT JOIN users ON readposts.userid = users.id WHERE users.id IS NULL");
         
         // deleting orphan image in torrent's folder (if image code is enabled)
         $tordir = realpath("$CURRENTPATH/../$TORRENTSDIR");
         if ($dir = @opendir($tordir."/"));
           {
            while(false !== ($file = @readdir($dir)))
               {
                   if ($ext = substr(strrchr($file, "."), 1) == "png")
                       unlink("$tordir/$file");
               }
            @closedir($dir);
         }

}

//warn 
$query = do_sqlquery("SELECT * FROM `{$TABLE_PREFIX}users` WHERE warn='yes'");
$conf = mysql_fetch_array($query);
$expire_dat = $conf['warnadded'];
$expire2 = strtotime ($expire_dat);
$nown = strtotime("now");
if ($nown >= $expire2 )
{
$subj = sqlesc("Your Warning time is expired !!");
$msg = sqlesc("You are not longer Warned , please be carefull to not make the same mistake again !!");
mysql_query("INSERT INTO {$TABLE_PREFIX}messages (sender, receiver, added, msg, subject) VALUES(0, '$conf[id]', UNIX_TIMESTAMP(), $msg, $subj)") or sqlerr(__FILE__, __LINE__);  
mysql_query("UPDATE {$TABLE_PREFIX}users SET warn='no' WHERE id='$conf[id]'") or sqlerr();
}
//warn

//begin invitation system by dodge
global $INV_EXPIRES;
$deadtime = $INV_EXPIRES * 86400;
$user = do_sqlquery("SELECT inviter FROM {$TABLE_PREFIX}invitations WHERE time_invited < DATE_SUB(NOW(), INTERVAL $deadtime SECOND)");
@$arr = mysql_fetch_assoc($user);
if (mysql_num_rows($user) > 0)
{
    mysql_query("UPDATE {$TABLE_PREFIX}users SET invitations=invitations+1 WHERE id = '" .
        $arr["inviter"] . "'");
    mysql_query("DELETE FROM {$TABLE_PREFIX}invitations WHERE inviter = '" . $arr["inviter"] .
        "' AND time_invited < DATE_SUB(NOW(), INTERVAL $deadtime SECOND)");
}
//end invitation system
?>
