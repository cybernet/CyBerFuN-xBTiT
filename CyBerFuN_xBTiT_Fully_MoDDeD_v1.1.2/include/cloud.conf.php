<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. cloud
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xList.ro/
// Modified By cybernet2u

include 'settings.php';
mysql_connect("$dbhost", $dbuser, $dbpass);
mysql_select_db($database);
function tag_info() {
  //pay attention below
  $result = mysql_query("SELECT * FROM tags GROUP BY tag ORDER BY count DESC LIMIT 35");
  //fetch
  while($row = mysql_fetch_array($result)) {
    //make an array
    $arr[$row['tag']] = $row['count'];
    }
   //sorting the array
   ksort($arr);
   return $arr;
   }
  //functions 2 for tag cloud
  function cloud() {
   //font size limits
   $small = 12;
   $big = 37;
    //variables
    $tags = tag_info();
      //amounts
      $minimum_count = min(array_values($tags));
      $maximum_count = max(array_values($tags));
      $spread = $maximum_count - $minimum_count;
      if($spread == 0) {$spread = 1;}
       //html half
       $cloud_html = '';
      //query half
      $cloud_tags = array();
      foreach ($tags as $tag => $count) {
     //match size to count
     $size = $small + ($count - $minimum_count)
     * ($big - $small) / $spread;
    //attempt to reduce xss
    $tag = str_replace("<script>", "",$tag);
    $tag = str_replace("</script>", "",$tag);
    $tag = str_replace("<img src=", "",$tag);
    $tag = str_replace(" />", "",$tag);
    $tag = str_replace("<iframe", "",$tag);
    $tag = str_replace("<", "",$tag);
    $tag = str_replace(">", "",$tag);
    $tag = str_replace("<!--", "",$tag);
    $tag = str_replace("-->", "",$tag);
    $tag = str_replace("meta", "",$tag);
    $tag = str_replace("exec", "",$tag);
    $tag = str_replace("shell", "",$tag);
    $tag = str_replace("embed", "",$tag);
    $tag = str_replace("<?", "",$tag);
    $tag = str_replace("?>", "",$tag);
    $tag = str_replace("\'", "",$tag);
    $tag = str_replace("\"", "",$tag);
    $tag = str_replace("\\", "",$tag);
    $tag = str_replace("&#x3C;&#x73;&#x63;&#x72;&#x69;&#x70;&#x74;&#x3E;", "",$tag);
    $tag = str_replace("&#x3C;&#x2F;&#x73;&#x63;&#x72;&#x69;&#x70;&#x74;&#x3E;", "",$tag);
    $tag = preg_replace('/v(er)?\s?(\d\.)*(\d)+$/i', '', $tag);
    $tag = preg_replace('/\.\w+$/', '', $tag);
    //build those tags
    $cloud_tags[] = '<a style="font-size: '. floor($size) . 'px'
    . '" href="index.php?page=torrents&search=' . $tag
    . '" title="\'' . $tag  . '\' returned a count of ' . $count . '">'
    . htmlspecialchars(stripslashes($tag)) . '</a>';
   //word filter
	$cloud_tags = str_replace("tits", "",$cloud_tags);
	$cloud_tags = str_replace("sex", "",$cloud_tags);
	$cloud_tags = str_replace("busty", "",$cloud_tags);
	$cloud_tags = str_replace("hentai", "",$cloud_tags);
	$cloud_tags = str_replace("tits", "",$cloud_tags);
	$cloud_tags = str_replace("anal", "",$cloud_tags);
	$cloud_tags = str_replace("pussy", "",$cloud_tags);
	$cloud_tags = str_replace("dick", "",$cloud_tags);
	$cloud_tags = str_replace("gay", "",$cloud_tags);
	$cloud_tags = str_replace("Gay", "",$cloud_tags);
  //end tag entries
  }
  $cloud_html = join("\n", $cloud_tags) . "\n";
//show cloud
return $cloud_html;
}



?>
