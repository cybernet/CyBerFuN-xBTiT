<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// ** Featured Torrent Block Hack By MCANGELI 1/30/2008
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
//
////////////////////////////////////////////////////////////////////////////////////

// CyBerFuN.ro & xList.ro

// xList .::. Featured Block
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
// Modified By CyBerNe7

require_once ("include/blocks.php");
if (!isset($CURUSER)) global $CURUSER;
if (!$CURUSER || $CURUSER["view_news"] == "no")
   {
       //err_msg(ERROR,NOT_AUTH_VIEW_NEWS."!");
       //stdfoot();
       //exit;
       // modified 1.2
       // do nothing - the exit terminate the script, not really good
}
else{

global $BASEURL, $STYLEPATH, $dblist, $XBTT_USE, $btit_settings;

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
    $tcompletes="f.finished as finished";
    $ttables = "{$TABLE_PREFIX}files f";
    }



    $sql = mysql_query("SELECT * FROM {$TABLE_PREFIX}featured ORDER BY fid DESC limit 1");
    $result = mysql_fetch_assoc($sql);

    
$torrent = mysql_query("SELECT f.info_hash, f.filename, f.url, UNIX_TIMESTAMP(f.data) as data, f.size, f.comment, f.uploader, c.name as cat_name, c.image as cat_image, c.id as cat_id, $tseeds, $tleechs, $tcompletes, f.speed, f.external, f.announce_url,UNIX_TIMESTAMP(f.lastupdate) as lastupdate,UNIX_TIMESTAMP(f.lastsuccess) as lastsuccess, f.anonymous, u.username FROM $ttables LEFT JOIN {$TABLE_PREFIX}categories c ON c.id=f.category LEFT JOIN {$TABLE_PREFIX}users u ON u.id=f.uploader WHERE f.info_hash ='$result[torrent_id]'");

    
    $tor = mysql_fetch_assoc($torrent);


    $description = format_comment($tor["comment"]);
?><center><table width=99% border=0 style="border:0px;padding:5px">
<tr class="lista">
<td colspan=3 class="lista">

	<h2>	<b><center><a href="/index.php?page=torrent-details&id=<?php echo $tor[info_hash]; ?>">
    <?php
    echo $tor[filename];
    ?></a></b></center>
</td></tr>
<tr class="lista">
<td class="lista">
    
    <?php
    if (isset($tor["cat_name"])) {
			print("<a href=\"index.php?page=torrents&amp;category=$tor[cat_id]\">" . image_or_link( ($tor["cat_image"] == "" ? "" : "$STYLEPATH/images/categories/" . $tor["cat_image"]), "", $tor["cat_name"]) . "</a>");
		}
    ?><br /><b>Seeders: </b><?php echo $tor[seeds]; ?><br />
    <b>Leechers: </b><?php echo $tor[leechers];?>
	
</td><td class="lista">
<span class="desc">
<table border=0 style="border:0px" width="99%"><tr><td>
<?php
    echo $description;
    ?>
  </td></tr></table>  
    </span>
</td><td class="lista">
			<span class="chart">
    
                                        	<?php
						  $seedttl = $tor['seeds'];
						  $peerttl = ($tor['seeds'] + $tor['leechers']);
						  $leecttl = $tor['leechers'];
						  
						?>
					
			<img src="/images/piechart2.php?data=<?php echo"$seedttl*$leecttl"; ?>&label=Seeders*Leechers" />
</span>        
</td></tr>
<tr>
<td colspan=3>	
	<div class="foot">
		<center>
    <a href="/index.php?page=torrent-details&id=<?php echo $tor[info_hash]; ?>" alt="Torrent Details"><b>More Information</b></a> - <a href="/download.php?id=<?php echo $tor[info_hash];?>&f=<?php echo $tor[filename]; ?>.torrent" alt="Download"><b>Download Torrent</b></a>
    </div>
   </div></td></tr></table> 

<?php
}
?>