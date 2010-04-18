<table class="header" width="100%" align="center">
  <tr>
    <td class="lista" colspan="4"><tag:pager_top /></td>
  </tr>
  <tr>
    <td class="lista"><b>Username</b></td>
    <td class="lista"><b>Expire Time</b></td>
    <td class="lista"><b>Warn Reason</b></td>
    <td class="lista"><b>Warn added by</b></td>
  </tr>
  <loop:warns>
  <tr>
    <td class="header"><tag:warns[].username /></td>
    <td class="header"><tag:warns[].warnadded /></td>
    <td class="header"><tag:warns[].warnreason /></td>
    <td class="header"><tag:warns[].warnaddedby /></td>
  </tr>
  </loop:warns>
  <tr>
    <td class="lista" colspan="4"><tag:pager_bottom /></td>
  </tr>
</table>