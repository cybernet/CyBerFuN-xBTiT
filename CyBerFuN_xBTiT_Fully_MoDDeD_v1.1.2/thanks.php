<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Thanks
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

if (isset($_POST["infohash"]))
{

  $THIS_BASEPATH = dirname(__FILE__);
  require("$THIS_BASEPATH/include/functions.php");
  include(load_language("lang_torrents.php"));
  dbconn();

  $uid = intval(0 + $CURUSER['uid']);
  $infohash = ($_POST["infohash"]);

  $out = "";

  $rt = mysql_query("SELECT uploader FROM {$TABLE_PREFIX}files WHERE info_hash=$infohash AND uploader=$uid");
  // he's not the uploader
  if (mysql_num_rows($rt) == 0)
     $button = true;
  else
     $button = false;

  // saying thank you.
  if (isset($_POST["thanks"]) && $button)
  {
      mysql_free_result($rt);
      $rt = mysql_query("SELECT userid FROM {$TABLE_PREFIX}files_thanks WHERE userid=$uid AND infohash=$infohash");
      // never thanks for this file
      if (mysql_num_rows($rt) == 0)
        {
           @mysql_query("INSERT INTO {$TABLE_PREFIX}files_thanks (infohash, userid) VALUES ($infohash, $uid)");
      }
  }

  mysql_free_result($rt);
  $rt = mysql_query("SELECT u.id, u.username, ul.prefixcolor, ul.suffixcolor FROM {$TABLE_PREFIX}files_thanks t LEFT JOIN
                   {$TABLE_PREFIX}users u ON u.id=t.userid LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE infohash=$infohash");
  if (mysql_num_rows($rt) == 0)
     $out = $language["THANKS_BE_FIRST"];


  while ($ty = mysql_fetch_assoc($rt))
    {
      if ($ty["id"] == $uid) // already thank
        $button = false;
      $out .= "<a href=\"$BASEURL/index.php?page=userdetails&amp;id=".$ty["id"]."\">".unesc($ty["prefixcolor"].$ty["username"].$ty["suffixcolor"])."</a> ";
  }
  if ($button && $CURUSER["uid"] > 1)
     $out .= "|0";
  else
     $out .= "|1";

}
else
  $out = "no direct access!";

echo $out;
die;
?>
