<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2009  Btiteam
//
//    This file is part of xbtit.
//
// Torrent Request & Vote by miskotes  - converted to XBTIT-2 by DiemThuy - March 2009
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
      
$id = $_GET["id"];
$res = mysql_query("SELECT * FROM {$TABLE_PREFIX}requests WHERE id = $id") or sqlerr();
$num = mysql_fetch_array($res);

$s = $num["request"];

$reqdetailstpl = new bTemplate();
$reqdetailstpl->set("language",$language);

$reqdetailstpl->set("rd1","<center><table width=550 border=0 cellspacing=0 cellpadding=3>\n");

//Edit request by RippeR change by miskotes
$url = "index.php?page=reqedit&id=$id";
 if (isset($_GET["returnto"])) {
         $addthis = "&amp;returnto=" . urlencode($_GET["returnto"]);
         $url .= $addthis;
         $keepget .= $addthis;
 }
 $editlink = "a href=\"$url\"";
$reqdetailstpl->set("rd2","<table class=lista align=center width=550 cellspacing=2 cellpadding=0>\n");
$reqdetailstpl->set("rd3","<br><tr><td align=left class=header><B>Request :</B></td><td class=lista width=70% align=left>$num[request]");
if ($CURUSER["uid"] == $num["userid"] || $CURUSER["edit_torrents"]== "yes")
{
$reqdetailstpl->set("rd4","&nbsp;&nbsp;&nbsp;<".$editlink."><b>[edit]</b></a></td></tr>");
}
else
{
}

$reqdetailstpl->set("rd5","</td></tr>");

if ($num["descr"])
$reqdetailstpl->set("rd6","<tr><td align=left class=header><B>Info :</B></td><td class=lista width=70% align=left>".format_comment(unesc($num[descr]))."</td></tr>");
$reqdetailstpl->set("rd7","<tr><td align=left class=header><B>Added :</B></td><td class=lista width=70% align=left>$num[added]</td></tr>");

$cres = mysql_query("SELECT username FROM {$TABLE_PREFIX}users WHERE id=$num[userid]");
   if (mysql_num_rows($cres) == 1)
   {
     $carr = mysql_fetch_assoc($cres);
     $username = "$carr[username]";
   }
$reqdetailstpl->set("rd8","<tr><td align=left class=header><B>Requested By:</B></td><td class=lista align=left><a href=index.php?page=userdetails&id=$num[userid]><b>$username</b></td></tr>");


if ($num["filled"] == NULL)
{
$reqdetailstpl->set("rd9","<tr><td align=left class=header><B>Vote For This</B></td><td class=lista width=50% align=left><a href=index.php?page=addrequest&id=$id><b>Vote</b></a></td></tr>");

if ($CURUSER["can_upload"]=="yes")
{
$reqdetailstpl->set("rd10","<tr><td class=header align=left width=30%><b>How To Fill A Request</b> </td><td class=lista align=left width=70%>Type <b>full</b> direct torrent URL, i.e. http://www.mysite.com/index.php?page=torrent-details&id=813.. (you can only copy/paste from another window) or modify existing URL of torrent ID...</td></tr>");
$reqdetailstpl->set("rd11","<tr><td class=lista align=center width=100% colspan=2><form method=get action=index.php><input type=hidden name=page value=reqfilled />");
$reqdetailstpl->set("rd12","<input type=text size=80 name=filledurl value=\"TYPE-DIRECT-TORRENT-URL-HERE\"><input type=submit value=Send>");
$reqdetailstpl->set("rd13","<input type=hidden value=$id name=requestid>");
$reqdetailstpl->set("rd14","</form></table>");
//$reqdetailstpl->set("rd15","<hr><form method=get action=index.php><input type=hidden name=page value=requests&id=add /><input type=submit value=Add Request></form></td></tr>");
		}
}
		else
//$reqdetailstpl->set("rd16","<tr><td class=lista align=center width=100% colspan=2><form method=get action=index.php><input type=hidden name=page value=requests&id=add /><input type=submit value=Add Request></form></td></tr>");
$reqdetailstpl->set("rd17","</table>");


?>