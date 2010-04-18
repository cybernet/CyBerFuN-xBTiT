<div align="center">
  <form action="<tag:torrent.link />" method="post" name="edit" ENCTYPE="multipart/form-data">
    <table class="lista">
      <tr>
        <td align="right" class="header"><tag:language.FILE /></td>
        <td class="lista"><input type="text" name="name" value="<tag:torrent.filename />" size="60" /></td>
      </tr>
      <tr>
        <td align="right" class="header">Tag</td>
        <td class="lista"><input type="text" name="tag" value="<tag:torrent.tag />" size="60" /></td>
      </tr>
      <if:imageon>
      <tr>
      <td class="header" ><tag:language.IMAGE /> (<tag:language.FACOLTATIVE />):<input type="hidden" name="userfileold" value="<tag:torrent.image />" /></td>
      <td class="lista" align="left"><input type="file" name="userfile" size="15" /></td>
      </tr>
      </if:imageon>
      <tr>
        <td align="right" class="header"><tag:language.INFO_HASH /></td>
        <td class="lista"><tag:torrent.info_hash /></td>
      </tr>
      <tr>
        <td align="right" class="header"><tag:language.DESCRIPTION /></td>
        <td class="lista"><tag:torrent.description /></td>
      </tr>
      <if:screenon>
      <tr>
      <td class="header" ><tag:language.SCREEN /> (<tag:language.FACOLTATIVE />):<input type="hidden" name="userfileold1" value="<tag:torrent.screen1 />" /></td>
      <td class="lista">
      <table class="lista" border="0" cellspacing="0" cellpadding="0">
      <td class="lista" align="left"><input type="file" name="screen1" size="5" /></td>
      <td class="lista" align="left"><input type="file" name="screen2" size="5" /></td>
      <td class="lista" align="left"><input type="file" name="screen3" size="5" /></td>
      </table>
      </tr>
      </if:screenon>
      <tr>
        <td class="header" ><tag:language.CATEGORY_FULL /></td>
        <td class="lista"><tag:torrent.cat_combo /></td>
      </tr>
      <if:LEVEL_OK>
      <tr>
        <td align="right" class="header"><tag:language.STICKY /></td>
        <td class="lista"><tag:torrent.sticky /></td>
      </tr>
      </if:LEVEL_OK>
      <if:LEVEL_VISIBLE_OK>
      <tr>
        <td align="right" class="header"><tag:language.LEVEL_VISIBILE /></td>
        <td class="lista"><tag:torrent.visible /></td>
      </tr>
      </if:LEVEL_VISIBLE_OK>
      <tr>
	<td align="left" class="header"><tag:language.PROFILE_COMMENT_MAIL_NOTIFY /></td>
      <td class="lista">&nbsp;&nbsp;<tag:language.YES /><input type="radio" name="comment_notify" value="true" <tag:torrent.COMMENT_NOTIFY_TRUE /> />&nbsp;&nbsp;<tag:language.NO /><input type="radio" name="comment_notify" value="false" <tag:torrent.COMMENT_NOTIFY_FALSE /> />&nbsp;&nbsp;<tag:language.ALLOW_COMMENT_NOTIFY /></td>
    </tr>
      <tr>
        <td align=right class="header"><tag:language.SIZE /></td>
        <td class="lista" ><tag:torrent.size /></td>
      </tr>
      <tr>
        <td align=right class="header"><tag:language.ADDED /></td>
        <td class="lista" ><tag:torrent.date /></td>
      </tr>
      <tr>
        <td align=right class="header"><tag:language.DOWNLOADED /></td>
        <td class="lista" ><tag:torrent.complete /></td>
      </tr>
      <tr>
        <td align=right class="header"><tag:language.PEERS /></td>
        <td class="lista" ><tag:torrent.peers /></td>
      </tr>
    </table>
    <input type="hidden" name="info_hash" value="<tag:torrent.info_hash />" />
    <table>
      <td align="right">
            <input type="submit" class="btn" value="<tag:language.FRM_CONFIRM />" name="action" />
      </td>
      <td align="left">
            <input type="submit" class="btn" value="<tag:language.FRM_CANCEL />" name="action" />
      </td>
    </table>
  </form>
</div>
