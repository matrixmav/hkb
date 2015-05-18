<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>



<?php

if(isset($ProceedUpdateLanguagesMenuType))
{
	ms_w($menu_type);
	SetParameter(
		3,
		$menu_type
	);
	
	$HISTORY=$menu_type." ".$BEEN_SET_BY;

	
}

$currentMenuType=Parameter(3);
?>
<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
		
		<form action=index.php method=post>
		<input type=hidden name=ProceedUpdateLanguagesMenuType>
		<input type=hidden name=category value="<?php echo $category;?>">
		<input type=hidden name=action value="<?php echo $action;?>">
		
		<b><?php echo $VEUILLEZ_CHOISIR_TYPE_MENU;?>:</b>
		<br><br><br>
		
		
		<table>
			<tr>
				<td class=basictext width=30>
				<input type=radio name=menu_type value="standart" <?php if($currentMenuType=="standart") echo "checked";?>>			
				</td>
				<td class=basictext width=45  align=center>
					<img src="images/icons<?php echo $DN;?>/wizard.gif" border="0" width="31" height="38" alt="">
				</td>
				<td class=basictext>		
					<?php echo $MENU_STANDART_EXPLICATION;?>
				</td>
			</tr>
		</table>
		
		<br><br>

			<table>
			<tr>
				<td class=basictext width=30>
				<input type=radio name=menu_type value="custom"  <?php if($currentMenuType=="custom") echo "checked";?>>
				</td>
				<td class=basictext width=45 align=center>
					<img src="images/icons<?php echo $DN;?>/tools.gif" border="0" width="45" height="43" alt="">
				</td>
				<td class=basictext>		
					<b><?php echo $MENU_PERSONNALISE;?></b> 
					
						
		&nbsp;&nbsp;
		<a href="index.php?category=<?php echo $category;?>&folder=menu&page=edit" style="text-decoration:none">
		<b><?php echo $CREER_MODIFIER;?></b>
		</a>
		&nbsp;&nbsp;
		<a href="index.php?category=<?php echo $category;?>&folder=menu&page=params" style="text-decoration:none">
		<b>[<?php echo $PARAMETRES;?>]</b>
		</a>
		
				</td>
			</tr>
		</table>
		
		
	
		<br><br><br>
		
		<input type=submit class=adminButton value=" <?php echo $SAUVEGARDER;?> ">
		
		</form>
		
		
		</td>
	</tr>
</table>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_LANGUAGES_MENU_M;?>";
document.onmousedown = HTMouseDown;
</script>

