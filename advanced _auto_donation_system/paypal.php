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

$THIS_BASEPATH=dirname(__FILE__);
require("$THIS_BASEPATH/include/functions.php");

dbconn(true);

// get settings
$zap_pp = mysql_query("SELECT * FROM {$TABLE_PREFIX}paypal_settings WHERE id ='1'");
$settings = mysql_fetch_array($zap_pp);

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate

$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";

// If testing on Sandbox use:
if ($settings["test"]=="true")
{
$header .= "Host: www.sandbox.paypal.com:80\r\n";
}
if ($settings["test"]=="false")
{
$header .= "Host: www.paypal.com:80\r\n";
}
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

// If testing on Sandbox use:
if ($settings["test"]=="true")
{
$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
$ppmail= $settings["sandbox_email"];
}
if ($settings["test"]=="false")
{
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
$ppmail= $settings["paypal_email"];
}

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$anonymous=$_POST['custom'];
$receiver_email = $_POST['receiver_email'];
$custom=$_POST['custom'];
$payer_email = $_POST['payer_email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$country = $_POST['address_country'];
$payment_type = $_POST['payment_type'];

// block pending echecks. paypal posts payments again when echecks clear, blocks double credits.
if ($payment_type == "echeck" && $payment_status == "Pending") die;

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
// process payment

if ($receiver_email == $ppmail)
{
// find username
$zap_usr = mysql_query("SELECT username,id_level FROM {$TABLE_PREFIX}users WHERE id =$custom");
$wyn_usr = mysql_fetch_array($zap_usr);

if ($item_number == 1 OR $item_number == 2 )
{$first_name_site = $wyn_usr["username"]; }

else
{$first_name_site="anonymous"; }

$vipdays = ($payment_amount * $settings["vip_days"]);

// write to database
$query = "INSERT INTO {$TABLE_PREFIX}donors (id, userid, first_name, last_name, payers_email, mc_gross, date, country, item)VALUES ('', '$custom', '$first_name_site', '$last_name', '$payer_email', '$payment_amount', NOW() ,'$country' , '$item_number')";

$ppt=  ($settings["received"]+ $payment_amount);
mysql_query("UPDATE {$TABLE_PREFIX}paypal_settings SET received='$ppt' WHERE id='1'");

// upload bonus
if ($item_number == 2 )
{
$bonus =(1073741824*$settings["gb"]);
$bonus_user = ($payment_amount * $bonus );
$pm_bonus =( $payment_amount * $settings["gb"] );
// send pm here
$mesg=" Dear ".$wyn_usr["username"]." ,\n\n Our System have received a ".$payment_currency.$payment_amount." donation on our paypal account today \n\n The transaction reflects your userid \n\n You did recieve a upload bonus of ".$pm_bonus." GB \n\n Thank you for your help to keep ".$SITENAME." alive\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]";
send_pm(0,$custom,sqlesc('Your Donation Transaction Confirmation'),sqlesc($mesg));
mysql_query ("UPDATE {$TABLE_PREFIX}users SET uploaded = uploaded +".$bonus_user." WHERE `id` = '".$custom."' ");
}
//timed ranks start
if ($item_number == 0 OR $item_number == 1 )
{
// staff demote protection
$staff = $wyn_usr["id_level"];
$zap_usr_st = mysql_query("SELECT id_level FROM {$TABLE_PREFIX}users_level WHERE id =$staff");
$wyn_usr_st = mysql_fetch_array($zap_usr_st);

if  ($wyn_usr_st["id_level"] <=6 AND $item_number == 1)
{
mysql_query("UPDATE `{$TABLE_PREFIX}users` SET  `old_rank` = `id_level` WHERE `id`=".$custom);

$dt2 = "yes";
$dt3 = $settings["vip_rank"];
$dt4 = $vipdays;
$dt1=rank_expiration_dt(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($dt4),date('Y')));

mysql_query("UPDATE `{$TABLE_PREFIX}users` SET  `timed_rank`='".$dt1."',`rank_switch`='".$dt2."', `id_level`='".$dt3."' WHERE `id`=".$custom);

//smf rank
global $FORUMLINK ;
if($FORUMLINK=="smf")
{
$smf=mysql_query("SELECT smf_fid FROM {$TABLE_PREFIX}users WHERE id =".$custom);
$smf_user = mysql_fetch_array($smf);
mysql_query("UPDATE smf_members SET ID_GROUP = ".$settings["smf"]." WHERE ID_MEMBER=".$smf["smf_fid"]);
}

// send pm here
$mesg=" Dear ".$wyn_usr["username"]." ,\n\n Our System have received a ".$payment_currency.$payment_amount." donation on our paypal account today \n\n The transaction reflects your userid \n\n You are now promoted to VIP for ".$vipdays." days \n\n Thank you for your help to keep ".$SITENAME." alive\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]";
send_pm(0,$custom,sqlesc('Your Donation Transaction Confirmation'),sqlesc($mesg));
}
else
{
$mesg=" Dear ".$wyn_usr["username"]." ,\n\n Our System have received a ".$payment_currency.$payment_amount." donation on our paypal account today \n\n The transaction reflects your userid \n\n Because you are a staff member or a anonymous donator we will not promote or demote you to VIP \n\n Thank you for your help to keep ".$SITENAME." alive\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]";
send_pm(0,$custom,sqlesc('Your Donation Transaction Confirmation'),sqlesc($mesg));
}
}
//timed ranks end

$result = mysql_query($query) or die ("Could not execute query : $query." . mysql_error());

// donation star bridge
if ($settings["don_star"]=="true")
{
mysql_query("UPDATE {$TABLE_PREFIX}users SET donor = 'yes' WHERE id =".$custom);
}
// donation historie bridge
if ($settings["historie"]=="true")
{

$donation = mysql_query("SELECT * FROM {$TABLE_PREFIX}don_historie WHERE don_id ='$custom'");
$dh = mysql_fetch_assoc($donation);

if(empty($dh["don_ation"]))
{
do_sqlquery('insert '.$TABLE_PREFIX.'don_historie SET donate_date=NOW(),don_ation="'.$payment_amount.'" ,don_id='.$custom);
}
else if(empty($dh["don_ation_1"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_1="'.$payment_amount.'",donate_date_1=NOW() WHERE don_id='.$custom);
}
 else if(empty($dh["don_ation_2"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_2="'.$payment_amount.'",donate_date_2=NOW() WHERE don_id='.$custom);
}
else if(empty($dh["don_ation_3"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_3="'.$payment_amount.'",donate_date_3=NOW() WHERE don_id='.$custom);
}
else if(empty($dh["don_ation_4"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_4="'.$payment_amount.'",donate_date_4=NOW() WHERE don_id='.$custom);
}
else if(empty($dh["don_ation_5"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_5="'.$payment_amount.'",donate_date_5=NOW() WHERE don_id='.$custom);
}
else if(empty($dh["don_ation_6"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_6="'.$payment_amount.'",donate_date_6=NOW() WHERE don_id='.$custom);
}
else if(empty($dh["don_ation_7"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_7="'.$payment_amount.'",donate_date_7=NOW() WHERE don_id='.$custom);
}
else if(empty($dh["don_ation_8"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_8="'.$payment_amount.'",donate_date_8=NOW() WHERE don_id='.$custom);
}
else if(empty($dh["don_ation_9"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_9="'.$payment_amount.'",donate_date_9=NOW() WHERE don_id='.$custom);
}
 else if(empty($dh["don_ation_10"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_10="'.$payment_amount.'",donate_date_10=NOW() WHERE don_id='.$custom);
}
}
// don historie end
}
}
}
fclose ($fp);
}
?>
