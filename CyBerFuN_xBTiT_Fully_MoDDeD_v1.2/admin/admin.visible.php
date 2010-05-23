<?php
if (!defined("IN_BTIT"))
      die("non direct access!");

if (!defined("IN_ACP"))
      die("non direct access!");


/*
$admintpl->set("add_new",false,true);

*/
$admintpl->set("read",false,true);
switch ($action)
    {
         case 'edit':
          $block_title=$language["VISIBLE_SETTINGS"];
          $id=max(0,$_GET["id"]);
          $admintpl->set("edit",false,true);
          $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=visible&amp;action=save&amp;id=$id");
          $admintpl->set("language",$language);
          $visible_group=get_result("SELECT * FROM {$TABLE_PREFIX}visible WHERE id=$id",true);
          $visible_current_group=$visible_group[0];
          unset($sticky_group);
          $visible_current_group["level"]=unesc($visible_current_group["level"]);
          
          $admintpl->set("visible",$visible_current_group);
          break;
          
        case 'save':
          if ($_POST["write"]==$language["FRM_CONFIRM"])
            {
              
                   $visible=sqlesc($_POST["visible"]);
                   $id=max(0,$_GET["id"]);
                  
                   do_sqlquery("UPDATE {$TABLE_PREFIX}visible SET level = $visible",true);
                   
              
            }

            // we don't break, so now we read ;)

        case '':
        case 'read':
        default:

          $block_title=$language["VISIBLE_SETTINGS"];
           
          $admintpl->set("list",true,true);
          $admintpl->set("language",$language);
          $rvisible=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}visible ORDER BY id",true);
          
          
          
          $visible=array();
         $v=mysql_fetch_assoc($rvisible);
                $id = $v['id'];
                $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=visible&amp;action=save&amp;id=$id");
                $visible["visible"]=$v["level"];
                //$sticky[$i]["group_view"]=$s["group_view"];

          $rez_levels=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users_level ORDER BY id",true);
          $level = "<select name='visible'>";
           while($row=mysql_fetch_assoc($rez_levels))
           {
                $selected='';
                if($v['level']==$row['id_level'])
                {
                    $selected = 'selected';
                }
                $level .="<option value=".$row['id_level']." ".$selected.">".$row['level']."</option>";
           }
           $level .= '</select>';
          $admintpl->set("level",$level);

          unset($v);
//          mysql_free_result($rsticky);
mysql_free_result($rvisible);

          $admintpl->set("visible",$visible);

}

?>
