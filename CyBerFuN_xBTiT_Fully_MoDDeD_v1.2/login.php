<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Login
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


require_once(load_language("lang_login.php"));
dbconn();
function login() {
 
   global $TABLE_PREFIX, $language, $logintpl;
// Invalid Login System Hack Start
if ($btit_settings["inv_login"] == "true")
 {
    $real_ip = $_SERVER["REMOTE_ADDR"];
    $db_ip = sprintf("%u", ip2long($real_ip));

    $resource = mysql_query("SELECT * FROM {$TABLE_PREFIX}invalid_logins WHERE ip ='".$db_ip."'") or die(mysql_error());
    $result = mysql_fetch_array($resource);

    if (!$result)
      $logins_left = $btit_settings["att_login"];
    else
      $logins_left = $result["remaining"];

    if ($result["remaining"] == "0")
      {
	  //find remaining minutes untill next sanity
	  //current time
	  $now = time("d/m/Y H:i:s");

	  //last sanity
	  $res = mysql_query("SELECT last_time FROM {$TABLE_PREFIX}tasks WHERE task='sanity' ") or mysqlerr();
	  $sanity = mysql_fetch_assoc($res);
	  $last_sanity = $sanity["last_time"];

	  //next sanity
	  $next_sanity = $last_sanity + $GLOBALS["clean_interval"];

	  //minutes untill next sanity
	  $ban_time = ($next_sanity - $now) / 60;

	  $ban = round($ban_time);

	  if ("$ban" >= "2" || "$ban" == "0")
	    $s = "s";
	  elseif ("$ban" == "1")
	    $s = "";

$count=("<tr><td colspan=\"2\"  class=\"header\" align=\"center\">This is your last remaining login attempt.<br>If you fail to login now you'll be banned for <span style=\"color:#FF6666\">".$ban." minute".$s."</td></tr>");
$logintpl->set("count", $count);
      }
 }
// Invalid Login System Hack Stop
    $logintpl->set("language", $language);
    $language["INSERT_USERNAME"] = AddSlashes($language["INSERT_USERNAME"]);
    $language["INSERT_PASSWORD"] = AddSlashes($language["INSERT_PASSWORD"]);

    $login = array();
    $login["action"] = "index.php?page=login&amp;returnto=".urlencode("index.php")."";
    $login["username"] = $user;
// Invalid Login System Hack
if ($btit_settings["inv_login"] == "true")
{
  if ("$logins_left" >= "2" || "$logins_left" == "0")
    $ss = "s";
  elseif ("$logins_left" == "1")
    $ss = "";

$last=("<tr><td colspan=\"2\"  class=\"header\" align=\"center\">You have <span style=\"color:#FF6666\">".$logins_left."</span> remaining login attempt".$ss.".</td></tr>");
$logintpl->set("last",$last);
}
// Invalid Login System Hack stop
    $login["create"] = "index.php?page=signup";
    $login["recover"] = "index.php?page=recover";
    $logintpl->set("login", $login);
}


$logintpl = new bTemplate();


