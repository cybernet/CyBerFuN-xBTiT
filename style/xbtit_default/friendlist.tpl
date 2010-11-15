<table class="header" width="100%" align="center">

  <tr>
    <td class="header"><b>Avatar</b></td>
    <td class="header"><b>User Name</b></td>
    <td class="header"><b>User Level</b></td>
    <td class="header"><b>Users Last Acces</b></td>
    <td class="header"><b>Status</b></td>
    <td class="header"><b>Delete User</b></td>
  </tr>
  <loop:friend>
  <tr>
    <td class="lista"><tag:friend[].avatar /></td>
    <td class="lista"><tag:friend[].name /></td>
    <td class="lista"><tag:friend[].level /></td>
    <td class="lista"><tag:friend[].acces /></td>
    <td class="lista"><tag:friend[].status /></td>
    <td class="lista"><tag:friend[].delete /></td>
  </tr>
  </loop:friend>

</table>


