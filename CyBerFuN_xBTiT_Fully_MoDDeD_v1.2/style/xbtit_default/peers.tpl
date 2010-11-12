<!-- ################################################################################################
     # Speed stats in peers with filename -->
       
<table width="100%" class="lista" border="0">
       <tr>
         <td align="center" class="header"><tag:peers.filename />&nbsp;&nbsp;&nbsp;&nbsp;<tag:peers.size /></td>
       </tr>
</table>

<if:NOPEERS>
        
<!-- # End       
     ############################################################################################ -->
    

	
<table width="100%" class="lista" border="0">
       <tr>
         <td align="center" class="lista"><tag:language.NO_PEERS /></td>
       </tr>
</table>
<else:NOPEERS>
<script type="text/javascript">
function windowunder(link)
{
  window.opener.document.location=link;
  window.close();
}
</script>
<table width="100%" class="lista" border="0">
       <tr>
         <td align="center" class="header" colspan="2"><tag:language.USER_NAME /></td>
         <td align="center" class="header"><tag:language.PEER_COUNTRY /></td>
                 <if:XBTT>
                 <else:XBTT>
         <td align="center" class="header"><tag:language.PEER_PORT /></td>
                 </if:XBTT>
         <td align="center" class="header"><tag:language.PEER_PROGRESS /></td>
         <td align="center" class="header"><tag:language.PEER_STATUS /></td>
		 <if:XBTT3>
		 <else:XBTT3>
         <td align="center" class="header"><tag:language.PEER_CLIENT /></td>
         <td align="center" class="header"><tag:language.DOWNLOADED /></td>
         

<!-- ################################################################################################
     # Speed stats in peers with filename -->

         <td align="center" class="header"><tag:language.SPEED /> <font color=red>&#9660</font></td>

         <td align="center" class="header"><tag:language.UPLOADED /></td>
         
         <td align="center" class="header"><tag:language.SPEED /> <font color=green>&#9650</font></td>

<!-- # End       
     ############################################################################################ -->


	
         <td align="center" class="header"><tag:language.RATIO /></td>
         <td align="center" class="header"><tag:language.SEEN /></td></tr>
         <!-- peers' listing -->
         <loop:peers>
         <tr>
         <td align="center" class="lista"><tag:peers[].USERNAME /></td>
         <td align="center" class="lista"><tag:peers[].PM /></td>
         <td align="center" class="lista"><tag:peers[].FLAG /></td>
                 <if:XBTT2>
                 <else:XBTT2>
         <td align="center" class="lista"><tag:peers[].PORT /></td>
                 </if:XBTT2>
         <td valign="top" align="center" class="lista"><tag:peers[].PROGRESS /></td>
         <td align="center" class="lista"><tag:peers[].STATUS /></td>
		 <if:XBTT4>
		 <else:XBTT4>
         <td align="center" class="lista"><tag:peers[].CLIENT /></td>
		 </if:XBTT4>
         <td align="center" class="lista"><tag:peers[].DOWNLOADED /></td>
         

<!-- ################################################################################################
     # Speed stats in peers with filename -->

         <td align="center" class="lista"><tag:peers[].DLSPEED /></td>
               
         
         <td align="center" class="lista"><tag:peers[].UPLOADED /></td>
         
         
         <td align="center" class="lista"><tag:peers[].UPSPEED /></td>

<!-- # End       
     ############################################################################################ -->
         <td align="center" class="lista"><tag:peers[].RATIO /></td>
         <td align="center" class="lista"><tag:peers[].SEEN /></td>
       </tr>
</loop:peers>
</table>
</if:NOPEERS>
<if:ADMIN_ACCESS>
    <br />
    <table align='center' width='100%'>
      <tr>
        <td class='block' align='center' colspan='6'><tag:language.BAN_CLIENTS /></td>
      </tr>
      <tr>
        <td align='center' class='header'><tag:language.PEER_CLIENT /></td>
        <td align='center' class='header'><tag:language.USER_AGENT /></td>
        <td align='center' class='header'><tag:language.PEER_ID /></td>
        <td align='center' class='header'><tag:language.PEER_ID_ASCII /></td>
        <td align='center' class='header'><tag:language.TIMES_SEEN /></td>
        <td align='center' class='header'><tag:language.BAN_CLIENT /></td>
      </tr>

      <loop:clients> 
      <tr>
        <td class='lista'><center><tag:clients[].client /></center></td>
        <td class='lista'><center><tag:clients[].user_agent /></center></td>
        <td class='lista'><center><tag:clients[].peer_id /></center></td>
        <td class='lista'><center><tag:clients[].peer_id_ascii /></center></td>
        <td class='lista'><center><tag:clients[].times_seen /></center></td>
        <td class='lista'><center><a title='<tag:language.BAN /> <tag:clients[].client />' href='index.php?page=admin&user=<tag:uid />&code=<tag:random />&do=banclient&agent=<tag:clients[].encode1 />&peer_id=<tag:clients[].encode2 />&returnto=<tag:clients[].encode3 />'><img src='images/smilies/thumbsdown.gif' border='0' alt='<tag:language.BAN />' <tag:clients[].client />'></a></center></td>
      </tr>
      </loop:clients>
    </table>
    <br />

<if:banned_clients>
    <br />
    <table align='center' width='100%'>
      <tr>
        <td class='block' align='center' colspan='6'><tag:language.REMOVE_BANNED_CLIENTS /></td>
      </tr>
      <tr>
        <td align='center' class='header'><tag:language.CLIENT /></td>
        <td align='center' class='header'><tag:language.USER_AGENT /></td>
        <td align='center' class='header'><tag:language.PEER_ID /></td>
        <td align='center' class='header'><tag:language.PEER_ID_ASCII /></td>
        <td align='center' class='header'><tag:language.BAN_REASON /></td>
        <td align='center' class='header'><tag:language.REMOVE_BAN /></td>
      </tr>

      <loop:banned>       
      <tr>
        <td class='lista'><center><tag:banned[].client_name /></center></td>
        <td class='lista'><center><tag:banned[].user_agent /></center></td>
        <td class='lista'><center><tag:banned[].peer_id /></center></td>
        <td class='lista'><center><tag:banned[].peer_id_ascii /></center></td>
        <td class='lista'><center><tag:banned[].reason /></center></td>
        <td class='lista'><center><a title='<tag:language.REMOVE_BAN_ON /> <tag:banned[].client_name />' href='index.php?page=admin&user=<tag:uid />&code=<tag:random />&do=clearclientban&id=<tag:banned[].id />&returnto=<tag:banned[].encode />'><img border='0' src='images/smilies/thumbsup.gif' alt='<tag:language.REMOVE_BAN_ON /> <tag:banned[].client_name />'></a></center></td>
      </tr>
      </loop:banned>
    </table>
</if:banned_clients>
</if:ADMIN_ACCESS>
<tag:BACK2 />
