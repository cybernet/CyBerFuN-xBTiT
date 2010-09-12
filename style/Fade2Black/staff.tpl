<div align="center">
 <!-- <form action="index.php" name="ricerca" method="get">
  <input type="hidden" name="page" value="users" />
    <table border="0" class="lista">
      <tr>
        <td class="block"><tag:language.FIND_USER /></td>
        <td class="block"><tag:language.USER_LEVEL /></td>
        <td class="block">&nbsp;</td>
      </tr>
      <tr>
        <td><input type="text" name="searchtext" size="30" maxlength="50" value="<tag:user_search />" /></td>
        <td><select name="level">
            <option value="0" <tag:users_search_level />><tag:language.ALL /></option>
            <tag:staff_search_select />
            </select>
        </td>
        <td><input type="submit" value="<tag:language.SEARCH />" /></td>
      </tr>
    </table>
  </form>-->
  <tag:staff_pagertop />
    <table class="lista" width="95%">
      <tr>
        <td class="header" align="center"><tag:staff_sort_staffname /></td>
        <td class="header" align="center"><tag:staff_sort_stafflevel /></td>
        <td class="header" align="center"><tag:staff_sort_lastaccess /></td>
        <td class="header" align="center"><tag:staff_pm /></td>
				<td class="header" align="center"><tag:staff_status /></td>
      </tr>
      <if:no_staff>
        <tr>
          <td class="lista" colspan="9"><tag:language.NO_STAFF_FOUND /></td>
        </tr>
      <else:no_staff>
        <loop:staff>
          <tr>
            <td class="lista" align="center" style="padding-left:10px;"><tag:staff[].staffname /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:staff[].stafflevel /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:staff[].lastconnect /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:staff[].pm /></td>
						<td class="lista" align="center" style="text-align: center;"><tag:staff[].status /></td>
          </tr>
        </loop:staff>
      </if:no_staff>
    </table>
</div>
<br />