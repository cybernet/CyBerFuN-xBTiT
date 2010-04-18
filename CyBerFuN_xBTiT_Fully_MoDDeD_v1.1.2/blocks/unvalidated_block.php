<?php



/*---------------------------------------------------\

| Revalidation Block for XBTIT 2.0.0 by Petr1fied    |

\---------------------------------------------------*/



global $CURUSER, $VALIDATION, $BASEURL, $language;



$i = 0;



if (isset($_POST["Re"]))

{

    if ($_POST["Re"] == $language["RESEND_VALIDATION_MAIL"])

    {

        $i = 1;

        block_begin($language["BLOCK_SEND_VALIDATION_MAIL"]);

        send_mail($CURUSER["email"], $language["ACCOUNT_CONFIRM"], $language["ACCOUNT_MSG"]."\n\n".$BASEURL."/index.php?page=account&act=confirm&confirm=".$CURUSER["random"]."&language=".$CURUSER["language"]);

        write_log($CURUSER["username"]." (".$CURUSER["email"].") ".$language["RESENT_VALIDATION"], "add");



        print("<div style='width:75%;padding-left:12.5%'><p style='font-size:120%;text-align:center'>". $language["VALIDATION_SENT_TO_1"] ."<br/><br /><span style='color:#FF0000'><b>".$CURUSER["email"]."</b></span><br /><br />".$language["VALIDATION_SENT_TO_2"]."<a href='index.php?page=usercp&do=user&action=change&uid=".$CURUSER["uid"]."'>".$language["HERE"]."</a>.</p></div>");

        block_end();

    }

}

if ($VALIDATION == "user" && $i == 0)

{

    block_begin($language["BLOCK_UNVALIDATED"]);

    print("<div style='width:75%;padding-left:12.5%'><p style='font-size:120%;text-align:center'>".$language["ERR_NOT_VALIDATED_1"]." (".$CURUSER["email"].") ".$language["ERR_NOT_VALIDATED_2"]."<a href='index.php?page=usercp&do=user&action=change&uid=".$CURUSER["uid"]."'>".$language["HERE"]."</a>.</p>");

    print ("<form method=post><p style='text-align:center'><input type='submit' name='Re' value='".$language["RESEND_VALIDATION_MAIL"]."'></input></form></p></div>\n");

    block_end();

}



?>
