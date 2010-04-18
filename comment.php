<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Comment
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xList.ro/
// Modified By cybernet2u

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


if (!$CURUSER || $CURUSER["uid"] == 1)
   {
   stderr($language["ERROR"], $language["ONLY_REG_COMMENT"]);
}

$comment = ($_POST["comment"]);

$id = $_GET["id"];
if (isset($_GET["cid"]))
    $cid = intval($_GET["cid"]);
else
    $cid = 0;


if (isset($_GET["action"]))
 {
  if ($CURUSER["delete_torrents"] == "yes" && $_GET["action"] == "delete")
    {
     do_sqlquery("DELETE FROM {$TABLE_PREFIX}comments WHERE id=$cid");
     redirect("index.php?page=torrent-details&id=$id#comments");
     exit;
    }
 }

$tpl_comment = new bTemplate();

$tpl_comment->set("language", $language);
$tpl_comment->set("comment_id", $id);
$tpl_comment->set("comment_username", $CURUSER["username"]);
$tpl_comment->set("comment_comment", textbbcode("comment", "comment", htmlspecialchars(unesc($comment))));


if (isset($_POST["info_hash"])) {
   if ($_POST["confirm"] == $language["FRM_CONFIRM"]) {
   $comment = addslashes($_POST["comment"]);
      $user = AddSlashes($CURUSER["username"]);
      if ($user == "") $user = "Anonymous";
global $BASEURL, $SITENAME, $language;

$res1 = mysql_fetch_assoc(mysql_query("SELECT comment_notify, uploader, anonymous FROM {$TABLE_PREFIX}files WHERE info_hash = '$id'")) or sqlerr();
$arr1 = $res1["uploader"];
$res = mysql_fetch_assoc(mysql_query("SELECT email FROM {$TABLE_PREFIX}users WHERE id = '$arr1'")) or sqlerr();
$email = $res["email"];
$comment_email_notify = $res1["comment_notify"];
$sender = $CURUSER['username'];
$senderid = $CURUSER['uid'];
$anonym_check = $res1["anonymous"];
$npmn = $language["NEW_COMMENT_T"];
$npmn2 = $language["BY"];
$npmn4 = $language["BODY"];

$body = <<<EOD
$npmn $npmn2 $sender.

$npmn4:

$comment

$BASEURL/index.php?page=torrent-details&id=$id#comments

------------------------------------------------
$SITENAME
EOD;
	if($comment_email_notify == "true" && $senderid != $arr1 && $anonym_check = "false")
	{ini_set("sendmail_from","");
   if (mysql_errno() == 0)
     {
      send_mail($email, $npmn, $body);
      }
   else
       die(mysql_error());
	}
  do_sqlquery("INSERT INTO {$TABLE_PREFIX}comments (added,text,ori_text,user,info_hash) VALUES (NOW(),\"$comment\",\"$comment\",\"$user\",\"" . mysql_real_escape_string(StripSlashes($_POST["info_hash"])) . "\")", true);
  redirect("index.php?page=torrent-details&id=" . StripSlashes($_POST["info_hash"])."#comments");
  die();
  }

# Comment preview by miskotes
#############################

if ($_POST["confirm"] == $language["FRM_PREVIEW"]) {

$tpl_comment->set("PREVIEW", TRUE, TRUE);
$tpl_comment->set("comment_preview", set_block($language["COMMENT_PREVIEW"], "center", format_comment($comment), false));

#####################
# Comment preview end
}
  else
    {
    redirect("index.php?page=torrent-details&id=" . StripSlashes($_POST["info_hash"])."#comments");
    die();
  }
}
else
    $tpl_comment->set("PREVIEW", FALSE, TRUE);

?>
