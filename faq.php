<?php

// CyBerFuN.ro & xList.ro

// CyBerFuN .::. FaQ
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

if ($limit > 0)
$limitqry = "LIMIT $limit";
$res = get_result("SELECT f.title AS title, f.id AS id, f.description AS description ,fg.title AS cat_title, fg.id AS cat_id, fg.sort_index AS sort_index 
                    FROM {$TABLE_PREFIX}faq f 
                    INNER JOIN {$TABLE_PREFIX}faq_group fg on f.cat_id=fg.id 
                    WHERE f.active = '1' AND fg.active = '1' GROUP BY f.id ORDER BY fg.sort_index DESC $limitqry", true, $btit_settings['cache_duration']);



$faqtpl = new bTemplate();
$faqtpl->set("language", $language);


$faq = array();
$i = 0;

$faqtpl->set("faq_exists", (count($res) > 0), TRUE);

include("$THIS_BASEPATH/include/offset.php");

$id = '';
while ($rows = mysql_fetch_array($res))
  {
      
        if($id != $rows['cat_id'])
    {
        $faq[$i]["posted_date"] = date("d/m/Y H:i", $rows["news_date"] - $offset);
        $faq[$i]["faq_group_title"] = unesc($rows["cat_title"]);
        $faq[$i]["faq_title"] = unesc($rows["title"]);
        $faq[$i]["faq_text"] = format_comment($rows["description"]);
        $faq[$i]["faq_link"] = unesc("index.php?page=faq#".$rows['id']);
        //faq2
        $faq2[$i]["posted_date"] = date("d/m/Y H:i",$rows["date"] - $offset);
        $faq2[$i]["faq_group_title"] = unesc(" <tr>
             <td class='header' align='center'>
              <b>".$rows["cat_title"]."</b>
             </td>
           </tr>");
        $faq2[$i]["faq_title"] = unesc($rows["title"]);
        $faq2[$i]["faq_text"] = format_comment($rows["description"]);
        $faq2[$i]["faq_link"] = unesc($rows['id']);
        $id = $rows['cat_id'];
    }
    else 
    {
        $faq[$i]["posted_date"] = date("d/m/Y H:i", $rows["news_date"] - $offset);
        $faq[$i]["faq_title"] = unesc($rows["title"]);
        $faq[$i]["faq_text"] = format_comment($rows["description"]);
        $faq[$i]["faq_link"] = unesc("index.php?page=faq#".$rows['id']);
        //faq2
        $faq2[$i]["posted_date"] = date("d/m/Y H:i", $rows["news_date"] - $offset);
        $faq2[$i]["faq_title"] = unesc($rows["title"]);
        $faq2[$i]["faq_text"] = format_comment($rows["description"]);
        $faq2[$i]["faq_link"] = unesc($rows['id']);
        
    }
      
    
      $i++;
    
  }

$faqtpl->set("faq", $faq);
$faqtpl->set("faq2", $faq2);

?>
