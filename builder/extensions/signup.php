<br><br><br><div class="container">


<?php
if(!isset($STEP))
{
	$STEP = 1;
}
$i_1=1+(ord($CAPTCHA_SALT[0])+(int)date("j"))%5;
$i_2=1+(ord($CAPTCHA_SALT[1])+(int)date("z"))%5;
if(get_param("ProceedStep1") != "")
{
	$Error = "";
	
	
	if(!isset($_POST[md5("SV".$CAPTCHA_SALT.date("j").date("z").$BLOG_DOMAIN)])  ||   $_POST[md5("SV".$CAPTCHA_SALT.date("j").date("z").$BLOG_DOMAIN)]!=md5($CAPTCHA_SALT.date("j").date("z").$BLOG_DOMAIN)) $Error=" ";
	
	if($USE_SECURITY_IMAGES)
	{
		if(!isset( $_SESSION[md5($CAPTCHA_SALT."A".floor(time() / 3600))])||$_SESSION[md5($CAPTCHA_SALT."A".floor(time() / 3600))]!=md5($CAPTCHA_SALT."B".floor(time() / 3600))) $Error=" ";
	}
	

	
	if($USE_SECURITY_IMAGES && ( (md5($CAPTCHA_SALT.$_POST['code'].$CAPTCHA_SALT) != $_SESSION['code'])|| trim($_POST['code']) == "" ) )
	{
		$Error = $M_WRONG_SECURITY_IMAGE_CODE;
		
	}
	
	if($answer2 != ($i_1+$i_2) )
	{
		$Error = $M_WRONG_ANSWER;
	}
	
	if($password != $password2)
	{
		$Error = $PWD_MISSMATCH;
	}
	
	if(!isset($agree))
	{
		$Error = $HAVE_TO_AGREE;
	}
	
	if(strlen(get_param("username"))<3||strlen(get_param("username"))>25)
	{
		$Error = $M_USERNAME_BETWEEN;
	}
	
	if (!preg_match ("/^[0-9a-zA-Z_]{3,25}$/", get_param("username"))) 
	{
		$Error = $M_USERNAME_INVALID;
	}
	
	if(strlen(get_param("password"))<3)
	{
		$Error = $CREATE_PASSWORD_EXPL;
	}
	
	if(file_exists("include/stop_words.php"))
	{
		$stop_words = implode('', file("include/stop_words.php"));
		
		$arrWords = explode("\n",$stop_words);
		
		if(in_array(strtolower(get_param("username")), $arrWords) )
		{
			$Error = $USERNAME_TAKEN;
		}
	}
	
	if(SQLCount("admin_users","WHERE username='".strtolower(get_param("username"))."'"))
	{
		$Error = $USERNAME_TAKEN;
	}
		
	if(trim($first_name) == trim($last_name) )
	{
		$Error = $M_FIRST_NAME_EQUAL_LAST;
	}
		
	
	if($Error == "")
	{
	
		ms_i(get_param("package"));
		$arrPackage = DataArray("blog_packages","id=".get_param("package"));	
	
		SQLInsert
		(
			"admin_users",
			array
			(
				"plan",
				"type",
				"username",
				"password",
				"first_name",
				"last_name",
				"company",
				"email",
				"subdomain",
				"card_type",
				"card_number",
				"card_exp_month",
				"card_exp_year",
				"card_name",
				"card_security_code",
				"address_address1",
				"address_address2",
				"address_city",
				"address_state",
				"address_zip",
				"address_country",
				"blog_created",
				"last_update",
				"blog_category",
				"bo_lang",
				"language",
				"blog_lang",
				"payment"
			),
			array
			(
				get_param("package"),
				$arrPackage["name"],
				strtolower(get_param("username")),
				md5($CAPTCHA_SALT.get_param("password")),
				get_param("first_name"),
				get_param("last_name"),
				get_param("company"),
				get_param("email"),
				get_param("subdomain"),
				get_param("card_type"),
				get_param("card_number"),
				get_param("card_exp_month"),
				get_param("card_exp_year"),
				get_param("card_name"),
				get_param("card_security_code"),
				get_param("address_address1"),
				get_param("address_address2"),
				get_param("address_city"),
				get_param("address_state"),
				get_param("address_zip"),
				get_param("address_country"),
				time(),
				time(),
				get_param("blog_category"),
				get_param("blog_language"),
				get_param("blog_language"),
				get_param("blog_language"),
				get_param("payment_option"),
			)
		);
		
		if(file_exists("phpbb_config.php"))
		{
			include("phpbb_config.php");
																					
			if(PHPBB_INSTALLED)
			{
				include("include/phpbb.php");
			}

		}
														
		$defTmpl = implode('', file('user_templates/'.$DEFAULT_TEMPLATE.'.htm'));
					
		SQLInsert("user_templates",array("user","html","menu"),array(strtolower(get_param("username")),$defTmpl,"<li><a href=\"[LINK_HREF]\" class=\"selected\">[LINK_TEXT]</a></li>"));
		
		include("include/user_default_pages.php");

		foreach($arrDefaultPages as $arrDefaultPage)
		{
			SQLInsert
			(
				"user_pages",
				array("name_en","link_en","html_en","user"),
				array($arrDefaultPage[0],$arrDefaultPage[0],$arrDefaultPage[1],strtolower(get_param("username")))
			);
		}

		
		if(SQLCount("weblog","WHERE user='".strtolower(get_param("username"))."'")==0)
		{
			SQLInsert("weblog",array("user","format"),array(strtolower(get_param("username")),$DEFAULT_TEMPLATE));
		}
		
		if(SQLCount("note_settings","WHERE user='".strtolower(get_param("username"))."'")==0)
		{
			SQLInsert("note_settings",array("user"),array(strtolower(get_param("username"))));
			SQLInsert("contact_settings",array("user","email"),array(strtolower(get_param("username")),""));
		}
					
		
		if($arrPackage["price"] == "0.00" || $arrPackage["price"] == "" )
		{
				
			if($VALIDATE_EMAIL_ADDRESSES_ON_SIGNUP)	
			{
				$CLICK_ACTIVATE="An email message containing
				an activation code has been sent to the email address you provided.";
				$ERROR_WHILE_SENDING_ACTIVATION = "There was an error while
				sending the activation code to: ".$user_email;
				
				
				$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
						
				$activationCode = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
				.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);
	
				$headers  = "From: \"".$SYSTEM_EMAIL_FROM."\"<".$SYSTEM_EMAIL_ADDRESS.">\n";
			
				$message="http://www.".$BLOG_DOMAIN."/USERSADMIN/activate.php?id=".$activationCode;
				
				if(!mail(get_param("email"), $BLOG_DOMAIN." activation", $message, $headers))
				{
					echo "<br><br>".$ERROR_WHILE_SENDING_ACTIVATION."<br><br>";
				}
				else
				{
					echo "<br><br>
					<b>$CLICK_ACTIVATE</b>
					</b><br>";
				}
				
				SQLUpdate_SingleValue
				(
					"admin_users",
					"username",
					"'".strtolower(get_param("username"))."'",
					"activation_code",
					$activationCode
				);
				
				SQLUpdate_SingleValue
				(
					"admin_users",
					"username",
					"'".strtolower(get_param("username"))."'",
					"blog_active",
					"0"
				);
			}
			else
			{
					
							echo("
									<br>
									<div style='margin-left:20px;margin-right:5px;font-weight:800'>
									".$THANK_YOU_MSG." ".$BLOG_DOMAIN."!
									".($USE_ABSOLUTE_URLS?"<br><br>".$ADDRESS_BLOG.": <a href=\"".BlogUrl(strtolower(get_param("username")))."\" target=_blank>".BlogUrl(strtolower(get_param("username")))."</a>":"")."
									<br><br>
									
									<form name=LoginForm id=LoginForm action=\"USERSADMIN/loginaction.php\" method=\"Post\" >
									<input type=\"hidden\" name=\"sv\" value=\"".md5($CAPTCHA_SALT.date("j").date("z").$BLOG_DOMAIN)."\">
	  
									".$CLICK_TO_LOGIN.": <input type=\"hidden\"  name=\"Email\" value=\"".strtolower($username)."\">
									<input type=\"hidden\"  name=\"Password\" value=\"".$password."\">
									
									<input type=\"submit\" class=\"button\" value='     ".$M_GO."     '>
									</div>
											
									</form>
							");
			}
		}
		else
		{
		
				if(get_param("payment_option") == "paypal")
				{
				
							SQLUpdate_SingleValue
									(
												"admin_users",
												"username",
												"'".strtolower(get_param("username"))."'",
												"blog_active",
												"0"
									);
									
							echo "<div style='margin-left:20px;margin-right:5px;font-weight:800'>
								 ".$THANK_YOU_MSG." ".$BLOG_DOMAIN."!
								
								".($USE_ABSOLUTE_URLS?"<br><br>".$ADDRESS_BLOG.": <a href=\"".BlogUrl(strtolower(get_param("username")))."\" target=_blank>".BlogUrl(strtolower(get_param("username")))."</a>":"")."
								<br><br>
								".$PLEASE_CLICK_ICON_PAYPAL."
								<br><br>";
								?>
								
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
								<input type="image" src="images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
								 <input type="hidden" name="cmd" value="_xclick-subscriptions">
								<input type="hidden" name="business" value="<?php echo $PAYPAL_ACCOUNT;?>"> 
								<input type="hidden" name="item_name" value="<?php echo $BLOG_DOMAIN." ".$M_PACKAGE.": ".$arrPackage["id"]; ?>"> 
								<input type="hidden" name="item_number" value="<?php echo $arrPackage["id"]; ?>"> 
								<input type="hidden" name="no_note" value="1"> 
								<input type="hidden" name="currency_code" value="<?php echo $PAYPAL_CURRENCY_CODE; ?>"> 
								<input type="hidden" name="a3" value="<?php echo $arrPackage["price"]; ?>"> 
								<input type="hidden" name="p3" value="<?php echo $arrPackage["billed"]; ?>"> 
								<input type="hidden" name="t3" value="M"> 
								<input type="hidden" name="src" value="1"> 
								<input type="hidden" name="sra" value="1"> 
								<input type="hidden" name="return" value="http://www.<?php echo $BLOG_DOMAIN;?>"> 
								<input type="hidden" name="cancel_return" value="http://www.<?php echo $BLOG_DOMAIN;?>"> 
								<input type="hidden" name="custom" value="<?php echo get_param("username"); ?>"> 
								<INPUT TYPE="hidden" NAME="first_name" VALUE="<?php echo get_param("first_name");?>">
								<INPUT TYPE="hidden" NAME="last_name" VALUE="<?php echo get_param("last_name");?>">
								<INPUT TYPE="hidden" NAME="company" VALUE="<?php echo get_param("company");?>">
								<input type="hidden" name="notify_url" value="<?php echo "http://www.".$BLOG_DOMAIN."/ipn.php";?>">
								</form>
								
								<?php
								echo "<br><br>".$M_ACCOUNT_PAYPAL_NOT_ACTIVE;
								
								echo "</div>
								";
							
				}
				else
				if(get_param("payment_option") == "cheque")
				{
				
						$strAmount = $CURRENCY_SYMBOL.$arrPackage["price"];
						
						SQLUpdate_SingleValue
									(
												"admin_users",
												"username",
												"'".strtolower(get_param("username"))."'",
												"blog_active",
												"0"
									);
						
						SQLInsert
							( 
								"blog_payments",
								array("date","user","method","validated","amount"),
								array(time(),get_param("username"),"cheque","0",$arrPackage["price"])
							);
									
						echo "<div style='margin-left:20px;margin-right:5px;font-weight:800'>
								 ".$THANK_YOU_MSG." ".$BLOG_DOMAIN."!
								
								".($USE_ABSOLUTE_URLS?"<br><br>".$ADDRESS_BLOG.": <a href=\"".BlogUrl(strtolower(get_param("username")))."\" target=_blank>".BlogUrl(strtolower(get_param("username")))."</a>":"")."
								<br><br>
								".str_replace("{AMOUNT}","<span class=redtext>".$strAmount."</span>",$M_PLEASE_SEND_CHECK_TO)."
								<br><br>
								".$CHEQUE_ADDRESS."
								<br><br>
								<span class=redtext>$M_YOUR_ACCOUNT_NOT_ACTIVE</span>
								</div>
								";
						
				}
				else
				if(get_param("payment_option") == "bank_wire")
				{
						
						$strAmount = $CURRENCY_SYMBOL.$arrPackage["price"];
						
						SQLUpdate_SingleValue
						(
							"admin_users",
							"username",
							"'".strtolower(get_param("username"))."'",
							"blog_active",
							"0"
						);
						
						SQLInsert
							( 
								"blog_payments",
								array("date","user","method","validated","amount"),
								array(time(),get_param("username"),"bank transfer","0",$arrPackage["price"])
							);
										
						echo "<div style='margin-left:20px;margin-right:5px;font-weight:800'>
								 ".$THANK_YOU_MSG." ".$BLOG_DOMAIN."!
								
								".($USE_ABSOLUTE_URLS?"<br><br>".$ADDRESS_BLOG.": <a href=\"".BlogUrl(strtolower(get_param("username")))."\" target=_blank>".BlogUrl(strtolower(get_param("username")))."</a>":"")."
								<br><br>
								".str_replace("{AMOUNT}","<span class=redtext>".$strAmount."</span>",$M_PLEASE_MAKE_TRANSFER)."
								<br><br>
								".$BANK_WIRE_TRANSFER_INFO."
								<br><br>
								<span class=redtext>$M_YOUR_ACCOUNT_NOT_ACTIVE</span>
								</div>
								";
						
				}
				
		
		}
		
	
	$STEP = 3;
	}
	else
	{
		echo "<br><span class=\"redtext\" style=\"font-size:18px;\">".$Error."</span><br><br>";
		
		$STEP = 1;
	}
	
}

