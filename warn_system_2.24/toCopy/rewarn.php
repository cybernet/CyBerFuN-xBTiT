<?php
# first check for direct linking
if(!defined('IN_BTIT'))die('non direct access!');
# then require functions (is this needed?)
require_once $THIS_BASEPATH.'/include/functions.php';
# connect to db
dbconn();
# check if allowed and die if not
if($CURUSER['edit_torrents']=='no'&&$CURUSER['edit_users']=='no')die('Unauthorised access!');
# inits
$warn=addslashes($_POST['warn']);
$id=(int)$_GET['id'];
$returnto = $_POST["returnto"];
$warneduser=get_result('SELECT username FROM `'.$TABLE_PREFIX.'users` WHERE `id`='.$id.' LIMIT 1;', false, 3600);
$warneduser=$warneduser[0]['username'];
$subj=sqlesc('Your Warning is canceled !');
$msg=sqlesc('[b]We did cancel your Warning!\n\r'.$CURUSER['username'].'[/b].');
# process it 
quickQuery('UPDATE '.$TABLE_PREFIX.'users SET warn="no", warns=warns-1 WHERE id='.$id);
# message him
quickQuery('INSERT INTO '.$TABLE_PREFIX.'messages (sender, receiver, added, msg, subject) VALUES(0,'.$id.',UNIX_TIMESTAMP(),'.$msg.','.$subj.')')or sqlerr(__FILE__,__LINE__);  
# log it
write_log("Warning canceled for ".$warneduser." by: ".$CURUSER['username'].""," Warning removed");
# send back to original page
header('Location: '.$returnto);
die();
?>
