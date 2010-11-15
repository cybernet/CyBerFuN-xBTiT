<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2009  Btiteam
//
//  converted from BTI to XBTIT by DiemThuy - Feb 2008
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

ob_start();

if (!$CURUSER || $CURUSER["view_torrents"] == "no")
   {
    err_msg(ERROR.NOT_AUTHORIZED." ",SORRY."...");
    stdfoot();
    exit();
   }
else
    {
function round_time($ts)
{
    $mins = floor($ts / 60);
  $hours = floor($mins / 60);
  $mins -= $hours * 60;
  $days = floor($hours / 24);
  $hours -= $days * 24;
  $weeks = floor($days / 7);
  $days -= $weeks * 7;
  $t = "";
  if ($weeks > 0)
    return "$weeks week" . ($weeks > 1 ? "s" : "");
  if ($days > 0)
    return "$days day" . ($days > 1 ? "s" : "");
  if ($hours > 0)
    return "$hours hour" . ($hours > 1 ? "s" : "");
  if ($mins > 0)
    return "$mins min" . ($mins > 1 ? "s" : "");
  return "< 1 min";
}

$msg_problem = trim($_POST["msg_problem"]);
$msg_answer = trim($_POST["msg_answer"]);
$id = $_POST["id"];
$addedbyid = $_POST["addedbyid"];
$title = trim($_POST["title"]);

$action = $_GET["action"];
$solve = $_GET["solve"];

// --- action: cleanuphd
if ($action == 'cleanuphd') {
    mysql_query("DELETE FROM {$TABLE_PREFIX}helpdesk WHERE solved='yes' OR solved='ignored'");
    $action = 'problems';
}
// --- action: problems

if ($action == 'problems') {

if (!$CURUSER || $CURUSER["id_level"] < 6) // 6 is default id_level for moderators
{
  err_msg("Sorry...", "You are not authorized to view this.");
  stdfoot();
  die;
}

// Standard HD Replies
// English
$hd_reply['1'] = array("Read the FAQ","First read the [b]FAQ[/b] and then start asking questions!");
$hd_reply['2'] = array("Search forums","Search the [b]FORUMS[/b] please.");
$hd_reply['3'] = array("Die n00b","Die n00b! Such a thing knows even my grandma!");

// POST & GET
$id = $_GET["id"];
$hd_answer=$_POST["hd_answer"];
if ($hd_answer) {
		$body = $hd_reply[$hd_answer][1];
 }

//block_begin("Problems");

// VIEW PROBLEM DETAILS
if ($id != 0) {

$res = mysql_query("SELECT * FROM {$TABLE_PREFIX}helpdesk WHERE id='$id'");
$arr = mysql_fetch_array($res);

$zap = mysql_query("SELECT username FROM {$TABLE_PREFIX}users WHERE id='$arr[added_by]'");
$wyn = mysql_fetch_array($zap);

$added_by_name = $wyn["username"];

$zap_s = mysql_query("SELECT username FROM {$TABLE_PREFIX}users WHERE id='$arr[solved_by]'");
$wyn_s = mysql_fetch_array($zap_s);

$solved_by_name = $wyn_s["username"];

print("<table align=center border=1 cellpadding=5 cellspacing=0>".
      "<tr><td align=center colspan=2 class=colhead>".$arr["title"]."</td></tr>".
      "<tr><td align=right><b>Added</b></td><td align=left>On&nbsp;<b>".get_date_time($arr["added"])."</b>&nbsp;by&nbsp;<a href=index.php?page=userdetails&id=".$arr["added_by"]."><b>".$added_by_name."</b></a></td></tr>");


if ($arr["solved"] == 'yes') {

  print("<tr><td align=right><b>Problem</b></td><td align=left><textarea name=msg_problem cols=60 rows=10>".$arr["msg_problem"]."</textarea></td></tr>".
        "<tr><td align=right><b>Solved</b></td><td align=left><font color=green><b>Yes</b></font>&nbsp;on&nbsp;<b>".get_date_time($arr["solved_date"])."</b>&nbsp;by&nbsp;<a href=index.php?page=userdetails&id=".$arr["solved_by"]."><b>".$solved_by_name."</b></a></td></tr>".
        "<tr><td align=right><b>Answer</b></td><td align=left><textarea name=msg_answer cols=60 rows=10>".$arr["msg_answer"]."</textarea></td></tr>".
        "<tr><td align=center colspan=2 class=colhead><a href=\"javascript: history.go(-1);\">back</a></td></tr></table>");
 }
else if ($arr["solved"] == 'ignored') {

  print("<tr><td align=right><b>Problem</b></td><td align=left><textarea name=msg_problem cols=60 rows=10>".$arr["msg_problem"]."</textarea></td></tr>".
        "<tr><td align=right><b>Solved</b></td><td align=left><font color=orange><b>Ignored</b></font>&nbsp;on&nbsp;<b>".get_date_time($arr["solved_date"])."</b>&nbsp;by&nbsp;<a href=index.php?page=userdetails&id=".$arr["solved_by"]."><b>".$solved_by_name."</b></a></td></tr>".
       "<tr><td align=center colspan=2 class=colhead><a href=\"javascript: history.go(-1);\">back</a></td></tr></table>");

}
else if ($arr["solved"] == 'no') {

$addedbyid = $arr["added_by"];

print("<form method=post action=index.php?page=modules&amp;module=helpdesk><tr><td><tr><td align=right><b>Problem</b></td><td align=left><textarea name=msg_problem cols=60 rows=10>".$arr["msg_problem"]."</textarea></td></tr>".
      "<tr><td align=right><b>Solved</b></td><td align=center><font color=red><b>No</b></font>".
      "<tr><td align=right><b>Answer</b></td><td><textarea name=msg_answer cols=60 rows=10>$body</textarea><br/>[<b>BB tags</b> are <b>allowed</b>]<input type=hidden name=id value=$id><input type=hidden name=addedbyid value=$addedbyid></td></tr>".
      "<tr><td colspan=2 align=center><input type=submit value=Answer! class=btn> <b>||</b> <a href=index.php?page=modules&amp;module=helpdesk&action=solve&pid=$id&solved=ignored><font color=red><b>IGNORE</b></font></a></td></tr>".
      "<tr><td align=center colspan=2 class=colhead><a href=\"javascript: history.go(-1);\">back</a></td></tr></form></table>");
}
}


// VIEW PROBLEMS


else {


print("<br><table align=center border=1 cellpadding=5 cellspacing=0>"
     ."<tr><td class=colhead align=center>Added</td>"
	 ."<td class=colhead align=center>Added by</td>"
	 ."<td class=colhead align=center>Problem</td>"
	 ."<td class=colhead align=center>Solved - by</td>"
	 ."<td class=colhead align=center>Solved in [ xx ]</td></tr>");

$res = mysql_query("SELECT * FROM {$TABLE_PREFIX}helpdesk ORDER BY added DESC");
while($arr = mysql_fetch_array($res)) {

$zap = mysql_query("SELECT username FROM {$TABLE_PREFIX}users WHERE id = $arr[added_by]");
$wyn = mysql_fetch_array($zap);

$added_by_name = $wyn["username"];

$zap_s = mysql_query("SELECT username FROM {$TABLE_PREFIX}users WHERE id = $arr[solved_by]");
$wyn_s = mysql_fetch_array($zap_s);

$solved_by_name = $wyn_s["username"];

// SOLVED IN
$added = $arr["added"];
$solved_date = $arr["solved_date"];

if ($solved_date == "0") {
  $solved_in = "&nbsp;[N/A]";
  $solved_color = "black";
  }
else
{
  $solved_in_wtf = $arr["solved_date"] - $arr["added"];
  $solved_in = "&nbsp;[".round_time($solved_in_wtf)."]";

  if ($solved_in_wtf > 2*3600) {
    $solved_color = "red";
  }
  else if ($solved_in_wtf > 3600) {
    $solved_color = "black";
  }
  else if ($solved_in_wtf <= 1800) {
    $solved_color = "green";
  }
}


  print("<tr><td>".get_date_time($arr["added"])."</td>".
        "<td><a href=index.php?page=userdetails&id=".$arr["added_by"].">".$added_by_name."</a></td>".
        "<td><a href=index.php?page=modules&amp;module=helpdesk&action=problems&id=".$arr["id"]."><b>".$arr["title"]."</b></a></td>");

        if ($arr["solved"] == 'no') {
          $solved_by = "N/A";
          print("<td><font color=red><b>No</b></font>&nbsp;-&nbsp;".$solved_by."</td>");
        }
        else if ($arr["solved"] == 'yes') {
          $solved_by = "<a href=index.php?page=userdetails&id=".$arr["solved_by"].">".$solved_by_name."</a>";
          print("<td><font color=green><b>Yes</b></font>&nbsp;-&nbsp;".$solved_by."</td>");
        }
        else if ($arr["solved"] == 'ignored') {
          $solved_by = "<a href=index.php?page=userdetails&id=".$arr["solved_by"].">".$solved_by_name."</a>";
          print("<td><font color=orange><b>Ignored</b></font>&nbsp;-&nbsp;".$solved_by."</td>");
        }

  print("<td><font color=".$solved_color.">".$solved_in."</font></td></tr>");

}

print("<tr><td align=center class=colhead colspan=5><form method=post action=index.php?page=modules&module=helpdesk&action=cleanuphd><input type=submit value='Delete solved and/or ignored problems' style='height:20;align:center;'></form></tr></table>");
print("<br><br>".
      "<center><font color=green>[ xx ]</font> - Solved Fast ".
      "<font color=black>[ xx ]</font> - Solved in Time ".
      "<font color=red>[ xx ]</font> - Solved to Late </center>");
}

//block_end();

if ($arr["solved"] == 'no') {


  	print("<br><br>".
  	      "<form method=post action=index.php?page=modules&amp;module=helpdesk&action=problems&id=$id>");
  	?>
	  <table align="center"  border="1" cellspacing="0" cellpadding="5">
	  <tr><td>
	  <b>Standard Replies:</b>
	  <select name="hd_answer"><?
	  for ($i = 1; $i <= count($hd_reply); $i++)
	  {
	    echo "<option value=$i ".($hd_answer == $i?"selected":"").
	      ">".$hd_reply[$i][0]."</option>\n";
	  }?>
	  </select>
	  <input type="submit" value="Use" class="btn">
	  </td></tr></table></form>
	<?php

}

//stdfoot();
//die;

}

// Main FILE

//block_begin("Helpdesk");

if ($action == 'solve') {

  $pid = $_GET["pid"];

  if ($solve = 'ignored') {

    mysql_query("UPDATE {$TABLE_PREFIX}helpdesk SET solved='ignored', solved_by=$CURUSER[uid], solved_date = UNIX_TIMESTAMP() WHERE id=$pid");

  }
}

if (($msg_answer != "") && ($id != 0)){

$zap_usr = mysql_query("SELECT username FROM {$TABLE_PREFIX}users WHERE id = $addedbyid");
$wyn_usr = mysql_fetch_array($zap_usr);
$addedby_name = $wyn_usr["username"];
$ans_usr = mysql_query("SELECT username FROM {$TABLE_PREFIX}users WHERE id = $CURUSER[uid]");
$wan_usr = mysql_fetch_array($ans_usr);
$sendby_name = $wan_usr["username"];

$msg = sqlesc("[color=red][b]From the $SITENAME HELPDESK [/b][/color]\n\n[quote=".$addedby_name."]".$msg_problem."[/quote]\n".$msg_answer."\n\nregards $SITENAME staff member $sendby_name");

mysql_query("UPDATE {$TABLE_PREFIX}helpdesk SET solved='yes', solved_by=$CURUSER[uid], solved_date = UNIX_TIMESTAMP(), msg_answer = ".sqlesc($msg_answer)." WHERE id=$id");
// PM function SMF & Int PM system XBTIT
send_pm($CURUSER[uid],$addedbyid,sqlesc('Helpdesk'), $msg );

// need a historie - 2

}

if (($msg_problem != "") && ($title != "")){

do_sqlquery("INSERT INTO {$TABLE_PREFIX}helpdesk (title, msg_problem, added, added_by) VALUES (".sqlesc($title).", ".sqlesc($msg_problem).", UNIX_TIMESTAMP(),  $CURUSER[uid])",true);

// mysql_query("INSERT INTO helpdesk (added) VALUES ($dt)") or sqlerr();

  err_msg("Help desk", "Message sent! Await for reply.");
  block_end();
  stdfoot();
  die;
}

// ----- MAIN HELP DESK ---------

if (!$CURUSER || $CURUSER["id_level"] >= 6) // 6 is default id_level for moderators
{
$st_usr = mysql_query("SELECT username FROM {$TABLE_PREFIX}users WHERE id = $CURUSER[uid]");
$sta_usr = mysql_fetch_array($st_usr);
$staff_name = $sta_usr["username"];

$countt = get_result("SELECT * FROM {$TABLE_PREFIX}helpdesk WHERE solved='no'");
$count = count($countt);

print("<center><a href=index.php?page=modules&amp;module=helpdesk&action=problems><h1><br><font color=blue>welcome staff member ".$staff_name." there are </font><font color=red>".$count." </font><font color=blue>unanswered questions waiting</font></h1></a></center>");
}
?>
<!-- ENGLISH -->
<br><center><h1><font color=purple><?php print($SITENAME) ?> HELPDESK</h1></font></center>
<center><font color=red size=2>Here you can ask your questions and post your problems , but before using the <b>Helpdesk</b> check of your question is already answered in the <a href=index.php?page=forum><b>Forum</b></a> first.</font><br/></center>

<br/>

<form method="post" action="index.php?page=modules&amp;module=helpdesk">
<table border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="right">&nbsp;<b>Title:</b></td>
    <td align="left"><input type="text" size="60" maxlength="50" name="title"></td>
  </tr>

  <tr>
    <td colspan="2"><textarea name="msg_problem" cols="60" rows="10"></textarea>
    [<b>BB tags</b> are <b>allowed</b>]
  </tr>
  <tr>
    <td align="center" colspan="2"><input type="submit" value="Help me!" class="btn"></td>
  </tr>
</table>
</form>
<?php

}

global $module_out;
$module_out = ob_get_contents();
ob_end_clean();
?>