if(true)
{
?>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody>

	
			<tr>
				<td >
					<table  cellpadding="0">
						<tbody>
							<tr >
								<td colspan="2">
		

<?php

if($STEP == 1)
{
?>
<script>


function ContainsSpecialSymbols(strInput){
	
	
	var reg = new RegExp("#|%|'");

	if (reg.test(strInput)){
		
		return true;
	}
	else{
		
		return false;
	}
  		
}

function CheckValidEmail(strEmail) 
{
	if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
	{
		return true;
	}
	else
	{
		return false;
	}
}
						
var lang = "<?php echo strtolower($LANG);?>";

function ValidateAddNewUser(x){


	if(ContainsSpecialSymbols(x.username.value))
	{
		if(lang == "bg")
		{
			alert("<?php echo string2utf8($M_USERNAME_INVALID);?>");
		}
		else
		{
			alert("<?php echo $M_USERNAME_INVALID;?>!");
		}
		return false;
	}
	
	if(x.username.value=="")
	{
					
		if(lang == "bg")
		{
			
			alert("<?php echo string2utf8($USERNAME_EMPTY_FIELD_MESSAGE);?>");
		}
		else
		{
			alert("<?php echo $USERNAME_EMPTY_FIELD_MESSAGE;?>");
		}
		x.username.focus();
		return false;
	}
	
	
	if(x.password.value=="")
	{
		if(lang == "bg")
		{
			
			alert("<?php echo string2utf8($PASSWORD_EMPTY_FIELD_MESSAGE);?>");
		}
		else
		{
			alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>!");
		}
		x.password.focus();
		return false;
	}
	
	if(x.password2.value=="")
	{
		if(lang == "bg")
		{
			alert("<?php echo string2utf8($PASSWORD_EMPTY_FIELD_MESSAGE);?>");
		}
		else
		{
			alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>!");
		}
		x.password2.focus();
		return false;
	}
	
	if(x.first_name.value=="")
	{
		if(lang == "bg")
		{
			
			alert("<?php echo string2utf8($PLS_ENTER_NAME);?>");
		}
		else
		{
			alert("<?php echo $PLS_ENTER_NAME;?>");
		}
		x.first_name.focus();
		return false;
	}
	
	if(x.last_name.value=="")
	{
		if(lang == "bg")
		{
			
			alert("<?php echo string2utf8($PLS_ENTER_NAME);?>");
		}
		else
		{
			alert("<?php echo $PLS_ENTER_NAME;?>");
		}
		x.last_name.focus();
		return false;
	}
	
	
	if(x.answer2.value=="")
	{
		if(lang == "bg")
		{
			alert("<?php echo string2utf8($M_SUM_EXPL);?>");
		}
		else
		{
			alert("<?php echo $M_SUM_EXPL;?>");
		}
		x.answer2.focus();
		return false;
	}
	
	if(x.code.value=="")
	{
		if(lang == "bg")
		{
			alert("<?php echo string2utf8($M_PLEASE_WRITE_CODE);?>");
		}
		else
		{
			alert("<?php echo $M_PLEASE_WRITE_CODE;?>");
		}
		x.code.focus();
		return false;
	}
	
	
	if(x.email.value=="")
	{
		if(lang == "bg")
		{
			alert("<?php echo string2utf8($PLEASE_ENTER_YOUR_EMAIL);?>");
		}
		else
		{
			alert("<?php echo $PLEASE_ENTER_YOUR_EMAIL;?>");
		}
		x.email.focus();
		return false;
	}
	
	if(!CheckValidEmail(x.email.value) )
	{
	
			if(lang == "bg")
			{
				alert(x.email.value+" <?php echo string2utf8($NOT_VALID_EMAIL);?>");
			}
			else
			{
				alert(x.email.value+" <?php echo $NOT_VALID_EMAIL;?>");
			}
			x.email.focus();
			return false;
	}
							
	
	if(!x.agree.checked)
	{
		if(lang == "bg")
		{
			
			alert("<?php echo string2utf8($HAVE_TO_AGREE);?>");
		}
		else
		{
			alert("<?php echo $HAVE_TO_AGREE;?>");
		}
		return false;
	}
	
	
	return true;
}

</script>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="home_table_first_TR">
			
				<b><?php echo $M_SIGN_UP;?></b>
			
		</td>
	</tr>
</table>




<br>

<form method="post" action="index.php" onsubmit="return ValidateAddNewUser(this);this.continue_button.disabled = 1;">
<?php
echo  "<input type=\"hidden\" name=\"".md5("SV".$CAPTCHA_SALT.date("j").date("z").$BLOG_DOMAIN)."\" value=\"".md5($CAPTCHA_SALT.date("j").date("z").$BLOG_DOMAIN)."\">";

if(isset($mod))				  
{
?>
<input name="mod" value="<?php echo $mod;?>" type="hidden">
<?php
}
else
if(isset($page))				  
{
?>
<input name="page" value="<?php echo $page;?>" type="hidden">
<?php
}
?>
<input name="ProceedStep1" value="1" type="hidden">


<b><?php echo $MEMBER_NAME;?></b><br>
<input name="username" class="text_field" id="username" value="<?php echo get_param("username");?>" onkeyup="setDomainName(this.form.subdomain, this.value)" ></b></font>
<br>
<i style="font-size:11px"><?php echo $MEMBER_NAME_EXPL;?></i>
<br><br>


<b><?php echo $CREATE_PASSWORD;?></b><br>
<input name="password" class="text_field" id="password" value="" type="password"></b></font>
<br>
<i style="font-size:11px"><?php echo $CREATE_PASSWORD_EXPL;?></i>
<br><br>


<b><?php echo $CONFIRM_PASSWORD;?></b><br>
<input name="password2" class="text_field" id="password2" value="" type="password"></b></font>
<br><br>



<b><?php echo $FIRST_NAME;?></b><br>
<input name="first_name" class="text_field" id="first_name" value="<?php echo get_param("first_name");?>"></b></font>

<br><br>

<b><?php echo $LAST_NAME;?></b><br>
<input name="last_name" class="text_field" id="last_name" value="<?php echo get_param("last_name");?>"></b></font>

<br><br>

<b><?php echo $M_COMPANY;?></b><br>
<input name="company" class="text_field" id="company" value="<?php echo get_param("company");?>"></b></font>

<br><br>

<b><?php echo $i_1;?> + <?php echo $i_2;?> = ?</b><br>
<input name="answer2" id="answer2" value="<?php echo get_param("answer2");?>" type="text"></b></font>
<br>
<i style="font-size:11px"><?php echo $M_SUM_EXPL;?></i>
<br><br>

<b><?php echo $M_EMAIL;?></b><br>
<input name="email" class="text_field" id="email" value="<?php echo get_param("email");?>"></b></font>
<?php
if($VALIDATE_EMAIL_ADDRESSES_ON_SIGNUP)	
{
	echo "<br>
	<b>".$M_ACTIVATION_CODE_SENT."</b>
	
	";
}
?>
<br><br>

<?php
if(!$WEBSITE_MULTILANGUAGE)
{
?>
<div style="display:none">
<?php
}
?>

<b><?php echo $M_BLOG_LANGUAGE;?></b>
<br>
<?php


echo "<select class=\"text_field\" name=\"blog_language\">";

$arrSupportedLanguages=array();
$tableLanguages = DataTable("languages","WHERE active=1");
{
	while($aLanguage = mysql_fetch_array($tableLanguages))
	{
		array_push($arrSupportedLanguages, array($aLanguage["name"], strtolower($aLanguage["code"])));
	}
}


foreach($arrSupportedLanguages as $arrLang)
{
	echo "<option value=\"".strtolower($arrLang[1])."\" ".(strtolower($arrLang[1])==$lang?"selected":"").">".$arrLang[0]."</option> ";
}

echo "</select>";

?>

<br><br>
<?php
if(!$WEBSITE_MULTILANGUAGE)
{
?>
</div>
<?php
}
?>




<b><?php echo $M_BLOG_CATEGORY;?></b>
<br>
<?php

echo "<select name=\"blog_category\" class=\"text_field\">";


if(file_exists('include/categories_'.strtolower($lang).'.php'))
		$categories_content = file_get_contents('include/categories_'.strtolower($lang).'.php');
	else
		$categories_content = file_get_contents('include/categories_en.php');


	$arrCategories = explode("\n", trim($categories_content));

	$bF = true;$bC=0;$iCatC=0;

	foreach($arrCategories as $strCategory)
	{
		$category = explode(". ",$strCategory);
		$prefix = "";
		
		if(substr_count($strCategory, '.')>1) $prefix = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"font-size:9px\">";
		
		echo "<option value=\"".$category[0]."\">".$prefix.$category[1]."</option>";
	}	

echo "</select>";

?>

<br>

</p>



<?php
if($SERVICE_IS_FREE)
{
	$arrSelectedPackage = DataArray("blog_packages","price='0.00'");
	echo "<input type=hidden name=\"package\" value=\"".$arrSelectedPackage["id"]."\">";
}
else
{
?>
<br>
				<script>
				
				
				
				function ShowPaymentOptions(x,y,z)
				{
				
					if(z==""||z=="0.00"||z=="0")
					{
						document.getElementById("PaymentOptions").style.display="none";
					}
					else
					{
						document.getElementById("PaymentOptions").style.display="block";
					}
					
					for(i=1;i<=iTotalPackages;i++)
					{
					
						document.getElementById("tr"+i).style.background="#f1f1f1";
						document.getElementById("table"+i).style.display="none";
					}
					
					
					document.getElementById("tr"+x).style.background="#ececec";
					
					
					
					
					var arrItems=y.split("-"); 
					
					if(arrItems.length>1)
					{
									document.getElementById("PaymentOptions").style.display="block";
									
									for(i=0;i<arrItems.length;i++)
									{
										if(arrItems[i] != "")
										{
											document.getElementById("table"+arrItems[i]).style.display = "block";
										}
									}
									
					}
					else
					{
									document.getElementById("PaymentOptions").style.display="none";
					}
				
					
				}
				
				</script>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr class="home_table_first_TR">
						<td>
							<div class="home_table_first_offset">
								<b><?php echo $M_SELECT_YOUR_PACKAGE;?></b>
							</div>
						</td>
					</tr>
				</table>
				<br>
				
				<?php
				$tablePackages = DataTable("blog_packages","ORDER BY price");
				
				echo "<table width=\"800\" cellpadding=0 cellspacing=0>";
				
					echo "<tr height=30>
								<td width=35></td>	
								<td><i>".strtoupper($NOM)."</i></td>
								<td width=160><i>".strtoupper($SPACE)."</i></td>	
								<td width=160><i>".strtoupper($BANDWIDTH)."</i></td>	
								
							</tr>";
				
				$iPCounter=1;			
				$bFirst = true;
				$iTotalPackages = 0;
				
				$strFirstPrice = "";
				$bFirstPrice = true;
				$strFirstPaymentOptions = "";
				
				while($arrCurrentPackage = mysql_fetch_array($tablePackages))
				{
				
						
						
								
						$iTotalPackages++;
						
						$strPaymentOptions = "";
						$strPayments = "";
						
						if($arrCurrentPackage["paypal"] == 1)
						{
							$strPayments .= "<b>".$M_PAYPAL."</b>, ";
							$strPaymentOptions .= "1-";
						}
						
						if($arrCurrentPackage["cheque"] == 1)
						{
							$strPayments .="<b>". $M_CHEQUE."</b>, ";
							$strPaymentOptions .= "2-";
						}
						
						if($arrCurrentPackage["bank_wire"] == 1)
						{
							$strPayments .= "<b>".$M_BANK_WIRE."</b>, ";
							$strPaymentOptions .= "3-";
						}
						
						if($bFirstPrice)
						{
							$strFirstPaymentOptions = $strPaymentOptions;
							$strFirstPrice=$arrCurrentPackage["price"];
							$bFirstPrice = false;
						}
						
						
						$strPayments = trim($strPayments);
						
						if($arrCurrentPackage["price"] == "0.00" || $arrCurrentPackage["price"] == "")
						{
							$strPaymentOptions = "";
						}
				
					echo "<tr height=35 bgcolor='".($bFirst?"#ececec":"#f1f1f1")."' id=\"tr".$iPCounter."\">";
					
					echo "
								<td>
										<input ".($bFirst?"checked":"")." onclick=\"javascript:ShowPaymentOptions(".$iPCounter.",'".$strPaymentOptions."','".$arrCurrentPackage["price"]."')\" type=\"radio\" name=\"package\" value=\"".$arrCurrentPackage["id"]."\">
								</td>
								<td>
										<b>".$arrCurrentPackage["name"]."</b>
								</td>
								<td>
										<b>".FormatSpace($arrCurrentPackage["space"])."</b>
								</td>
								<td>
										<b>".FormatSpace($arrCurrentPackage["traffic"])."</b>
								</td>
								
					
					";	
					
					$bFirst = false;	
						
					echo "</tr>";
					
					echo "
							<tr height=35 bgcolor=#fafafa>
								<td colspan=4>
										<div style='margin-top:10px;margin-left:5px;margin-right:5px;margin-bottom:10px'>
							";
					
					if($arrCurrentPackage["price"] == "0.00" || $arrCurrentPackage["price"] == "")			
					{
						echo "<b>".strtoupper($M_PRICE).":
										<span class=redtext>".$M_FREE."!!!</span></b>";
					
					}
					else
					{
						echo "<b>".strtoupper($M_PRICE_FOR." ".$arrCurrentPackage["billed"]." ".$MM_MONTHS).":
										<span class=redtext>".$CURRENCY_SYMBOL.$arrCurrentPackage["price"]."</span></b>";
						echo "
							<br><i>
							(".$M_PAID_PER." <b>".$arrCurrentPackage["billed"]."</b> ".$MM_MONTHS.", 
							".$M_AVERAGE_PRICE_MONTH.": ".$CURRENCY_SYMBOL.number_format(round($arrCurrentPackage["price"]/$arrCurrentPackage["billed"],2),2,'.','')."</i>)";				
						
						
						
						if(strlen($strPayments)>1)
						{
							$strPayments = substr($strPayments, 0, (strlen($strPayments)-1) );
						}
						
						
						echo "<br><br>".$M_PAYMENTS_BY.": ".$strPayments;
						
						
					}
										
					echo "			<br><br>
										<i>".$arrCurrentPackage["description"]."</i>
										</div>
								</td>
							</tr>
							<tr height=5>
								<td colspan=4>
									&nbsp;
								</td>
							</tr>
					";
					$iPCounter++;
				}
				
				echo "</table>";
				
				echo "
				<script>
				var iTotalPackages=".$iTotalPackages.";
				</script>
				";
				
				?>
				
				
				<div id="PaymentOptions" <?php if($strFirstPrice==""||$strFirstPrice=="0.00") echo "style=\"display:none\"";?>>
				<b><?php echo $M_PLEASE_SELECT_YOUR_PAYMENT;?>:<br></b>
				
				
				<table id="table1" <?php if(!strstr($strFirstPaymentOptions, "1")) echo "style=\"display:none\"";?>>
					<tr><td  width="200" valign=middle><input type=radio checked name=payment_option value=paypal> <b><?php echo $M_PAYPAL;?></b> </td><td width=178 valign=middle ><img src='images/paypal.gif'></td></tr>
				</table>
				
				<table id="table2" <?php if(!strstr($strFirstPaymentOptions, "2")) echo "style=\"display:none\"";?>>
						<tr><td  width="200" valign=middle><input type=radio name=payment_option value=cheque> <b><?php echo $M_CHEQUE;?></b> </td><td valign=middle><img src='images/cheque.gif'></td></tr>
				</table>
				
				<table id="table3" <?php if(!strstr($strFirstPaymentOptions, "3")) echo "style=\"display:none\"";?>>
						<tr><td  width="200" valign=middle><input type=radio name=payment_option value=bank_wire> <b><?php echo $M_BANK_WIRE;?></b> </td><td valign=middle><img src='images/banque.gif'></td></tr>
				</table>
				
				<br>
				
				</div>



						
<?php
}
?>			




<?php
	if($USE_SECURITY_IMAGES)
	{
	?>
	
			
			<img src="include/sec_image.php">
			
			&nbsp;&nbsp;&nbsp;
		
			<?php
			echo $M_CODE
			;?>:
			
			<input type="text" name="code" value="" size="8">	
	

	<?php
	}
	?>


<br>

<p><label><input name="agree" value="1" type="checkbox"> <?php echo $I_AGREE;?>

 </label> (<a onclick="window.open(this.href, '_blank', 'width=500,height=500,scrollbars=yes'); return false" href="include/conditions.php"><?php echo $M_TOS;?></a>)</p>



<br>
	<div style="text-align: right;">
		<input type="submit" class="button" value="<?php echo $M_SUBMIT;?>">
	</div>

</form>


</div>
<br>
<?php
}
?>
  
						</td>
					</tr>
				</tbody>
			</table>
			
		</td>
	</tr>
	
	</tbody>
</table>


<?php
}
?>

</div>