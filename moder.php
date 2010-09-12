<?php
if ($CURUSER["moderate_trusted"]=="yes" || $CURUSER["edit_torrents"]=="yes")
$check4=TRUE;

if (!defined("IN_BTIT"))
die("non direct access!");
if ($CURUSER["moderate_trusted"] || $CURUSER["edit_torrents"]=="yes")
{
$torrenttpl=new bTemplate();
$full="SELECT f.moder as moder, f.filename, f.info_hash, f.uploader as upname, u.username as uploader, c.image, c.name as cname, f.category as catid FROM {$TABLE_PREFIX}files f LEFT JOIN {$TABLE_PREFIX}users u ON u.id = f.uploader LEFT JOIN {$TABLE_PREFIX}categories c ON c.id = f.category";

if ($_GET["hash"]) {
	$sql=$full." WHERE info_hash='".$_GET["hash"]."'";
	$row = do_sqlquery($sql,true);

	if (mysql_num_rows($row)==1) 
	{
		while ($data=mysql_fetch_array($row)) {
			$torrenttpl->set("filename",$data['filename']);
			$torrenttpl->set("uploader","<a href=\"index.php?page=userdetails&id=".$data['upname']."\">".$data['uploader']."</a>");
			$torrenttpl->set("info_hash",$data['info_hash']);
			$link="index.php?page=moder&hash=".$data['info_hash']."";
			$torrenttpl->set("link",$link);

			if (!empty($_POST["msg"])) {
				$torrent="[url=".$btit_settings['url']."/index.php?page=torrent-details&id=".$data['info_hash']."]".$data['filename']."[/url]";
				$msg="Sorry ".$data[uploader].", but $torrent has been removed for this reason: [b]".mysql_escape_string(htmlspecialchars($_POST["msg"].$_POST['moderate_reasons']))."[/b]
Do not reply, this is an automatic message.";
				do_sqlquery("INSERT INTO `{$TABLE_PREFIX}messages` (`sender`, `receiver`, `added`, `subject`, `msg`) VALUES ('".$CURUSER["uid"]."', '".$data['upname']."', UNIX_TIMESTAMP(), '".$data['filename']."', '".$msg."')");
				//send to smf
				
				/*do_sqlquery("INSERT INTO `smf_personal_messages` (`ID_MEMBER_FROM`, `fromName`, `msgtime`, `subject`, `body`) VALUES ('1', 'System', UNIX_TIMESTAMP(), '".$subject."', '".$body."')");
        $pm_id=mysql_insert_id();
        do_sqlquery("INSERT INTO `smf_pm_recipients` (`ID_PM`, `ID_MEMBER`) VALUES ($pm_id, $smf_fid)");
        do_sqlquery("UPDATE smf_members SET instantMessages=instantMessages+1, unreadMessages=unreadMessages+1 WHERE ID_MEMBER=$smf_fid");*/
        
				$sended="Your message has been sended.";
				$answer=TRUE;
				$torrenttpl->set("message",$sended);
			}
			elseif ($_POST && empty($_POST["msg"])) {
				$sended2="You have to explain a reason.";
				$answer2=TRUE;
				$torrenttpl->set("message2",$sended2);
			}
		}
		
		$sql = "SELECT * FROM {$TABLE_PREFIX}warn_reasons WHERE active='1'";
		$row = do_sqlquery($sql,true);
		$select_reasons ="<select name='moderate_reasons' onchange=\"var desc = document.getElementById('description'); desc.innerHTML = this[this.selectedIndex].value;\">
		<option value=''>Nothing...</option>
		";
		while ($data=mysql_fetch_array($row)) {
			
			$select_reasons .="<option value='".$data['text']."'>".$data['title']."</option>";
		}
		$select_reasons.="</select>";
		
		$torrenttpl->set("moderate_reasons",$select_reasons);
		
		$torrenttpl->set("SENDED",$answer,TRUE);
		$torrenttpl->set("NO_SENDED",$answer2,TRUE);
		$check=TRUE;
		
	}
	else {
		$check2=TRUE;
	}
	$torrenttpl->set("return","index.php?page=moder");
}
elseif ($_GET["edit"]) {
	$check5=TRUE;
	$sql=$full." WHERE info_hash='".$_GET["edit"]."'";
	$row = do_sqlquery($sql,true);
	if (mysql_num_rows($row)==1) {
		while ($data=mysql_fetch_array($row)) {
			$torrenttpl->set("filename2",$data['filename']);
			$torrenttpl->set("uploader2","<a href=\"index.php?page=userdetails&id=".$data['upname']."\">".$data['uploader']."</a>");
			$torrenttpl->set("info_hash2",$data['info_hash']);
			switch ($data['moder']) {
				case 'ok':
					$checked1="SELECTED";
					break;
				case 'bad':
					$checked2="SELECTED";
					break;
				case 'um':
					$checked3="SELECTED";
					break;
			}
			$link2="index.php?page=moder&edit=".$data['info_hash']."";
			$editing="<form method=\"post\" action=\"".$link2."\"><select name=\"moder\">
								<option ".$checked1." value=\"ok\">Ok</option>
								<option ".$checked2." value=\"bad\">Bad</option>
								<option ".$checked3." value=\"um\">Unmoderated</option>
					</select>
					<input type=\"hidden\" name=\"hash\" value=\"".$data['info_hash']."\" />
					<input type=\"hidden\" name=\"ex_moder\" value=\"".$data['moder']."\" />
					<input type=\"submit\" value=\"Moder\" /></form>";
			if (isset($_POST["moder"])) {
				do_sqlquery("UPDATE {$TABLE_PREFIX}files SET moder='".$_POST['moder']."' WHERE info_hash='".$data['info_hash']."'",true);
				$check6=TRUE;
				if ($_POST["ex_moder"]!=$_POST["moder"] && $_POST["moder"]=="bad") {
					header ("Location: index.php?page=moder&hash=".$_POST["hash"]."");
				}
				$torrenttpl->set("return","index.php?page=moder");
			}
			else
			$check8=TRUE;
			$torrenttpl->set("editing",$editing);
		}
	}
	else {
		$check2=TRUE;
	}
	$torrenttpl->set("return","index.php?page=moder");
}
else {
	$check3=TRUE;
	$sql=$full." WHERE moder!='ok'";
	$row = do_sqlquery($sql,true);
	if (mysql_num_rows($row)>0) {
		$selecting="<table border=\"1\">";
		$selecting.="<tr><td align=\"center\"><b>Mod.</b></td><td align=\"center\"><b>Cat.</b></td><td align=\"center\"><b>Name<b></td><td align=\"center\"><b>Dl<b></td><td align=\"center\"><b>Uploader</b></td></tr>";
		while ($data=mysql_fetch_array($row)) {
			if ($CURUSER['edit_torrents']=="yes") {
				$link="edit&info_hash";
			}
			else {
				$link="moder&edit";
			}
			$selecting.="<tr>";
			$selecting.="<td align=\"center\"><a href=\"index.php?page=".$link."=".$data["info_hash"]."\" title=\"".$data["moder"]."\"><img alt=\"".$data["moder"]."\" src=\"images/mod/".$data["moder"].".png\"></a></td>";
			$selecting.="<td align=\"center\"><a href=\"index.php?page=torrents&category=$data[catid]\" title=\"".$data["cname"]."\">".image_or_link(($data["image"]==""?"":"$STYLEPATH/images/categories/".$data["image"]),"",$data["cname"])."</a></td>";
			$selecting.="<td align=\"center\"><a href=\"index.php?page=torrent-details&id=".$data['info_hash']."\">".$data['filename']."</a></td>";
			$selecting.="<td align=\"center\"><a href=\"download.php?id=".$data["info_hash"]."&f=".urlencode($data["filename"]).".torrent\" title=\"".$data["filename"]."\">".image_or_link("images/download.gif","","torrent")."</a></td>";
			$selecting.="<td align=\"center\"><a href=\"index.php?page=userdetails&id=".$data['upname']."\">".$data['uploader']."</a></td>";
			$selecting.="</tr>";
		}
		$selecting.="</table>";
	}
	else
	$selecting="No torrents unmodered.<br>";
	$torrenttpl->set("selecting",$selecting);
	$torrenttpl->set("return","index.php?page=torrents");
}
$torrenttpl->set("CHECK",$check,TRUE);
$torrenttpl->set("CHECK2",$check2,TRUE);
$torrenttpl->set("CHECK3",$check3,TRUE);
$torrenttpl->set("CHECK4",$check4,TRUE);
$torrenttpl->set("CHECK5",$check5,TRUE);
$torrenttpl->set("CHECK6",$check6,TRUE);
$torrenttpl->set("CHECK8",$check8,TRUE);
}
else 
{
	die('no no !');
}
?>