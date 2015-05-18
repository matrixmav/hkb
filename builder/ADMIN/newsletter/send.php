<?php

if(isset($ProceedSend))
{
	ms_i($newsletter_id);

	$arrNewsletter = DataArray("newsletter","id=$newsletter_id");

	$strMessageBody = $arrNewsletter["html"];

		
	$strMessageSubject = $arrNewsletter["subject"];
	$strMessageHeaders = "From: \"".$SYSTEM_EMAIL_FROM."\"<".$SYSTEM_EMAIL_ADDRESS.">\n";

	$arrEmails = array();

	$iSuccessCounter = 0;
	
	
	if($recepients == "11")
	{
		$arrMailingList = DataTable ("admin_users","WHERE username<>'administrator' AND newsletter=1");
		while($arrMailing = mysql_fetch_array($arrMailingList))
		{
				array_push($arrEmails,$arrMailing["email"]);
		}
	}
	else
	if($recepients == "12")
	{
		$arrMailingList = DataTable ("admin_users","WHERE username<>'administrator' ");
		while($arrMailing = mysql_fetch_array($arrMailingList))
		{
				array_push($arrEmails,$arrMailing["email"]);
		}
	}
	
	else
	if($recepients == 2)
	{
		$arrLines = explode("\n", $recepient_textarea);
		
		foreach($arrLines as $arrLine)
		{
			array_push($arrEmails, trim($arrLine));
		}
	}
	

	if(sizeof($arrEmails) > 0)
	{
					
		foreach($arrEmails as $arrEmail)
		{
			if(trim($arrEmail) == "") continue;
			$bSuccess = mail($arrEmail, $strMessageSubject,$strMessageBody, $strMessageHeaders);
	
			
			if($bSuccess)
			{
				$iSuccessCounter++; 
			}
			
			SQLInsert(
				"newsletter_log",
				array("email","date","newsletter_id","status"),
				array($arrEmail, time(), $newsletter_id,($bSuccess?"success":"error"))
				
			);
		}
	}
	
	echo '
					<table summary="" border="0" width=100%>
				 	<tr>
				 		<td><b>'.$NEWSLETTER_SENT.' '.$iSuccessCounter.' users (from '.sizeof($arrEmails).'). You may look at the <a href="index.php?category=newsletter&action=log">log</a> for details. </b></td>
				 	</tr>
				 </table>
 	';
}

?>


<table width=100%><tr><td>
<br>
<b>
Send a newsletter to the users 
</b>
<br><br><br>

<form action="index.php" >
<input type=hidden name=ProceedSend>
<input type=hidden name=action value="<?php echo $action;?>">
<input type=hidden name=category value="<?php echo $category;?>">


1. <?php echo $CHOOSE_NEWSLETTER;?>:
<select name=newsletter_id>
<?php
$tableNewsletter = DataTable ("newsletter","");

while($arrNewsletter = mysql_fetch_array($tableNewsletter))
{
	echo "<option value=\"".$arrNewsletter["id"]."\">".$arrNewsletter["subject"]."</option>";
}

?>
</select>
<br><br>
2.<?php echo  $CHOOSE_RECEPIENTS;?>:
<br><br>


<input type="radio" name="recepients" value="12" >

Send the newsletter to all the users 
<br><br>

<input type=radio name=recepients value=2 > <?php echo $SEND_NEWSLETTER_ONLY;?>:
<br>
<textarea cols=40 rows=6 name=recepient_textarea></textarea>



<br><br>
<br>
<input type=submit class=adminButton value=" <?php echo $ENVOYER;?> ">

</form>


</td></tr></table>
<br><br>

