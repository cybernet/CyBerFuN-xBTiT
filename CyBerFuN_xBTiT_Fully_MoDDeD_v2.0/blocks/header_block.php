<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2011  Btiteam
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

global $CURUSER, $FORUMLINK, $db_prefix, $XBTT_USE, $btit_settings;
?>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<?php

print("<td style=\"text-align:center;\" align=\"center\"><a href='index.php'>".$language["MNU_INDEX"]."</a></td>\n");
if ($CURUSER["uid"]==1 || !$CURUSER)
{
    print("<td class=\"green\" align=\"center\"><a href='index.php?page=login'>".$language["LOGIN"]."</a>\n");
}
if($CURUSER["view_torrents"]=="yes") 
{
print("</td><td class=\"red\" align=\"center\"><a href=\"index.php?page=torrents\">".$language["MNU_TORRENT"]."</a>");
print("</td><td class=\"red\" align=\"center\"><a href=\"index.php?page=viewrequests\">".$language["VR"]."</a>");
}
if ($CURUSER["can_upload"]=="yes")                
{
print("<td class=\"green\" align=\"center\"><a href='index.php?page=upload'>".$language["MNU_UPLOAD"]."</a></td>\n");
}
if ($CURUSER["view_news"]=="yes")
    {
        print("<td style=\"text-align:center;\" align=\"center\"><a href='index.php?page=viewnews'>".$language['MNU_NEWS']."</a></td>\n");
    }
		if ($CURUSER["view_users"]=="yes")
		{    
    print("<td style=\"text-align:center;\" align=\"center\"><a href='index.php?page=users'>".$language["MNU_MEMBERS"]."</a></td>\n");
    }
?>
</tr>
</table>
