<?php
# first check for direct linking
if(!defined("IN_BTIT"))die('non direct access!');
# then require functions (is this needed?)
require_once $THIS_BASEPATH.'/include/functions.php';
# connect to db
dbconn();
# check if allowed and die if not
if($CURUSER['edit_torrents']=='no'&&$CURUSER['edit_users']=='no')die('Unauthorised access!');

# inits
$id=(int)$_GET['id'];
$warn=addslashes($_POST['warn']);
$warnreason=addslashes($_POST['warnreason']);
$warnaddedby=$CURUSER['username'];
$added=warn_expiration(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($_POST['days']),date('Y')));
$returnto=$_POST['returnto'];
$subj=sqlesc('You did recieve a Warning!');
$msg=sqlesc('[b]The reason for this warning is: '.$warnreason.' By: '.$CURUSER['username'].'[/b].Expire date for the warning: '.$added.'.');
# get the username of warned dude
$warneduser=get_result('SELECT username FROM `'.$TABLE_PREFIX.'users` WHERE `id`='.$id.' LIMIT 1;', false, 3600);
$warneduser=$warneduser[0]['username'];

# functions
function warn_expiration($timestamp=0){return gmdate('Y-m-d H:i:s',$timestamp);}

# process it in one line as to not stress the database server
quickQuery('UPDATE '.$TABLE_PREFIX.'users SET warn="yes",warns=warns+1,warnreason="'.$warnreason.'",warnaddedby="'.$warnaddedby.'",warnadded="'.$added.'" WHERE id='.$id);
# message him
quickQuery('INSERT INTO '.$TABLE_PREFIX.'messages (sender, receiver, added, msg, subject) VALUES(0,'.$id.',UNIX_TIMESTAMP(),'.$msg.','.$subj.')')or sqlerr(__FILE__, __LINE__);  
# log it
write_log('Warned User: '.$warneduser.'. Reason: '.$warnreason,'WARN');
# send back to original page
header('Location: '.$returnto);
die();
?>