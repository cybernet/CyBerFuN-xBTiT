<?php
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

require_once ("include/functions.php");
require_once ("include/config.php");

      if ($CURUSER["id_level"]==1)
{
	redirect("users.php"); // redirects to users.php if guest
	exit();
}
$usercptpl= new bTemplate();
$usercptpl-> set("language",$language);
require_once("include/functions.php");

dbconn();


$do = $_GET["do"];
$ignore_id = $_GET["ignore_id"];

// Add member to friendlist

if ($action=="add")
{
	if (!isset($ignore_id))
	{
		redirect("index.php?page=users"); // redirects to users.php if friend_id not set
		exit();
	}

    $hmm=mysql_query("SELECT * FROM {$TABLE_PREFIX}ignore WHERE ignore_id = '$ignore_id' AND user_id = ".$CURUSER['uid']);
	if (mysql_num_rows($hmm))
	{
		err_msg(ERROR,MEMBER_ALREADY_EXIST);
		block_end();
		stdfoot();
		exit();
	}
	$qry = mysql_query("SELECT * FROM {$TABLE_PREFIX}users WHERE id = '$ignore_id'");
	$res = mysql_fetch_array($qry);
	$chk = mysql_num_rows($qry);
	if (!$chk)
	{
		redirect("index.php?page=users"); // redirects to users.php if friend_id not in database
		exit();
	}
	mysql_query("INSERT INTO {$TABLE_PREFIX}ignore (user_id, ignore_id, ignore_name, added) VALUES ('".$CURUSER["uid"]."', '".$ignore_id."', '".$res["username"]."', NOW())");
    redirect("index.php?page=usercp&uid=".$CURUSER["uid"]."&do=ignore");
	exit();

}
// Delete friend
elseif ($action=="del")
{

	{
        $msg = $_GET["id"];
		@mysql_query("DELETE FROM {$TABLE_PREFIX}ignore WHERE id=\"$msg\"");
	}
	redirect("index.php?page=usercp&uid=".$CURUSER["uid"]."&do=ignore");
	exit();
}
// Main friendlist page
else
{

	$qry=mysql_query("SELECT * FROM {$TABLE_PREFIX}ignore WHERE user_id = ".$CURUSER['uid']);
	$coun=mysql_num_rows($qry);
	
if ($coun > 0){$usercptpl-> set("seznam",true,true);$usercptpl-> set("noseznam",false,true);}else{$usercptpl-> set("noseznam",true,true);$usercptpl-> set("seznam",false,true);}
if (!$coun)

         $ignore=array();
         $i=0;
	while ($res=mysql_fetch_array($qry))
	{
		$tor=mysql_query("SELECT ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.id>1 AND u.id = ".$res['ignore_id']);

        $ret=mysql_fetch_array($tor);

       $ignore[$i]["id"]=$res["id"];
       $ignore[$i]["name"]=("<a href=index.php?page=userdetails&id=".$res["ignore_id"].">".unesc($ret["prefixcolor"]).unesc($ret["username"]).unesc($ret["suffixcolor"])."</a>");
       $ignore[$i]["added"]=("<center>$res[added]</center>");
       $ignore[$i]["delete"]=("<center><a href=\"index.php?page=usercp&uid=".$CURUSER["uid"]."&do=ignore&action=del&amp;id=".$ignore[$i]["id"]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a></center>");
       $i++;
    }
       
if (!$coun)	

$usercptpl-> set ("nic","<tr><td class=lista align=center colspan=40><center>List Ignore users is empty</tr></td>");

}
$usercptpl->set("ignore",$ignore);

    block_end();

?>
