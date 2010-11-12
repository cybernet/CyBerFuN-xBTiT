<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Details
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xList.ro/
// http://xDnS.ro/
// http://yDnS.ro/
// Modified By cybernet2u

// CyBerFuN xBTiT Fully MoDDeD v1.2


// https://cyberfun-xbtit.svn.sourceforge.net/svnroot/cyberfun-xbtit


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


$id = AddSlashes((isset($_GET["id"])?$_GET["id"]:false));

if (!isset($id) || !$id)
    stderr($language["ERROR"], $language["ERROR_ID"].": $id", $GLOBALS["usepopup"]);

require_once(load_language("lang_torrents.php"));

if (isset($_GET["act"]) && $_GET["act"] == "update")
   {
       //die("<center>".$language["TORRENT_UPDATE"]."</center>");
       require_once(dirname(__FILE__)."/include/getscrape.php");

       scrape(urldecode($_GET["surl"]), $id);

       redirect("index.php?page=torrent-details&id=$id");
       exit();
   }

if ($XBTT_USE)
   {
    $tseeds = "f.seeds+ifnull(x.seeders,0) as seeds";
    $tleechs = "f.leechers+ifnull(x.leechers,0) as leechers";
    $tcompletes = "f.finished+ifnull(x.completed,0) as finished";
    $ttables = "{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash = f.bin_hash";
   }
else
    {
    $tseeds = "f.seeds as seeds";
    $tleechs = "f.leechers as leechers";
    $tcompletes = "f.finished as finished";
    $ttables = "{$TABLE_PREFIX}files f";
    }


if(!$CURUSER || $CURUSER["view_torrents"] != "yes")
{
    err_msg($language["ERROR"], $language["NOT_AUTHORIZED"]." ".$language["MNU_TORRENT"]."!<br />\n".$language["SORRY"]."...");
    stdfoot();
    exit();
}


$res = get_result("SELECT tag, f.screen1, f.screen2, f.screen3, f.image, u.warn, f.info_hash, f.filename, f.url, UNIX_TIMESTAMP(f.data) as data, f.size, f.comment, f.uploader, c.name as cat_name, $tseeds, $tleechs, $tcompletes, f.speed, f.external, f.announce_url,UNIX_TIMESTAMP(f.lastupdate) as lastupdate,UNIX_TIMESTAMP(f.lastsuccess) as lastsuccess, f.anonymous, u.username FROM $ttables LEFT JOIN {$TABLE_PREFIX}categories c ON c.id=f.category LEFT JOIN {$TABLE_PREFIX}users u ON u.id=f.uploader WHERE f.info_hash ='" . $id . "'", true, $btit_settings['cache_duration']);

$res_m = getmoderstatusbyhash($id);

if (count($res) < 1)
   stderr($language["ERROR"], "Bad ID!", $GLOBALS["usepopup"]);
$row = $res[0];

$spacer = "&nbsp;&nbsp;";


$torrenttpl = new bTemplate();
// Snatchers hack by DT dec 2008
$sres = get_result("SELECT * FROM {$TABLE_PREFIX}history WHERE infohash = '$id' AND date IS NOT NULL ORDER BY date DESC LIMIT 10 ", true, $btit_settings['cache_duration']);
$srow = count($sres);

	if (count($sres) > 0)

       $snatchers = array();
       $plus = 0;

    foreach ($sres as $id=>$srow)

{
$res = get_result("SELECT prefixcolor, suffixcolor, users.id, username, level FROM {$TABLE_PREFIX}users users INNER JOIN {$TABLE_PREFIX}users_level users_level ON users.id_level=users_level.id WHERE users.id='".$srow["uid"]."'", true, $btit_settings['cache_duration']);
$result = $res[0];
$snatchers[$plus]["snatch"] = "<a href=index.php?page=userdetails&id=$result[id]>".unesc($result["prefixcolor"]).unesc($result["username"]).unesc($result["suffixcolor"])."</a>&nbsp;";
$plus++;
}
$torrenttpl->set("snatchers", $snatchers);
// Snatchers hack end

