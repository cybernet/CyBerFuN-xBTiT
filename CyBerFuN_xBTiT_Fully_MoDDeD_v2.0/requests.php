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

 if ($CURUSER["id_level"] < $btit_settings["req_post"])
   {
       stderr("Error", "Sorry , but your rank is to low to post Requests");
       stdfoot();
       die;
   }
else
    {


$requeststpl = new bTemplate();
$requeststpl->set("language",$language);

$requeststpl->set("r1","<br>\n");

$where = "WHERE userid = " . $CURUSER["uid"] . "";
$res2 = mysql_query("SELECT * FROM {$TABLE_PREFIX}requests $where") or sqlerr();
$num2 = mysql_num_rows($res2);

$requeststpl->set("r2","<table border=0 width=100% cellspacing=0 cellpadding=3>");
$requeststpl->set("r3","<tr><td class=colhead align=center>Search if the torrent allready exists before adding a request</td></tr>");
$requeststpl->set("r4","<tr><td align=center><form method=get action=index.php><input type=hidden name=page value=torrents />");
$requeststpl->set("r5","<input type=text name=search size=40 value=$searchstr>");
$requeststpl->set("r6","in");
$requeststpl->set("r7","<select name=category>");
$requeststpl->set("r8","<option value=0>(all)</option>");



$cats = genrelist();
$catdropdown = "";
foreach ($cats as $cat) {
   $catdropdown .= "<option value=\"" . $cat["id"] . "\"";
   if ($cat["id"] == $_GET["cat"])
       $catdropdown .= " selected=\"selected\"";
   $catdropdown .= ">" . htmlspecialchars($cat["name"]) . "</option>\n";
}

$deadchkbox = "<input type=\"checkbox\" name=\"active\" value=\"0\"";
if ($_GET["active"])
   $deadchkbox .= " checked=\"checked\"";
$deadchkbox .= " />Including Dead Torrents\n";


$requeststpl->set("r9",$catdropdown);
$requeststpl->set("r10","</select>");
$requeststpl->set("r11",$deadchkbox);
$requeststpl->set("r12","<input type=submit value=SEARCH>");
$requeststpl->set("r13","</form>");
$requeststpl->set("r14","</td></tr></table><BR><HR><BR>");

$requeststpl->set("r15","<br>\n");

$requeststpl->set("r16","<table class=lista align='center' width='550' cellspacing=2><form name=request method=post action=index.php?page=takerequest><a name=add id=add></a>");
$requeststpl->set("r17","<tr><td class=header align=center width=100% colspan=\"2\">Add a new Request</td></tr>");
$requeststpl->set("r18","<tr><td class=header align=left width=30%>Torrent File</td><td class=lista align=left width=70%><input type=text size=40 name=requesttitle></td></tr>");
$requeststpl->set("r19","<tr><td class=header align=left width=30%>Category</td><td class=lista align=left width=70%>");


$requeststpl->set("r20","<select name=category>");
$requeststpl->set("r21","<option value=0>(Select Category)</option>");


$res2 = mysql_query("SELECT id, name FROM {$TABLE_PREFIX}categories  order by name");
$num = mysql_num_rows($res2);
$catdropdown2 = "";
for ($i = 0; $i < $num; ++$i)
   {
 $cats2 = mysql_fetch_assoc($res2);  
     $catdropdown2 .= "<option value=\"" . $cats2["id"] . "\"";
     $catdropdown2 .= ">" . htmlspecialchars($cats2["name"]) . "</option>\n";
   }

$requeststpl->set("r22",$catdropdown2 );
$requeststpl->set("r23","</select>");

$requeststpl->set("r23","<br>\n");

$requeststpl->set("r24","<tr><td class=header align=left width=30%>Description</td><td class=lista align=left width=70%>");
$requeststpl->set("r25",(textbbcode("request","description")));
$requeststpl->set("r26","</td></tr>");
$requeststpl->set("r27","<tr><td class=lista align=center width=100% colspan=\"2\"><center><input type=submit value=Confirm></td></tr>");
$requeststpl->set("r28","</form>\n");
$requeststpl->set("r29","</table></CENTER>\n");
}

?>