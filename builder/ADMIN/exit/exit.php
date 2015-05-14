<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
SQLQuery("
	INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
	VALUES('".$AuthUserName."','".$_SERVER['REMOTE_ADDR']."','".time()."','logout','')
");
$HISTORY=$USER_EXITED;
setcookie("Auth","",time()-1);
?>
		
		<table border="0" width="750" cellpadding="0" cellspacing="0">
		  	<tr>
		  		
    			<td class=basictext valign=top>
							
						<b><?php echo $NOUS_VOUS_REMERCIONS;?></b>
				</td>
			</tr>
		</table>		
						<br><br>
						
						<script>
						
							setTimeout("document.location.href='index.php'",5000);
						</script>
						
		</td>
	</tr>
</TABLE>
