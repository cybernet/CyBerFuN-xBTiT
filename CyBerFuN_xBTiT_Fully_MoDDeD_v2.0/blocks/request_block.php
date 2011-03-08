<?php
block_begin("Top 5 Requests");

global $btit_settings ;

$number = $btit_settings["req_number"];

$res = mysql_query("SELECT users.downloaded, users.uploaded, users.username, requests.filled, requests.filledby, requests.id, requests.userid, requests.request, requests.added, requests.hits, categories.image as catimg, categories.name as cat FROM {$TABLE_PREFIX}requests requests inner join {$TABLE_PREFIX}categories categories on requests.cat = categories.id inner join {$TABLE_PREFIX}users users on requests.userid = users.id ORDER BY requests.hits DESC, requests.id DESC LIMIT $number") or sqlerr();
$num = mysql_num_rows($res);

print("<table border=0 width=100% align=center cellspacing=1 cellpadding=0>\n");
print("<tr><td class=header align=center>Name</td><td class=header align=center>Cat</td><td class=header align=center>Date</td><td class=header align=center>By</td><td class=header align=center>Filled</td><td class=header align=center>Votes</td>\n");

for ($i = 0; $i < $num; ++$i)
{
 $arr = mysql_fetch_assoc($res);
$privacylevel = $arr["privacy"];

if ($arr["downloaded"] > 0)
   {
     $ratio = number_format($arr["uploaded"] / $arr["downloaded"], 2);
     //$ratio = "<font color=" . get_ratio_color($ratio) . "><b>$ratio</b></font>";
   }
   else if ($arr["uploaded"] > 0)
       $ratio = "Inf.";
   else
       $ratio = "---";

$res3 = mysql_query("SELECT username from {$TABLE_PREFIX}users where id=" . $arr[filledby]);
$arr3 = mysql_fetch_assoc($res3);
if ($arr3[username])
$filledby = $arr3[username];
else
$filledby = " ";

if (!$CURUSER || $CURUSER["delete_torrents"]=="no"){
if (!$CURUSER || $CURUSER["view_users"]=="yes"){
			$addedby = "<td class=lista align=center><center><a href=index.php?page=userdetails&id=$arr[userid] title=\"Request By : ".$arr[username]." (".$ratio.")\"><b>$arr[username]</b></a></td>";
		}else{
			$addedby = "<td class=lista align=center><center><a href=index.php?page=userdetails&id=$arr[userid] title=\"Request By : ".$arr[username]." (".$ratio.")\"><b>$arr[username]</b></a></td>";
		}
}else{
			$addedby = "<td class=lista align=center><center><a href=index.php?page=userdetails&id=$arr[userid] title=\"Request By : ".$arr[username]." (".$ratio.")\"><b>$arr[username]</b></a></td>";
}

$filled = $arr[filled];
if ($filled){
$filled = "<a href=$filled><font color=green title=\"Filled By: ".$arr3[username]."\"><b>Yes</b></font></a>";
}
else{
$filled = "<a href=index.php?page=reqdetails&id=$arr[id] title=\"Request Details :".$arr[request]."\"><font color=red><b>No</b></font></a>";
}

$reqname = $arr[request];

//Name of Request too Big Hack Start
   if (strlen($arr[request])>45)
  {
  $extension = "...";
  $arr[request] = substr($arr[request], 0, 45)."$extension";
  }
//Name of Request too Big Hack Stop
 print("<tr><td class=lista align=left width=270><a href=index.php?page=reqdetails&id=$arr[id] title=\"Request Name :".$reqname."\"><b>$arr[request]</b></a></td>");
 print("<td class=lista align=center><center>".image_or_link(($arr['catimg']==''?'':'style/xbtit_default/images/categories/'.$arr[catimg]),' title=\'Catagory : '.$arr[cat].'\'',$arr['cat'])."</td><td class=lista width=20% align=center><center><font title=\"Added : ".$arr[added]."\">".$arr["added"]."</font></td>$addedby<td class=lista align=center><center>$filled</td><td class=lista align=center><center><a href=index.php?page=votesview&requestid=$arr[id] title=\"Votes : ".$arr[hits]."\"><b>$arr[hits]</b></a></td></tr>\n");
}
print("</table>\n");

block_end();
?>