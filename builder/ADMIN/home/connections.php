<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
$HISTORY=$CONSULTATION_DE_LA_LISTE_DE_VOS_CONNEXIONS;
?>	

	
<table width="100%"><tr><td class=basictext>

		<table summary="" border="0">
		  	<tr>
		  		<td class=basictext  width=50>
				<img src="images/icons<?php echo $DN;?>/lock.gif" border="0" width="29" height="36" alt="">
				</td>
		  		<td class=basictext>
				
						<b><?php echo $LISTE_CONNEXIONS;?></b>

				
							
				</td>
		  	</tr>
		  </table>
		  
		  
</td></tr></table>
<div id="div2" style="display:none">
<?php
					
					$oCol=array("ip","date");
					$oNames=array("IP",$DATE_MESSAGE);
				
	?>
</div>				
<br>
<table width="100%"><tr><td class=basictext>


		  
</td></tr></table>		
<div id="div3">					
	<?php		
					RenderTable("login_log",$oCol,$oNames,"100%","WHERE action='login' AND username='$AuthUserName'  ","","id","index.php?action=connections&category=".$category);

	?>
</div>				
<br>
<table width="100%"><tr><td class=basictext>

		<table summary="" border="0">
		  	<tr>
		  		<td class=basictext  width=50>
				<img src="images/icons<?php echo $DN;?>/key.gif" border="0" width="44" height="24" alt="">
				</td>
		  		<td class=basictext>
				
				<b><?php echo $ERREURS_LOGIN;?></b>

		
				</td>
		  	</tr>
		  </table>
		  
</td></tr></table>		
<div id="div4">
<?php				
					
					RenderTable("login_log",$oCol,$oNames,"100%","WHERE action='error' AND username='$AuthUserName' ","","id","index.php?action=connections&category=".$category);
			
?>
</div>
<br>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_CONNECTIONS;?>";
document.onmousedown = HTMouseDown;
</script>

