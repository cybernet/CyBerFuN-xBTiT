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

if (!defined("IN_BTIT"))
      die("non direct access!");

global $CURUSER;
if (!$CURUSER || $CURUSER["edit_torrents"]=="no")
   {
    // do nothing
   }
else
    {

if (empty($_POST["delreq"])){

      stderr("ERROR","You must select at least one request to delete.");
      stdfoot();
      die;

}

$do="DELETE FROM {$TABLE_PREFIX}requests WHERE id IN (" . implode(", ", $_POST[delreq]) . ")";
$do2="DELETE FROM {$TABLE_PREFIX}addedrequests WHERE requestid IN (" . implode(", ", $_POST[delreq]) . ")";
$res2=mysql_query($do2);
$res=mysql_query($do);


        information_msg("Request Deleted","Go back to<a href=index.php?page=viewrequests><b> REQUESTS</a>");
        stdfoot();
        exit();
}
?>