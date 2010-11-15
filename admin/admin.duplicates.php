<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Admin - Duplicates
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
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

                          ###############################
                          #                             #
                          # Name: Duplicate Accounts    #
                          # Type: Module/Hack           #
                          # Version: 1.0                #
                          # Designed for: Xbtit 2.0     #
                          # Developer: CobraCRK         #
                          # WWW: www.veldev.net         #
                          # E-mail: cobracrk@veldev.net #
                          # Credits: all btiteam dev    #
                          #                             #
                          ###############################

if (!defined("IN_BTIT"))
      die("non direct access!");

if (!defined("IN_ACP"))
      die("non direct access!");


    $res = mysql_query("SELECT lip FROM {$TABLE_PREFIX}users WHERE id>1 AND lip<>0 GROUP BY lip HAVING count(*) > 1") or sqlerr();


$num = mysql_num_rows($res);
if($num == 0){
err_msg($language['ERROR'], $language['ERR_USERS_NOT_FOUND']);
block_end();
stdfoot(false, false, true);
exit;

}

$i = 0;
while($r = mysql_fetch_assoc($res))
{
if ($XBTT_USE)
    $ros = mysql_query("SELECT {$TABLE_PREFIX}users.username, {$TABLE_PREFIX}users.id, {$TABLE_PREFIX}users.email, ({$TABLE_PREFIX}users.uploaded+xbt_users.uploaded) as uploaded, ({$TABLE_PREFIX}users.downloaded+xbt_users.downloaded) as downloaded,{$TABLE_PREFIX}users.cip,{$TABLE_PREFIX}users.id,{$TABLE_PREFIX}users.joined, {$TABLE_PREFIX}users.lastconnect  FROM {$TABLE_PREFIX}users INNER JOIN xbt_users ON xbt_users.uid={$TABLE_PREFIX}users.id WHERE {$TABLE_PREFIX}users.lip='".$r['lip']."' ORDER BY {$TABLE_PREFIX}users.lip") or sqlerr();
else 
    $ros = mysql_query("SELECT {$TABLE_PREFIX}users.username, {$TABLE_PREFIX}users.id, {$TABLE_PREFIX}users.email, {$TABLE_PREFIX}users.uploaded, {$TABLE_PREFIX}users.downloaded,{$TABLE_PREFIX}users.cip,{$TABLE_PREFIX}users.id,{$TABLE_PREFIX}users.joined, {$TABLE_PREFIX}users.lastconnect  FROM {$TABLE_PREFIX}users  WHERE {$TABLE_PREFIX}users.lip='".$r['lip']."' ORDER BY {$TABLE_PREFIX}users.lip") or sqlerr();



$num2 = mysql_num_rows($ros);
//echo $num2;
while($arr = mysql_fetch_assoc($ros))
{
if ($arr['joined'] == '0000-00-00 00:00:00')
$arr['joined'] = '-';
if ($arr['lastconnect'] == '0000-00-00 00:00:00')
$arr['lastconnect'] = '-';
if($arr["downloaded"] != 0)
$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
else
$ratio = "---";

$ratio = "$ratio";
$uploaded = makesize($arr["uploaded"]);
$downloaded = makesize($arr["downloaded"]);
$added = substr($arr['joined'], 0, 10);
$last_access = substr($arr['lastconnect'], 0, 10);
$ip = htmlspecialchars($arr['cip']);

$dupes[$i]["USER_NAME"] = $arr['username'];
$dupes[$i]["ID"] = $arr['id'];
$dupes[$i]["EMAIL"] = $arr['email'];
$dupes[$i]["RATIO"] = $ratio;
$dupes[$i]["UPLOADED"] = $uploaded;
$dupes[$i]["DOWNLOADED"] = $downloaded;
$dupes[$i]["ADDED"] = $added;
$dupes[$i]["LAST_ACCESS"] = $last_access;
$dupes[$i]["IP"] = $ip;
$i++;

}
}

$admintpl->set("users", $dupes);
$admintpl->set("language", $language);
?>
