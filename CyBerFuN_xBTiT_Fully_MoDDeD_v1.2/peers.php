<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Peers
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xList.ro/
// http://xDnS.ro/
// http://yDnS.ro/
// Modified By cybernet2u

// CyBerFuN xBTiT Fully MoDDeD v1.2


// https://cyberfun-xbtit.svn.sourceforge.net/svnroot/cyberfun-xbtit


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

if (!defined("IN_BTIT"))
      die("non direct access!");


$i = 0;
$scriptname = htmlspecialchars($_SERVER["PHP_SELF"]."?page=peers&amp;id=$_GET[id]");
$addparam = "";
$id = AddSlashes($_GET["id"]);
if (!isset($id) || !$id)
    die("Error ID");

/*
$res = get_result("SELECT size FROM {$TABLE_PREFIX}files WHERE info_hash='$id'", true);
*/


    ################################################################################################
    # Speed stats in peers with filename

$res = get_result("SELECT size, filename FROM {$TABLE_PREFIX}files WHERE info_hash='$id'", true);

    # End       
    ################################################################################################

if ($res) {
   $row = $res[0];
   if ($row) {
      $tsize = 0 + $row["size"];


    ################################################################################################
    # Speed stats in peers with filename
       
      $peers["filename"] = $row["filename"];
      $peers["size"] = makesize($row["size"]);      
        
    # End       
    ################################################################################################
    

	
      }
}
else
    die("Error ID");

if ($XBTT_USE)
   $res = get_result("SELECT x.uid,x.completed, x.downloaded, x.uploaded, x.left as bytes, IF(x.left=0,'seeder','leecher') as status, x.mtime as lastupdate, u.username, u.flag, c.flagpic, c.name FROM xbt_files_users x LEFT JOIN xbt_files ON x.fid=xbt_files.fid LEFT JOIN {$TABLE_PREFIX}files f ON f.bin_hash=xbt_files.info_hash LEFT JOIN {$TABLE_PREFIX}users u ON u.id=x.uid LEFT JOIN {$TABLE_PREFIX}countries c ON u.flag=c.id WHERE f.info_hash='$id' AND active=1 ORDER BY status DESC, lastupdate DESC", true, $btit_settings['cache_duration']);
else
   $res = get_result("SELECT * FROM {$TABLE_PREFIX}peers p LEFT JOIN {$TABLE_PREFIX}countries c ON p.dns=c.domain WHERE infohash='$id' ORDER BY bytes ASC, status DESC, lastupdate DESC", true, $btit_settings['cache_duration']);

require(load_language("lang_peers.php"));

$peerstpl = new bTemplate();
$peerstpl->set("language", $language);
$peerstpl->set("peers_script", "index.php");

if (count($res) == 0)
  $peerstpl->set("NOPEERS", TRUE, TRUE);