if (!empty($row["image"]))
{
$image1 = "".$row["image"]."";
$upload_dir = $GLOBALS["uploaddir"];
$image_new = "$upload_dir/$image1"; // url of picture
// $image_new = str_replace(' ','%20', $image_new); // take url and replace spaces
$max_width = "490"; // maximum width allowed for pictures
$resize_width = "490"; // same as max width
$size = getimagesize("$image_new"); // get the actual size of the picture
$width = $size[0]; // get width of picture
$height = $size[1]; // get height of picture
if ($width > $max_width){
$new_width = $resize_width; // Resize Image If over max width
} else {
$new_width = $width; // Keep original size from array because smaller than max
}
$torrenttpl->set("width", $new_width);
}
$torrenttpl->set("language", $language);
$torrenttpl->set("IMAGEIS", !empty($row["image"]), TRUE);
$torrenttpl->set("SCREENIS1", !empty($row["screen1"]), TRUE);
$torrenttpl->set("SCREENIS2", !empty($row["screen2"]), TRUE);
$torrenttpl->set("SCREENIS3", !empty($row["screen3"]), TRUE);
$torrenttpl->set("uploaddir", $upload_dir);
if ($CURUSER["uid"] > 1 && ($CURUSER["uid"] == $row["uploader"] || $CURUSER["edit_torrents"] == "yes" || $CURUSER["delete_torrents"] == "yes"))
   {
    $torrenttpl->set("MOD", TRUE, TRUE);
    $torrent_mod = "<br />&nbsp;&nbsp;";
    $torrenttpl->set("SHOW_UPLOADER", true, true);
   }
else
   {
    $torrenttpl->set("SHOW_UPLOADER", $SHOW_UPLOADER, true);
    $torrenttpl->set("MOD", false, TRUE);
   }

// edit and delete picture/link
if ($CURUSER["uid"] > 1 && ($CURUSER["uid"] == $row["uploader"] || $CURUSER["edit_torrents"] == "yes")) {
      if ($GLOBALS["usepopup"])
        $torrent_mod .= "<a href=\"javascript: windowunder('index.php?page=edit&amp;info_hash=".$row["info_hash"]."&amp;returnto=".urlencode("index.php?page=torrent-details&id=$row[info_hash]")."')\">".image_or_link("$STYLEPATH/images/edit.png","", $language["EDIT"])."</a>&nbsp;&nbsp;";
      else
        $torrent_mod .= "<a href=\"index.php?page=edit&amp;info_hash=".$row["info_hash"]."&amp;returnto=".urlencode("index.php?page=torrent-details&id=$row[info_hash]")."\">".image_or_link("$STYLEPATH/images/edit.png","", $language["EDIT"])."</a>&nbsp;&nbsp;";

}

if ($CURUSER["uid"] > 1 && ($CURUSER["uid"] == $row["uploader"] || $CURUSER["delete_torrents"] == "yes")) {
      if ($GLOBALS["usepopup"])
        $torrent_mod .= "<a href=\"javascript: windowunder('index.php?page=delete&amp;info_hash=".$row["info_hash"]."&amp;returnto=".urlencode("index.php?page=torrents")."')\">".image_or_link("$STYLEPATH/images/delete.png","", $language["DELETE"])."</a>&nbsp;&nbsp;";
      else
        $torrent_mod .= "<a href=\"index.php?page=delete&amp;info_hash=".$row["info_hash"]."&amp;returnto=".urlencode("index.php?page=torrents")."\">".image_or_link("$STYLEPATH/images/delete.png","", $language["DELETE"])."</a>";
}


$torrenttpl->set("mod_task", $torrent_mod);
if (!empty($row["comment"]))
   $row["description"] = format_comment($row["comment"]);

if (isset($row["cat_name"]))
    $row["cat_name"] = unesc($row["cat_name"]);
else
    $row["cat_name"] = unesc($language["NONE"]);

# <!--
##################################################################
########################################################################-->
require('ajaxstarrater/_drawrating.php'); # ajax rating

  if ($row["username"] != $CURUSER["username"] && $CURUSER["uid"] > 1) {
      $row["rating"] =  rating_bar("" . $_GET["id"]. "", 5);
  } else {
      $row["rating"] = rating_bar("" . $_GET["id"]. "", 5, 'static');
  }
  $row["rating"];
# <!--
##################################################################
########################################################################-->
$row["size"] = makesize($row["size"]);
// files in torrent - by Lupin 20/10/05

