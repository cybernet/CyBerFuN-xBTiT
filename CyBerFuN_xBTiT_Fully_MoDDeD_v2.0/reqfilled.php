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

if ($CURUSER["can_upload"]=="no")
   {
    // do nothing
   }
else
    {
$reqfilledtpl = new bTemplate();
$reqfilledtpl->set("language",$language);
$reqfilledtpl->set("rf0","<table align='center' width=550 class=lista><tr><td class=lista align=center width=100%>");

$filledurl = $_GET["filledurl"];
$requestid = $_GET["requestid"];
$filldate =  date('Y-m-d H:i:s');


$res = mysql_query("SELECT users.username, requests.userid, requests.request FROM {$TABLE_PREFIX}requests requests inner join {$TABLE_PREFIX}users users on requests.userid = users.id where requests.id = $requestid") or sqlerr();
 $arr = mysql_fetch_assoc($res);

$res2 = mysql_query("SELECT username FROM {$TABLE_PREFIX}users where id =" . $CURUSER[uid]) or sqlerr();
 $arr2 = mysql_fetch_assoc($res2);


$msg = "".REQUEST.": [url=$BASEURL/index.php?page=reqdetails&id=" . $requestid . "][b]" . $arr[request] . "[/b][/url], is filled by [url=$BASEURL/index.php?page=userdetails&id=" . $CURUSER[uid] . "][b]" . $arr2[username] . "[/b][/url].

The torrent can be downloaded from the following link:
[url=" . $filledurl. "][b]" . $filledurl. "[/b][/url]

Do not forget to thank the uploader.
If for some reason this is not what you want, please reset this by clicking [url=$BASEURL/index.php?page=reqreset&requestid=" . $requestid . "][b]HERE![/b][/url].

[b]DO NOT[/b] click the link unless you are absolutly sure you want to reset the request.";
$subject= "Your torrent request is filled !";

       mysql_query ("UPDATE {$TABLE_PREFIX}requests SET filled = '$filledurl', fulfilled= '$filldate', filledby = $CURUSER[uid] WHERE id = $requestid") or sqlerr();

if ($btit_settings["req_rwon"]==true)
{
 if ($btit_settings["req_sbmb"]==true)
 
 {
mysql_query("UPDATE {$TABLE_PREFIX}users SET uploaded = uploaded + $btit_settings[req_mb]  WHERE id=$CURUSER[uid]");
 }
 
 if ($btit_settings["req_sbmb"]==false)
 
 {
mysql_query("UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus + $btit_settings[req_sb] WHERE id=$CURUSER[uid]");
 }
}

send_pm($CURUSER[uid],$arr[userid],sqlesc($subject),sqlesc($msg));


$reqfilledtpl->set("rf1","<table class=lista align=center width=550 cellspacing=2 cellpadding=0>\n");
$reqfilledtpl->set("rf2","<br><BR><div align=left>Request " . $arr[request] . " has now been successfuly filled here: <a href=$filledurl>$filledurl</a>.  User <a href=index.php?page=account-details&id=$arr[userid]><b>$arr[username]</b></a> has recieved a PM about this upload.  <br>
<br><b>Is this is an accident?</b><br><br>No worries, only <a href=index.php?page=reqreset&requestid=$requestid><b>CLICK HERE</b></a> to reset this request.<br><b>WARNING</b> do not click this unless you realy want to reset the request !<br><BR></div>");
$reqfilledtpl->set("rf3","<BR><BR>Thanks for filling out this request :)<br><br>Go back to<a href=index.php?page=viewrequests><b> View Requests</b></a>");
$reqfilledtpl->set("rf4","</td></tr></table></table>");
}

?>