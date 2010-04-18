<?php
// CyBerFuN.ro & xList.ro

// CyBerFuN .::. inDeX
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
// Modified By cybernet2u

if (file_exists("install.unlock") && file_exists("install.php"))
   {
   if (dirname($_SERVER["PHP_SELF"])=="/" || dirname($_SERVER["PHP_SELF"])=="\\")
      header("Location: http://".$_SERVER["HTTP_HOST"]."/install.php");
   else
      header("Location: http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/install.php");
   exit;
}

define("IN_BTIT",true);


$THIS_BASEPATH = dirname(__FILE__);

include("$THIS_BASEPATH/btemplate/bTemplate.php");

require("$THIS_BASEPATH/include/functions.php");

$sp = $_SERVER['SERVER_PORT']; $ss = $_SERVER['HTTPS']; if ( $sp =='443' || $ss == 'on' || $ss == '1') $p = 's';
$domain = 'http'.$p.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$domain = str_replace('/index.php', '', $domain);

if ($BASEURL != $domain) {
 $currentFile = $_SERVER['REQUEST_URI']; preg_match("/[^\/]+$/",$currentFile,$matches);
 $filename = "/" . $matches[0];
 header ("Location: " . $BASEURL . $filename . "");          
}


$time_start = get_microtime();

//require_once ("$THIS_BASEPATH/include/config.php");

dbconn(true);


// get user's style
$resheet=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}style where id=".$CURUSER["style"]."");
if (!$resheet)
   {

   $STYLEPATH="$THIS_BASEPATH/style/xbtit_default";
   $STYLEURL="$BASEURL/style/xbtit_default";
}
else
    {
        $resstyle=mysql_fetch_array($resheet);
        $STYLEPATH="$THIS_BASEPATH/".$resstyle["style_url"];
        $STYLEURL="$BASEURL/".$resstyle["style_url"];
}

$style_css=load_css("main.css");


$idlang=intval($_GET["language"]);

$pageID=(isset($_GET["page"])?$_GET["page"]:"");

$no_columns=(isset($_GET["nocolumns"]) && intval($_GET["nocolumns"])==1?true:false);

// getting user language
if ($idlang==0)
   $reslang=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}language WHERE id=".$CURUSER["language"]);
else
   $reslang=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}language WHERE id=$idlang");

if (!$reslang)
   {
   $USERLANG="$THIS_BASEPATH/language/english";
   }
else
    {
        $rlang=mysql_fetch_array($reslang);
        $USERLANG="$THIS_BASEPATH/".$rlang["language_url"];
    }



clearstatcache();

session_start();


check_online(session_id(), ($pageID==""?"index":$pageID));

require(load_language("lang_main.php"));


$tpl=new bTemplate();
$tpl->set("main_title",$btit_settings["name"]." .::. "."Index");

// is language right to left?
if (!empty($language["rtl"]))
   $tpl->set("main_rtl"," dir=\"".$language["rtl"]."\"");
else
   $tpl->set("main_rtl","");
if (!empty($language["charset"]))
  {
   $GLOBALS["charset"]=$language["charset"];
   $btit_settings["default_charset"]=$language["charset"];
}
$tpl->set("main_charset",$GLOBALS["charset"]);
$tpl->set("main_css","$style_css");


require_once("$THIS_BASEPATH/include/blocks.php");

$logo.="<div></div>";
$slideIt="<span style=\"align:left;\"><a href=\"javascript:collapse2.slideit()\"><img src=\"$STYLEURL/images/slide.png\" border=\"0\" alt=\"\" /></a></span>";
$header.="<div>".main_menu()."</div>";

$left_col=side_menu();
$right_col=right_menu();

if ($left_col=="" && $right_col=="")
   $no_columns=1;

include 'include/jscss.php';

$tpl->set("main_jscript",$morescript);
if (!$no_columns && $pageID!='admin' && $pageID!='forum' && $pageID!='torrents' && $pageID!='usercp') {
  $tpl->set("main_left",$left_col);
  $tpl->set("main_right",$right_col);
}

$tpl->set("main_logo",$logo);

$tpl->set("main_slideIt",$slideIt);

$tpl->set("main_header",$header.$err_msg_install);

$tpl->set("more_css",$morecss);
$data = mysql_query ("SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash = '$_GET[id]'");
while ($object = mysql_fetch_object($data))
$tpl->set("main_title",$btit_settings["name"]." .::. "."$object->filename");

