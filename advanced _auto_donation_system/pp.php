<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2009  Btiteam
//
//    This file is part of xbtit.
//
//    Advanced Auto Donation System by DiemThuy ( sept 2009 )
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
      
// get settings
$zap_pp = mysql_query("SELECT * FROM {$TABLE_PREFIX}paypal_settings WHERE id ='1'");
$settings = mysql_fetch_array($zap_pp);
      
$pptpl= new bTemplate();

$pptpl-> set("language",$language);
$pptpl-> set("url_back",$BASEURL);
$pptpl-> set("site",$SITENAME);
$user=($CURUSER["prefixcolor"].$CURUSER["username"].$CURUSER["suffixcolor"] );
$pptpl-> set("user",$user);
$pptpl-> set("uid",$CURUSER["uid"]);
$pptpl-> set("days",$settings["vip_days"]);
$pptpl-> set("gb",$settings["gb"]);

// If testing on Sandbox use:
if ($settings["test"]=="true")
{
$email= $settings["sandbox_email"];
$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
}
if ($settings["test"]=="false")
{
$email= $settings["paypal_email"];
$url = "https://www.paypal.com/cgi-bin/webscr";
}
$pptpl-> set("email",$email);
$pptpl-> set("url",$url);

if ($settings["units"]=="true")
{
$unit = "Euro";
$sign = "&#8364;";
$currency ="EUR";
}
Else
{
$unit = "Dollar";
$sign = "&#36;";
$currency ="USD";
}
$pptpl-> set("unit",$unit);
$pptpl-> set("sign",$sign);
$pptpl-> set("currency",$currency);

$vip = $settings["vip_rank"];
$zap_usr_v = mysql_query("SELECT prefixcolor,suffixcolor,level FROM {$TABLE_PREFIX}users_level WHERE id =$vip");
$wyn_usr_v = mysql_fetch_array($zap_usr_v);
$vipname = ($wyn_usr_v["prefixcolor"].$wyn_usr_v["level"].$wyn_usr_v["suffixcolor"]);
$pptpl-> set("vip_name",$vipname);
?>
