<?php
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

if (!defined("IN_ACP"))
      die("non direct access!");

$action=(isset($_GET["action"])?$_GET["action"]:"");
$settings = array();
function readGoldSettings()
{
	global $TABLE_PREFIX, $settings;
	 $res=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);

       $count=0;


       foreach ($res as $key=>$value)
         {
             $settings[$count]["gold_picture"]=unesc("<img src='../gold/".$value["gold_picture"]."' border='0' alt='gold'/>
             										  <br/>Choose new picture (max size 100px x 100px):<br/><input type='file' name='gold_picture'/>");
             $settings[$count]["level"]=createUsersLevelCombo(unesc($value["level"]));
             $settings[$count]["silver_picture"]=unesc("<img src='../gold/".$value["silver_picture"]."' border='0'  alt='silver'/>
             											<br/>Choose new picture (max size 100px x 100px):<br/><input type='file' name='silver_picture'/>");
             $settings[$count]["gold_description"]=unesc("<textarea name='gold_description' style='width:250px; height:120px; border:1px solid #999999;'>".$value["gold_description"]."</textarea>");
             $settings[$count]["silver_description"]=unesc("<textarea name='silver_description' style='width:250px; height:120px; border:1px solid #999999;'>".$value["silver_description"]."</textarea>");
             $settings[$count]["classic_description"]=unesc("<textarea name='classic_description' style='width:250px; height:120px; border:1px solid #999999;'>".$value["classic_description"]."</textarea>");
            
             $count++;
         }
        
}
function getFileExtension($name) {
		return substr($name, strrpos($name, '.'));
	}
switch ($action)
  {
    case "save":

       if (!isset($_POST["level"]) && !isset($_POST["gold_description"]) && !isset($_POST["silver_description"]) && !isset($_POST["classic_description"]))
           {
            redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=gold");
            exit();
       }
       $pass = true;
       $error_msg='';
       $upload_path='/gold/';
       $gold_file='';
       $silver_file='';
       $g_file_uploaded=false;
       $s_file_uploaded=false;
       if(isset($_FILES['gold_picture']) && $_FILES['gold_picture']['name'] !='')
       {
       	if($_FILES['gold_picture']['size']>1)
       	{
       		if(is_uploaded_file($_FILES['gold_picture']['tmp_name']))
       		{
       			if(!is_dir($_SERVER['DOCUMENT_ROOT'].$upload_path))
       			{
       				@mkdir($_SERVER['DOCUMENT_ROOT'].'/gold',0777);
       			}
       			$size = @getimagesize($_FILES['gold_picture']['tmp_name']);
       			if($size[0]<=100 && $size[1]<=100)
       			{
	       			if (@move_uploaded_file($_FILES['gold_picture']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$upload_path.'zlatan'.getFileExtension($_FILES['gold_picture']['name'])))
					{
						chmod($upload_path.'zlatan'.getFileExtension($_FILES['gold_picture']['name']),0777);
						$gold_file = 'zlatan'.getFileExtension($_FILES['gold_picture']['name']);
						$g_file_uploaded = true;
					}
					else 
					{
						$pass = false;
	       				$error_msg = 'File not uploaded!';
					}
					
       			}
       			else 
       			{
       				$pass = false;
	       			$error_msg = 'Picture size is limited on 100px X 100px!';
       			}
       		}
       		else 
       		{
       				$pass = false;
       				$error_msg = 'File not temp-uploaded!';
       		}
       	}
       	else 
       	{
       		$pass = false;
       		$error_msg = 'Picture size in KB  > 1!';
       	}
       }
       if(isset($_FILES['silver_picture']) && $_FILES['silver_picture']['name'] !='')
       {
       	if($_FILES['silver_picture']['size']>1)
       	{
       		if(is_uploaded_file($_FILES['silver_picture']['tmp_name']))
       		{
       			
       			if(!is_dir($_SERVER['DOCUMENT_ROOT'].$upload_path))
       			{
       				@mkdir($_SERVER['DOCUMENT_ROOT'].'/gold',0777);
       				//chmod($_SERVER['DOCUMENT_ROOT'].$upload_path,0777);
       			}
       			
       			$size = @getimagesize($_FILES['silver_picture']['tmp_name']);
       			
       			if($size[0]<=100 && $size[1]<=100)
       			{
	       			if (@move_uploaded_file($_FILES['silver_picture']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$upload_path.'silver'.getFileExtension($_FILES['silver_picture']['name'])))
					{
						
						chmod($upload_path.'silver'.getFileExtension($_FILES['silver_picture']['name']),0777);
						$silver_file = 'silver'.getFileExtension($_FILES['silver_picture']['name']);
						$s_file_uploaded = true;
					}
					else 
					{
						$pass = false;
	       				$error_msg = 'File not uploaded!';
					}
					
       			}
       			else 
       			{
       				$pass = false;
	       			$error_msg = 'Picture size is limited on 100px X 100px!';
       			}
       		}
       		else 
       		{
       				$pass = false;
       				$error_msg = 'File not temp-uploaded!';
       		}
       	}
       	else 
       	{
       		$pass = false;
       		$error_msg = 'Picture size in KB  > 1!';
       	}
       }
      // print_r($_POST);
      if($pass)
      {
       $level = unesc($_POST['level']);
       $gold_description = unesc($_POST['gold_description']);
       $silver_description = unesc($_POST['silver_description']);
       $classic_description = unesc($_POST['classic_description']);
       if($g_file_uploaded)
       {
       	$gold_picture = $gold_file;
       }
       else 
       {
       		$res=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
       		foreach ($res as $key=>$value)
         	{
         		$gold_picture = $value["gold_picture"];
         	}
       }
		if($s_file_uploaded)
       {
       	$silver_picture = $silver_file;
       }
       else 
       {
       		$res=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
       		foreach ($res as $key=>$value)
         	{
         		$silver_picture = $value["silver_picture"];
         	}
       }
		
       do_sqlquery("UPDATE {$TABLE_PREFIX}gold 
       				SET level = $level , 
       				gold_description = '$gold_description' , 
       				silver_description = '$silver_description', 
       				classic_description = '$classic_description' ,
       				silver_picture = '$silver_picture' ,
       				gold_picture = '$gold_picture' 
       				WHERE id='1'",true);
      
       $admintpl->set("settings_done_msg","<div align=\"center\">Settings saved!</div>");
      }
      else 
      {
      	
      	 $admintpl->set("settings_done_msg",$error_msg);
      }
      	$admintpl->set("language",$language);
       readGoldSettings();
       
       $admintpl->set("settings",$settings);
       $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=gold&amp;action=save");
       break;

    default:

      $block_title=$language["PRUNE_TORRENTS"];
      
      readGoldSettings();

      $admintpl->set("language",$language);
	  $admintpl->set("settings_done_msg","");
	  $admintpl->set("settings",$settings);
      $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=gold&amp;action=save");
      
}

?>