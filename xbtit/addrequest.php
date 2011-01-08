<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2009  Btiteam
//
//    This file is part of xbtit.
//
// Torrent Request & Vote by miskotes  - converted to XBTIT-2 by DiemThuy - March 2009
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

// DT no TPL file needed - file = 100 done

$requestid = (int)$_GET["id"];
$userid = (int)$CURUSER["uid"];
$res = mysql_query("SELECT * FROM {$TABLE_PREFIX}addedrequests WHERE requestid=$requestid and userid = $userid") or sqlerr();
$arr = mysql_fetch_assoc($res);
$voted = $arr;

if ($voted) {

      stderr("ERROR","<p>You've already voted for this request, only 1 vote for each request is allowed</p><p>Back to <a href=index.php?page=viewrequests><b>view requests</b></a></p>");
      stdfoot();
      die;

}else {
mysql_query("UPDATE {$TABLE_PREFIX}requests SET hits = hits + 1 WHERE id=$requestid") or sqlerr();
@mysql_query("INSERT INTO {$TABLE_PREFIX}addedrequests VALUES(0, $requestid, $userid)") or sqlerr();


        information_msg("Successfully voted","<p>Successfully voted for request $requestid</p><p>Back to <a href=index.php?page=viewrequests><b>view requests</b></a></p>");
        stdfoot();
        exit();
}


?>