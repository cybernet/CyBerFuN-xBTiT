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

// DT viewrequests.tpl needed

if (!defined("IN_BTIT"))
      die("non direct access!");

require_once("include/functions.php");
require_once("include/config.php");
dbconn();

global $CURUSER;
if (!$CURUSER || $CURUSER["view_torrents"]=="no")
   {
    // do nothing
   }
else
    {

if ($btit_settings["req_onoff"]==true){

       $maxallowed = $btit_settings["req_max"];
       $res3 = mysql_query("SELECT * FROM {$TABLE_PREFIX}requests as reqcount WHERE userid=$CURUSER[uid]") or mysql_error();
       $arr3 = mysql_num_rows($res3);
       $numreqs = $arr3;
       $reqrem = $maxallowed-$numreqs;
       $reward = makesize($btit_settings["req_mb"]);
       
$viewrequeststpl = new bTemplate();
$viewrequeststpl->set("language",$language);

if ($btit_settings["req_maxon"]==true){
       
$viewrequeststpl->set("vr0","<br><div align=center ><font color=steelblue>Available Requests for <b>$CURUSER[username]: $maxallowed</b> | Posted Requests: <b>$arr3</b> | Remaining: <b>$reqrem</b></font></div><br>");
}

if ($btit_settings["req_rwon"]==true)
{
 if ($btit_settings["req_sbmb"]==true)

 {
$viewrequeststpl->set("vr01","<br><div align=center ><font color=steelblue>If you furfill a request , you will recieve <b>$reward</b></font></div><br>");
//mysql_query("UPDATE {$TABLE_PREFIX}users SET uploaded = uploaded + $btit_settings[req_mb]  WHERE id=$CURUSER[uid]");
 }

 if ($btit_settings["req_sbmb"]==false)

 {
$viewrequeststpl->set("vr01","<br><div align=center ><font color=steelblue>If you furfill a request , you will recieve <b>$btit_settings[req_sb]</b> seedbonus points</font></div><br>");
//mysql_query("UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus + $btit_settings[req_sb] WHERE id=$CURUSER[uid]");
 }
}
$viewrequeststpl->set("vr1","<div align=right><a href=index.php?page=requests>Add New Request</a> | <a href=index.php?page=viewrequests&requestorid=$CURUSER[uid]>View my requests</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
$viewrequeststpl->set("vr2","<br><br><a href=index.php?page=viewrequests&category=" . $_GET[category] . "&sort=" . $_GET[sort] . "&filter=true><b>Hide Filled Requests</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div>");

$categ = $_GET["category"];
$requestorid = $_GET["requestorid"];
$sort = $_GET["sort"];
$search = $_GET["search"];
$filter = $_GET["filter"];

$search = " AND requests.request like '%$search%' ";

if ($sort == "votes")
$sort = " order by hits desc ";
else if ($sort == "request")
$sort = " order by request ";
else
$sort = " order by added desc ";

if ($filter == "true")
$filter = " AND requests.filledby = 0 ";
else
$filter = "";


if ($requestorid <> NULL)
{
if (($categ <> NULL) && ($categ <> 0))
 $categ = "WHERE requests.cat = " . $categ . " AND requests.userid = " . $requestorid;
else
 $categ = "WHERE requests.userid = " . $requestorid;
}

else if ($categ == 0)
$categ = '';
else
$categ = "WHERE requests.cat = " . $categ;

/*
if ($categ == 0)
$categ = 'WHERE requests.cat > 0 ';
else
$categ = "WHERE requests.cat = " . $categ;
*/


$res = mysql_query("SELECT count(requests.id) FROM {$TABLE_PREFIX}requests requests inner join {$TABLE_PREFIX}categories categories on requests.cat = categories.id inner join {$TABLE_PREFIX}users users on requests.userid = users.id  $categ $filter $search") or die(mysql_error());
   $req=array();
   $ii = 0;
$row = mysql_fetch_array($res);
$count = $row[0];


$dir = 'index.php?page=viewrequests';
$perpage = $btit_settings["req_page"];

list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $dir ."&" . "category=" . $_GET["category"] . "&sort=" . $_GET["sort"] . "&" );

$res = mysql_query("SELECT users.downloaded, users.uploaded, users.username, requests.filled, requests.filledby, requests.id, requests.userid, requests.request, requests.added, requests.hits, categories.image as catimg, categories.id as catid, categories.name as cat FROM {$TABLE_PREFIX}requests requests inner join {$TABLE_PREFIX}categories categories on requests.cat = categories.id inner join {$TABLE_PREFIX}users users on requests.userid = users.id  $categ $filter $search $sort $limit") or sqlerr();
$num = mysql_num_rows($res);

$viewrequeststpl->set("vr3","<br><br><CENTER><form method=get action=index.php><input type=hidden name=page value=viewrequests />");
$viewrequeststpl->set("vr4","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=text size=30 name=search>");
$viewrequeststpl->set("vr5"," <input type=submit align=center value=Search style='height: 22.5px'>\n");
$viewrequeststpl->set("vr6","</form></CENTER><br>");

$viewrequeststpl->set("pagtop","<center>$pagertop</center>");

$viewrequeststpl->set("vr7","<Table border=0 width=99% align=center cellspacing=0 cellpadding=0><TR><TD width=49.5% align=left>");

$viewrequeststpl->set("vr8","<p>Sort By : <a href=index.php?page=viewrequests&category=" . $_GET[category] . "&filter=" . $_GET[filter] . "&sort=votes>Votes</a> - <a href=index.php?page=viewrequests&category=" . $_GET[category] . "&filter=" . $_GET[filter] . "&sort=request> Name</a> - <a href=index.php?page=viewrequests&category=" . $_GET[category] . "&filter=" . $_GET[filter] . "&sort=added> Date </a></p>");

$viewrequeststpl->set("vr9","<form method=get action=index.php><input type=hidden name=page value=viewrequests />");

$viewrequeststpl->set("vr10","</td><td width=100% align=right>");
$viewrequeststpl->set("vr11","<select name=category>");
$viewrequeststpl->set("vr12","<option value=0>----\n</option>");


$cats = genrelist();
$catdropdown = "";
foreach ($cats as $cat) {
   $catdropdown .= "<option value=\"" . $cat["id"] . "\"";
   $catdropdown .= ">" . htmlspecialchars($cat["name"]) . "</option>\n";
}


$viewrequeststpl->set("vr13",$catdropdown);
$viewrequeststpl->set("vr14","</select>");

$viewrequeststpl->set("vr15","<input type=submit align=center value=Display >\n");
$viewrequeststpl->set("vr16","</form></td></tr></table>");

$viewrequeststpl->set("vr17","<form method=post action=index.php?page=takedelreq>");
$viewrequeststpl->set("vr18","<table width=99% align=center cellspacing=1 class=lista>\n");
$viewrequeststpl->set("vr19","<tr><td class=header align=center>Requests</td><td class=header align=center>Type</td><td class=header align=center width=150>Date Added</td><td class=header align=center>Added By</td><td class=header align=center>Filled</td><td class=header align=center>Filled By</td><td class=header align=center>Votes</td>\n");

if (!$CURUSER || $CURUSER["edit_torrents"]=="yes")
$viewrequeststpl->set("vr20","<td class=header align=center>Delete</td></tr>\n");


for ($i = 0; $i < $num; ++$i)
{



 $arr = mysql_fetch_assoc($res);

$privacylevel = $arr["privacy"];

if ($arr["downloaded"] > 0)
   {
     $ratio = number_format($arr["uploaded"] / $arr["downloaded"], 2);
     //$ratio = "<font color=" . get_ratio_color($ratio) . "><b>$ratio</b></font>";
   }
   else if ($arr["uploaded"] > 0)
       $ratio = "Inf.";
   else
       $ratio = "---";


$res2 = mysql_query("SELECT username from {$TABLE_PREFIX}users where id=" . $arr[filledby]);
$arr2 = mysql_fetch_assoc($res2);  
if ($arr2[username])
$filledby = $arr2[username];
else
$filledby = " ";     

if (!$CURUSER || $CURUSER["delete_torrents"]=="no"){
if (!$CURUSER || $CURUSER["view_users"]=="yes"){
			$addedby = "<td class=lista align=center><center><a href=index.php?page=userdetails&id=$arr[userid]><b>$arr[username] ($ratio)</b></a></td>";
		}else{
			$addedby = "<td class=lista align=center><center><a href=index.php?page=userdetails&id=$arr[userid]><b>$arr[username] (----)</b></a></td>";
		}
}else{
		$addedby = "<td class=lista align=center><center><a href=index.php?page=userdetails&id=$arr[userid]><b>$arr[username] ($ratio)</b></a></td>";
}

$filled = $arr[filled];
if ($filled){
$filled = "<a href=$filled><font color=green><b>Yes</b></font></a>";
$filledbydata = "<a href=index.php?page=userdetails&id=$arr[filledby]><b>$arr2[username]</b></a>";
}
else{
$filled = "<a href=index.php?page=reqdetails&id=$arr[id]><font color=red><b>No</b></font></a>";
$filledbydata  = "<i>nobody</i>";
}

  $req[$ii]["vr21"]=("<tr><td class=lista align=left><a href=index.php?page=reqdetails&id=$arr[id]><b>$arr[request]</b></a></td>" .
 "<td class=lista align=center><center>".image_or_link(($arr['catimg']==''?'':'style/xbtit_default/images/categories/'.$arr[catimg]),' title='.$arr[cat].'',$arr['cat'])."</td><td class=lista align=center><center>" . $arr["added"] . "</td>$addedby<td class=lista align=center><center>$filled</td><td class=lista><center>$filledbydata</td><td class=lista align=center><a href=index.php?page=votesview&requestid=$arr[id]><b><center>$arr[hits]</b></a></td>\n");

if (!$CURUSER || $CURUSER["edit_torrents"]=="yes")
  $req[$ii]["vr22"]=("<td class=lista align=center><center><input type=\"checkbox\" name=\"delreq[]\" value=\"" . $arr[id] . "\" /></td></tr>\n");
  $ii++;
}
$viewrequeststpl->set("req",$req);
$viewrequeststpl->set("vr23","</table>\n");

if (!$CURUSER || $CURUSER["edit_torrents"]=="yes")
$viewrequeststpl->set("vr23","<table width=99%><td align=right><input type=submit value=Go></td></table>");
$viewrequeststpl->set("vr24","</form>");

}else{
       stderr("Offline Message","The request section is offline on the moment");
       stdfoot();
       die;
}
}

?>