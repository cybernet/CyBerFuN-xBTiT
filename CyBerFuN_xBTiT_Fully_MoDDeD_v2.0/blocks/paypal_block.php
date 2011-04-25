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

block_begin("Donate");


$zap_usr = mysql_query("SELECT * FROM {$TABLE_PREFIX}paypal_settings WHERE id ='1'");
$settings = mysql_fetch_array($zap_usr);

if ($settings["donation_block"] == "true" )
{
echo  "<marquee onmouseover=this.stop() onmouseout=this.start()  scrollAmount=2 direction=left >";
echo "<font color = red size = 2><b>", $settings["scrol_tekst"];
echo "</marquee>";
}

$date_time = $settings["due_date"];
$funds_so_far = $settings["received"];
$totalneeded = $settings["needed"];
$funds_difference = $totalneeded - $funds_so_far;
$Progress_so_far = $funds_so_far / $totalneeded * 100;
if($Progress_so_far >= 100)
$funds_img = "./images/progress-5.gif";
elseif($Progress_so_far >= 76)
$funds_img = "./images/progress-4.gif";
elseif($Progress_so_far >= 51)
$funds_img = "./images/progress-3.gif";
elseif($Progress_so_far >= 26)
$funds_img = "./images/progress-2.gif";
elseif($Progress_so_far >= 1)
$funds_img = "./images/progress-1.gif";
else
$funds_img = "./images/progress-0.gif";
if($totalneeded >= $funds_so_far)
$monthly_goal = "[ ".round($Progress_so_far)."% ]";
else
$monthly_goal = "[ Monthly goal met! ]";
if ($settings["units"]=="true")
{

$sign = "&#8364;";
$currency ="EUR";
}
Else
{

$sign = "&#36;";
$currency ="USD";
}
echo"<table><tr><td align=center><a href=index.php?page=donate><img src=images/donate.gif border=0></a></td></tr><tr><td align=center>Donations this month: <font color=steelblue><b> ".round($Progress_so_far)."%</b></td></tr><tr><td width=198 hight=15><center><img title=\"".round($Progress_so_far)."% (".$funds_so_far." of ".$totalneeded." ".$sign.")\" src=$funds_img align=center valign=middle><br>Goal : <font color=blue><b>".$sign." $totalneeded</font></b><br>Due: <font color=red><b>$date_time</font></b></center></td></tr> <TR><TD align=center class=header>Last Donators</TD></TR></table>";

echo "<TABLE width=100% border=0 cellspacing=1 cellpadding=1 class=forumline>
<TR>
<TD class=lista>Donator :</TD>
<TD class=lists>Date :</TD>
</TR>";
$pp=$settings["num_block"];
$donor = mysql_query("SELECT * FROM {$TABLE_PREFIX}donors ORDER BY date DESC LIMIT $pp") or die(mysql_error());

 while ($fetch=mysql_fetch_assoc($donor))
{
if ($fetch["userid"]  == "0")
{}
else
{
 $r2 = mysql_query("SELECT id_level FROM {$TABLE_PREFIX}users WHERE id=$fetch[userid]") or die(mysql_error());
 $a2 = mysql_fetch_assoc($r2);
 $r3 = mysql_query("SELECT prefixcolor,suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id=$a2[id_level]") or die(mysql_error());
 $a3 = mysql_fetch_assoc($r3);
 
if ($fetch["first_name"] == "anonymous")
{
$un="anonymous";
$link="";
}
else
{
$un=$a3["prefixcolor"].$fetch["first_name"].$a3["suffixcolor"];
$link="<a href=index.php?page=userdetails&id=" . $fetch["userid"] . ">";
}
echo"<TR align=left><TD>".$link."".$un."</a></TD><TD>".date('d/m/Y',strtotime($fetch["date"]))."</TD></TR>";
}}
print("</td></tr></table>");
block_end();

?>
