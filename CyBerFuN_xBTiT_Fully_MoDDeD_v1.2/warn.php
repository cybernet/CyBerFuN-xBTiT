<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Warn
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

# first check for direct linking
if(!defined("IN_BTIT"))die('non direct access!');
# then require functions (is this needed?)
require_once $THIS_BASEPATH.'/include/functions.php';
# connect to db
dbconn();
# check if allowed and die if not
if($CURUSER['edit_torrents'] == 'no' && $CURUSER['edit_users'] == 'no') die('Unauthorised access!');

# inits
$id = (int)$_GET['id'];
$warn = addslashes($_POST['warn']);
$warnreason = addslashes($_POST['warnreason']);
$warnaddedby = $CURUSER['username'];
$added = warn_expiration(mktime(date('H') + 2, date('i'), date('s'), date('m'), date('d') + addslashes($_POST['days']), date('Y')));
$returnto = $_POST['returnto'];
$subj = sqlesc('You did recieve a Warning!');
$msg = sqlesc('[b]The reason for this warning is: '.$warnreason.' By: '.$CURUSER['username'].'[/b].Expire date for the warning: '.$added.'.');
# get the username of warned dude
$warneduser = get_result('SELECT username FROM `'.$TABLE_PREFIX.'users` WHERE `id`='.$id.' LIMIT 1;', false, 3600);
$warneduser = $warneduser[0]['username'];

# functions
function warn_expiration($timestamp = 0){return gmdate('Y-m-d H:i:s', $timestamp);}

# process it in one line as to not stress the database server
quickQuery('UPDATE '.$TABLE_PREFIX.'users SET warn="yes",warns=warns+1,warnreason="'.$warnreason.'",warnaddedby="'.$warnaddedby.'",warnadded="'.$added.'" WHERE id='.$id);
# message him
quickQuery('INSERT INTO '.$TABLE_PREFIX.'messages (sender, receiver, added, msg, subject) VALUES(0,'.$id.',UNIX_TIMESTAMP(),'.$msg.','.$subj.')')or sqlerr(__FILE__, __LINE__);  
# log it
write_log('Warned User: '.$warneduser.'. Reason: '.$warnreason, 'WARN');
# send back to original page
header('Location: '.$returnto);
die();
?>
