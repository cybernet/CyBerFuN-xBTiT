<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Friend List
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
// BTI version created by TheDevil , converted to XBTIT-2 by DiemThuy - Nov 2008
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
      
      if ($CURUSER["id_level"] == 1)
{
	redirect("users.php"); // redirects to users.php if guest
	exit();
}
$friendtpl = new bTemplate();
$friendtpl-> set("language", $language);
require_once("include/functions.php");

dbconn();


$do = $_GET["do"];
$friend_id = $_GET["friend_id"];

// Add member to friendlist

if ($do == "add")
{
	if (!isset($friend_id))
	{
		redirect("index.php?page=users"); // redirects to users.php if friend_id not set
		exit();
	}

    $hmm = mysql_query("SELECT * FROM {$TABLE_PREFIX}friendlist WHERE friend_id = '$friend_id' AND user_id = ".$CURUSER['uid']);
	if (mysql_num_rows($hmm))
	{
		err_msg(ERROR,MEMBER_ALREADY_EXIST);
		block_end();
		stdfoot();
		exit();
	}
	$qry = mysql_query("SELECT * FROM {$TABLE_PREFIX}users WHERE id = '$friend_id'");
	$res = mysql_fetch_array($qry);
	$chk = mysql_num_rows($qry);
	if (!$chk)
	{
		redirect("index.php?page=users"); // redirects to users.php if friend_id not in database
		exit();
	}
	mysql_query("INSERT INTO {$TABLE_PREFIX}friendlist (user_id, friend_id, friend_name) VALUES ('".$CURUSER["uid"]."', '".$friend_id."', '".$res["username"]."')");
    redirect("index.php?page=friendlist");
	exit();

}
// Delete friend
elseif ($do == "del")
{

	{
        $msg = $_GET["id"];
		@mysql_query("DELETE FROM {$TABLE_PREFIX}friendlist WHERE id=\"$msg\"");
	}
	redirect("index.php?page=friendlist");
	exit();
}
// Main friendlist page
else
{

	$qry = mysql_query("SELECT * FROM {$TABLE_PREFIX}friendlist WHERE user_id = ".$CURUSER['uid']);
	$coun = mysql_num_rows($qry);


	if ($coun)

         $friend = array();
         $i=0;
	while ($res = mysql_fetch_array($qry))
	{
		$tor = mysql_query("SELECT ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.id>1 AND u.id = ".$res['friend_id']);

        $ret = mysql_fetch_array($tor);
        $avatar = ($ret["avatar"] && $ret["avatar"] != "" ? htmlspecialchars($ret["avatar"]) : "");
        if ($avatar=="")
        $av=("<img src='$STYLEURL/images/default_avatar.gif' border='0' width=50 />");
           else
           $av=("<img width=50 src=$avatar>");
// Online User

		$last = $ret['lastconnect'];
		$online = time();
			$online -= 60 * 15;
		if($last > $online)
		{
			$online = "<img src=images/fonline.gif border=0> User is Online";
		}
		else
			$online = "<img src=images/foffline.gif border=0> User is Offline";
// end online users
       $friend[$i]["id"] = $res["id"];
       $friend[$i]["avatar"] = ("<center>$av</center>");
       $friend[$i]["name"] = ("<a href=index.php?page=userdetails&id=".$res["friend_id"].">".unesc($ret["prefixcolor"]).unesc($ret["username"]).unesc($ret["suffixcolor"])."</a>");
       $friend[$i]["level"] = $ret['level'];
       $friend[$i]["acces"] = date("d/m/y h:i:s",$ret['lastconnect']);
       $friend[$i]["status"] = ("<center>$online</center>");
       $friend[$i]["delete"] = ("<center><a href=\"index.php?page=friendlist&do=del&amp;id=".$friend[$i]["id"]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a></center>");
       $i++;
}
}
	$friendtpl->set("friend",$friend);

?>
