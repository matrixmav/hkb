<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
if($AuthGroup !="Administrators")
{
	die("");
}
?>

<?php
if(isset($Delete))
{
	if(sizeof(array_diff($CheckList,array("1")))>0)
	{
				
		foreach($CheckList as $CheckId)
		{
			ms_i($CheckId);
			$arrBlUser = DataArray("admin_users","id=".$CheckId);
			$dr = $arrBlUser["username"];
			SQLQuery("DELETE FROM ".$DBprefix."admin_users WHERE username='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."blog_files WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."blog_documents WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."comments WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."user_pages WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."contact WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."contact_settings WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."note_categories WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."note_settings WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."notes WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."photo WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."user_statistics WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."user_templates WHERE user='".$dr."'");
			SQLQuery("DELETE FROM ".$DBprefix."weblog WHERE user='".$dr."'");
		}
		
		SQLDelete("admin_users","id",array_diff($CheckList,array("1")));
	}
}
?>

<?php
if(isset($reset))
{
	ms_i($reset);
	$arrResetUser = DataArray("admin_users","id=".$reset);
	
	if(isset($go))
	{
		?>
		<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
					<TR>
						<td class=basicText>
					<?php
	
						$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
						
						$new_pwd = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(100,999)
									.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(100,999);
														
						SQLUpdate_SingleValue
							(
								"admin_users",
								"id",
								$reset,
								"password",
								md5($CAPTCHA_SALT.$new_pwd)
								
							);
						
						echo "<b>The new password of: <font color=red>".$arrResetUser["username"]."</font> is:&nbsp;&nbsp; <font color=red size=3>".$new_pwd."</font></b><br><br>";
				
						if(isset($send_by_email)&&$send_by_email==1)
						{
							if($arrResetUser["email"] == "")
							{
								echo "<font color=red><i>The user didn't set his email so the new password can not be sent by email!</i></font>";
								
							}
							else
							{
								
								
									$headers  = "From: \"".$SYSTEM_EMAIL_FROM."\"<".$SYSTEM_EMAIL_ADDRESS.">\n";
								
									$message="Your new password is: ".$new_pwd;
									
									if(!mail($arrResetUser["email"], "New password for ".$BLOG_DOMAIN, $message, $headers))
									{
										echo "<i>There was an error while trying to send the new password to the user's email address: <b>".$arrResetUser["email"]."</b></i>";
							
									}
									else
									{
										echo "<i>The new password has also been emailed to the user to his email address: <b>".$arrResetUser["email"]."</b></i>";
									}
									
							}
							
						}
		
				?>
						</td>
					</tr>
				</table>
			<?php
		
	}
	else
	{
				
				?>
				
				<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
					<TR>
						<td class=basicText>
						
						<br>
						<b>
						Are you sure you want to reset the password of user: 
						&nbsp;
						<font color=red>
						<?php
							echo $arrResetUser["username"];
						?>
						</font>
						?
						</b>
						<br><br><br>
						
						<table border="0" cellpadding="0" cellspacing="0">
				  			<tr>
				  				<td valign="top">
									<form action="index.php" method="post" style="margin-top:0px;margin-bottom:0px">
										<input type=hidden name="category" value="<?php echo $category;?>">
										<input type=hidden name="action" value="<?php echo $action;?>">
										<input type=hidden name="reset" value="<?php echo $reset;?>">
										<input type=hidden name="go" value="<?php echo $go;?>">
										
										<input type=submit value=" YES " class=adminButton style="width:100px">
										<br>
										<br><br>
										<input type=checkbox name="send_by_email" value="1" checked> <i>send the pwd by email</i>
									</form>
								</td>
								<td width="40">
									&nbsp;
								</td>
				  				<td valign="top">
								
									<form action="index.php" method="post" style="margin-top:0px;margin-bottom:0px">
										<input type=hidden name="category" value="<?php echo $category;?>">
										<input type=hidden name="action" value="<?php echo $action;?>">
										
										<input type=submit value=" NO " class=adminButton style="width:100px">
									</form>
								
								</td>
				  			</tr>
				  		</table>
						
						</td>
					</tr>
				</table>
				
				<?php
		}
}
else
{
?>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	<TR>
		<td class=basicText>
			
				
				<table summary="" border="0">
				  	<tr>
				  		<td width=38><img src="images/icons<?php echo $DN;?>/erase.gif" border="0" width="38" height="41" alt=""></td>
				  		<td class=basictext><b><?php echo $LISTE_DES_UTILISATEURS;?></b></td>
				  	</tr>
				  </table>
	  
				<br>
				<center>
				<?php
					
					$oCol=array("ShowModifierUtilisateur","ResetPWD","username","first_name","last_name","country","email","blog_created","plan");
					$oNames=array($MODIFIER,"Reset PWD",$UTILISATEUR,"First Name","Last Name","Country",$EMAIL,"Created","Package");
					$ORDER_QUERY="ORDER BY id DESC";
					
					
					RenderTable("admin_users",$oCol,$oNames,"950","WHERE username<>'administrator'  ",$EFFACER,"id","index.php?action=$action&category=".$category);
		
				?>
				</center>
				<br>
		</td>
	</tr>
	</table>

<?php
}
?>
