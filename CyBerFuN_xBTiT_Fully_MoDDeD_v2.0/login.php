<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2011  Btiteam
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
// Invalid Login System
dbconn();
// Invalid Login System - end
function xbtit_login() {
 
   global $TABLE_PREFIX, $language, $logintpl, $btit_settings;
// Invalid Login System Hack
if ($btit_settings["inv_login"]=="true")
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
	  $next_sanity = $last_sanity+$GLOBALS["clean_interval"];

	  //minutes untill next sanity
	  $ban_time = ($next_sanity-$now)/60;

	  $ban = round($ban_time);

	  if ("$ban" >= "2" || "$ban" == "0")
	    $s="s";
	  elseif ("$ban" == "1")
	    $s="";

$count = ("<tr><td colspan=\"2\"  class=\"header\" align=\"center\">This is your last remaining login attempt.<br>If you fail to login now you'll be banned for <span style=\"color:#FF6666\">".$ban." minute".$s."</td></tr>");
$logintpl->set("count",$count);
      }
 }
// Invalid Login System Hack Stop
    $logintpl->set("language",$language);
    $language["INSERT_USERNAME"]=AddSlashes($language["INSERT_USERNAME"]);
    $language["INSERT_PASSWORD"]=AddSlashes($language["INSERT_PASSWORD"]);

    $login=array();
    $login["action"]="index.php?page=login&amp;returnto=".urlencode("index.php")."";
    $login["username"]=$user;
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
    $login["create"]="index.php?page=signup";
    $login["recover"]="index.php?page=recover";
    $logintpl->set("login",$login);
}


$logintpl=new bTemplate();


