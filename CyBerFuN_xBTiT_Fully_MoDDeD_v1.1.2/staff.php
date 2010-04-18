<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Staff
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

if (!defined("IN_BTIT"))
      die("non direct access!");
      
require(load_language("lang_staff.php"));

$stafftpl= new bTemplate();
$stafftpl-> set("language", $language);

if ($CURUSER["view_users"] == "no")
{
    err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".strtolower($language["STAFF"])."!");
    stdfoot();
    exit;
}
else
{  
    $query = "SELECT u.id, u.username, u.avatar, UNIX_TIMESTAMP(u.joined) joined, ";
    $query .= "UNIX_TIMESTAMP(u.lastconnect) lastconnect, ul.level, ul.prefixcolor, ";
    $query .= "ul.suffixcolor, c.name country, c.flagpic, o.lastaction ";
    $query .= "FROM {$TABLE_PREFIX}users u ";
    $query .= "LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level = ul.id ";
    $query .= "LEFT JOIN {$TABLE_PREFIX}countries c ON u.flag = c.id ";
    $query .= "LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id ";
    $query .= "WHERE u.id_level >=6 ";
    $query .= "AND u.id_level <=8 ";
    $query .= "ORDER BY u.id_level DESC, u.id ASC";
    
    $res = do_sqlquery($query);
    
    $i = 0;
    while($row = mysql_fetch_assoc($res))
    {
        ((is_null($row["avatar"]) || $row["avatar"] == "") ? $avatar = "<img src='$STYLEURL/images/default_avatar.gif' height=80 width=80>" : $avatar = "<img src='".$row["avatar"]."' height=80 width=80>");
        (is_null($row["lastaction"]) ? $lastseen = $row["lastconnect"] : $lastseen = $row["lastaction"]);
        ((time()-$lastseen > 900) ? $status = "<img src='images/offline.gif' border='0' alt='".$language["OFFLINE"]."'>" : $status = "<img src='images/online.gif' border='0' alt='".$language["ONLINE"]."'>");
        if(is_null($row["flagpic"]))
        {
            $row["flagpic"] = "unknown.gif";
            $row["country"] = $language["UNKNOWN"];
        }
        $user[$i] = "<tr>";
        $user[$i] .= "<td class='lista' width='84'><center>$avatar</center></td>";
        $user[$i] .= "<td class='lista'><center><a href='index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=".$CURUSER["uid"]."&amp;what=new&amp;to=".$row["username"]."'><img src='$STYLEURL/images/pm.gif'alt='".$language["PM"]."' border='0'></a></center></td>";
        $user[$i] .= "<td class='lista'><center><a href='index.php?page=userdetails&amp;id=".$row["id"]."'>".stripslashes($row["prefixcolor"]) . $row["username"] . stripslashes($row["suffixcolor"])."</a></center></td>";
        $user[$i] .= "<td class='lista'><center>".ucfirst($row["level"])."</center></td>";
        $user[$i] .= "<td class='lista'><center><img src='images/flag/".$row["flagpic"]."' border='0' alt='".$row["country"]."'></center></td>";
        $user[$i] .= "<td class='lista'><center>".date("d/m/Y H:i:s", $row["joined"])."</center></td>";
        $user[$i] .= "<td class='lista'><center>$status</center></td>";
        $user[$i] .= "</tr>";
        $i++;
    }
}
$stafftpl-> set("user",$user);

?>