if (!$CURUSER || $CURUSER["uid"] == 1) {


if (isset($_POST["uid"]) && $_POST["uid"])
  $user = $_POST["uid"];
else $user = '';
// Invalid Login System
$ip = $_SERVER["REMOTE_ADDR"];
$attempts = $btit_settings["att_login"];
// Invalid Login System Hack Stop
if (isset($_POST["pwd"]) && $_POST["pwd"])
  $pwd = $_POST["pwd"];
else $pwd = '';

if (isset($_POST["uid"]) && isset($_POST["pwd"]))
  {
    if ($FORUMLINK == "smf")
        $smf_pass = sha1(strtolower($user) . $pwd);
    $res = do_sqlquery("SELECT u.id, u.random, u.password".(($FORUMLINK=="smf") ? ", u.smf_fid, s.passwd, s.passwordSalt" : "")." FROM {$TABLE_PREFIX}users u ".(($FORUMLINK=="smf") ? "LEFT JOIN {$db_prefix}members s ON u.smf_fid=s.ID_MEMBER" : "" )." WHERE u.username ='".AddSlashes($user)."'", true);
    $row = mysql_fetch_array($res);
	// Invalid Login System Hack
    $resource = mysql_query("SELECT * FROM {$TABLE_PREFIX}invalid_logins WHERE ip='".sprintf("%u", ip2long($ip))."'") or die(mysql_error());
    $results = mysql_fetch_array($resource);
    // Invalid Login System Hack Stop

    if (!$row)
        {
          $logintpl->set("FALSE_USER", true, true);
          $logintpl->set("FALSE_PASSWORD", false, true);
		  // Invalid Login System Hack
		if (!$results)
			mysql_query("INSERT INTO {$TABLE_PREFIX}invalid_logins SET ip='".sprintf("%u", ip2long($ip))."', userid='".$row['id']."', username='".$row['username']."', failed=failed+1, remaining=$attempts-1") or die(mysql_error());
		elseif ($results["failed"] < "$attempts")
			mysql_query("UPDATE {$TABLE_PREFIX}invalid_logins SET ip='".sprintf("%u", ip2long($ip))."', failed=failed+1, remaining=$attempts-failed WHERE ip='".sprintf("%u", ip2long($ip))."'") or die(mysql_error());
		elseif ($results["failed"] == "$attempts" && $results["remaining"] == "0")
			{
			$firstip = $ip;
			$lastip = $ip;
			$comment = "max_number_of_invalid_logins_reached";
			$firstip = sprintf("%u", ip2long($firstip));
			$lastip = sprintf("%u", ip2long($lastip));
			$comment = sqlesc($comment);
			$added = sqlesc(time());
			mysql_query("INSERT INTO {$TABLE_PREFIX}bannedip (added, addedby, first, last, comment) VALUES($added, '2', $firstip, $lastip, $comment)") or die(mysql_error());
			mysql_query("DELETE FROM {$TABLE_PREFIX}invalid_logins WHERE ip='".sprintf("%u", ip2long($ip))."' LIMIT 1") or sqlerr();
			}
         // Invalid Login System Hack Stop
          $logintpl->set("login_username_incorrent", $language["ERR_USERNAME_INCORRECT"]);
          login();
        }
    elseif (md5($row["random"].$row["password"].$row["random"]) != md5($row["random"].md5($pwd).$row["random"]))
        {
          $logintpl->set("FALSE_USER", false, true);
          $logintpl->set("FALSE_PASSWORD", true, true);
		  // Invalid Login System Hack Start
		if (!$results)
			mysql_query("INSERT INTO {$TABLE_PREFIX}invalid_logins SET ip='".sprintf("%u", ip2long($ip))."', userid='".$row['id']."', username='".$row['username']."', failed=failed+1, remaining=$attempts-1") or die(mysql_error());
		elseif ($results["failed"] < "$attempts" && $results["remaining"] != "0")
			mysql_query("UPDATE {$TABLE_PREFIX}invalid_logins SET ip='".sprintf("%u", ip2long($ip))."', failed=failed+1, remaining=$attempts-failed WHERE ip='".sprintf("%u", ip2long($ip))."'") or die(mysql_error());
		elseif ($results["failed"] == "$attempts" && $results["remaining"] == "0")
			{
			$firstip = $ip;
			$lastip = $ip;
			$comment = "max_number_of_invalid_logins_reached";
			$firstip = sprintf("%u", ip2long($firstip));
			$lastip = sprintf("%u", ip2long($lastip));
			$comment = sqlesc($comment);
			$added = sqlesc(time());
			mysql_query("INSERT INTO {$TABLE_PREFIX}bannedip (added, addedby, first, last, comment) VALUES($added, '2', $firstip, $lastip, $comment)") or die(mysql_error());
			mysql_query("DELETE FROM {$TABLE_PREFIX}invalid_logins WHERE ip='".sprintf("%u", ip2long($ip))."' LIMIT 1") or sqlerr();
			}
           // Invalid Login System Hack Stop
          $logintpl->set("login_password_incorrent", $language["ERR_PASSWORD_INCORRECT"]);
          login();
        }
    else
      {
       
        logincookie($row["id"],md5($row["random"].$row["password"].$row["random"]));
        if ($FORUMLINK == "smf" && $smf_pass == $row["passwd"])
            set_smf_cookie($row["smf_fid"], $row["passwd"], $row["passwordSalt"]);
        elseif ($FORUMLINK == "smf" && $row["password"] == $row["passwd"])
        {
            $salt=substr(md5(rand()), 0, 4);
            @mysql_query("UPDATE {$db_prefix}members SET passwd='$smf_pass', passwordSalt='$salt' WHERE ID_MEMBER=".$row["smf_fid"]);
            set_smf_cookie($row["smf_fid"], $smf_pass, $salt);
        }
        if (isset($_GET["returnto"]))
           $url = urldecode($_GET["returnto"]);
        else
            $url = "index.php";
			// Invalid Login System Hack Start
            mysql_query("DELETE FROM {$TABLE_PREFIX}invalid_logins WHERE ip='".sprintf("%u", ip2long($ip))."' LIMIT 1") or sqlerr();
            // Invalid Login System Hack Stop
        redirect($url);
        die();
      }
  }

else
  {
    $logintpl->set("FALSE_USER", false, true);
    $logintpl->set("FALSE_PASSWORD", false, true);
    login();
  }






}
else {

  if (isset($_GET["returnto"]))
     $url = urldecode($_GET["returnto"]);
  else
      $url = "index.php";
  redirect($url);
  die();
}
?>
