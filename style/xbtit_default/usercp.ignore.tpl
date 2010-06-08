<table class="header" width="100%" align="center">
  <tr>
    <td class="header" align"center"><center><tag:language.IGNORE_USERS /></td>
    <td class="header" align"center"><center><tag:language.SINCE_IGNORE /></td>
    <td class="header" align"center"><center><tag:language.DELETE_IGNORE /></td>
  </tr>
  <loop:ignore>
  <tr>
    <td class="lista" align"center"><center><tag:ignore[].name /></td>
    <td class="lista" align"center"><center><tag:ignore[].added /></td>
    <td class="lista" align"center"><center><tag:ignore[].delete /></td>
  </tr>
  </loop:ignore>
   </if:zaznam>
 <if:nozaznam>
   <tag:nic />
 </if:nozaznam>
</table>
