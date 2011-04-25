<form name="donate" action="<tag:frm_action />" method="post">
<table class="header" width="100%" align="center">


       <tr>
      <td class="header" align="center" colspan="4"><center><b>You need a Paypal Business account and IPN enabled in your Paypal Profile to lett this work !!</b></center></td>
      </tr>
      <tr>
      <td class="header">Test or Real</td>
      <tag:test />
      <td class="header">Units</td>
      <tag:testt />
      </tr>
      <tr>
      <td class="header">Vip Rank ID XBTIT</td>
      <td class="lista"><input type="text" name="pp_rank" value="<tag:pp_rank />" size="10" /></td>
      <td class="header">Vip Rank ID SMF</td>
      <td class="lista"><input type="text" name="pp_smf" value="<tag:pp_smf />" size="10" /></td>
      </tr>
      <tr>
      <td class="header">Sandbox Email</td>
      <td class="lista"><input type="text" name="pp_email_sand" value="<tag:pp_email_sand />" size="30" /></td>
      <td class="header">Paypal Email</td>
      <td class="lista"><input type="text" name="pp_email" value="<tag:pp_email />" size="30" /></td>
      <tr>
      <tr>
      <td class="header">1 Euro/Dollar = .. Vip Day's</td>
      <td class="lista"><input type="text" name="pp_day" value="<tag:pp_day />" size="10" /></td>
      <td class="header">1 Euro/Dollar = .. GB</td>
      <td class="lista"><input type="text" name="pp_gb" value="<tag:pp_gb />" size="10" /></td>
      </tr>
      <tr>
      <td class="header">Needed<br><font color=red>(Numeric) No points</font></td>
      <td class="lista"><input type="text" name="pp_needed" value="<tag:pp_needed />" size="10" /></td>
      <td class="header">Received<br><font color=red>(Numeric) No points</font></td>
      <td class="lista"><input type="text" name="pp_received" value="<tag:pp_received />" size="10" /></td>
      </tr>
      <tr>
      <td class="header">Due Date<br><font color=red>20/10/08</font></td>
      <td class="lista" width=100%><input type="text" name="pp_due_date" value="<tag:pp_due_date />" size="10" /></td>
      <td class="header">Number Donators in Block</td>
      <td class="lista"><input type="text" name="pp_block" value="<tag:pp_block />" size="10" /></td>
      </tr>
      <tr>
      <td class="header">Scrolling Block Tekst</td>
      <td class="lista" ><textarea name="pp_scrol_tekst" rows="3" cols="60"><tag:pp_scrol_tekst /></textarea></td>
      <td class="header">Enable Scroll Line</td>
      <tag:testtt />
      </tr>
      <tr>
      <td class="header">Donation Historie Bridge</td>
      <tag:testttt />
      <td class="header">Donor Star Bridge</td>
      <tag:testtttt />
      </tr>
      <tr>
     <td colspan="6" class="lista" style="text-align:center"><br><input type="submit" name="action" value="Update Settings" /></td>
     </tr></table></form>
      
<table class="header" width="100%" align="center">
<tr>

    <td class="header"><center><b>Username</b></center></td>
    <td class="header"><center><b>Anonymous</b></center></td>
    <td class="header"><center><b>Last Name</b></center></td>
    <td class="header"><center><b>E-mail</b></center></td>
    <td class="header"><center><b>Donate Date</b></center></td>
    <td class="header"><center><b>Amount</b></center></td>
    <td class="header"><center><b>Upload</b></center></td>
    <td class="header"><center><b>VIP</b></center></td>
    <td class="header"><center><b>Old Rank</b></center></td>

  </tr>
  <loop:don>
  <tr>
    <td class="lista"><center><tag:don[].Username /></center></td>
    <td class="lista"><center><tag:don[].Anonymous /></center></td>
    <td class="lista"><center><tag:don[].Last_name /></center></td>
    <td class="lista"><center><tag:don[].Email /></center></td>
    <td class="lista"><center><tag:don[].Date /></center></td>
    <td class="lista"><center><tag:don[].Amount /></center></td>
    <td class="lista"><center><tag:don[].Upload /></center></td>
    <td class="lista"><center><tag:don[].Vip /></center></td>
    <td class="lista"><center><tag:don[].Rank /></center></td>


  </tr>
  </loop:don>

</table>


