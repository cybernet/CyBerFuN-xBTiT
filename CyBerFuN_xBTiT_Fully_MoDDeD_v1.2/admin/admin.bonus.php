<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Admin - Bonus
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
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

if (!defined("IN_ACP"))
      die("non direct access!");


if (!$CURUSER || $CURUSER["admin_access"] != "yes")
{
       err_msg(ERROR, NOT_ADMIN_CP_ACCESS);
       stdfoot();
       exit;
}
else
{
  $i = 0;
  $r = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}bonus");
  while($row = mysql_fetch_array($r)){
    $traffic = makesize($row["traffic"]);
$traf[$i]["traffic"] = $traffic;
$traf[$i]["points"] = $row["points"];
$traf[$i]["name"] = $row["name"];
$i++;
  }
    $admintpl->set("language", $language);
    $admintpl->set("price_vip", $btit_settings["price_vip"]);
    $admintpl->set("price_ct", $btit_settings["price_ct"]);
    $admintpl->set("price_name", $btit_settings["price_name"]);
    $admintpl->set("bonus", $btit_settings["bonus"]);
    $admintpl->set("traf", $traf);
    $admintpl->set("random", $CURUSER["random"]);
    $admintpl->set("uid", $CURUSER["uid"]);
    $admintpl->set("firstview", (($_POST["action"] == "Update")?FALSE:TRUE), TRUE);

 
    if($_POST["action"] == "Update")
    {
        (isset($_POST["price_vip"]) && !empty($_POST["price_vip"])?$price_vip=intval($_POST["price_vip"]):$minage=0);
        (isset($_POST["price_ct"]) && !empty($_POST["price_ct"])?$price_ct=intval($_POST["price_ct"]):$maxage=0);
        (isset($_POST["price_name"]) && !empty($_POST["price_name"])?$price_name=intval($_POST["price_name"]):$maxage=0);
        (isset($_POST["bonus"]) && !empty($_POST["bonus"])?$bonus=addslashes($_POST["bonus"]):$bonus=0);
        (isset($_POST["gb1"]) && !empty($_POST["gb1"])?$gb1=addslashes($_POST["gb1"]):$gb1=0);
        (isset($_POST["pts1"]) && !empty($_POST["pts1"])?$pts1=addslashes($_POST["pts1"]):$pts1=0);
        (isset($_POST["gb2"]) && !empty($_POST["gb2"])?$gb2=addslashes($_POST["gb2"]):$gb2=0);
        (isset($_POST["pts2"]) && !empty($_POST["pts2"])?$pts2=addslashes($_POST["pts2"]):$pts2=0);
        (isset($_POST["gb3"]) && !empty($_POST["gb3"])?$gb3=addslashes($_POST["gb3"]):$gb3=0);
        (isset($_POST["pts3"]) && !empty($_POST["pts3"])?$pts3=addslashes($_POST["pts3"]):$pts3=0);
        $gbinbytes1 = $gb1 * 1024 * 1024 * 1024;
        $gbinbytes2 = $gb2 * 1024 * 1024 * 1024;
        $gbinbytes3 = $gb3 * 1024 * 1024 * 1024;
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`=$price_vip WHERE `key`='price_vip'");
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`=$price_ct WHERE `key`='price_ct'");
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$price_name' WHERE `key`='price_name'");
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$bonus' WHERE `key`='bonus'");
        do_sqlquery("UPDATE `{$TABLE_PREFIX}bonus` SET `points`='$pts1', `gb`='$gb1', `traffic`='$gbinbytes1' WHERE `name`='1'");
        do_sqlquery("UPDATE `{$TABLE_PREFIX}bonus` SET `points`='$pts2', `gb`='$gb2', `traffic`='$gbinbytes2' WHERE `name`='2'");
        do_sqlquery("UPDATE `{$TABLE_PREFIX}bonus` SET `points`='$pts3', `gb`='$gb3', `traffic`='$gbinbytes3' WHERE `name`='3'");

    }
}

?>
