<?php

// CyBerFuN.ro & xList.ro

// xList .::. Main User Toolbar Block
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
// Modified By CyBerNe7

global $INVITATIONSON, $CURUSER, $FORUMLINK, $db_prefix, $XBTT_USE, $btit_settings;

  if (isset($CURUSER) && $CURUSER && $CURUSER["uid"] > 1)
  {
  print("<form name=\"jump1\" action=\"index.php\" method=\"post\">\n");
?>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<?php
$style = style_list();
$langue = language_list();

print("<td style=\"text-align:center;\" align=\"center\">".$language["USER_LEVEL"].": ".$CURUSER["level"]."</td>\n");
print("<td class=\"green\" align=\"center\"> <img src=\"images/speed_up.png\"> ".makesize($CURUSER['uploaded']));
print("</td><td class=\"red\" align=\"center\"> <img src=\"images/speed_down.png\">  ".makesize($CURUSER['downloaded']));
print("</td><td class=\"yellow\" align=\"center\"> (<img src=\"images/arany.png\"> ".($CURUSER['downloaded'] > 0 ? number_format($CURUSER['uploaded'] / $CURUSER['downloaded'], 2):"---").")</td>\n");
print("<td class=\"green\" align=\"center\"><a href=index.php?page=modules&module=seedbonus>(BON ".($CURUSER['seedbonus'] > 0 ? number_format($CURUSER['seedbonus'], 2):"---").")</a></td>\n");

if ($CURUSER["admin_access"] == "yes")
   print("\n<td align=\"center\" style=\"text-align:center;\"><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."\">".$language["MNU_ADMINCP"]."</a></td>\n");

print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."\">".$language["USER_CP"]."</a></td>\n");
// friendlist
print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=friendlist&amp;uid=".$CURUSER["uid"]."\">Friendlist</a></td>\n");
// end friendlist

if($INVITATIONSON)
{
    require(load_language("lang_usercp.php"));
    $resinvs = do_sqlquery("SELECT invitations FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
    $arrinvs = mysql_fetch_row($resinvs);
    $invs = $arrinvs[0];
    print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=usercp&do=invite&action=read&uid=".$CURUSER["uid"]."\">".$language["INVITATIONS"]." ".($invs > 0 ? "(".$invs.")":"")."</a></td>\n");
}

if($FORUMLINK == "smf")
    $resmail = get_result("SELECT unreadMessages as ur FROM {$db_prefix}members WHERE ID_MEMBER=".$CURUSER["smf_fid"],true,$btit_settings['cache_duration']);
else
    $resmail = get_result("SELECT COUNT(*) as ur FROM {$TABLE_PREFIX}messages WHERE readed='no' AND receiver=$CURUSER[uid]",true,$btit_settings['cache_duration']);
if ($resmail && count($resmail) > 0)
   {
    $mail = $resmail[0];
    if ($mail['ur'] > 0)
       print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\">".$language["MAILBOX"]."</a> (<font color=\"#FF0000\"><b>".$mail['ur']."</b></font>)</td>\n");
    else
        print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\">".$language["MAILBOX"]."</a></td>\n");
   }
else
    print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\">".$language["MAILBOX"]."</a></td>\n");

print("\n<td style=\"text-align:center;\"><select name=\"style\" size=\"1\" onchange=\"location=document.jump1.style.options[document.jump1.style.selectedIndex].value\">");
foreach($style as $a)
               {
               print("<option ");
               if ($a["id"] == $CURUSER["style"])
                  print("selected=\"selected\"");
               print(" value=\"account_change.php?style=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["style"]."</option>");
               }
print("</select></td>");

print("\n<td style=\"text-align:center;\"><select name=\"langue\" size=\"1\" onchange=\"location=document.jump1.langue.options[document.jump1.langue.selectedIndex].value\">");
foreach($langue as $a)
               {
               print("<option ");
               if ($a["id"] == $CURUSER["language"])
                  print("selected=\"selected\"");
               print(" value=\"account_change.php?langue=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["language"]."</option>");
               }
print("</select></td>");
// print("<td class=lista align=center>".USER_LASTACCESS.": ".date("d/m/Y H:i:s",$CURUSER["lastconnect"])."</td>\n");
?>
</tr>
</table>
</form>
<?php
}
else
    {
    if (!isset($user)) $user = '';
    ?>
    <form action="index.php?page=login" name="login" method="post">
    <table class="lista" border="0" width="100%" cellpadding="4" cellspacing="1">
    <tr>
    <td class="lista" align="left">
      <table border="0" cellpadding="0" cellspacing="0">
      <tr>
      <td align="right" class="lista"><?php echo $language["USER_NAME"]?>:</td>
      <td class="lista"><input type="text" size="15" name="uid" value="<?php $user ?>" maxlength="40" style="font-size:10px" /></td>
      <td align="right" class="lista"><?php echo $language["USER_PWD"]?>:</td>
      <td class="lista"><input type="password" size="15" name="pwd" maxlength="40" style="font-size:10px" /></td>
      <td class="lista" align="center"><input type="submit" value="<?php echo $language["FRM_LOGIN"]?>" style="font-size:10px" /></td>
      </tr>
      </table>
    </td>
    <td class="lista" align="center"><a href="index.php?page=signup"><?php echo $language["ACCOUNT_CREATE"]?></a></td>
    <td class="lista" align="center"><a href="index.php?page=recover"><?php echo $language["RECOVER_PWD"]?></a></td>
    </tr>
    </table>
    </form>
<?php
}
?>
