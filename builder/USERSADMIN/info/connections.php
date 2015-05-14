	
<table width=100%><tr><td class=basictext>

	<i><?php echo $LISTE_CONNEXIONS;?></i>
	  
</td></tr></table>
<div id="div2">
<?php
					
	$oCol=array("username","ip","date");
	$oNames=array($M_USERNAME,$IP_MESSAGE,$DATE_MESSAGE);
			
	RenderTable_BA("login_log",$oCol,$oNames,"100%","WHERE action='login'  AND username='$AuthUserName' ","","id","index.php?action=connections&category=".$category);
	
?>
</div>				
<br>
		
<br>
<table width=100%><tr><td class=basictext>

<i><?php echo $ERREURS_LOGIN;?></i>

		  
</td></tr></table>		
<div id="div4" >
<?php				
					
	RenderTable_BA("login_log",$oCol,$oNames,"100%","WHERE action='error' AND username='$AuthUserName' ","","id","index.php?action=connections&category=".$category);
			
?>
</div>
<br>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_CONNECTIONS;?>";
document.onmousedown = HTMouseDown;
</script>
