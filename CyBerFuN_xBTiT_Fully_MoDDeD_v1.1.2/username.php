<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Username
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

require_once ("include/functions.php");
require_once ("include/config.php");
dbconn();
  if ($CURUSER["uid"] > 1)
    {
  $uid = $CURUSER['uid'];
  $r = do_sqlquery("SELECT * from {$TABLE_PREFIX}users where id=$uid");
  $c = mysql_result($r, 0, "seedbonus");
if($c >= $GLOBALS["price_name"]) {
          if (isset($_POST["name"])) $custom = mysql_escape_string($_POST["name"]);
             else $custom = "";
    if ("$custom" == "")
        {
        }
    else
        {
          $res = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users WHERE username='".htmlspecialchars($custom)."'",true);
          if (mysql_num_rows($res) > 0){}else
          {do_sqlquery("UPDATE {$TABLE_PREFIX}users SET username='".htmlspecialchars($custom)."' WHERE id=$CURUSER[uid]");
          if ($FORUMLINK == "smf")
                {do_sqlquery("UPDATE {db_prefix}members SET  memberName='".htmlspecialchars($custom)."' WHERE ID_MEMBER=".$CURUSER["smf_fid"]);}
          $p = $GLOBALS["price_name"];
          do_sqlquery("UPDATE {$TABLE_PREFIX}users SET seedbonus=seedbonus-$p WHERE id=$CURUSER[uid]");}
        }
        }
header("Location: index.php?page=modules&module=seedbonus");
   }
else header("Location: index.php");
?>