require_once(dirname(__FILE__)."/include/BDecode.php");
if (file_exists($row["url"]))
  {
    $torrenttpl->set("DISPLAY_FILES", TRUE, TRUE);
    $ffile = fopen($row["url"], "rb");
    $content = fread($ffile, filesize($row["url"]));
    fclose($ffile);
    $content = BDecode($content);
    $numfiles = 0;
    if (isset($content["info"]) && $content["info"])
      {
        $thefile = $content["info"];
        if (isset($thefile["length"]))
          {
          $dfiles[$numfiles]["filename"] = htmlspecialchars($thefile["name"]);
          $dfiles[$numfiles]["size"] = makesize($thefile["length"]);
          $numfiles++;
          }
        elseif (isset($thefile["files"]))
         {
           foreach($thefile["files"] as $singlefile)
             {
               $dfiles[$numfiles]["filename"] = htmlspecialchars(implode("/",$singlefile["path"]));
               $dfiles[$numfiles]["size"] = makesize($singlefile["length"]);
               $numfiles++;
             }
         }
       else
         {
            // can't be but...
         }
     }
     $row["numfiles"] = $numfiles.($numfiles == 1?" file":" files");
     unset($content);
  }
else
    $torrenttpl->set("DISPLAY_FILES", false, TRUE);

$torrenttpl->set("files", $dfiles);

// end files in torrents
include(dirname(__FILE__)."/include/offset.php");
$row["date"] = date("d/m/Y", $row["data"] - $offset);

if ($row["anonymous"] == "true")
{
   if ($CURUSER["edit_torrents"] == "yes")
       $uploader = "<a href=\"index.php?page=userdetails&amp;id=".$row['uploader']."\">".$language["TORRENT_ANONYMOUS"]."</a>";
   else
      $uploader = $language["TORRENT_ANONYMOUS"];
   }
else
    $uploader = "<a href=\"index.php?page=userdetails&amp;id=".$row['uploader']."\">".$row["username"].warn($row) ."</a>";

$row["uploader"] = $uploader;

if ($row["speed"] < 0) {
  $speed = "N/D";
}
else if ($row["speed"] > 2097152) {
  $speed = round($row["speed"] / 1048576, 2) . " MB/sec";
}
else {
  $speed = round($row["speed"] / 1024, 2) . " KB/sec";
}

$torrenttpl->set("NOT_XBTT", !$XBBT_USE, TRUE);
$torrenttpl->set("YES_TAG", $row["tag"], TRUE);

$row["speed"] = $speed;

// moder
    if ($CURUSER['moderate_trusted'] == 'yes')
    $moderation = TRUE;
    $torrenttpl->set("MODER", $moderation, TRUE);
    
    $moder = $res_m;
    $row["moderation"] .= "<a title=\"".$moder."\" href=\"index.php?page=edit&info_hash=".$row["info_hash"]."\"><img alt=\"".$moder."\" src=\"images/mod/".$moder.".png\"></a>";
// moder

if (($XBTT_USE && !$PRIVATE_ANNOUNCE) || $row["external"] == "yes") 
   {
$row["downloaded"] = $row["finished"]." " . $language["X_TIMES"];
$row["peers"] = ($row["leechers"] + $row["seeds"])." ".$language["PEERS"];
$row["seeds"] = $language["SEEDERS"].": ".$row["seeds"];
$row["leechers"] = $language["LEECHERS"].": " . $row["leechers"];
   }
else
   {
$row["downloaded"] = "<a href=\"index.php?page=torrent_history&amp;id=".$row["info_hash"]."\">" . $row["finished"] . "</a> " . $language["X_TIMES"];
$row["peers"] = "<a href=\"index.php?page=peers&amp;id=".$row["info_hash"]."\">" . ($row["leechers"]+$row["seeds"]) . "</a> ".$language["PEERS"];
$row["seeds"] = $language["SEEDERS"].": <a href=\"index.php?page=peers&amp;id=".$row["info_hash"]."\">" . $row["seeds"] . "</a>";
$row["leechers"] = $language["LEECHERS"].": <a href=\"index.php?page=peers&amp;id=".$row["info_hash"]."\">" . $row["leechers"] ."</a>";
   }
if ($row["external"] == "yes")
   {
     $torrenttpl->set("EXTERNAL", TRUE, TRUE);
     $row["update_url"] = "<a href=\"index.php?page=torrent-details&amp;act=update&amp;id=".$row["info_hash"]."&amp;surl=".urlencode($row["announce_url"])."\">".$language["UPDATE"]."</a>";
     $row["announce_url"] = "<b>".$language["EXTERNAL"]."</b><br />".$row["announce_url"];
     $row["lastupdate"] = get_date_time($row["lastupdate"]);
     $row["lastsuccess"] = get_date_time($row["lastsuccess"]);
   }
else
   $torrenttpl->set("EXTERNAL", false, TRUE);