// assign main content
switch ($pageID) {

    case 'modules':
        $module_name=htmlspecialchars($_GET["module"]);
        $modules=get_result("SELECT * FROM {$TABLE_PREFIX}modules WHERE name=".sqlesc($module_name),true,$btit_settings["cache"]);
        if (count($modules)<1) // MODULE NOT SET
           stderr($language["ERROR"],$language["MODULE_NOT_PRESENT"]);

        if ($modules[0]["activated"]=="no") // MODULE SET BUT NOT ACTIVED
           stderr($language["ERROR"],$language["MODULE_UNACTIVE"]);

        $module_out="";
        if (!file_exists("$THIS_BASEPATH/modules/$module_name/index.php")) // MODULE SET, ACTIVED, BUT WRONG FOLDER??
           stderr($language["ERROR"],$language["MODULE_LOAD_ERROR"]."<br />\n$THIS_BASEPATH/modules/$module_name/index.php");

        // ALL OK, LET GO :)
        require("$THIS_BASEPATH/modules/$module_name/index.php");
        $tpl->set("main_content",set_block(ucfirst($module_name),"center",$module_out));
        $tpl->set("main_title",$btit_settings["name"]." .::. ".ucfirst($module_name));
        break;

    case 'admin':
        require("$THIS_BASEPATH/admin/admin.index.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Admin");
        // the main_content for current template is setting within admin/index.php
        break;
                
    case 'forum':
        require("$THIS_BASEPATH/forum/forum.index.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Browse Forums");
        break;

    case 'torrents':
        require("$THIS_BASEPATH/torrents.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$torrenttpl->fetch(load_template("torrent.list.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Browse Torrents");
        break;
                
// shouthistory
    case 'allshout':
        ob_start();
        require("$THIS_BASEPATH/ajaxchat/getHistoryChatData.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Shout History");
        $out=ob_get_contents();
        ob_end_clean();
        $tpl->set("main_content",set_block($language["SHOUTBOX"]." ".$language["HISTORY"],"left",$out));
        break;
/*
    case 'allshout':
        require("$THIS_BASEPATH/allshout.php");
        $tpl->set("main_content",set_block($language["SHOUTBOX"]." ".$language["HISTORY"],"center",$tpl_shout->fetch(load_template("shoutbox_history.tpl")),($GLOBALS["usepopup"]?false:true)));
        $tpl->set("main_title","Index->All Shout");
        break;
*/
    case 'comment':
        require("$THIS_BASEPATH/comment.php");
        $tpl->set("main_content",set_block($language["COMMENTS"],"center",$tpl_comment->fetch(load_template("comment.tpl")),false));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Comment");
        break;

    case 'comment-edit':
        require("$THIS_BASEPATH/commedit.php");
        $tpl->set("main_content",set_block($language["COMMENTS"],"center",$tpl_comment->fetch(load_template("comment.edit.tpl")),false));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Comment Edit");
        break;

    case 'delete':
        require("$THIS_BASEPATH/delete.php");
        $tpl->set("main_content",set_block($language["DELETE_TORRENT"],"center",$torrenttpl->fetch(load_template("torrent.delete.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Torrent Delete");
        break;

    case 'edit':
        require("$THIS_BASEPATH/edit.php");
        $tpl->set("main_content",set_block($language["EDIT_TORRENT"],"center",$torrenttpl->fetch(load_template("torrent.edit.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Torrent Edit");
        break;

    case 'extra-stats':
        require("$THIS_BASEPATH/extra-stats.php");
        $tpl->set("main_content",set_block($language["MNU_STATS"],"center",$out));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Statistics");
        break;

    case 'history':
    case 'torrent_history':
        require("$THIS_BASEPATH/torrent_history.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$historytpl->fetch(load_template("torrent_history.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Torrent History");
        break;

    case 'login':
        require("$THIS_BASEPATH/login.php");
        $tpl->set("main_content",set_block($language["LOGIN"],"center",$logintpl->fetch(load_template("login.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Login");
        break;

    case 'moresmiles':
        require("$THIS_BASEPATH/moresmiles.php");
        $tpl->set("main_content",set_block($language["MORE_SMILES"],"center",$moresmiles_tpl->fetch(load_template("moresmiles.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." "."More Smilies");
        break;

   case 'news':
        require("$THIS_BASEPATH/news.php");
        $tpl->set("main_content",set_block($language["MANAGE_NEWS"],"center",$newstpl->fetch(load_template("news.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."News");
        break;

    case 'peers':
        require("$THIS_BASEPATH/peers.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$peerstpl->fetch(load_template("peers.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Peers");
        break;


    case 'recover':
        require("$THIS_BASEPATH/recover.php");
        $tpl->set("main_content",set_block($language["RECOVER_PWD"],"center",$recovertpl->fetch(load_template("recover.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Recover account");
        break;

    case 'account':
    case 'signup':
    case 'invite':
        require("$THIS_BASEPATH/account.php");
        $tpl->set("more_css","<link rel=\"stylesheet\" type=\"text/css\" href=\"$BASEURL/jscript/passwdcheck.css\" />");
        $tpl->set("main_content",set_block($language["ACCOUNT_CREATE"],"center",$tpl_account->fetch(load_template("account.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Signup");
        break;

    case 'torrent-details':
    case 'details':
        require("$THIS_BASEPATH/details.php");
        $tpl->set("main_content",set_block($language["TORRENT_DETAIL"],"center",$torrenttpl->fetch(load_template("torrent.details.tpl")),($GLOBALS["usepopup"]?false:true)));
        break;

    case 'users':
        require("$THIS_BASEPATH/users.php");
        $tpl->set("main_content",set_block($language["MEMBERS_LIST"],"center",$userstpl->fetch(load_template("users.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Users");
        break;


    case 'usercp':
        require("$THIS_BASEPATH/user/usercp.index.php");
        // the main_content for current template is setting within users/index.php
        $tpl->set("main_title",$btit_settings["name"]." .::. "."My Panel");
        break;

    case 'upload':
        require("$THIS_BASEPATH/upload.php");
        $tpl->set("main_content",set_block($language["MNU_UPLOAD"],"center",$uploadtpl->fetch(load_template("$tplfile.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Upload Torrent");
        break;

    case 'userdetails':
        require("$THIS_BASEPATH/userdetails.php");
        $tpl->set("main_content",set_block($language["USER_DETAILS"],"center",$userdetailtpl->fetch(load_template("userdetails.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Users Details");
        break;

    case 'viewnews':
        require("$THIS_BASEPATH/viewnews.php");
        $tpl->set("main_content",set_block($language["LAST_NEWS"],"center",$viewnewstpl->fetch(load_template("viewnews.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."News");
        break;
 
            case 'warn':
        require("$THIS_BASEPATH/warn.php");
        break;

            case 'rewarn':
        require("$THIS_BASEPATH/rewarn.php");
        break;

    case 'staff':
        require("$THIS_BASEPATH/staff.php");
        $tpl->set("main_content",set_block($SITENAME . " " . $language["STAFF"],"center",$stafftpl->fetch(load_template("staff.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Staff");
        break;

/*Mod by losmi - faq mod*/
    case 'faq':
        require("$THIS_BASEPATH/faq.php");
        $tpl->set("main_content",set_block($language["MNU_FAQ"],"center",$faqtpl->fetch(load_template("faq.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->F.A.Q.");
        break;
/*End mod by losmi faq - mod*/
    
    case 'index':
    case '':
    default:
        $tpl->set("main_content",center_menu());
        break;
}



// controll if client can handle gzip
if ($GZIP_ENABLED)
    {
     if (stristr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip") && extension_loaded('zlib') && ini_get("zlib.output_compression") == 0)
         {
         if (ini_get('output_handler')!='ob_gzhandler')
             {
             ob_start("ob_gzhandler");
             $gzip='enabled';
             }
         else
             {
             ob_start();
             $gzip='enabled';
             }
     }
     else
         {
         ob_start();
         $gzip='disabled';
         }
}
else
    $gzip='disabled';




// fetch page with right template
switch ($pageID) {

    // for admin page we will display page with header and only left column (for menu)
    case 'admin':
    case 'usercp':
        stdfoot(false,false,true);
        break;
            
        // for torrents and forums pages we will display page with header and no columns (for full view)
        case 'torrents':
        case 'forum':
        stdfoot(false,true,false,true,true);
        break;      

    // if popup enabled then we display the page without header and no columns, else full page
    case 'comment':
    case 'torrent-details':
    case 'torrent_history':
    case 'peers':
        stdfoot(($GLOBALS["usepopup"]?false:true));
        break;

    // we display the page without header and no columns
    case 'allshout':
    case 'moresmiles':
        stdfoot(false);
        break;

    // full page
    default:
        stdfoot();
        break;
}




?>
