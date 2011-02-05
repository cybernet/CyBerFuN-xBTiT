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

// DT , no tpl needed

if (!defined("IN_BTIT"))
      die("non direct access!");
		
$id2 = (int)$_POST["id"];
$res = mysql_query("SELECT * FROM {$TABLE_PREFIX}requests WHERE id=$id2");
$row = mysql_fetch_array($res);

if ($CURUSER["uid"] == $row["userid"] || $CURUSER["id_level"] >= "7")
{
	$id = (int)$_POST["id"];
	$requesttitle = $_POST["requesttitle"];
	$descr = $_POST["description"];
	$cat = $_POST["category"];
	
	if ($requesttitle=="" || $cat==0 || $descr=="")
	{
      stderr("ERROR","Missing Data");
      stdfoot();
      die;
    }
	
	$request = sqlesc($requesttitle);
	$descr = sqlesc($descr);
	$cat = sqlesc($cat);
	
	mysql_query("UPDATE {$TABLE_PREFIX}requests SET cat=$cat, request=$request, descr=$descr where id=$id");
	
	$id = mysql_insert_id();
	
	header("Refresh: 0; url=index.php?page=viewrequests");
}
else
{
      stderr("ERROR","No Authorisation");
      stdfoot();
      die;

}

?>