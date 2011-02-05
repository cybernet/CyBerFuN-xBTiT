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

// pagerfunctie afmaken

if (!defined("IN_BTIT"))
      die("non direct access!");



$requestid = (int)$_GET[requestid];

$res2 = mysql_query("select count(addedrequests.id) from {$TABLE_PREFIX}addedrequests addedrequests inner join {$TABLE_PREFIX}users users on addedrequests.userid = users.id inner join {$TABLE_PREFIX}requests requests on addedrequests.requestid = requests.id WHERE addedrequests.requestid =$requestid") or die(mysql_error());
$row = mysql_fetch_array($res2);
$count = $row[0];

$home = 'index.php?page=votesview';
$perpage = 20;

 list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $home ."&" );

$res = mysql_query("select users.id as userid,users.username, users.downloaded,users.uploaded, requests.id as requestid, requests.request from {$TABLE_PREFIX}addedrequests addedrequests inner join {$TABLE_PREFIX}users users on addedrequests.userid = users.id inner join {$TABLE_PREFIX}requests requests on addedrequests.requestid = requests.id WHERE addedrequests.requestid =$requestid $limit") or sqlerr();



$res2 = mysql_query("select request from {$TABLE_PREFIX}requests where id=$requestid");
      $req=array();
      $i=0;
$arr2 = mysql_fetch_assoc($res2);

$votesviewtpl = new bTemplate();
$votesviewtpl->set("language",$language);

$votesviewtpl->set("vv1","<p align=center>Vote For This <a href=index.php?page=addrequest&id=$requestid><b>Request</b></a></p>");

//echo $pagertop;

if (mysql_num_rows($res) == 0)
$votesviewtpl->set("vv2","<p align=center><b>Nothing Found</b></p>\n");
else
{
$votesviewtpl->set("vv3","<center><table width=99% class=lista align=center cellpadding=3>\n");
$votesviewtpl->set("vv4","<tr><td class=header>Username</td><td class=header>Uploaded</td><td class=header>Downloaded</td>".
   "<td class=header>Ratio</td>\n");

 while ($arr = mysql_fetch_assoc($res))
 {

if ($arr["downloaded"] > 0)
{
       $ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
       //$ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";
    }
    else
       if ($arr["uploaded"] > 0)
         $ratio = "Inf.";
 else
  $ratio = "---";
$uploaded = makesize($arr["uploaded"]);
$joindate = "$arr[added] (" . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"])) . " ago)";
$downloaded = makesize($arr["downloaded"]);
if ($arr["enabled"] == 'no')
 $enabled = "<font color = red>No</font>";
else
 $enabled = "<font color = green>Yes</font>";

  $req[$i]["vv5"]=("<tr><td class=lista><center><a href=index.php?page=userdetails&id=$arr[userid]><b>$arr[username]</b></a></td><td align=left class=lista><center>$uploaded</td><td align=left class=lista><center>$downloaded</td><td align=left class=lista><center>$ratio</td></tr>\n");
  $i++;
 }
$votesviewtpl->set("req",$req);
$votesviewtpl->set("vv6","</table></center><BR><BR>\n");
}

?>