// comments...
if ($XBTT_USE)
   {
    $subres = get_result("SELECT u.downloaded+IFNULL(x.downloaded,0) as downloaded, u.uploaded+IFNULL(x.uploaded,0) as uploaded, u.avatar, c.id, c.text, UNIX_TIMESTAMP(c.added) as data, c.user, u.id uid, u.id_level FROM {$TABLE_PREFIX}comments c LEFT JOIN {$TABLE_PREFIX}users u ON c.user=u.username LEFT JOIN xbt_users x ON x.uid=u.id LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE info_hash = '" . $id . "' ORDER BY c.added DESC", true, 0);
   }
else
   {
    $subres = get_result("SELECT u.downloaded as downloaded, u.uploaded as uploaded, u.avatar, u.id_level, u.custom_title, c.id, u.warn, text, UNIX_TIMESTAMP(added) as data, user, u.id as uid FROM {$TABLE_PREFIX}comments c LEFT JOIN {$TABLE_PREFIX}users u ON c.user=u.username WHERE info_hash = '" . $id . "' ORDER BY added DESC", true, 0);
}
if (!$subres || count($subres) == 0) {
     if($CURUSER["uid"] > 1)
       $torrenttpl->set("INSERT_COMMENT", TRUE, TRUE);
     else
       $torrenttpl->set("INSERT_COMMENT", false, TRUE);

    $torrenttpl->set("NO_COMMENTS", true, TRUE);
}
else {

     $torrenttpl->set("NO_COMMENTS", false, TRUE);

     if($CURUSER["uid"] > 1)
       $torrenttpl->set("INSERT_COMMENT", TRUE, TRUE);
     else
       $torrenttpl->set("INSERT_COMMENT", false, TRUE);
     $comments = array();
     $count = 0;
     foreach ($subres as $subrow) {

       $level = get_result("SELECT level FROM {$TABLE_PREFIX}users_level WHERE id_level='$subrow[id_level]'", true, $btit_settings['cache_duration']);
       $lvl = $level[0];
       if (!$subrow[uid])
        $title = "orphaned";
       elseif (!"$subrow[custom_title]")
        $title = "".$lvl['level']."";
       else
        $title = unesc($subrow["custom_title"]);
       $comments[$count]["user"] = "<a href=\"index.php?page=userdetails&amp;id=".$subrow["uid"]."\">" . unesc($subrow["user"]).warn($row)."</a>";
       $comments[$count]["user"] .= "</a><br/> ".$title;
       $comments[$count]["date"] = date("d/m/Y H.i.s", $subrow["data"] - $offset);

       $comments[$count]["elapsed"] = "(".get_elapsed_time($subrow["data"]) . " ago)";
       $comments[$count]["avatar"] = "<img onload=\"resize_avatar(this);\" src=\"".($subrow["avatar"] && $subrow["avatar"] != "" ? htmlspecialchars($subrow["avatar"]): "$STYLEURL/images/default_avatar.gif" )."\" alt=\"\" />";
       $comments[$count]["ratio"] = "<img src=\"images/arany.png\">&nbsp;".(intval($subrow['downloaded']) > 0 ? number_format($subrow['uploaded'] / $subrow['downloaded'], 2):"---");
       $comments[$count]["uploaded"] = "<img src=\"images/speed_up.png\">&nbsp;".(makesize($subrow["uploaded"]));
       $comments[$count]["downloaded"] = "<img src=\"images/speed_down.png\">&nbsp;".(makesize($subrow["downloaded"]));
       // only users able to delete torrents can delete comments...
       if ($CURUSER["delete_torrents"] == "yes")
         $comments[$count]["delete"] = "<a onclick=\"return confirm('". str_replace("'","\'",$language["DELETE_CONFIRM"])."')\" href=\"index.php?page=comment&amp;id=".$row["info_hash"]."&amp;cid=" . $subrow["id"] . "&amp;action=delete\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>";
       $comments[$count]["comment"] = format_comment($subrow["text"]);
       $count++;
        }
     unset($subrow);
     unset($subres);
}

$torrenttpl->set("current_username", $CURUSER["username"]);

if ($GLOBALS["usepopup"])
    $torrenttpl->set("torrent_footer", "<a href=\"javascript: window.close();\">".$language["CLOSE"]."</a>");
else
    $torrenttpl->set("torrent_footer", "<a href=\"javascript: history.go(-1);\">".$language["BACK"]."</a>");


$torrenttpl->set("torrent", $row);
$torrenttpl->set("comments", $comments);
$torrenttpl->set("files", $dfiles);

?>
