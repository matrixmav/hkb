<?php

$show_signup_form=true;
$Error="";
if($me&&$me["id"]!="")
{

	if(get_param("ProceedStep1") != "")
	{
	
	
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
		
		if($password != $password2)
		{
			$Error = $PWD_MISSMATCH;
		}
		
		if(strlen(get_param("password"))<3||strlen(get_param("password"))>15)
		{
			$Error = $CREATE_PASSWORD_EXPL;
		}

		if(file_exists("include/stop_words.php"))
		{
			$stop_words = implode('', file("include/stop_words.php"));
			
			$arrWords = explode("\n",$stop_words);
			
			if(in_array(get_param("username"), $arrWords) )
			{
				$Error = $USERNAME_TAKEN;
			}
			
			
		}
		
		if(SQLCount("admin_users","WHERE username='".get_param("username")."'"))
		{
			$Error = $USERNAME_TAKEN;
		}
		
		
		if($Error == "")
		{
			$show_signup_form=false;
			$arrPackage = DataArray("blog_packages","price='0.00' ");	
			
			if(!isset($arrPackage["id"]))
			{
				$arrPackage = DataArray("blog_packages","ORDER BY id");	
			}
			
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
						
						"blog_created",
						"last_update",
						"blog_category",
						"bo_lang",
						"language",
						"blog_lang",
						"payment",
						"facebook_id"
					),
					array
					(
						$arrPackage["id"],
						$arrPackage["name"],
						get_param("username"),
						md5($CAPTCHA_SALT.get_param("password")),
						$me["first_name"],
						$me["last_name"],
						
						time(),
						time(),
						"1",
						"en",
						"en",
						"en",
						"",
						$me["id"]
					)
			);
			
			$defTmpl = implode('', file('blog_templates/'.$DEFAULT_TEMPLATE.'.php'));
					
			SQLInsert("user_templates",array("user","html"),array(get_param("username"),$defTmpl));
			
			
			if(SQLCount("weblog","WHERE user='".get_param("username")."'")==0)
			{
				SQLInsert("weblog",array("user","format"),array(get_param("username"),"1"));
			}
			
			if(SQLCount("note_settings","WHERE user='".get_param("username")."'")==0)
			{
				SQLInsert("note_settings",array("user"),array(get_param("username")));
				SQLInsert("contact_settings",array("user","email"),array(get_param("username"),""));
			}
			
			echo("
					<br>
					<div style='margin-right:5px;font-weight:800'>
					".$THANK_YOU_MSG." ".$BLOG_DOMAIN."!
					<br><br>
					".$ADDRESS_BLOG.": <a href=\"http://".BlogUrl(get_param("username"))."\" target=_blank>".BlogUrl(get_param("username"))."</a>
					<br><br>
					
					<form name=LoginForm id=LoginForm action=\"BLOGSADMIN/loginaction.php\" method=\"Post\" >
					<input type=\"hidden\" name=\"sv\" value=\"".md5($CAPTCHA_SALT.date("j").date("G").$BLOG_DOMAIN)."\">

					".$CLICK_TO_LOGIN.": <input type=hidden  name=Email value=\"".$username."\">
					<input type=hidden  name=Password value=\"".$password."\">
					
					<input type=\"submit\" class=\"button\" value='     ".$M_GO."     '>
					</div>
							
					</form>
			");
			$show_signup_form=false;
		}
		else
		{
			echo "<br><span class=\"redtext\" style=\"font-size:18px;\">".$Error."</span><br><br>";
			
			$STEP = 1;
			$show_signup_form=true;
		}
	}
	

	if($show_signup_form)
	{
		if($Error!="" || !isset($arrBlogger["id"]) || $arrBlogger["username"]=="")
		{
		
			$suggested_username = 
				strtolower
				(
					preg_replace('/[^[a-zA-Z]]*/','',$me["first_name"].$me["last_name"])
				);

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
					
				var lang = "<?php echo strtolower($LANG);?>";

				function ValidateAddNewUser(x)
				{


					if(ContainsSpecialSymbols(x.username.value))
					{
						if(lang == "bg")
						{
							
							alert("<?php echo string2utf8($NOM_UTILISATEUR_CARACTERES);?>");
						}
						else
						{
							alert("<?php echo $NOM_UTILISATEUR_CARACTERES;?>!");
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
							alert("<?php echo $USERNAME_EMPTY_FIELD_MESSAGE;?>!");
						}
						x.username.focus();
						return false;
					}
					
					
					if(x.password.value=="")
					{
						if(lang == "bg")
						{
							
							alert("<?php echo string2utf8($MOT_DE_PASSE_VIDE);?>");
						}
						else
						{
							alert("<?php echo $MOT_DE_PASSE_VIDE;?>!");
						}
						x.password.focus();
						return false;
					}
					
					if(x.password2.value=="")
					{
						if(lang == "bg")
						{
							
							alert("<?php echo string2utf8($MOT_DE_PASSE_VIDE);?>");
						}
						else
						{
							alert("<?php echo $MOT_DE_PASSE_VIDE;?>!");
						}
						x.password2.focus();
						return false;
					}
					return true;
				}
				</script>
		
			<br>
			<i><?php echo $M_JUST_CONFIRM_USERNAME;?></i>
			<br><br>
			<form action="index.php" method="post"  onsubmit="return ValidateAddNewUser(this);">
			<input type="hidden" name="mod" value="facebook_signup">
			<input name="ProceedStep1" value="1" type="hidden">

			<b><?php echo $MEMBER_NAME;?></b><br>
			<input name="username" id="username" value="<?php if(get_param("username")!="") echo get_param("username");else echo $suggested_username;?>" ></b></font>
			<br>
			<i><?php echo $MEMBER_NAME_EXPL;?></i>
			<br><br>


			<b><?php echo $CREATE_PASSWORD;?></b><br>
			<input name="password" id="password" type="password" value="<?php echo get_param("password");?>"></b></font>
			<br>
			<i><?php echo $CREATE_PASSWORD_EXPL;?></i>
			<br><br>


			<b><?php echo $CONFIRM_PASSWORD;?></b><br>
			<input name="password2" id="password2" type="password" value="<?php echo get_param("password2");?>"></b></font>

			<br><br>
			
			<p><label><input name="agree" value="1" type="checkbox" <?php if(isset($agree)) echo "checked";?>> <?php echo $I_AGREE;?>

			</label> (<a onclick="window.open(this.href, '_blank', 'width=500,height=500,scrollbars=yes'); return false" href="include/conditions.php"><?php echo $M_TOS;?></a>)</p>


			<br><br>
			
				<input type="submit" class="button" value="<?php echo $M_SUBMIT;?>">
			
			</form>
			<?php
		}
		else
		{


			echo "<i>".$M_REDIRECTED_MOMENT."</i>";


		}
	}
}
else
{

	echo "<script>document.location.href='index.php?mod=signup';</script>";
}

?>