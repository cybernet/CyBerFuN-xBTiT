<?php
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

if (!defined("IN_BTIT"))
      die("non direct access!");

require_once ("include/functions.php");
require_once ("include/config.php");

$usercptpl= new bTemplate();
$usercptpl-> set("language",$language);

dbconn();

$minratio=1;

if (!$CURUSER || $CURUSER["uid"]==1)
{
    block_begin("Please login");
    stderr("Chyba","To delete an account you must be logged in.");
    block_end();
    stdfoot();
    exit();
}

$row=mysql_fetch_assoc(mysql_query("SELECT (uploaded/downloaded) AS ratio FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]));

if ($CURUSER["mod_access"]=="yes" || $CURUSER["edit_torrents"]=="yes")
{
    block_begin("Access denied");
    stderr("Chyba","Member Staff you can not delete an account");
    block_end();
    stdfoot();
    exit();
}
elseif ($CURUSER["id_level"]>=5 && $CURUSER["id_level"]<=7)
{
    block_begin("Access denied");
    stderr("Chyba","This rank has no right delete me");
    block_end();
    stdfoot();
    exit();
}
elseif (is_null($row["ratio"]) || $row["ratio"]<$minratio)
{
    block_begin("Permission denied");
    stderr("Chyba","Ratio must be more than ".number_format($minratio, 2)." you have ".number_format($row["ratio"], 2));
    block_end();
    stdfoot();
    exit();
}
else
{
    if ($_POST["action"])
    {
        // -----------------------------
        // Captcha hack
        // -----------------------------

        if ($USE_IMAGECODE)
        {
            if (extension_loaded('gd'))
            {
                $arr = gd_info();
                if ($arr['FreeType Support']==1)
                {
                    $public=$_POST['public_key'];
                    $private=$_POST['private_key'];

                    $p=new ocr_captcha();

                    if ($p->check_captcha($public,$private) != true)
                    {
                        block_begin("Error");
                        stderr(ERROR,ERR_IMAGE_CODE);
                        block_end();
                        stdfoot();
                        exit();
                    }
                }
            }
        }

        @mysql_query("DELETE FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
        write_log($CURUSER["username"]." deleted their own account","delete");
        redirect("index.php");
    }
    
    block_begin("Delete Account");
    // -----------------------------
    // Captcha hack
    // -----------------------------
    if ($USE_IMAGECODE)
    {
        if (extension_loaded('gd'))
        {
            $arr = gd_info();
            if ($arr['FreeType Support']==1)
            {
                $p=new ocr_captcha();

                $usercptpl -> set("delete_cesta", "index.php?page=usercp&do=deleteme&action=change&uid=".$CURUSER["uid"]."");
                $deltpl[$i]["opistekod"]="<input type=\"text\" name=\"private_key\" value=\"\" maxlength=\"6\" size=\"7\">";
                $deltpl[$i]["opistekod2"]=$p->display_captcha(true);
                $i++;
                $private=$p->generate_private();
            }
        }
    }
$usercptpl->set("delme",$deltpl);

    block_end();
}
?>
