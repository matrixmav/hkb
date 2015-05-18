<?php
$LANGUAGE="en";
$lngTexts="texts_".strtolower(trim($LANGUAGE)).".php";
include($lngTexts);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<script>
function ValidateLoginForm(x){
	if(x.Email.value==""){
		alert("<?php echo $USERNAME_EMPTY_FIELD_MESSAGE;?>");
		x.Email.focus();
		return false;
	}
	else
	if(x.Password.value==""){
		alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>");
		x.Password.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body>

<?php
/*
if(BO_MULTILANGUAGE!="0")
{
?>
<div style="color:#00307b;font-family:verdana;font-size:11;position:absolute;top:30;left:818">
	<form>

	Language:
	<select onchange="document.location.href='login.php?lng='+this.selectedIndex+''" style="color:#00307b;font-family:verdana;font-size:11">
	<?php

	foreach($arrSupportedLanguages as $arrLang){

		list($languageName,$languageCode)=$arrLang;

		echo "<option value\"".$languageCode."\" ".($LANGUAGE2==$languageCode?"selected":"").">".$languageName."</option>";

	}
	?>
	</select>
	</form>
</div>

<?php
}
*/
?>



<table summary="" border="0" width=100% height=100%>


	<tr>
		<td align=center valign=middle>

		<br><br>

<?php
if(isset($error))
{
	echo "<b><font size=2 color=#2971ce face=verdana>";
	if($error=="login")
	{
		echo $LOGIN_ERROR_MESSAGE."<br><br>";
	}
	else
	if($error=="no")
	{
		echo $LOGIN_EMPTY_FIELD_MESSAGE."<br><br>";
	}
	else
	if($error=="expired")
	{
		echo $LOGIN_EXPIRED_MESSAGE."<br><br>";
	}
	echo "</font></b>";
}
?>



<table background="images/login2.gif" summary="" border="0"  width="260" height="108" alt="">
	<tr>
		<td style="font-size:12;font-family:verdana;" align=center>
		<br><br>
		<table cellpadding="1" cellspacing="0">
	<tr><td style="color:#2971ce;font-size:11;font-family:arial" align=right>

		<form action="loginaction.php" method="Post" onsubmit="return ValidateLoginForm(this)">
		<?php
		if(isset($return_url)&&$return_url!="")
		{
		
		}
		else
		{
			$return_url="";
			if(isset($category)) $return_url.="&category=".$category;
			if(isset($action)) $return_url.="&action=".$action;
			if(isset($page)) $return_url.="&page=".$page;
			if(isset($folder)) $return_url.="&folder=".$folder;
		}
		?>
		<input type="hidden" name="return_url" value="<?php echo $return_url;?>">
		
		<?php echo $NOM_DUTILISATEUR;?>:
		</td><td align=right>
		<input type="Text" name="Email" size=20 style="color:#2971ce;border-style:solid;border-color:#2971ce;border-width:1px 1px 1px 1px;width:150"> &nbsp;
		</td>
		</tr>

		<tr>
		<td style="color:#2971ce;font-size:11;font-family:arial" align=right>
		&nbsp;<?php echo $MOT_DE_PASSE;?>:
		</td><td align=right>
		<input type="password" name="Password" size=20 style="color:#2971ce;border-style:solid;border-color:#2971ce;border-width:1px 1px 1px 1px;width:150"> &nbsp;
		</td>
		</tr>

		<tr>
		<td colspan=2 align=right>
		<input type=image src="images/login_button.gif" width="52" height="17" alt="" border="0"> &nbsp;
		
		</td>
		</tr>

		</form>
		</td></tr>
		</table>


		</td>
	</tr>
</table>
<br><br><br>

		</td>
	</tr>
</table>

</body>
</html>