else
    {
    $peerstpl->set("NOPEERS", FALSE, TRUE);

if($CURUSER["admin_access"] == "yes")
{
    $peerstpl->set("ADMIN_ACCESS", TRUE, TRUE);
    $peerstpl->set("uid", $CURUSER["uid"]);
    $peerstpl->set("random", $CURUSER["random"]);
    $clients = array();
    $i = 0;
    $clientarr = array();
    foreach($clientarr as $n => $v)
    {
        $clients[$i]["client"] = $n;
        $clients[$i]["user_agent"] = $v["user_agent"];
        $clients[$i]["peer_id"] = $v["peer_id"];
        $clients[$i]["peer_id_ascii"] = $v["peer_id_ascii"];
        $clients[$i]["times_seen"] = $v["times_seen"];
        $clients[$i]["encode1"] = urlencode($v["user_agent"]);
        $clients[$i]["encode2"] = urlencode($v["peer_id"]);
        $clients[$i]["encode3"] = urlencode("index.php?page=peers&id=".$id);
        $i++;
    }
    $peerstpl->set("clients", $clients);
    
    $sqlquery = "SELECT * ";
    $sqlquery .= "FROM {$TABLE_PREFIX}banned_client ";
    $sqlquery .= "ORDER BY client_name ASC";

    $res = get_result($sqlquery, true, $btit_settings['cache_duration']);

    if(count($res) > 0)
    {
        $i = 0;
        $banned = array();
        while($row = mysql_fetch_assoc($res))
        {
            $banned[$i]["client_name"] = $row["client_name"];
            $banned[$i]["user_agent"] = $row["user_agent"];
            $banned[$i]["peer_id"] = $row["peer_id"];
            $banned[$i]["peer_id_ascii"] = $row["peer_id_ascii"];
            $banned[$i]["reason"] = stripslashes($row["reason"]);
            $banned[$i]["id"] = $row["id"];
            $banned[$i]["encode"] = urlencode("index.php?page=peers&id=".$id);	 
            $i++;
        }
        $peerstpl->set("banned_clients", TRUE, TRUE);
        $peerstpl->set("banned", $banned);
    }
    else
    {
        $peerstpl->set("banned_clients", FALSE, TRUE);
    }
}
else
{
    $peerstpl->set("ADMIN_ACCESS", FALSE, TRUE);
}

    foreach ($res as $id=>$row)
    {
    // Ban clients by Petr1fied
    if($CURUSER["admin_access"] == "yes")
    {
        $gotclient = htmlspecialchars(getagent(unesc($row["client"]), unesc($row["peer_id"])));
        if(!array_key_exists($gotclient,$clientarr))
        {
            $clientarr[$gotclient]["user_agent"] = ((substr($row["client"], 0, 7)=="Azureus") ? substr($row["client"], 0,  (((stripos($row["client"], ";")==true) ? stripos($row["client"], ";") : strlen($row["client"])))) : $row["client"]);
            $clientarr[$gotclient]["peer_id"] = substr($row["peer_id"], 0, 16);
            $clientarr[$gotclient]["peer_id_ascii"] = hex2bin(substr($row["peer_id"], 0, 16));
            $clientarr[$gotclient]["times_seen"] = 1;
        }
        else
            $clientarr[$gotclient]["times_seen"] = $clientarr[$gotclient]["times_seen"] + 1;
    }
      // for user name instead of peer
     if ($XBTT_USE)
        $resu = TRUE;
     elseif ($PRIVATE_ANNOUNCE)
        $resu = get_result("SELECT u.username,u.id,c.flagpic,c.name FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}countries c ON c.id=u.flag WHERE u.pid='".$row["pid"]."' LIMIT 1", true, $btit_settings['cache_duration']);
     else
        $resu = get_result("SELECT u.username,u.id,c.flagpic,c.name FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}countries c ON c.id=u.flag WHERE u.cip='".$row["ip"]."' LIMIT 1", true, $btit_settings['cache_duration']);

 if ($resu)
    {
    if($XBTT_USE)
    {
        $rowuser["username"] = $row["username"];
        $rowuser["id"] = $row["uid"];
        $rowuser["flagpic"] = $row["flagpic"];
        $rowuser["name"] = $row["name"];
    }
else
    {
    $rowuser = $resu[0];
	
    if ($rowuser && $rowuser["id"] > 1)
      {
      if ($GLOBALS["usepopup"]){
       $peers[$i]["USERNAME"] = "<a href=\"javascript: windowunder('index.php?page=userdetails&amp;id=".$rowuser["id"]."')\">".unesc($rowuser["username"])."</a>";
       $peers[$i]["PM"] = "<a href=\"javascript: windowunder('index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=$CURUSER[uid]&amp;what=new&amp;to=".urlencode(unesc($rowuser["username"]))."')\">".image_or_link("$STYLEPATH/images/pm.png","","PM")."</a>";
  }    else {
        $peers[$i]["USERNAME"] = "<a href=\"index.php?page=userdetails&amp;id=".$rowuser["id"]."\">".unesc($rowuser["username"])."</a>";
        $peers[$i]["PM"] = "<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=".$CURUSER["uid"]."&amp;what=new&amp;to=".urlencode(unesc($rowuser["username"]))."\">".image_or_link("$STYLEPATH/images/pm.png","","PM")."</a>";
       }
      }
    else
      {
       $peers[$i]["USERNAME"] = $language["GUEST"];
       $peers[$i]["PM"] = "";
    }
  }
  if ($row["flagpic"] != "" && $row["flagpic"] != "unknown.gif")
    $peers[$i]["FLAG"] = "<img src=\"images/flag/".$row["flagpic"]."\" alt=\"".unesc($row["name"])."\" />";
  elseif ($rowuser["flagpic"] != "" && !empty($rowuser["flagpic"]))
    $peers[$i]["FLAG"] = "<img src=\"images/flag/".$rowuser["flagpic"]."\" alt=\"".unesc($rowuser["name"])."\" />";
  else
    $peers[$i]["FLAG"] = "<img src=\"images/flag/unknown.gif\" alt=\"".$language["UNKNOWN"]."\" />";
// Peer Connectable by Petr1fied starts
if (!$XBTT_USE)
{
    if ($GLOBALS["NAT"])
        $peers[$i]["PORT"] = "<b><font color='".(($row["natuser"] == "Y")?"red":"green")."'>".$row["port"]."</font></b>";
    else
        $peers[$i]["PORT"] = $row["port"];
}
// Peer Connectable by Petr1fied ends
  $stat = floor((($tsize - $row["bytes"]) / $tsize) * 100);
  $progress = "<table width=\"100\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"progress\" align=\"left\">";
  $progress .= "<img height=\"10\" width=\"".number_format($stat,0)."\" src=\"$STYLEURL/images/progress.jpg\" alt=\"\" /></td></tr></table>";
$peers[$i]["PROGRESS"] = $stat."%<br />" . $progress;

$peers[$i]["STATUS"] = $row["status"];
if(!$XBTT_USE)
$peers[$i]["CLIENT"] = htmlspecialchars(getagent(unesc($row["client"]), unesc($row["peer_id"])));
  $dled = makesize($row["downloaded"]);
  $upld = makesize($row["uploaded"]);
$peers[$i]["DOWNLOADED"] = $dled;


    ################################################################################################
    # Speed stats in peers with filename

            if ($row['status'] == 'seeder') $transferrateDL = "<i>seeder</i>";             
              else if ($row['download_difference'] > '0' && $row['announce_interval'] > '0')
                $transferrateDL = round(round($row['download_difference'] / $row['announce_interval']) / 1000, 2)." KB/sec";
                else $transferrateDL = "0 KB/sec";
              
if ($transferrateDL >= 6.50) $color = "green";
else if ($transferrateDL >= 3.00) $color = "orange";
else if ($transferrateDL >= 0.01) $color = "red";
else if($row['status'] == 'seeder') $color = "#00D900";
else $color = "";
              $peers[$i]["DLSPEED"] = "<font color=$color>$transferrateDL</font>";


$peers[$i]["UPLOADED"] = $upld;


            if ($row['upload_difference'] > '0' && $row['announce_interval'] > '0')
              $transferrateUP = round(round($row['upload_difference'] / $row['announce_interval']) / 1000, 2)." KB/sec";
              else $transferrateUP = "0 KB/sec";
              
if ($transferrateUP >= 6.50) $color = "green";
else if ($transferrateUP >= 3.00) $color = "orange";
else if ($transferrateUP >= 0.01) $color = "red";
else $color = "";
              $peers[$i]["UPSPEED"] = "<font color=$color>$transferrateUP</font>";

    # End       
    ################################################################################################


	

//Peer Ratio
  if (intval($row["downloaded"]) > 0) {
     $ratio = number_format($row["uploaded"] / $row["downloaded"], 2);}
  else {$ratio = '&#8734;';}
  $peers[$i]["RATIO"] = $ratio;
//End Peer Ratio

  $peers[$i]["SEEN"] = get_elapsed_time($row["lastupdate"])." ago";
$i++;
}
}


if ($GLOBALS["usepopup"])
    $peerstpl->set("BACK2","<br /><br /><center><a href=\"javascript:window.close()\"><tag:language.CLOSE /></a></center>");
else
   $peerstpl->set("BACK2", "<br /><br /><center><a href=\"javascript: history.go(-1);\"><tag:language.BACK /></a></center>");
$peerstpl->set("XBTT", $XBTT_USE, TRUE);
$peerstpl->set("XBTT2", $XBTT_USE, TRUE);
$peerstpl->set("XBTT3", $XBTT_USE, TRUE);
$peerstpl->set("XBTT4", $XBTT_USE, TRUE);
$peerstpl->set("peers", $peers);
}
?>