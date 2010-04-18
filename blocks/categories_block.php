<?php

// CyBerFuN.ro & xList.ro

// xList .::. Categories Block
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
// Modified By CyBerNe7

global $CURUSER;
if (!$CURUSER || $CURUSER["view_torrents"] == "no")
   {
    // do nothing
   }
else
    {
block_begin(BLOCK_CAT);
function catnumber($val = "")
{
global $TABLE_PREFIX;
  print("<div id=catnumber style=\"width:100%;overflow:auto\" align=left><table class=\"lista\" cellpadding=\"2\" cellspacing=\"1\" style=\"width:100%;\" align=left>");

    $c_q = @mysql_query("SELECT * FROM {$TABLE_PREFIX}categories WHERE sub='0' ORDER BY sort_index ASC");
    while($c = mysql_fetch_array($c_q))
    {
        $cid = $c["id"];
        $name = unesc($c["name"]);
        // lets see if it has sub-categories.
        $s_q = mysql_query("SELECT * FROM {$TABLE_PREFIX}categories WHERE sub='$cid'");
        $s_t = mysql_num_rows($s_q);
            $res = mysql_query("select count(*) as allincat FROM {$TABLE_PREFIX}files where category=".$cid);
            if ($res)
            {
            $row = mysql_fetch_array($res);
            $totalall = $row["allincat"];
            }
            else
            $totalall = 0;
        if($s_t == 0)
        {
        print("<tr><td class=lista align=left><a href='index.php?page=torrents&amp;category=$cid'><font style=\"font-size:11px;\">".$name."</font></a></td><td class=lista align=right><b>".$totalall."</b>&nbsp;</td></tr>");
        } else {
                        print("<tr><td class=lista align=left colspan=2><font style=\"font-size:11px;\"><b>".$name." :</b></font></td></tr>");
//          print("<tr><td class=lista align=left colspan=2><a href='torrents.php?category=$cid'><font style=\"font-size:11px;\">".$name." :</font></a></td></tr>");
            while($s = mysql_fetch_array($s_q))
            {
            $sub = $s["id"];
            $name = unesc($s["name"]);
            $name2 = unesc($c["name"]);
                $res = mysql_query("select count(*) as allincat2 FROM {$TABLE_PREFIX}files where category=".$sub);
                if ($res)
                {
                $row = mysql_fetch_array($res);
                $totalall2 = $row["allincat2"];
                }
                else
                $totalall2 = 0;
            print("<tr><td class=lista align=left>&nbsp;&raquo;&nbsp;<a href='index.php?page=torrents&amp;category=$sub'><font style=\"font-size:11px;\">".$name."</font></a></td><td class=lista align=right><b>".$totalall2."</b>&nbsp;&nbsp;</td></tr>");
            }
               }
    }
    print("</table></div>");
}
catnumber( $category );

block_end();
}
?>