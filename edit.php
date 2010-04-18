<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. Edit
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



$link = urldecode($_GET["returnto"]);

if ($link == "")
   $link = "index.php?page=torrents";

// save editing and got back from where i come

if ((isset($_POST["comment"])) && (isset($_POST["name"]))){

   if ($_POST["action"] == $language["FRM_CONFIRM"]) {

   if ($_POST["name"] == '')
        {
        stderr("Error!","You must specify torrent name.");
   }

   if ($_POST["comment"] == '')
        {
        stderr("Error!", "You must specify description.");
   }
 /*Mod by losmi -sticky start*/
      $sticky = 0;
   if($_POST["sticky"] == 'on')
   {
    $sticky = 1;
   }
   /*Mod by losmi -sticky end*/
      /*Mod by losmi -visible start*/
      $visible = 3;
   if(isset($_POST["visible"]) && $_POST["visible"] != '')
   {
    $visible = sqlesc($_POST["visible"]);
   }
   /*Mod by losmi -visible end*/
   $fname = htmlspecialchars(AddSlashes(unesc($_POST["name"])));
   $torhash = AddSlashes($_POST["info_hash"]);
   write_log("Modified torrent $fname ($torhash)", "modify");
   do_sqlquery("UPDATE {$TABLE_PREFIX}files SET tag='".AddSlashes($_POST["tag"])."', filename='$fname', comment='" . AddSlashes($_POST["comment"]) . "', category=" . intval($_POST["category"]) . "  , visible = $visible, sticky = '" . $sticky . "'WHERE info_hash='" . $torhash . "'", true);
$userfile = $_FILES["userfile"];
        $screen1 = $_FILES["screen1"];
        $screen2 = $_FILES["screen2"];
        $screen3 = $_FILES["screen3"];
		$image_types = Array ("image/bmp",
								"image/jpeg",
								"image/pjpeg",
								"image/gif",
								"image/x-png");
        switch($_FILES["userfile"]["type"]) {
	        case 'image/bmp':
		    $file_name = $torhash.".bmp";
            break;
	        case 'image/jpeg':
    		$file_name = $torhash.".jpg";
            break;
	        case 'image/pjpeg':
    		$file_name = $torhash.".jpeg";
            break;
	        case 'image/gif':
    		$file_name = $torhash.".gif";
            break;
            case 'image/x-png':
    		$file_name = $torhash.".png";
            break;
        }
        switch($_FILES["screen1"]["type"]) {
	        case 'image/bmp':
		    $file_name_s1 = "s1".$torhash.".bmp";
            break;
	        case 'image/jpeg':
    		$file_name_s1 = "s1".$torhash.".jpg";
            break;
	        case 'image/pjpeg':
    		$file_name_s1 = "s1".$torhash.".jpeg";
            break;
	        case 'image/gif':
    		$file_name_s1 = "s1".$torhash.".gif";
            break;
            case 'image/x-png':
    		$file_name_s1 = "s1".$torhash.".png";
            break;
        }
        switch($_FILES["screen2"]["type"]) {
	        case 'image/bmp':
		    $file_name_s2 = "s2".$torhash.".bmp";
            break;
	        case 'image/jpeg':
    		$file_name_s2 = "s2".$torhash.".jpg";
            break;
	        case 'image/pjpeg':
    		$file_name_s2 = "s2".$torhash.".jpeg";
            break;
	        case 'image/gif':
    		$file_name_s2 = "s2".$torhash.".gif";
            break;
            case 'image/x-png':
    		$file_name_s2 = "s2".$torhash.".png";
            break;
        }
        switch($_FILES["screen3"]["type"]) {
	        case 'image/bmp':
		    $file_name_s3 = "s3".$torhash.".bmp";
            break;
	        case 'image/jpeg':
    		$file_name_s3 = "s3".$torhash.".jpg";
            break;
	        case 'image/pjpeg':
    		$file_name_s3 = "s3".$torhash.".jpeg";
            break;
	        case 'image/gif':
    		$file_name_s3 = "s3".$torhash.".gif";
            break;
            case 'image/x-png':
    		$file_name_s3 = "s3".$torhash.".png";
            break;
        }
        $uploadfile = $GLOBALS["uploaddir"] . $file_name;
        $uploadfile1 = $GLOBALS["uploaddir"] . $file_name_s1;
        $uploadfile2 = $GLOBALS["uploaddir"] . $file_name_s2;
        $uploadfile3 = $GLOBALS["uploaddir"] . $file_name_s3;
		$file_size = $_FILES["userfile"]["size"];
		$file_size1 = $_FILES["screen1"]["size"];
		$file_size2 = $_FILES["screen2"]["size"];
		$file_size3 = $_FILES["screen3"]["size"];
		$file_type = $_FILES["userfile"]["type"];
		$file_type1 = $_FILES["screen1"]["type"];
		$file_type2 = $_FILES["screen2"]["type"];
		$file_type3 = $_FILES["screen3"]["type"];
		$file_size = makesize1($file_size);
		$file_size1 = makesize1($file_size1);
		$file_size2 = makesize1($file_size2);
		$file_size3 = makesize1($file_size3);
		if (isset($_FILES["userfile"]))
		{
			if ($_FILES["userfile"]["name"] == '')
			{
			// do nothing...
			}
			else
			{
				if ($file_size > $GLOBALS["file_limit"])
				{
                    err_msg($language["ERROR"], $language["FILE_UPLOAD_TO_BIG"].": ".$file_limit.". ".$language["IMAGE_WAS"].": ".$file_size);
                    stdfoot();
                    exit();
				}
				elseif (in_array (strtolower ($file_type), $image_types, TRUE))
				{
					if (@move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
					{
                    	do_sqlquery("UPDATE {$TABLE_PREFIX}files SET image='".$file_name."' WHERE info_hash='" . $torhash . "'", true);
						$image_drop = "" . $_POST["userfileold"]. "";

						if (!empty($image_drop))
							unlink("".$GLOBALS["uploaddir"]."$image_drop");
					}
					else
					{
                        err_msg($language["ERROR"], $language["MOVE_IMAGE_TO"]." ".$GLOBALS["uploaddir"].". ".$language["CHECK_FOLDERS_PERM"]);
                        stdfoot();
                        exit();
					}
				}
				else
				{
                    err_msg ($language["ERROR"], $language["ILEGAL_UPLOAD"]);
					stdfoot();
					exit;
				}
			}
		}
		if (isset($_FILES["screen1"]))
		{
			if ($_FILES["screen1"]["name"] == '')
			{
			// do nothing...
			}
			else
			{
				if ($file_size1 > $GLOBALS["file_limit"])
				{
                    err_msg($language["ERROR"], $language["FILE_UPLOAD_TO_BIG"].": ".$file_limit.". ".$language["IMAGE_WAS"].": ".$file_size1);
                    stdfoot();
                    exit();
				}
				elseif (in_array (strtolower ($file_type1), $image_types, TRUE))
				{
					if (@move_uploaded_file($_FILES['screen1']['tmp_name'], $uploadfile1))
					{
                        do_sqlquery("UPDATE {$TABLE_PREFIX}files SET screen1='".$file_name_s1."' WHERE info_hash='" . $torhash . "'", true);
						$image_drop = "" . $_POST["userfileold1"]. "";

						if (!empty($image_drop))
							unlink("".$GLOBALS["uploaddir"]."$image_drop");
					}
					else
					{
                        err_msg($language["ERROR"], $language["MOVE_IMAGE_TO"]." ".$GLOBALS["uploaddir"].". ".$language["CHECK_FOLDERS_PERM"]);
                        stdfoot();
                        exit();
					}
				}
				else
				{
                    err_msg ($language["ERROR"], $language["ILEGAL_UPLOAD"]);
					stdfoot();
					exit;
				}
			}
		}
		if (isset($_FILES["screen2"]))
		{
			if ($_FILES["screen2"]["name"] == '')
			{
			// do nothing...
			}
			else
			{
				if ($file_size2 > $GLOBALS["file_limit"])
				{
                    err_msg($language["ERROR"], $language["FILE_UPLOAD_TO_BIG"].": ".$file_limit.". ".$language["IMAGE_WAS"].": ".$file_size2);
                    stdfoot();
                    exit();
				}
				elseif (in_array (strtolower ($file_type2), $image_types, TRUE))
				{
					if (@move_uploaded_file($_FILES['screen2']['tmp_name'], $uploadfile2))
					{
                        do_sqlquery("UPDATE {$TABLE_PREFIX}files SET screen2='".$file_name_s2."' WHERE info_hash='" . $torhash . "'", true);
						$image_drop = "" . $_POST["userfileold2"]. "";

						if (!empty($image_drop))
							unlink("".$GLOBALS["uploaddir"]."$image_drop");
					}
					else
					{
                        err_msg($language["ERROR"], $language["MOVE_IMAGE_TO"]." ".$GLOBALS["uploaddir"].". ".$language["CHECK_FOLDERS_PERM"]);
                        stdfoot();
                        exit();
					}
				}
				else
				{
                    err_msg ($language["ERROR"], $language["ILEGAL_UPLOAD"]);
					stdfoot();
					exit;
				}
			}
		}
		if (isset($_FILES["screen3"]))
		{
			if ($_FILES["screen3"]["name"] == '')
			{
			// do nothing...
			}
			else
			{
				if ($file_size3 > $GLOBALS["file_limit"])
				{
                    err_msg($language["ERROR"], $language["FILE_UPLOAD_TO_BIG"].": ".$file_limit.". ".$language["IMAGE_WAS"].": ".$file_size3);
                    stdfoot();
                    exit();
				}
				if (in_array (strtolower ($file_type3), $image_types, TRUE))
				{
					if (@move_uploaded_file($_FILES['screen3']['tmp_name'], $uploadfile3))
					{
                        do_sqlquery("UPDATE {$TABLE_PREFIX}files SET screen3='".$file_name_s3."' WHERE info_hash='" . $torhash . "'", true);
						$image_drop = "" . $_POST["userfileold3"]. "";

						if (!empty($image_drop))
							unlink("".$GLOBALS["uploaddir"]."$image_drop");
					}
					else
					{
                        err_msg($language["ERROR"], $language["MOVE_IMAGE_TO"]." ".$GLOBALS["uploaddir"].". ".$language["CHECK_FOLDERS_PERM"]);
                        stdfoot();
                        exit();
					}
				}
				else
				{
                    err_msg ($language["ERROR"], $language["ILEGAL_UPLOAD"]);
					stdfoot();
					exit;
				}
			}
		}
   do_sqlquery("UPDATE {$TABLE_PREFIX}files SET comment_notify='" . $_POST["comment_notify"] . "' WHERE info_hash='" . $torhash . "'", true);
   redirect($link);
   exit();
   }

   else {
        redirect($link);
        exit();
   }
}

// view torrent's details
if (isset($_GET["info_hash"])) {

   if ($XBTT_USE)
      {
       $tseeds = "f.seeds+ifnull(x.seeders,0) as seeds";
       $tleechs = "f.leechers+ifnull(x.leechers,0) as leechers";
       $tcompletes = "f.finished+ifnull(x.completed,0) as finished";
       $ttables = "{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
      }
   else
       {
       $tseeds = "f.seeds as seeds";
       $tleechs = "f.leechers as leechers";
       $tcompletes = "f.finished as finished";
       $ttables = "{$TABLE_PREFIX}files f";
       }

  $query = "SELECT f.sticky, tag, f.image, f.screen1, f.screen2, f.screen3, f.info_hash, f.filename, f.visible, f.url, UNIX_TIMESTAMP(f.data) as data, f.size, f.comment, f.category as cat_name, $tseeds, $tleechs, $tcompletes, f.speed, f.uploader FROM $ttables WHERE f.info_hash ='" . AddSlashes($_GET["info_hash"]) . "'";
  $res = do_sqlquery($query, true);
  $results = mysql_fetch_assoc($res);

  if (!$results || mysql_num_rows($res) == 0)
     err_msg($language["ERROR"], $language["TORRENT_EDIT_ERROR"]);

  else {

    if (!$CURUSER || $CURUSER["uid"] < 2 || ($CURUSER["edit_torrents"] == "no" && $CURUSER["uid"] != $results["uploader"]))
       {
           stderr($language["ERROR"], $language["CANT_EDIT_TORR"]);
       }

    $torrenttpl = new bTemplate();
    $torrenttpl->set("language", $language);
    $row = $res[0];
    $torrenttpl->set("imageon", $GLOBALS["imageon"] == "true", TRUE);
    $torrenttpl->set("screenon", $GLOBALS["screenon"] == "true", TRUE);
/*
    $s = "<select name=\"type\">\n<option value=\"0\">(".$language["CHOOSE_ONE"].")</option>\n";
    $cats = genrelist();

    foreach ($cats as $row) {
        $s .= "<option value=\"" . $row["id"] . "\"";
        if ($row["id"] == $results["cat_name"])
            $s .= " \"selected\"";
        $s .= ">" . unesc($row["name"]) . "</option>\n";
    }
    $s .= "</select>\n";
*/

    $torrent = array();
              /*Start sticky by losmi*/
              $query = "SELECT * FROM {$TABLE_PREFIX}sticky";
              $rez = do_sqlquery($query,true);
              $rez = mysql_fetch_assoc($rez);
              $rez_level = $rez['level'];
              $current_level = getLevel($CURUSER['id_level']);
              $level_ok = false;
              
              if ($CURUSER["uid"]>1 && $current_level>=$rez_level)
                 {
                  $torrenttpl->set("LEVEL_OK",true,FALSE);
                 }
              else
                 {
                  $torrenttpl->set("LEVEL_OK",false,TRUE);
                 }
             unset($rez);

            if($results["sticky"] == 1)
            {
             $torrent["sticky"] = "<input type='checkbox' name='sticky' checked>" ;
            }
            else 
            {
                $torrent["sticky"] = "<input type='checkbox' name='sticky'>" ;
            }
            /*End sticky by losmi*/

              /*Start mod visible by losmi*/
              $query = "SELECT * FROM {$TABLE_PREFIX}visible";
              $rez = do_sqlquery($query, true);
              $rez = mysql_fetch_assoc($rez);
              $rez_level = $rez['level'];
              $current_level = getLevelVisible($CURUSER['id_level']);
              $level_ok = false;

              if ($current_level >= $rez_level )
                 {
                  $torrenttpl->set("LEVEL_VISIBLE_OK", true, FALSE);
                 }
              else
                 {
                  $torrenttpl->set("LEVEL_VISIBLE_OK", false, TRUE);
                 }
             unset($rez);

              $users_level = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users_level ORDER BY id", true);
               $torrent['visible'] = "<select name='visible'>";
              while ($row = mysql_fetch_assoc($users_level))
                {
                    if($row['id_level'] >= 3)
                    {
                        if($results["visible"] == $row['id_level']){$selected = 'selected';} else{$selected = '';}
                        $torrent['visible'] .= "<option value=".$row['id_level']." ".$selected.">".$row['level']."</option>" ;
                        
                    }
                }
                $torrent['visible'] .= "</select>"; 
                
            /*End sticky by losmi*/
    $torrent["link"] = "index.php?page=edit&info_hash=".$results["info_hash"]."&returnto=".urlencode($link);
    $torrent["filename"] = $results["filename"];
    $torrent["tag"] = $results["tag"];
    $torrent["info_hash"] = $results["info_hash"];
    $torrent["description"] = textbbcode("edit", "comment", unesc($results["comment"]));
    $torrent["size"] = makesize($results["size"]);

    include(dirname(__FILE__)."/include/offset.php");

    $torrent["date"] = date("d/m/Y", $results["data"] - $offset);
    $torrent["complete"] = $results["finished"]." ".$language["X_TIMES"];
    $torrent["peers"] = $language["SEEDERS"] .": " .$results["seeds"].",".$language["LEECHERS"] .": ". $results["leechers"]."=". ($results["leechers"] + $results["seeds"]). " ". $language["PEERS"];
    $torrent["cat_combo"] = categories($results["cat_name"]); //$s;
// email_notification
		$res1 = mysql_fetch_assoc(mysql_query("SELECT comment_notify FROM {$TABLE_PREFIX}files WHERE info_hash = '" . AddSlashes($_GET["info_hash"]) . "'")) or sqlerr();
		$arr1 = $res1["comment_notify"];
//		$torrent["ed2klink"] = $results["ed2klink"];
		if ($arr1 == "true")
        {
          $torrent["COMMENT_NOTIFY_TRUE"] = "checked=\"checked\"";
          $torrent["COMMENT_NOTIFY_FALSE"] = "";
        }
		else
		{
			$torrent["COMMENT_NOTIFY_TRUE"] = "";
			$torrent["COMMENT_NOTIFY_FALSE"] = "checked=\"checked\"";
		}

    $torrenttpl->set("torrent", $torrent);

    unset($results);
    mysql_free_result($res);

  }
}
?>