if (!$CURUSER || $CURUSER["uid"]==1)
{

if (isset($_POST["uid"]) && $_POST["uid"])
  $user = $_POST["uid"];
else 
	$user="";
if (isset($_POST["pwd"]) && $_POST["pwd"])
  $pwd=$_POST["pwd"];
else 
	$pwd="";
// Invalid Login System
$ip = $_SERVER["REMOTE_ADDR"];
$attempts = $btit_settings["att_login"];
// Invalid Login System Hack Stop
if (isset($_POST["uid"]) && isset($_POST["pwd"]))
  {
    if (substr($FORUMLINK,0,3)=="smf")
        $smf_pass = sha1(strtolower($user) . $pwd);
        $res = do_sqlquery("SELECT `u`.`salt`, `u`.`pass_type`, `u`.`username`, `u`.`id`, `u`.`random`, `u`.`password`".((substr($FORUMLINK,0,3)=="smf") ? ", `u`.`smf_fid`, `s`.`passwd`":(($FORUMLINK=="ipb")?", `u`.`ipb_fid`, `i`.`members_pass_hash`, `i`.`members_pass_salt`, `i`.`name`, `i`.`member_group_id`":""))." FROM `{$TABLE_PREFIX}users` `u` ".((substr($FORUMLINK,0,3)=="smf") ? "LEFT JOIN `{$db_prefix}members` `s` ON `u`.`smf_fid`=`s`.".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")."":(($FORUMLINK=="ipb")?"LEFT JOIN `{$ipb_prefix}members` `i` ON `u`.`ipb_fid`=`i`.`member_id`":""))." WHERE `u`.`username` ='".AddSlashes($user)."'", true);
        $row = mysql_fetch_assoc($res);
// Invalid Login System Hack
    $resource = mysql_query("SELECT * FROM {$TABLE_PREFIX}invalid_logins WHERE ip='".sprintf("%u", ip2long($ip))."'") or die(mysql_error());
    $results = mysql_fetch_array($resource);
//Invalid Login System Hack Stop

        if (!$row)
        {
            $logintpl->set("FALSE_USER",true,true);
            $logintpl->set("FALSE_PASSWORD",false,true);
// Invalid Login System Hack
		if (!$results)
			mysql_query("INSERT INTO {$TABLE_PREFIX}invalid_logins SET ip='".sprintf("%u", ip2long($ip))."', userid='".$row['id']."', username='".AddSlashes($user)."', failed=failed+1, remaining=$attempts-1") or die(mysql_error());
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
            $logintpl->set("login_username_incorrect",$language["ERR_USERNAME_INCORRECT"]);
           xbtit_login();
        }
        else
        {
            $passtype=hash_generate($row, $pwd, $user);
            if($row["password"]==$passtype[$row["pass_type"]]["hash"])
            {
                // We have a correct password entry
                
                // If stored password type is not the same as the current set type
                if($row["pass_type"]!=$btit_settings["secsui_pass_type"])
                {
                    // We need to update the password
                    do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `password`='".mysql_real_escape_string($passtype[$btit_settings["secsui_pass_type"]]["rehash"])."', `salt`='".mysql_real_escape_string($passtype[$btit_settings["secsui_pass_type"]]["salt"])."', `pass_type`='".mysql_real_escape_string($btit_settings["secsui_pass_type"])."', `dupe_hash`='".mysql_real_escape_string($passtype[$btit_settings["secsui_pass_type"]]["dupehash"])."' WHERE `id`=".$row["id"],true);
                    // And update the values we got from the database earlier
                    $row["pass_type"]=$btit_settings["secsui_pass_type"];
                    $row["password"]=$passtype[$btit_settings["secsui_pass_type"]]["rehash"];
                    $row["salt"]=$passtype[$btit_settings["secsui_pass_type"]]["salt"];
                }
                // If we've reached this point we can set the cookies
                
                // call the logoutcookie function for good measure, just in case we have some old cookies that need destroying.
                logoutcookie();
                // Then login
                logincookie($row, $user);
                 if (substr($FORUMLINK,0,3)=="smf" && $smf_pass==$row["passwd"])
                {
                    $new_smf_salt=substr(md5(rand()), 0, 4);
                    do_sqlquery("UPDATE `{$db_prefix}members` SET ".(($FORUMLINK=="smf")?"`passwordSalt`":"`password_salt`")."='".$new_smf_salt."' WHERE ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")."=".$row["smf_fid"],true);
                    set_smf_cookie($row["smf_fid"], $row["passwd"], $new_smf_salt);
                }
                elseif (substr($FORUMLINK,0,3)=="smf" && $row["pass_type"]==1 && $row["password"]==$row["passwd"])
                {
                    $salt=substr(md5(rand()), 0, 4);
                    do_sqlquery("UPDATE `{$db_prefix}members` SET `passwd`='$smf_pass', ".(($FORUMLINK=="smf")?"`passwordSalt`='$salt' WHERE `ID_MEMBER`":"`password_salt`='$salt' WHERE `id_member`")."=".$row["smf_fid"]);
                    set_smf_cookie($row["smf_fid"], $smf_pass, $salt);
                }
                elseif (substr($FORUMLINK,0,3)=="smf" && $row["passwd"]=="ffffffffffffffffffffffffffffffffffffffff")
                {
                    $fix_pass=smf_passgen($user, $pwd);
                    do_sqlquery("UPDATE `{$db_prefix}members` SET `passwd`='".$fix_pass[0]."', ".(($FORUMLINK=="smf")?"`passwordSalt`='".$fix_pass[1]."' WHERE `ID_MEMBER`":"`password_salt`='".$fix_pass[1]."' WHERE `id_member`")."=".$row["smf_fid"]);
                    set_smf_cookie($row["smf_fid"], $fix_pass[0], $fix_pass[1]);
                }
		elseif($FORUMLINK=="ipb")
                {

                    if(!isset($THIS_BASEPATH) || empty($THIS_BASEPATH))
                        $THIS_BASEPATH=dirname(__FILE__);
                    require_once($THIS_BASEPATH. '/ipb/initdata.php' );
                    require_once( IPS_ROOT_PATH . 'sources/base/ipsRegistry.php' );
                    require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );
                    $registry = ipsRegistry::instance(); 
                    $registry->init();
        
                    $password=IPSText::parseCleanValue(urldecode(trim($pwd)));
                    $hash=md5(md5($row["members_pass_salt"]).md5($password));
                    $salt=pass_the_salt(5);
                    $rehash=$hash=md5(md5($salt).md5($password));

                    if ($ipbhash[0]==$row["members_pass_hash"])
                        set_ipb_cookie($row["ipb_fid"], $row["name"], $row["member_group_id"]);
                    elseif ($row["members_pass_hash"]=="ffffffffffffffffffffffffffffffff")
                    {
                        IPSMember::save($row["ipb_fid"], array("members" => array("member_login_key" => "", "member_login_key_expire" => "0", "members_pass_hash" => "$rehash", "members_pass_salt" => "$salt")));
                        set_ipb_cookie($row["ipb_fid"], $row["name"], $row["member_group_id"]);
                    }
                }
                if (isset($_GET["returnto"]))
                    $url=urldecode($_GET["returnto"]);
                else
                    $url="index.php";
                redirect($url);
                die();
            }
            else
            {
                // We have a bad password entry
                $logintpl->set("FALSE_USER",false,true);
                $logintpl->set("FALSE_PASSWORD",true,true);
// Invalid Login System Hack Start
		if (!$results)
			mysql_query("INSERT INTO {$TABLE_PREFIX}invalid_logins SET ip='".sprintf("%u", ip2long($ip))."', userid='".$row['id']."', username='".AddSlashes($user)."', failed=failed+1, remaining=$attempts-1") or die(mysql_error());
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
                $logintpl->set("login_password_incorrect",$language["ERR_PASSWORD_INCORRECT"]);
                xbtit_login();
            }
        }
    }
    else
    {
        $logintpl->set("FALSE_USER",false,true);
        $logintpl->set("FALSE_PASSWORD",false,true);
        xbtit_login();
    }
}
else
{
    if (isset($_GET["returnto"]))
        $url=urldecode($_GET["returnto"]);
    else
        $url="index.php";
// Invalid Login System Hack
	mysql_query("DELETE FROM {$TABLE_PREFIX}invalid_logins WHERE ip='".sprintf("%u", ip2long($ip))."' LIMIT 1") or sqlerr();
//Invalid Login System Hack Stop
    redirect($url);
    die();
}
?>
