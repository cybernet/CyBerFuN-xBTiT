<?php

// CyBerFuN Tracker .::. iRC
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// Modified By CyBerNe7

ob_start();
global $CURUSER, $BASEURL;
if ($CURUSER["uid"]>1)
{

function get_settings($key)
{
	global $TABLE_PREFIX;
	
	$curr_conf_query = do_sqlquery("SELECT `value` FROM `{$TABLE_PREFIX}settings` WHERE `key` = '".$key."'", true);
	$curr_conf = mysql_fetch_assoc($curr_conf_query);
	
	return $curr_conf["value"];
}

		$irc_server = get_settings("irc_server");
		$irc_port = get_settings("irc_port");
		$irc_channel = get_settings("irc_channel");

		$nick = str_replace(" ", "_", $CURUSER['username']);

$style = $CURUSER["style"];
?>
<div>
<applet codebase="<? echo $BASEURL."/irc"?>" code=IRCApplet.class archive="irc.jar,pixx.jar" width="100%" height="480">
<param codebase="<? echo $BASEURL."/irc"?>" name="CABINETS" value="irc.cab,securedirc-unsigned.cab,pixx.cab">
<param name="nick" value="<? echo $nick?>">
<param name="alternatenick" value="<? echo $nick?>1">
<param name="name" value="-<? echo $nick?>-">
<param name="host" value="<? echo $irc_server?>">
<param name="port" value="<? echo $irc_port?>">
<param name="gui" value="pixx">
<param name="language" value="english">
<param name="quitmessage" value="<? echo $SITENAME?> forever!">
<param name="asl" value="true">
<param name="style:bitmapsmileys" value="true">
<param name="style:smiley1" value=":) img/sourire.gif">
<param name="style:smiley2" value=":-) img/sourire.gif">
<param name="style:smiley3" value=":-D img/content.gif">
<param name="style:smiley4" value=":d img/content.gif">
<param name="style:smiley5" value=":-O img/OH-2.gif">
<param name="style:smiley6" value=":o img/OH-1.gif">
<param name="style:smiley7" value=":-P img/langue.gif">
<param name="style:smiley8" value=":p img/langue.gif">
<param name="style:smiley9" value=";-) img/clin-oeuil.gif">
<param name="style:smiley10" value=";) img/clin-oeuil.gif">
<param name="style:smiley11" value=":-( img/triste.gif">
<param name="style:smiley12" value=":( img/triste.gif">
<param name="style:smiley13" value=":-| img/OH-3.gif">
<param name="style:smiley14" value=":| img/OH-3.gif">
<param name="style:smiley15" value=":'( img/pleure.gif">
<param name="style:smiley16" value=":$ img/rouge.gif">
<param name="style:smiley17" value=":-$ img/rouge.gif">
<param name="style:smiley18" value="(H) img/cool.gif">
<param name="style:smiley19" value="(h) img/cool.gif">
<param name="style:smiley20" value=":-@ img/enerve1.gif">
<param name="style:smiley21" value=":@ img/enerve2.gif">
<param name="style:smiley22" value=":-S img/roll-eyes.gif">
<param name="style:smiley23" value=":s img/roll-eyes.gif">
<param name="soundbeep" value="snd/bell2.au">
<param name="soundquery" value="snd/ding.au">
<param name="pixx:language" value="pixx-english">
<param name="style:floatingasl" value="true">
<param name="pixx:highlight" value="true">
<param name="pixx:highlightnick" value="true">
<?
if ($style=="1")
{
echo'<param name="pixx:color5" value="A1BFD9" />
<param name="pixx:color6" value="A1BFD9" />
<param name="pixx:color9" value="A1BFD9" />';
}
elseif ($style=="2")
{
echo'<param name="pixx:color5" value="DEEDE5" />
<param name="pixx:color6" value="DEEDE5" />
<param name="pixx:color9" value="DEEDE5" />';
}
elseif ($style=="3")
{
echo'<param name="pixx:color5" value="87898A" />
<param name="pixx:color6" value="87898A" />
<param name="pixx:color9" value="87898A" />';
}
elseif ($style=="4")
{
echo'<param name="pixx:color5" value="000000" />
<param name="pixx:color6" value="000000" />
<param name="pixx:color9" value="4A4A4A" />';
}
elseif ($style=="5")
{
echo'<param name="pixx:color1" value="025082" />
<param name="pixx:color5" value="F0F0F0" />
<param name="pixx:color6" value="F0F0F0" />
<param name="pixx:color9" value="F0F0F0" />';
}
elseif ($style=="6")
{
echo'<param name="pixx:color1" value="003300" />
<param name="pixx:color5" value="DEEDE5" />
<param name="pixx:color6" value="DEEDE5" />
<param name="pixx:color9" value="DEEDE5" />';
}

?>
<param name="command1" value="/join #<? echo $irc_channel?>">
</applet>
<br />
<div align='left'><small>
If you cannot enter the chatroom then your web browser's Java Plugin may need to be upgraded.
<br>Please go to <a href='http://www.java.com/en/download/download_the_latest.jsp'>Sun's Java plugin site</a>
<br>or else use a client like <a href='http://www.mirc.com'>mIRC</a> instead.
</small></div>
</div>
<?php
}
else
    print("<div align=\"center\">\n<br />".$language["ERR_MUST_BE_LOGGED_SHOUT"]."</div>");

$module_out=ob_get_contents();
ob_end_clean();
?>
