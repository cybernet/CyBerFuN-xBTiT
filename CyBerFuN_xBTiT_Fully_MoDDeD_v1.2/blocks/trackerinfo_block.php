<?php

// CyBerFuN.ro & xList.ro

// xList .::. Tracker iNFO Block
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
// Modified By CyBerNe7

global $CURUSER, $btit_settings;
if (!$CURUSER || $CURUSER["view_torrents"] == "no")
   {
    // do nothing
   }
else
    {
   global $SITENAME, $XBTT_USE;

   block_begin(BLOCK_INFO);
   if ($XBTT_USE)
      $res = get_result("select count(*) as tot, sum(f.seeds)+sum(ifnull(x.seeders,0)) as seeds, sum(f.leechers)+sum(ifnull(x.leechers,0)) as leechs  FROM {$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON f.bin_hash=x.info_hash",true,$btit_settings['cache_duration']);
   else
       $res = get_result("select count(*) as tot, sum(seeds) as seeds, sum(leechers) as leechs  FROM {$TABLE_PREFIX}files",true,$btit_settings['cache_duration']);

   if ($res)
      {
      $row = $res[0];
      $torrents = $row["tot"];
      $seeds = 0 + $row["seeds"];
      $leechers = 0 + $row["leechs"];
      }
   else {
      $seeds = 0;
      $leechers = 0;
      $torrents = 0;
      }

   $res = get_result("select count(*) as tot FROM {$TABLE_PREFIX}users where id>1",true,$btit_settings['cache_duration']);
   if ($res)
      {
      $row = $res[0];
      $users = $row["tot"];
      }
   else
       $users = 0;
      if ($leechers > 0)
         $percent = number_format(($seeds / $leechers) * 100, 0);
      else
          $percent = number_format($seeds * 100, 0);

   $peers = $seeds + $leechers;

   if ($XBTT_USE)
      $res = get_result("select sum(u.downloaded+x.downloaded) as dled, sum(u.uploaded+x.uploaded) as upld FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id",true,$btit_settings['cache_duration']);
   else
      $res = get_result("select sum(downloaded) as dled, sum(uploaded) as upld FROM {$TABLE_PREFIX}users",true,$btit_settings['cache_duration']);
   $row = $res[0];
   $dled = 0 + $row["dled"];
   $upld = 0 + $row["upld"];
   $traffic = makesize($dled + $upld);

//   print("<tr><td class=\"blocklist\" align=\"center\">\n");
   print("<table width=\"100%\" class=\"lista\" cellspacing=\"0\">\n");
   print("<tr>\n<td colspan=\"2\" align=\"center\" class=\"lista\" style='text-align:center;'>".unesc($SITENAME)."</td></tr>\n");
   print("<tr><td align=\"left\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:70%;\">".$language["MEMBERS"].":</td><td align=\"right\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:30%;\">$users</td></tr>\n");
   print("<tr><td align=\"left\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:70%;\">".$language["TORRENTS"].":</td><td align=\"right\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:30%;\">$torrents</td></tr>\n");
   print("<tr><td align=\"left\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:70%;\">".$language["SEEDERS"].":</td><td align=\"right\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:30%;\">$seeds</td></tr>\n");
   print("<tr><td align=\"left\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:70%;\">".$language["LEECHERS"].":</td><td align=\"right\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:30%;\">$leechers</td></tr>\n");
   print("<tr><td align=\"left\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:70%;\">".$language["PEERS"].":</td><td align=\"right\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:30%;\">$peers</td></tr>\n");
   print("<tr><td align=\"left\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:70%;\">".$language["SEEDERS"]."/".$language["LEECHERS"].":</td><td align=\"right\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:30%;\">$percent%</td></tr>\n");
   print("<tr><td align=\"left\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:70%;\">".$language["TRAFFIC"].":</td><td align=\"right\" class=\"lista\" style=\"border-bottom: solid 1px #9BAEBF;width:30%;\">$traffic</td></tr>\n");
   print("</table>\n");
//   print("</table>\n</td></tr>");
//   block_end();

} // end if user can view
?>
