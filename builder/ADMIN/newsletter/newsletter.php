<?php 
$M_ONLY_USERS_SUBSCRIBED="only the users subscribed to the newsletter";
$M_CLICK_EXPORT="Click here to export the mail list";
if(isset($Export))
{
	if($Export == "e")
	{
		if(isset($newsletter)&&$newsletter=="1")
		{
			header("Location: newsletter/exportmaile.php?n=1");
		}
		else
		{
			header("Location: newsletter/exportmaile.php");
		}
	}
}

?>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=950>
	<tr>
		<td class=basicText align=left>
		<br>
		
					<b>Export the user emails to a text file (one email per line)  </b>
					
					<br><br>
		
					<form action="index.php" method=post>
					<input type="hidden" name="action" value="<?php echo $action;?>">
					<input type="hidden" name="Export" value="e">
					
					<input type=hidden name=category value="<?php echo($category);?>">
					
				
					<br><br>
					
					<input style="width:240px" type=submit value="<?php echo $M_CLICK_EXPORT;?>" class=adminButton>
					</form>
					
					
					<br>
					
					
					
					
		</td>
	</tr>
</table>
