<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
SQLQuery
("
	INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
	VALUES('".get_param("u")."','".$_SERVER['REMOTE_ADDR']."','".time()."','logout','')
");

setcookie("Auth","",time()-1);
?>
<br>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		
		<td class=basictext valign=top>
					
				<b><?php echo $NOUS_VOUS_REMERCIONS;?> <?php echo $BLOG_DOMAIN;?>!</b>
		</td>
	</tr>
</table>		
<br><br>

<script>

	setTimeout("document.location.href='../index.php'",1000);
</script>
