<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. rpc
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


/*
Page:           rpc.php
Created:        Aug 2006
Last Mod:       Mar 18 2007
This page handles the 'AJAX' type response if the user
has Javascript enabled.
--------------------------------------------------------- 
ryan masuga, masugadesign.com
ryan@masugadesign.com 
Licensed under a Creative Commons Attribution 3.0 License.
http://creativecommons.org/licenses/by/3.0/
See readme.txt for full credit details.
--------------------------------------------------------- */
header("Cache-Control: no-cache");
header("Pragma: nocache");

require('_config-rating.php'); // get the db connection info

//getting the values
$vote_sent = preg_replace("/[^0-9]/", "", $_REQUEST['j']);
$id_sent = preg_replace("/[^0-9a-zA-Z]/", "", $_REQUEST['q']);
$ip_num = preg_replace("/[^0-9\.]/", "", $_REQUEST['t']);
$units = preg_replace("/[^0-9]/", "", $_REQUEST['c']);

$ip = $ip_num;

if ($vote_sent > $units) die("Sorry, vote appears to be invalid."); // kill the script because normal users will never see this.


//connecting to the database to get some information
$query = mysql_query("SELECT total_votes, total_value, used_ips FROM $rating_dbname.$rating_tableName WHERE id='$id_sent' ")or die(" Error: ".mysql_error());
$numbers = mysql_fetch_assoc($query);
$checkIP = unserialize($numbers['used_ips']);
$count = $numbers['total_votes']; //how many votes total
$current_rating = $numbers['total_value']; //total number of rating added together and stored
$sum = $vote_sent + $current_rating; // add together the current vote value and the total vote value
$tense = ($count == 1) ? "vote" : "votes"; //plural form votes/vote

// checking to see if the first vote has been tallied
// or increment the current number of votes
($sum == 0 ? $added = 0 : $added = $count + 1);

// if it is an array i.e. already has entries the push in another value
((is_array($checkIP)) ? array_push($checkIP, $ip_num) : $checkIP = array($ip_num));
$insertip = serialize($checkIP);

//IP check when voting
$voted = mysql_num_rows(mysql_query("SELECT used_ips FROM $rating_dbname.$rating_tableName WHERE used_ips LIKE '%".$ip."%' AND id='".$id_sent."' "));
if(!$voted) {     //if the user hasn't yet voted, then vote normally...

	if (($vote_sent >= 1 && $vote_sent <= $units) && ($ip == $ip_num)) { // keep votes within range, make sure IP matches - no monkey business!
		$update = "UPDATE $rating_dbname.$rating_tableName SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insertip."' WHERE id='$id_sent'";
		$result = mysql_query($update);		
	} 
} //end for the "if(!$voted)"
// these are new queries to get the new values!
$newtotals = mysql_query("SELECT total_votes, total_value, used_ips FROM $rating_dbname.$rating_tableName WHERE id='$id_sent' ")or die(" Error: ".mysql_error());
$numbers = mysql_fetch_assoc($newtotals);
$count = $numbers['total_votes'];//how many votes total
$current_rating = $numbers['total_value'];//total number of rating added together and stored
$tense = ($count == 1) ? "vote" : "votes"; //plural form votes/vote

// $new_back is what gets 'drawn' on your page after a successful 'AJAX/Javascript' vote

$new_back = array();

$new_back[] .= '<ul class="unit-rating" style="width:'.$units * $rating_unitwidth.'px;">';
$new_back[] .= '<li class="current-rating" style="width:'.@number_format($current_rating / $count, 2) * $rating_unitwidth.'px;">Trenutna ocjena.</li>';
$new_back[] .= '<li class="r1-unit">1</li>';
$new_back[] .= '<li class="r2-unit">2</li>';
$new_back[] .= '<li class="r3-unit">3</li>';
$new_back[] .= '<li class="r4-unit">4</li>';
$new_back[] .= '<li class="r5-unit">5</li>';
$new_back[] .= '<li class="r6-unit">6</li>';
$new_back[] .= '<li class="r7-unit">7</li>';
$new_back[] .= '<li class="r8-unit">8</li>';
$new_back[] .= '<li class="r9-unit">9</li>';
$new_back[] .= '<li class="r10-unit">10</li>';
$new_back[] .= '</ul>';
$new_back[] .= '<div class="voted">Rating: <strong>'.@number_format($sum / $added, 1).' out of '.$units.'.0 </strong> (Votes: '.$count.') ';
$new_back[] .= '<span class="thanks">Your vote has been added!</span></div>';

$allnewback = join("\n", $new_back);

// ========================

//name of the div id to be updated | the html that needs to be changed
$output = "unit_long$id_sent|$allnewback";
echo $output;
?>
