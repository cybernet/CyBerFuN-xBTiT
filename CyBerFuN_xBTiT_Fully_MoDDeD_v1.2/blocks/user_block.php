<?php

// CyBerFuN.ro & xList.ro

// xList .::. user Block
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
// Modified By cybernet2u

global $CURUSER, $user, $USERLANG, $FORUMLINK, $db_prefix, $btit_settings;

require_once(load_language("lang_account.php"));

         block_begin("".BLOCK_USER."");

         if (!$CURUSER || $CURUSER["id"] == 1)
            {
            // guest-anonymous, login require
            ?>
            <form action="index.php?page=login" name="login" method="post">
            <table class="lista" border="0" align="center" width="100%">
            <tr><td style="text-align:center;" align="center" class="poller"><?php echo $language["USER_NAME"]?>:</td></tr><tr><td class="poller" style="text-align:center;" align="center"><input type="text" size="9" name="uid" value="<?php $user ?>" maxlength="40" /></td></tr>
            <tr><td style="text-align:center;" align="center" class="poller"><?php echo $language["USER_PWD"]?>:</td></tr><tr><td class="poller" style="text-align:center;" align="center"><input type="password" size="9" name="pwd" maxlength="40" /></td></tr>
            <tr><td colspan="2" class="poller" style="text-align:center;" align="center"><input type="submit" value="<?php echo $language["FRM_LOGIN"]?>" /></td></tr>
            <tr><td class="lista" style="text-align:center;" align="center"><a href="index.php?page=signup"><?php echo $language["ACCOUNT_CREATE"]?></a></td></tr><tr><td class="lista" style="text-align:center;" align="center"><a href="index.php?page=recover"><?php echo $language["RECOVER_PWD"]?></a></td></tr>
            </table>
            </form>
            <?php
            }
         else
             {
             // user information
             $style = style_list();
             $langue = language_list();
             print("\n<form name=\"jump\" method=\"post\" action=\"index.php\">\n<table class=\"poller\" width=\"100%\" cellspacing=\"0\">\n<tr><td align=\"center\">".$language["USER_NAME"].":  " .unesc($CURUSER["username"] . warn($CURUSER))."</td></tr>\n");
             print("<tr><td align=\"center\">".$language["USER_LEVEL"].": ".$CURUSER["level"]."</td></tr>\n");		         ?>
			 </table>

<table class="lista" width="100%">

<?php             
 ///////////seed-leech /////////////            

$style = style_list();
$langue = language_list();
$resuser = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
$rowuser = mysql_fetch_array($resuser);


print("<tr><td class=\"green\" align=\"left\"> <img src=\"images/speed_up.png\"> ".makesize($rowuser['uploaded']));
print("</td><td class=\"red\" align=\"left\"> <img src=\"images/speed_down.png\">  ".makesize($rowuser['downloaded']));
print("</td></tr>");

     
/////////////// end ///////////////   
?>
</table>

           
            <table class="lista" border="0" align="center" width="100%">


            <?php
			  
			 
			 print("\n<tr align=\"center\"><td class=\"yellow\" align=\"center\"><center><img src=\"images/arany.png\"> ".($rowuser['downloaded'] > 0 ? number_format($rowuser['uploaded'] / $rowuser['downloaded'], 2):"---")."</center></td><tr>\n");
             if($FORUMLINK == "smf")
                 $resmail = get_result("SELECT COUNT(*) as ur FROM {$TABLE_PREFIX}messages WHERE readed='no' AND receiver=$CURUSER[uid]",true,$btit_settings['cache_duration']);
             else
                 $resmail = do_sqlquery("SELECT COUNT(*) FROM {$TABLE_PREFIX}messages WHERE readed='no' AND receiver=$CURUSER[uid]");
             if ($resmail && count($resmail) > 0)
                {
                 $mail = $resmail[0];
                 if ($mail['ur'] > 0)
                    print("<tr><td align=\"center\"><a href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\">".$language["MAILBOX"]."</a> (<font color=\"#FF0000\"><b>".$mail['ur']."</b></font>)</td></tr>\n");
                 else
                     print("<tr><td align=\"center\"><a href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\">".$language["MAILBOX"]."</a></td></tr>\n");
                }
             else
                 print("<tr><td align=\"center\">".$language["NO_MAIL"]."</td></tr>");
             print("<tr><td align=\"center\">");
             include("include/offset.php");
             print($language["USER_LASTACCESS"].":<br />".date("d/m/Y H:i:s",$CURUSER["lastconnect"]-$offset));
             print("</td></tr>\n<tr><td align=\"center\">");
             print($language["USER_STYLE"].":<br />\n<select name=\"style\" size=\"1\" onchange=\"location=document.jump.style.options[document.jump.style.selectedIndex].value\">");
             foreach($style as $a)
                            {
                            print("<option ");
                            if ($a["id"] == $CURUSER["style"])
                               print("selected=\"selected\"");
                            print(" value=\"account_change.php?style=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["style"]."</option>");
                            }
             print("</select>");
             print("</td></tr>\n<tr><td align=\"center\">");
             print($language["USER_LANGUE"].":<br />\n<select name=\"langue\" size=\"1\" onchange=\"location=document.jump.langue.options[document.jump.langue.selectedIndex].value\">");
             foreach($langue as $a)
                            {
                            print("<option ");
                            if ($a["id"] == $CURUSER["language"])
                               print("selected=\"selected\"");
                            print(" value=\"account_change.php?langue=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["language"]."</option>");
                            }
             print("</select>");
             print("</td>\n</tr>\n");
             print("\n<tr><td align=\"center\"><a href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."\">".$language["USER_CP"]."</a></td></tr>\n");
             if ($CURUSER["admin_access"] == "yes")
                print("\n<tr><td align=\"center\"><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."\">".$language["MNU_ADMINCP"]."</a></td></tr>\n");

             print("</table>\n</form>");
             }
         block_end();
?>
