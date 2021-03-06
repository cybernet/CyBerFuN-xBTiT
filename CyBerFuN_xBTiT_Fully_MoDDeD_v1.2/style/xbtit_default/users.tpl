<div align="center">
  <form action="index.php" name="ricerca" method="get">
  <input type="hidden" name="page" value="users" />
    <table border="0" class="lista">
      <tr>
        <td class="block"><tag:language.FIND_USER /></td>
        <td class="block"><tag:language.USER_LEVEL /></td>
        <td class="block">&nbsp;</td>
      </tr>
      <tr>
        <td><input type="text" name="searchtext" size="30" maxlength="50" value="<tag:users_search />" /></td>
        <td><select name="level">
            <option value="0" <tag:users_search_level />><tag:language.ALL /></option>
            <tag:users_search_select />
            </select>
        </td>
        <td><input type="submit" class="btn" value="<tag:language.SEARCH />" /></td>
      </tr>
    </table>


<!-- Search by ip, email, pid ################################################################# -->

<?php
 if (!$CURUSER || $CURUSER["admin_access"] == "yes") {
?>
<a href='#advanced' onclick=javascript:collapse2.slideit()>
.:. <u> ADVANCED</u> .:.<br /></a>

<div id="slideadvanced">
    <script type="text/javascript">
    //Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
    var collapse2=new animatedcollapse("slideadvanced", 700, true, "lista")
    </script>

    <table border="0" class="lista">

      <tr>
        <td class="block"><tag:language.EMAIL /></td>
        <td class="block"><tag:language.LAST_IP /></td>
        <td class="block"><tag:language.PID /></td>
      </tr>

      <tr>
        <td><input type="text" name="smail" size="18" maxlength="50" value="<tag:smail />" /></td>
        <td><input type="text" name="sip" size="18" maxlength="50" value="<tag:sip />" /></td>
        <td><input type="text" name="pid" size="18" maxlength="48" value="<tag:pid />" /></td>
      </tr>

    </table>
</div>

<?php } ?>

<!-- Search by ip, email, pid # end ########################################################### -->
  </form>
  <tag:users_pagertop />
    <table class="lista" width="95%">
      <tr>
        <td class="header" align="center"><tag:users_sort_username /></td>
        <td class="header" align="center"><tag:users_sort_userlevel /></td>
        <td class="header" align="center"><tag:users_sort_joined /></td>
        <td class="header" align="center"><tag:users_sort_lastaccess /></td>
        <td class="header" align="center"><tag:users_sort_country /></td>
        <td class="header" align="center"><tag:users_sort_ratio /></td>
        <td class="header" align="center"><tag:users_pm /></td>
        <td class="header" align="center"><tag:users_edit /></td>
        <td class="header" align="center"><tag:users_delete /></td>
	<td class="header" align="center"><tag:language.LIST_IGNORE /></td>
      </tr>
      <if:no_users>
        <tr>
          <td class="lista" colspan="9"><tag:language.NO_USERS_FOUND /></td>
        </tr>
      <else:no_users>
        <loop:users>
          <tr>
            <td class="lista" align="center" style="padding-left:10px;"><tag:users[].username /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].userlevel /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].joined /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].lastconnect /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].flag /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].ratio /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].pm /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].edit /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].delete /></td>
	    <td class="lista" align="center" style="text-align: center;"><tag:users[].ignore /></td>
          </tr>
        </loop:users>
      </if:no_users>
    </table>
</div>
<br />
