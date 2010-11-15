<?php

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

if (!$INVITATIONSON)
    stderr($language["ERROR"], $language["ERR_INVITATIONS_OFF"]);

if (isset($_GET["action"]))
    $do = $_GET["action"];
else
    $action = "";

$id = 0 + $_GET["uid"];

$usercptpl->set("new_invitation", false, true);
$usercptpl->set("to_confirm", false, true);
$usercptpl->set("invs_sent", false, true);
$scriptname = htmlspecialchars($_SERVER["PHP_SELF"] .
    "?page=usercp&do=invite&action=read&uid=" . $CURUSER["uid"]);

switch ($action)
{
        //if inviter confirmation is defined and
        //inviter confirms invitee registration
    case 'confirm':

        if (isset($_POST[conusr]))
        {
            $res = do_sqlquery("SELECT id, email FROM {$TABLE_PREFIX}users WHERE id_level='2' AND id IN (" .
                implode(", ", $_POST["conusr"]) . ")", true);
            while ($arr = mysql_fetch_assoc($res))
            {
                do_sqlquery("UPDATE {$TABLE_PREFIX}users SET id_level='3' WHERE id=" . $arr["id"] .
                    "", true);
                do_sqlquery("UPDATE {$TABLE_PREFIX}invitations SET confirmed='true' WHERE hash='" .
                    $arr["id"] . "'");
                $email = $arr["email"];

                mail($email, "$SITENAME " . $language["ACCOUNT_CONFIRMED"] . "", $language["INVIT_MSGCONFIRM"],
                    "From: $SITENAME <$SITEEMAIL>");
            }
            if (!$res)
                die("ERROR: " . mysql_error() . "\n");
            else
            {
                if ($FORUMLINK == "smf")
                {
                    $get = mysql_fetch_assoc(mysql_query("SELECT smf_fid FROM {$TABLE_PREFIX}users WHERE id_level=13 AND random=$random2"));
                    do_sqlquery("UPDATE {$db_prefix}members SET ID_GROUP=13 WHERE ID_MEMBER=" . $arr["id"]);
                }
            }
        }
        else
        {
            stderr($language["ERROR"], $language["ERR_MISSING_DATA"]);
        }
        redirect("index.php?page=usercp&do=invite&action=read&uid=" . $id . "");
        break;

        //let's send the invitation
    case 'send':
		
		$id = 0 + $_GET["uid"];
        $hash = $_POST["hash"];
        $invitername = $_POST["invitername"];
        $email = mysql_real_escape_string($_POST["email"]);
        $body = mysql_real_escape_string($_POST["body"]);

        if (!$email)
            stderr($language["ERROR"], $language["INSERT_EMAIL"]);

        if (!$body)
            stderr($language["ERROR"], $language["INSERT_MESSAGE"]);

        $a = (mysql_fetch_row(@do_sqlquery("SELECT COUNT(*) FROM `{$TABLE_PREFIX}users` WHERE email='" .
            $email."'", true)));
        if ($a[0] != 0)
            stderr($language["ERROR"], "($email)<br>" . $language["ERR_EMAIL_ALREADY_EXISTS"]);

        send_mail($email, $SITENAME . " " . $language["INVIT_CONFIRM"] . "", $language["INVIT_MSG"] .
            " " . $invitername . "." . $language["INVIT_MSG1"] . "<a href=" . $BASEURL .
            "/index.php?page=signup&act=invite&invitationnumber=" . $hash . ">" . $BASEURL .
            "/index.php?page=signup&act=invite&invitationnumber=" . $hash . "</a>" . $language["INVIT_MSG2"] .
            " " . $invitername . ":<br>" . $body . "<br><br>" . $language["INVIT_MSG3"],
            "From: $SITENAME <$SITEEMAIL>");

        do_sqlquery("INSERT INTO `{$TABLE_PREFIX}invitations` (inviter, invitee, hash, time_invited, confirmed) VALUES ('$id', '$email', '$hash', NOW(), 'false')", true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `invitations` = invitations - 1 WHERE id = '" .
            $id . "'", true);

        redirect("index.php?page=usercp&do=invite&action=read&uid=$id");
        break;

        //If user wants to send a new invitation
    case 'new':

        $usercptpl->set("read_invitations", false, true);
        $usercptpl->set("new_invitation", true, true);
        $usercptpl->set("frm2_target",
            "index.php?page=usercp&amp;do=invite&amp;action=send&amp;uid=" . $id);
        $res = do_sqlquery("SELECT invitations FROM {$TABLE_PREFIX}users WHERE id = '" .
            $id . "'", true);
        $inv = mysql_fetch_assoc($res);
        $hash = md5(mt_rand(1, 10000));
        $invitername = $CURUSER["username"];
        $usercptpl->set("inv_someone", $language["INVITATIONS"] . ": " . $inv["invitations"]);

        if ($inv["invitations"] > 0)
        {
            $usercptpl->set("inv_hash", $hash);
            $usercptpl->set("invitername", $CURUSER["username"]);
        }
        break;

        //Display the invitees, if any...
    case '':
    case 'read':
    default:

        $id = 0 + $_GET["uid"];
        $usercptpl->set("read_invitations", true, true);

        $res = get_result("SELECT COUNT(*) as invite_num FROM {$TABLE_PREFIX}invitations WHERE inviter=" .
            $id, true);
        $count = $res[0]["invite_num"];

        if ($count > 0)
        {
            $usercptpl->set("invs_sent", true, true);
            $usercptpl->set("sent_inv", $count);
            $tobe_users = array();
            $i = 0;
            //All sent invitations
            $results = get_result("SELECT * FROM `{$TABLE_PREFIX}invitations` WHERE `inviter`='" .
                $id . "' ORDER BY id DESC", true);

            foreach ($results as $id => $data2)
            {
                $tobe_users[$i]["invitee"] = $data2["invitee"];
                $tobe_users[$i]["infohash"] = $data2["hash"];
                $tobe_users[$i]["send_date"] = $data2["time_invited"];
                if ($data2["confirmed"] == "true")
                    $data2["confirmed"] = "<font color=\"green\">" . $data2["confirmed"] . "</font>";
                else
                    $data2["confirmed"] = "<font color=\"red\">" . $data2["confirmed"] . "</font>";
                $tobe_users[$i]["confirmed"] = $data2["confirmed"];
                $i++;
            }
            $usercptpl->set("tobe_users", $tobe_users);
            unset($tobe_users);
        }

        $id = 0 + $_GET["uid"];

        $res = do_sqlquery("SELECT invitations FROM {$TABLE_PREFIX}users WHERE id=" . $id, true);
        @$inv = mysql_fetch_assoc($res);
        if ($inv["invitations"] > 0)
            $usercptpl->set("sendnew_inv", "<a href=\"index.php?page=usercp&amp;do=invite&amp;action=new&amp;uid=$id\"><input type=\"button\" value=\"" .
                $language["INVITE_SOMEONE_TO"] . " (" . $inv["invitations"] . " " . $language["REMAINING"] .
                ")\" onclick=\"document.location.href('index.php?page=usercp&amp;do=invite&amp;action=new&amp;uid=$id');\" ></a>");
        else
            $usercptpl->set("sendnew_inv", "<input type=\"button\" value=\"" . $language["NO_INV"] .
                "\" disabled=\"true\">");

        //        Let's display the list of users which
        //        have accepted an invitation and are registered...
        //        something like a buddy list ;)
        $res = get_result("SELECT COUNT(*) as num_members FROM {$TABLE_PREFIX}users WHERE invited_by=" .
            $id, true);
        $count = $res[0]["num_members"];
        list($pagertop, $pagerbottom, $limit) = pager('15', $count, $scriptname .
            "&amp;");

        $usercptpl->set("inv_pagertop", $pagertop);
        $usercptpl->set("inv_pagerbottom", $pagerbottom);

        $results = get_result("SELECT id, username, uploaded, downloaded, email, id_level FROM {$TABLE_PREFIX}users WHERE invited_by=" .
            $id . " ORDER BY id DESC $limit", true);
        $num = count($results);

        if ($num > 0)
        {
            $usercptpl->set("to_confirm", true, true);
            $usercptpl->set("number_confirmed", $count);
            $usercptpl->set("frm1_target",
                "index.php?page=usercp&do=invite&amp;action=confirm&amp;uid=$id");

            $numreg = (mysql_fetch_row(@do_sqlquery("SELECT COUNT(*) FROM {$TABLE_PREFIX}users WHERE invited_by=$id AND id_level=2", true)));

            if ($numreg[0] == 0)
                $usercptpl->set("confirm_btn", false, true);

            $invitees = array();
            $i = 0;
            foreach ($results as $id => $data)
            {
                $invitees[$i]["username"] = "<a href=index.php?page=userdetails&amp;id=" . $data["id"] .
                    ">" . unesc($data["username"] . "</a>");
                $invitees[$i]["email"] = $data["email"];
                $invitees[$i]["uploaded"] = makesize($data["uploaded"]);
                $invitees[$i]["downloaded"] = makesize($data["downloaded"]);
                if ($data["id_level"] < 3)
                {
                    $invitees[$i]["status"] = "<font color=\"red\">" . $language["PENDING"] .
                        "</font>";
                    $invitees[$i]["frm_chk"] = "<input type=\"checkbox\" name=\"conusr[]\" value=\"" .
                        $data["id"] . "\" />";
                }
                else
                {
                    $invitees[$i]["status"] = "<font color=\"green\">" . $language["CONFIRMED"] .
                        "</font>";
                    $invitees[$i]["frm_chk"] = "";
                }
                $i++;
            }
            $usercptpl->set("invitees", $invitees);
            unset($invitees);
        }
}

?>