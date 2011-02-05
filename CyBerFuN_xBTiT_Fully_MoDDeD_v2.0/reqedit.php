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

$id2 = (int)$_GET["id"];
$res = mysql_query("SELECT * FROM {$TABLE_PREFIX}requests WHERE id=$id2");
$row = mysql_fetch_array($res);

if ($CURUSER["uid"] == $row["userid"] || $CURUSER["edit_torrents"]== "yes")

{

if (!$row)
       die();

block_begin("Edit Request: ".$row["request"]."");

$where = "WHERE userid = ".$CURUSER["id"]."";
$res2 = mysql_query("SELECT * FROM {$TABLE_PREFIX}requests $where") or sqlerr();
$num2 = mysql_num_rows($res2);

$reqedittpl = new bTemplate();
$reqedittpl->set("language",$language);

$reqedittpl->set("re1","<form name=\"edit\" method=post action=index.php?page=takereqedit><a name=edit id=edit></a>");
$reqedittpl->set("re2","<table class=lista align=center width=550 cellspacing=2 cellpadding=0>\n");
$reqedittpl->set("re3","<br><tr><td align=left class=header><b>Torrent File :</b></td> <td class=lista align=left><input type=text size=60 name=requesttitle value=\"" . htmlspecialchars($row["request"]) . "\"></td></tr>");

$reqedittpl->set("re4","<tr><td align=center class=lista><b>Category :</b></td><td align=left class=lista>\n");

$s = "<select name=\"category\">\n";

       $cats = genrelist();
       foreach ($cats as $subrow) {
 $s .= "<option value=\"" . $subrow["id"] . "\"";
 if ($subrow["id"] == $row["cat"])
         $s .= " selected=\"selected\"";
 $s .= ">" . htmlspecialchars($subrow["name"]) . "</option>\n";
       }

       $s .= "</select>\n";
$reqedittpl->set("re5","$s</td></tr>\n");

$reqedittpl->set("re6","<tr><td align=left class=header>Description :</td><td align=left class=lista>");
$reqedittpl->set("re7",(textbbcode("edit","description",unesc($row["descr"]))));

$reqedittpl->set("re8","</td></tr>");
$reqedittpl->set("re9","<input type=\"hidden\" name=\"id\" value=\"$id2\">\n");
$reqedittpl->set("re10","<tr><td colspan=2 align=center class=lista><center><input type=submit value=\"Submit\">\n");
$reqedittpl->set("re11","</form>\n");
$reqedittpl->set("re12","</table>\n");


}

else

      {
      stderr("ERROR","Or you are not authorized , or this is a bug , report it to the site staff please !");
      stdfoot();
      die;
      }

?>