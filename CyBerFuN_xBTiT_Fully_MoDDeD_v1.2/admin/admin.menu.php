<?php
// CyBerFuN

if (!defined("IN_BTIT"))
      die("non direct access!");

if (!defined("IN_ACP"))
      die("non direct access!");

if ($moderate_user)
  {
    $admin_menu=array(
    0=>array(
            "title"=>$language["ACP_USERS_TOOLS"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=masspm&amp;action=write" ,
                    "description"=>$language["ACP_MASSPM"]),
                          1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=pruneu" ,
                    "description"=>$language["ACP_PRUNE_USERS"]),
                          2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=searchdiff" ,
                    "description"=>$language["ACP_SEARCH_DIFF"])
                    )
            ),
    );

}
else
  {
    $admin_menu=array(
    0=>array(
            "title"=>$language["ACP_TRACKER_SETTINGS"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=config&amp;action=read" ,
                    "description"=>$language["ACP_TRACKER_SETTINGS"]),
                          1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=banip&amp;action=read" ,
                    "description"=>$language["ACP_BAN_IP"]),

                          2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=language&amp;action=read" ,
                    "description"=>$language["ACP_LANGUAGES"]),
                          3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=style&amp;action=read" ,
                    "description"=>$language["ACP_STYLES"]),
        		  4=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=warn" ,
                    "description"=>$language["ACP_ADD_WARN"]."<font color='red'>(new)</font>"),
                          5=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=seedbonus" ,
                    "description"=>$language["ACP_SEEDBONUS"])
                                 )),
    1=>array(
            "title"=>$language["ACP_FRONTEND"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=category&amp;action=read" ,
                    "description"=>$language["ACP_CATEGORIES"]),
                          1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=poller&amp;action=read" ,
                    "description"=>$language["ACP_POLLS"]),
                          2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=badwords&amp;action=read" ,
                    "description"=>$language["ACP_CENSORED"]),
                          3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=blocks&amp;action=read" ,
                    "description"=>$language["ACP_BLOCKS"]) ,
                          4=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=featured&amp;action=read" ,
                    "description"=>$language["ACP_FEATURED"])
                    )
            ),
    2=>array(
            "title"=>$language["ACP_USERS_TOOLS"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=groups&amp;action=read" ,
                    "description"=>$language["ACP_USER_GROUP"]),
                          1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=masspm&amp;action=write" ,
                    "description"=>$language["ACP_MASSPM"]),
                          2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=pruneu" ,
                    "description"=>$language["ACP_PRUNE_USERS"]),
                          3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=searchdiff" ,
                    "description"=>$language["ACP_SEARCH_DIFF"]),
                          4=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=warned_users" ,
                    "description"=>"Warned users"),
                          5=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=duplicates" ,
                    "description"=>$language["DUPLICATES"])
                    )
            ),

    3=>array(
            "title"=>$language["ACP_TORRENTS_TOOLS"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=prunet" ,
                    "description"=>$language["ACP_PRUNE_TORRENTS"]),
                          1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=visible" ,
                    "description"=>$language["ACP_VISIBLE_TORRENTS"]),
                          2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=sticky" ,
                    "description"=>$language["ACP_STICKY_TORRENTS"]),
                          3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=gold" ,
                    "description"=>$language["ACP_GOLD"])
)
            ),

    4=>array(
            "title"=>$language["ACP_FORUM"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=forum&amp;action=read" ,
                    "description"=>$language["ACP_FORUM"])
                    )
            ),

    5=>array(
            "title"=>$language["ACP_OTHER_TOOLS"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=dbutil" ,
                    "description"=>$language["ACP_DBUTILS"]),
                          1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=mysql_stats" ,
                    "description"=>$language["ACP_MYSQL_STATS"]),
                          2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=logview" ,
                    "description"=>$language["ACP_SITE_LOG"]),
                          3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=invitations" ,
                    "description"=>$language["ACP_INVITATIONS"])
                    )
            ),
            
    6=>array(
            "title"=>$language["ACP_MODULES"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=module_config&amp;action=manage" ,
                    "description"=>$language["ACP_MODULES_CONFIG"])
                    )
            ),

    7=>array(
            "title"=>$language["ACP_HACKS"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=hacks&amp;action=read" ,
                    "description"=>$language["ACP_HACKS_CONFIG"])
                    )
            ),

    );
}
?>
