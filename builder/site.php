<?php
include("config.php");
session_start();
if(isset($_GET["user"])){$user=$_GET["user"];}else if(isset($_POST["user"])){ $user=$_POST["user"];} if(!isset($user) || $user == ""){ die("user not set"); } $user2=$user;
$user=str_replace("/","",$user);
include("ADMIN/Utils.php");
EnsureParams();
include("include/init.php");
if(function_exists("date_default_timezone_set")) date_default_timezone_set($DEFAULT_TIME_ZONE);
ms_ew($user);
$ouse=array();
$ouse["user"]=$user;
$ouseFlag = false;
if($ouse==$_GET) $ouseFlag = true;

if(isset($news)) {ms_i($news);$note = $news;}


$proceedMainFlag = true;

$i_1=1+(ord($CAPTCHA_SALT[0])+(int)date("j"))%5;
$i_2=1+(ord($CAPTCHA_SALT[1])+(int)date("G"))%5;

if($ENABLE_BLOGS_CACHE&&(isset($note)||$ouseFlag)&&!isset($vote)&&!isset($no_cache)&&$_SERVER["REQUEST_METHOD"]=="GET")
{
	$proceedMainFlag = false;

	if($ouseFlag)	
	{
		$filename = "cache/".$user."/main.php";
		$c_url = 'site.php?user='.$user.'&no_cache=1';
	}
	else
	{
		ms_i($note);
		$filename = "cache/".$user."/".$note.".php";
		$c_url = 'site.php?user='.$user.'&note='.$note.'&no_cache=1';
	}
		
	$proceedFlag = true;

	if(file_exists($filename) &&  filesize($filename) > 0 &&  (filemtime($filename)+$BLOGS_CACHE_EXPIRE_TIME*60) > time())
	{
		include($filename);
		$proceedFlag = false;
	}
	
	if($proceedFlag)
	{
	
		if(!file_exists("cache/".$user))
		{
			mkdir("cache/".$user);
		}
	
	    if (!$handle = fopen($filename, 'w')) 
		{
        	 $proceedMainFlag = true;
      	}

		$content = implode('', file('http://www.'.$BLOG_DOMAIN.'/'.$c_url));

    	if (fwrite($handle, $content) === FALSE) 
		{
			$proceedMainFlag = true;
        }

		if($handle)
		{
			fclose($handle);
		}
                    
		if(file_exists($filename))
		{
	 		include($filename);
			$proceedFlag = false;
		}				
		
	}
	
}

if($proceedMainFlag)
{
	
	$IP=$_SERVER["REMOTE_ADDR"];
	$OUTPUT_SIZE = 0;
	$OUTPUT_IMAGES = array();

	MySQL_OC();
	$arrAdminUser =  DataArray_OC("admin_users","username='$user'");
	$arrWeblog = DataArray_OC("weblog","user='$user'");
	if(trim($arrWeblog["user"]) == ""||trim($arrAdminUser["username"]) == ""||!isset($arrAdminUser["plan"])||$arrAdminUser["plan"]=="")
	{
		MySQL_CC();die("<script>alert(\"This site doesn't exist anymore!\");document.location.href='http://www.".$BLOG_DOMAIN."/';</script></script>");
	}
	$arrNoteSettings = DataArray_OC("note_settings","user='$user'");
	$arrPackage =  DataArray_OC("blog_packages","id=".$arrAdminUser["plan"]);
	$arrTemplate = DataArray_OC("user_templates","user='$user'");
	$arrContactSettings = DataArray_OC("contact_settings","user='".$user."'");
	$arrContactSettings = DataArray_OC("contact_settings","user='".$user."'");
	SQLQuery_OC("UPDATE ".$DBprefix."admin_users SET visits=visits+1 WHERE username='$user'");
	MySQL_CC();								

	include("include/texts_".$arrAdminUser["blog_lang"].".php");

	$width1 = 799;$width2 = 792;$width3 = 788;

	if(isset($DISABLE_BLOGS_WHEN_OVER_BANDWIDTH_QUOTA)&&$DISABLE_BLOGS_WHEN_OVER_BANDWIDTH_QUOTA)
	{
		$tableBand = DataTable_Query("SELECT sum(size) sm FROM ".$DBprefix."blog_band WHERE user='".$user."' AND date>".(time()-30*86400)." ");	
		$arrBand = mysql_fetch_array($tableBand);
				
		if($arrBand["sm"] > $arrPackage["traffic"]*1024)
		{
			die("<script>alert(\"This site has gone over his bandwith quota and is currently suspended!\");document.location.href='http://www.".$BLOG_DOMAIN."/';</script></script>");
		}
	}

	if(get_param("flag") != "")
	{
		if($ADMIN_EMAIL_NOTIFICATIONS_OBJECTIONABLE_CONTENT)
		{
			$headers  = "From: \"".$SYSTEM_EMAIL_FROM."\"<".$SYSTEM_EMAIL_ADDRESS.">\n";
									
			$message="Blogger: ".$user."\n\nURL: ".get_param("flag_url");
										
			mail($SYSTEM_EMAIL_ADDRESS, $BLOG_DOMAIN." objectionable content warning", $message, $headers);
		}
		
		SQLUpdate_SingleValue
		(
			"admin_users",
			"username",
			"'".$user."'",
			"card_type",
			get_param("flag_url")
		);
	}

	if($arrAdminUser["card_name"] != "")
	{
		if(isset($pwd_protect)&& $pwd_protect== $arrAdminUser["card_name"])
		{
			setcookie($user."_pwd", get_param("pwd_protect"), time()+4*3600, "/", ".".$BLOG_DOMAIN);
		}	 
		else	 
		 if(!isset($_COOKIE[$user."_pwd"]))
		 {
			 include("include/password.php");
			 die("");
		 }
		 
		if(isset($_COOKIE[$user."_pwd"])&&$_COOKIE[$user."_pwd"]!=$arrAdminUser["card_name"])
		{
			setcookie($user."_pwd", "", time()-1, "/", ".".$BLOG_DOMAIN);
			include("include/password.php");
			die("");
		}
	}

	if($arrAdminUser["blog_active"] == "0")
	{
		die("<script>alert(\"".$M_BLOG_NOT_ACTIVATED."\");document.location.href='http://www.".$BLOG_DOMAIN."';</script></script>");
	}

	$STR_TEMPLATE = $arrTemplate["html"];
	$STR_TEMPLATE = str_replace("<blog ","<wsa ",$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("http://www.netartmedia.net/blogsystem","http://www.wscreator.com",$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("Blog System","WSCreator",$STR_TEMPLATE);
	
	
	$strHomeURL = "";

	if($BLOG_URL_FORMAT == 1)
	{
		$strHomeURL = "http://".$user.".".$BLOG_DOMAIN;
	}
	else
	{
		$strHomeURL = "http://www.".$BLOG_DOMAIN."/".$user;
	}

	
	
	/// blog logo
	if($arrWeblog["logo"]!="" && $arrWeblog["logo"]!="0")
	{
		array_push($OUTPUT_IMAGES, $arrWeblog["logo"]);
		$logo = ShowImage($arrWeblog["logo"],$user);
	}
	else
	if(trim($arrWeblog["logo_text"]) != "<br>" && trim($arrWeblog["logo_text"]) != "")
	{
		$logo = $arrWeblog["logo_text"];
	}
	else
	if(trim($arrAdminUser["company"]) != "")
	{
		$logo = "<h1 class=\"header_title\">".trim($arrAdminUser["company"])."</h1>";
	}
	else
	{
	
		$logo = '

		 <span class=header_title style="font-size:28px">
		'.$BLOG_I_1.strtolower($arrAdminUser["first_name"]).' '.strtolower($arrAdminUser["last_name"]).$BLOG_I_2.'
		 </span>
		<br>
		
		';
	}
	/// end blog logo

	//MAIN NAVIGATION MENU START	
	$categories = "";
	$default_page_id=0;
	$menu_html_code = "";
	$bottom_menu_html = "";
	
	$custom_menu_template= trim(get_string_between($STR_TEMPLATE, "<!--menu-item", "menu-item-->"));
	
	if($custom_menu_template!= "")
	{
		$menu_item_template = $custom_menu_template;
	}
	else
	{
		$menu_item_template = trim($arrTemplate["menu"]);
	}
	
	$tableNotesCat=DataTable("user_pages","WHERE user='$user' AND active_en=1 AND parent_id=0 ORDER BY id");
	
	while($arrNote = mysql_fetch_array($tableNotesCat))
	{
		if($default_page_id == 0) $default_page_id = $arrNote["id"];
		
		if($USE_ABSOLUTE_URLS)
		{
			if($BLOG_URL_FORMAT == 1)
			{
				$str_link = "http://".$user.".".$BLOG_DOMAIN."/".$arrNote["id"]."-".format_str($arrNote["link_en"]).".html";
			}
			else
			{
				$str_link = "http://www.".$BLOG_DOMAIN."/".$user."/".$arrNote["id"]."-".format_str($arrNote["link_en"]).".html";
			}
		}
		else
		{
			$str_link = "site.php?user=".$user."&page_id=".$arrNote["id"];
		}
		
		
		$str_text = $arrNote["link_en"];
		
		$bottom_menu_html .= "<a href=\"".$str_link."\">".$str_text."</a> &nbsp;&nbsp; ";;
		
		if(trim($menu_item_template) == "")
		{
			$menu_html_code.= "<a href=\"".$str_link."\">".$str_text."</a><br>";
		}
		else
		{
			$current_item = $menu_item_template;
			$current_item = str_replace("[LINK_HREF]",$str_link,$current_item);
			$current_item = str_replace("[LINK_TEXT]",$str_text,$current_item);
			$menu_html_code.= $current_item;
			
		}
		
		
		if(isset($page_id)&&$page_id == $arrNote["id"])
		{
			ms_i($page_id);
			$sub_pages=DataTable("user_pages","WHERE user='$user' AND active_en=1 AND parent_id=".$page_id." ORDER BY id");
	
			if(mysql_num_rows($sub_pages)>0)
			{
				$menu_html_code.= "<ul >";
				while($sub_page = mysql_fetch_array($sub_pages))
				{
					$str_sub_text = $sub_page["link_en"];
		
					if($USE_ABSOLUTE_URLS)
					{
						if($BLOG_URL_FORMAT == 1)
						{
							$str_sub_link = "http://".$user.".".$BLOG_DOMAIN."/".$sub_page["id"]."-".format_str($sub_page["link_en"]).".html";
						}
						else
						{
							$str_sub_link = "http://www.".$BLOG_DOMAIN."/".$user."/".$sub_page["id"]."-".format_str($sub_page["link_en"]).".html";
						}
					}
					else
					{
						$str_sub_link = "site.php?user=".$user."&page_id=".$sub_page["id"];
					}
					$menu_html_code.= "<li><a href=\"".$str_sub_link."\">".$str_sub_text."</a></li>";
				}
				$menu_html_code.= "</ul>";
			}
		}
	}
	mysql_free_result($tableNotesCat);

	//MAIN NAVIGATION MENU END
	
	

	/// content
	$content = "";

			
			if(isset($imprint))
			{
				 
				
				$content .=' <table border="0" width="100%" cellpadding="6" class="blog_table">
				<tr>
					<td class=header>
						
						
						'.$M_IMPRINT.'
						
					</td>
				</tr>
			</table>
			<br>';
			
			
				$content .= '<table cellspacing=8 summary="" border="0">
					<tr>
						<td>'.$FIRST_NAME.':</td>
						<td><b>'.$arrAdminUser["first_name"].'</b></td>
					</tr>
					<tr>
						<td>'.$LAST_NAME.':</td>
						<td><b>'.$arrAdminUser["last_name"].'</b></td>
					</tr>
					<tr>
						<td>'.$TELEPHONE.':</td>
						<td><b>'.$arrAdminUser["telephone"].'</b></td>
					</tr>
					<tr>
						<td>'.$EMAIL.':</td>
						<td><b>'.$arrAdminUser["email"].'</b></td>
					</tr>
					<tr>
						<td>'.$COUNTRY.':</td>
						<td><b>'.$arrAdminUser["country"].'</b></td>
					</tr>
					<tr>
						<td>'.$ADDRESS1.':</td>
						<td><b>'.$arrAdminUser["address_address1"].'</b></td>
					</tr>
					<tr>
						<td>'.$ADDRESS2.':</td>
						<td><b>'.$arrAdminUser["address_address2"].'</b></td>
					</tr>
					<tr>
						<td>'.$CITY.':</td>
						<td><b>'.$arrAdminUser["address_city"].'</b></td>
					</tr>
					<tr>
						<td>'.$M_ZIP.':</td>
						<td><b>'.$arrAdminUser["address_zip"].'</b></td>
					</tr>
				</table>';
			
				
										
		
			}
			else
			if(isset($contact))
			{
				$content .=' <table border="0" width="100%" cellpadding="6" class="blog_table">
						<tr>
							<td class=header>
								
								
								'.$CONTACT_THE_AUTHOR.'
								
							</td>
						</tr>
					</table>
					<br>';
					
					
				if(isset($add_contact))
				{
						if($USE_SECURITY_IMAGES && ( (md5($CAPTCHA_SALT.$_POST['captcha_code'].$CAPTCHA_SALT) !=$_SESSION['code'])|| trim($_POST['captcha_code']) == "" ) )
						{
																										
							$content .= '<br>
					
					
								<font color=red><b>'.$M_WRONG_SECURITY_IMAGE_CODE.'</b></font>
								<br><br><br><br>
							';		
						}
						else
						{
			
							SQLInsert
							(
								"contact",
								array("user","name","email","message","date"),
								array($user,$name,$email,$message,time())
							);
							
							
							$content .= '<br>
							<b>
							'.$MESSAGE_SEND_SUCCESS.'
							</b>';
			
							
							if($arrContactSettings["send_email"] == "YES")
							{
								mail($arrContactSettings["email"],"Blog Contact","Name: $name\n\nEmail: $email\n\nMessage: $message ");
							}
									
						}
					}
					else
					{
					
					
							$content .= '
										<form method="post" action="'.CreateLink("index.php").'" >
												<input type="hidden" name="contact" value="1">
												<input type="hidden" name="add_contact" value="yes">
								
												
													'.$M_NAME.':<br>
													<input   id="name" name="name" >
													<br><br>
													'.$M_EMAIL.':<br>
													<input  id="email" name="email" >
													<br><br>
														
												'.$M_MESSAGE2.':<br>
												<textarea  id="message" name="message" rows="10" cols="40"></textarea></p>';
												
								if($USE_SECURITY_IMAGES)
								{
									$content .= '
									<br>
											<table summary="" border="0">
												<tr>
													<td valign="top">
													
													<img src="'.($USE_ABSOLUTE_URLS?'http://www.'.$BLOG_DOMAIN.'/':'').'include/sec_image.php"  >
													'.$M_CODE.':

													<input type="text" name="captcha_code" value="" size=8>	
													
													</td>
												</tr>
											 </table>
									
									';
								}							
												
								$content .= '<br>
													<input style="font-weight: bold;" type="submit"  name="post" value="&nbsp;'.$M_POST.'&nbsp;" >
												
											</form>';
					}

	
			}
		else 
		
		if(isset($note))
		{
			ms_i($note);
			$arrNote = DataArray("notes","id=$note AND user='".$user."'");
			
			if(!isset($arrNote["title"])||$arrNote["active"]=="NO")
			{
				die("<script>document.location.href='http://www.".$BLOG_DOMAIN."/site.php?user=".$user."';</script>");
			}
			
					
			$showCommentsForm = true;
			$arrGlobalNote = $arrNote;
			
			 
							
						
						
					
							
										$content .='<table border="0" width="100%" cellpadding="6" class="blog_table">
											<tr>
												<td class=header>
													
													<font size=1>['.FormatDate($arrNote["date"]).']<br></font>
													
													'.stripslashes($arrNote["title"]).'
													
												</td>
											</tr>
											<tr>
												<td class="blog_table_content_td">
												
												
												
													'.stripslashes($arrNote["html"]).'
												
												</td>
											</tr>
										  </table>
											<br>';
											
											
										// start trackbacks				
											
										$strErrorSecCode = "";	
										
																			
										$showCommentsForm = true;	
										$strErrorSecCode = "";
										
										if($arrNote["accept_comments"]=="YES")
										{
										
										$content .='<table border="0" width="100%" cellpadding="6" class="blog_table">
											<tr>
												<td class=header>
													
													<a name="comments">'.$M_COMMENTS.'</a>
													
												</td>
											</tr>
											<tr>
												<td class="blog_table_content_td">';
												
												
													if(get_param("add_comment") != "")
													{
														
														if($answer2 != ($i_1+$i_2) )
														{
															$Error = $M_WRONG_ANSWER;
														}
														else
														 if($USE_SECURITY_IMAGES && ( (md5($CAPTCHA_SALT.$_POST['captcha_code'].$CAPTCHA_SALT) != $_SESSION['code'])|| trim($_POST['captcha_code']) == "" ) )
														 {
																		
																$strErrorSecCode = "<font color=red><b>".$M_WRONG_SECURITY_IMAGE_CODE."</b></font><br><br>";
																		
														 }
														 else
														 {
																SQLInsert("comments",array("ip","title","author","email","html","note_id","date","user"),array($_SERVER["REMOTE_ADDR"],strip_tags(get_param("title")),strip_tags(get_param("author")),strip_tags(get_param("email")),strip_tags(get_param("comment")),$note,time(),$user));
																
																if($arrNoteSettings["send_comments_email"] == 1)
																{
																	if(trim($arrAdminUser["email"]) != "")
																	{
																		mail($arrAdminUser["email"],"[".$BLOG_DOMAIN." COMMENT] ".get_param("title"),
																		"http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&note=".$note."\n\n".get_param("comment"),"From: \"".get_param("author")."\"<".get_param("email").">\n");
																	}
																}
																
																$showCommentsForm = false;
														 }
													}
													
													
													$tableComments = DataTable("comments","WHERE note_id=$note ORDER BY id DESC");
													
													while($arrComment = mysql_fetch_array($tableComments))
													{
														$content .='<b>'.strip_tags(stripslashes($arrComment["title"])).'</b>
														<br>
														'.strip_tags(stripslashes($arrComment["html"])).'
														<br>';			
														
														if($ALLOW_SEND_EMAIL_TO_PEOPLE_POSTED_COMMENTS)
														{															
															 $content .=''.$M_WRITTEN_BY.': <a href="javascript:PopUp('.$arrComment["id"].')">'.strip_tags($arrComment["author"]).'</a> | '.FormatDate($arrComment["date"]);
														}
														else
														{
															 $content .=''.$M_WRITTEN_BY.': '.strip_tags($arrComment["author"]).' | '.FormatDate($arrComment["date"]);
														}														
														
														$content .= '<br><br>
														';
													}
													
												
												$content .='</td>
											</tr>
										  </table>
											<br>';
											
											
											
											
											if($arrNoteSettings["allow_comments"] == 0)
											{
												$showCommentsForm = false;
											}
											
											$arrBlackListIPs = explode("\n",$arrNoteSettings["blacklist"]);
											
											foreach($arrBlackListIPs as $arrBlackListIP)
											{
												if(trim($arrBlackListIP) == trim($IP))
												{
													$showCommentsForm = false;
												}
											}
											
											if($showCommentsForm)
											{
												$content .='<table border="0" width="100%" cellpadding="6" class="blog_table">
											<tr>
												<td class=header>
													
													'.$POST_A_COMMENT.'
													
												</td>
											</tr>
											<tr>
												<td class="blog_table_content_td">
													<form method="post" action="'.CreateLink('index.php').'" >
													<input type="hidden" name="note" value="'.$note.'">
													<input type="hidden" name="add_comment" value="yes">
														
														'.$strErrorSecCode.'
													
														'.$M_NAME.':<br>
														<input   id="author" name="author" value="'.get_param('author').'" size="40">
														<br><br>
														'.$M_EMAIL.':<br>
														<input  id="email" name="email" value="'.get_param('email').'" size="40">
														<br><br>
														<b>'.$i_1.' + '.$i_2.' = ?</b><br>
																															
														<input name="answer2" id="answer2" value="" type="text" size="40"></b></font>
														<br>
														<i style="font-size:11px">'.$M_SUM_EXPL.'</i>
														
														<br><br>
														'.$M_TITLE.':<br>
														<input   id="title" name="title" value="'.get_param('title').'" size="40">
														
														<br><br>
													'.$M_COMMENTS.':<br>
													<textarea  id="comment" name="comment" rows="10" cols="40">'.get_param('comment').'</textarea>
													<br>';
																
													if($USE_SECURITY_IMAGES)
													{
														$content .= '
																<table summary="" border="0">
																	<tr>
																		<td valign="middle">
																		
																		<img src="'.($USE_ABSOLUTE_URLS?'http://www.'.$BLOG_DOMAIN.'/':'').'include/sec_image.php" >
																		'.$M_CODE.':
				
																		<input type="text" name="captcha_code" value="" size=8>	
																		
																		</td>
																	</tr>
																 </table>
														
														';
													}		
																
																	
													$content .='<br>
																		<input style="font-weight: bold;" type="submit"  name="post" value="&nbsp;'.$M_POST.'&nbsp;" >
																	
																</form>
												</td>
											</tr>
										  </table>
											<br>';
											}
											
											}
											
			
					
			}
			else
			
			
			if(isset($photo_id))
			{
					ms_i($photo_id);
					$arrAlbum =  DataArray("photo","id='".$photo_id."' AND user='$user'");
					
					
					$iPgFormat = $arrAlbum["album_format"];
					
					$bShowTitle = $arrAlbum["show_title"];
					
					$bShowDate = $arrAlbum["show_date"];
					$bShowLegend = $arrAlbum["show_legende"];
					$bShowPlace = $arrAlbum["show_place"];
					$bShowDescription = $arrAlbum["show_description"];
					
					if($bShowTitle == "YES" || $bShowTitle == "OUI" || $bShowTitle == "1") $bShowTitle = true;else $bShowTitle = false;
					if($bShowDate == "YES" || $bShowDate == "OUI" || $bShowDate == "1") $bShowDate = true;else $bShowDate = false;
					if($bShowLegend == "YES" || $bShowLegend == "OUI" || $bShowLegend == "1") $bShowLegend = true;else $bShowLegend = false;
					if($bShowPlace == "YES" || $bShowPlace == "OUI" || $bShowPlace == "1") $bShowPlace = true;else $bShowPlace = false;
					if($bShowDescription == "YES" || $bShowDescription == "OUI" || $bShowDescription == "1") $bShowDescription = true;else $bShowDescription = false;
					
					
						$content .= ""; 
					
						$content .= '<table summary="" border="0" width=100%>
										<tr>
											<td>';
								
								
											/// internal pages
											
											if(isset($photo_id)&&isset($photo))
											{
												$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."' AND id<>0");
												
												
												
												
												$thumbSize=50;
																	
													if($arrAlbum["thumbnails_size"] == 1)
													{
														$thumbSize=50;
													}
													else
													if($arrAlbum["thumbnails_size"] == 2)
													{
														$thumbSize=75;
													}
													else
													if($arrAlbum["thumbnails_size"] == 3)
													{
														$thumbSize=115;
													}
												
												/// internal format 1
												if($iPgFormat == 1)
												{
													$content .= "
														<table  border=0>
																<tr>
																	<td valign=top>
																	";
																	
																$arrCurrentPhoto = array();			
																	
																while($rowAlbum = mysql_fetch_array($tableAlbum))
																{
																
																	if($rowAlbum["id"] == $photo)
																	{
																		$arrCurrentPhoto = $rowAlbum;
																	}
																	
																	$content .= "
																													
																	<a href=".CreateLink("index.php?photo_id=$photo_id&image_id=".$rowAlbum["image_id"]."&photo=".$rowAlbum["id"])." >";
																	$content .= ShowImage($rowAlbum["image_id"],$user,"",$thumbSize,$thumbSize);
																	
																	$content .= "</a>
																		<br>	<br>										
																	";
													
																}
																
																
																
														$content .= "	</td><td width=15>&nbsp;</td>
																	<td valign=top>";
														
														if($bShowTitle)		
														{
															$content .= "<b>".stripslashes($arrCurrentPhoto["title"])."</b><br>";
														}
														ms_i($image_id);
														array_push($OUTPUT_IMAGES, $image_id);		
														$content .= ShowImage($image_id,$user);
														
														if($bShowDescription)		
														{
															$content .= "<br>".stripslashes($arrCurrentPhoto["description"])."<br>";
														}
														
														if($bShowDate)		
														{
															$content .= "<br>".$M_DATE2.": ".($arrCurrentPhoto["date"]!=""?$arrCurrentPhoto["date"]:"n/a")."<br>";
														}
														
														if($bShowPlace)		
														{
															$content .= "<br>".$M_PLACE2.": ".($arrCurrentPhoto["place"]!=""?$arrCurrentPhoto["place"]:"n/a")."<br>";
														}
														
														$content .= "	</td>
																</tr>
															 </table>
													";
												
												}
												else
												/// end internal 1
											
												/// internal format 2
												if($iPgFormat == 2)
												{
												
														$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."'");
												
														$arrPhotos = array();
														
														$arrCurrentPhoto = array();
														
																while($rowAlbum = mysql_fetch_array($tableAlbum))
																{
																	if($rowAlbum["id"] == $photo)
																	{
																		$arrCurrentPhoto = $rowAlbum;
																	}
																	array_push($arrPhotos , array($rowAlbum["image_id"], $rowAlbum["id"]) );				
																}
														
														$iIndex = 0;
														
														for($i=0;$i<sizeof($arrPhotos);$i++)	
														{
														
															if($arrPhotos[$i][1] == $photo)
															{
																$iIndex = $i;
																
																break;
															}
														}
														
														$content .= "
														<center>
														";
														
														if($iIndex > 0)
														{
															$content .= "<a href=\"".CreateLink("index.php?photo_id=$photo_id&image_id=".$arrPhotos[$iIndex-1][0]."&photo=".$arrPhotos[$iIndex-1][1])."\">&lt;&lt;".$M_PREVIOUS."</a>";
														}
														
														$content .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
														
														if($iIndex < (sizeof($arrPhotos)-1) )
														{
															$content .= "<a href=\"".CreateLink("index.php?photo_id=$photo_id&image_id=".$arrPhotos[$iIndex+1][0]."&photo=".$arrPhotos[$iIndex+1][1])."\">".$M_NEXT.">></a>";
														}
														
														$content .= "</center><br>
														";			
														
																													
														if($bShowTitle)		
														{
															$content .= "<b>".stripslashes($arrCurrentPhoto["title"])."</b><br>";
														}
														ms_i($image_id);
														array_push($OUTPUT_IMAGES, $image_id);				
														$content .= ShowImage($image_id,$user);
														
														if($bShowDescription)		
														{
															$content .= "<br>".stripslashes($arrCurrentPhoto["description"])."<br>";
														}
														
														if($bShowDate)		
														{
															$content .= "<br>".$M_DATE2.": ".($arrCurrentPhoto["date"]!=""?$arrCurrentPhoto["date"]:"n/a")."<br>";
														}
														
														if($bShowPlace)		
														{
															$content .= "<br>".$M_PLACE2.": ".($arrCurrentPhoto["place"]!=""?$arrCurrentPhoto["place"]:"n/a")."<br>";
														}							
														
												
												}
												/// end internal format 2
												else
												
												/// internal format 3
												if($iPgFormat == 3)
												{
												
														$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."'");
												
														$arrPhotos = array();
														
														$arrCurrentPhoto = array();
														
																while($rowAlbum = mysql_fetch_array($tableAlbum))
																{
																	if($rowAlbum["id"] == $photo)
																	{
																		$arrCurrentPhoto = $rowAlbum;
																	}
																	array_push($arrPhotos , array($rowAlbum["image_id"], $rowAlbum["id"]) );				
																}
														
														$iIndex = 0;
														
														for($i=0;$i<sizeof($arrPhotos);$i++)	
														{
														
															if($arrPhotos[$i][1] == $photo)
															{
																$iIndex = $i;
																
																break;
															}
														}
														
														$content .= "
														<center>
														";
														
														if($iIndex > 0)
														{
															$content .= "<a href=\"".CreateLink("index.php?photo_id=$photo_id&image_id=".$arrPhotos[$iIndex-1][0]."&photo=".$arrPhotos[$iIndex-1][1])."\">&lt;&lt;".$M_PREVIOUS."</a>";
														}
														
														$content .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
														
														if($iIndex < (sizeof($arrPhotos)-1) )
														{
															$content .= "<a href=\"".CreateLink("index.php?photo_id=$photo_id&image_id=".$arrPhotos[$iIndex+1][0]."&photo=".$arrPhotos[$iIndex+1][1])."\">".$M_NEXT.">></a>";
														}
														
														$content .= "</center><br>
														";			
														
														if($bShowTitle)		
														{
															$content .= "<b>".stripslashes($arrCurrentPhoto["title"])."</b><br>";
														}
														ms_i($image_id);	
															array_push($OUTPUT_IMAGES, $image_id);				
														$content .= "	<table><tr><td valign=top>".ShowImage($image_id,$user);
														
														$content .= "</td><td valign=top>";
														
														if($bShowDescription)		
														{
															$content .= "<br>".stripslashes($arrCurrentPhoto["description"])."<br>";
														}
														
														if($bShowDate)		
														{
															$content .= "<br>".$M_DATE2.": ".($arrCurrentPhoto["date"]!=""?$arrCurrentPhoto["date"]:"n/a")."<br>";
														}
														
														if($bShowPlace)		
														{
															$content .= "<br>".$M_PLACE2.": ".($arrCurrentPhoto["place"]!=""?$arrCurrentPhoto["place"]:"n/a")."<br>";
														}	
												
														$content .= "</td></tr></table>";
												}
												/// end internal format 3
												
											}
											else
											/// end internal pages
											
											if(isset($photo_id))
											{
												ms_i($photo_id);
								
												$content .= "<center><h3>".$arrAlbum["name"]."</h3></center><br><br>";
												$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."' AND image_id<>0");
												
												$iHomePageFormat = $arrAlbum["home_page_format"];
												
												
												$thumbSize=50;
																	
													if($arrAlbum["home_thumbnails_size"] == 1)
													{
														$thumbSize=50;
													}
													else
													if($arrAlbum["home_thumbnails_size"] == 2)
													{
														$thumbSize=75;
													}
													else
													if($arrAlbum["home_thumbnails_size"] == 3)
													{
														$thumbSize=115;
													}
												
												/// format 1
												if($iHomePageFormat == 1 || $iHomePageFormat == 4)
												{
																$iFormat = $arrAlbum["home_thumbnails_columns"];
																
																$content .= "<center><table>";
																
																$imageCounter = 0;
																
																while($rowAlbum = mysql_fetch_array($tableAlbum))
																{
														
																	if($imageCounter==0||$imageCounter%$iFormat==0)
																	{
																		$content .= "<tr>";
																	}
																	
																	$content .= "
																	
																	<td valign=top align=center>";
																	
																	if($iPgFormat == 4)
																	{
																		$content .= "<a href=\"".ImageURL($rowAlbum["image_id"],"","",$user)."\" target=_blank>";
																	}
																	else
																	{
																		$content .= "<a href=".CreateLink("index.php?photo_id=$photo_id&image_id=".$rowAlbum["image_id"]."&photo=".$rowAlbum["id"])." >";
																	}
																	
																	$content .= ShowImage($rowAlbum["image_id"],$user,"",$thumbSize,$thumbSize);
																	
																	$content .= "</a>
																	<br>
																	".stripslashes($rowAlbum["description"])."
																	</td>
																	
																	";
													
																				
																	if($imageCounter!=0&&($imageCounter+1)%$iFormat==0)
																	{
																		$content .= "</tr>";
																	}
																			
																	$imageCounter++; 
																}
																
																$content .= "</table></center>";
												}
												/// end format1
												
												
												
												/// format 2
												if($iHomePageFormat == 2 )
												{
																
																
																$content .= "<center><table>";
																
																$imageCounter = 0;
																
																while($rowAlbum = mysql_fetch_array($tableAlbum))
																{
																												
																	$content .= "<tr>";
																												
																	$content .= "
																	
																	<td valign=top>";
																	
																	
																	if($iPgFormat == 4)
																	{
																		$content .= "<a href=\"".ImageURL($rowAlbum["image_id"],"","",$user)."\" target=_blank>";
																	}
																	else
																	{
																		$content .= "<a href=".CreateLink("index.php?photo_id=$photo_id&image_id=".$rowAlbum["image_id"]."&photo=".$rowAlbum["id"])." >";
																	}
																	
																	
																	$content .= ShowImage($rowAlbum["image_id"],$user,"",$thumbSize,$thumbSize);
																	
																	$content .="</a>
													
																	".stripslashes($rowAlbum["description"])."
																	</td>
																	
																	";
													
																	$content .= "</tr>";
													
																					
																	$imageCounter++; 
																}
																
																$content .= "</table></center>";
												}
												/// end format2
												
												
												
												
												
												/// format 3
												if($iHomePageFormat == 3 )
												{
																
																
																$content .= "<center><table width=500>";
																
																$imageCounter = 0;
																
																while($rowAlbum = mysql_fetch_array($tableAlbum))
																{
																												
																	$content .= "<tr>";
																												
																	$content .= "
																	
																	<td valign=top align=center>
																	<a href=".CreateLink("index.php?photo_id=$photo_id&image_id=".$rowAlbum["image_id"]."&photo=".$rowAlbum["id"])." >
																	
																	";
																	
																	
																	
																	$content .= ShowImage($rowAlbum["image_id"],$user,"",$thumbSize,$thumbSize);
																	
																	$content .="</a>
													
																
																	</td>
																	
																	";
													
																	$content .= "</tr>";
													
																					
																	$imageCounter++; 
																	break;
																}
																
																$content .= "</table>
																
																<br><br>
																".stripslashes($arrAlbum["description"])."
																<br><br>
																
																</center>";
												}
												/// end format3
												
											}
											
											
											
											$content .= '</td>
										</tr>
									</table>';
			
			}
			else
			if(get_param("file") != "")
			{
				ms_i($file);
				$arrDocument = DataArray("blog_documents","id=".$file." AND  user='$user'");
				$arrFile = DataArray("blog_files","file_id=".$arrDocument["file_id"]." AND  user='$user'");
						
				$content .='<table border="0" width="100%" cellpadding="6" class="blog_table">
						<tr>
							<td class=header>
								<a href="'.CreateLink('show_file.php?id='.$arrDocument["file_id"]).'">'.stripslashes($arrDocument["title"]).'</a>
								
							</td>
						</tr>
						<tr>
							<td class="blog_table_content_td">
					
								 <a href="'.CreateLink('show_file.php?id='.$arrDocument["file_id"]).'">'.stripslashes($arrFile["file_name"]).'</a> ['.round($arrFile["file_size"]/1024).'KB]
						<br><br><br>
					  '.stripslashes($arrDocument["description"]).'
					  <br>
							
							</td>
						</tr>
					  </table>
						<br>';

									
								
																   
											
			}
			
			else
			{
				//HOME PAGE START
				$current_page = $default_page_id;
				if(isset($page_id))
				{
					ms_i($page_id);
					$current_page = $page_id;
				}
				
				$arrPage = DataArray("user_pages","user='".$user."' AND id=".$current_page."");
				
				$content .= "<br>".$arrPage["html_en"];
			
			//HOME PAGE END
		}
			
			
	/// blog author
	array_push($OUTPUT_IMAGES, $arrWeblog["author_image"]);		

	$author = "";
	  
	if($arrWeblog["author_image"] != "0" && $arrWeblog["author_image"] > 1)
	{
			 $author .= "<a href=\"".ImageURL($arrWeblog["author_image"],"","",$user)."\" target=_blank>".ShowImage($arrWeblog["author_image"],$user,"",$arrWeblog["author_image_width"], $arrWeblog["author_image_height"])."</a>";
	}
	else
	{
		$author .= "<img src=\"images/no_pic.gif\" border=\"0\">";
	}
	$author .= "<p>". stripslashes($arrWeblog["author"])."</p>";
	/// end author   
	   
	
	

	/// recent_notes

		if(isset($notes_flag_1))
		{
			if(mysql_num_rows($tableNotes)>0)
			mysql_data_seek($tableNotes,0);
		}
		else
		{
			$tableNotes=DataTable("notes","WHERE user='".$user."' AND active='YES' ORDER BY id ".($arrNoteSettings["notes_order"]==0?"asc":"desc"));
		}
		
		$iFirstNote = -1;
		$arrNoteDays = array();
		array_push($arrNoteDays,-1);
		
		$recent_notes = "";		
		$iNotesCounter = 0;
		
		while($arrNote = mysql_fetch_array($tableNotes))
		{
			if($iNotesCounter >= $arrNoteSettings["notes_visible"])
			{
				break;
			}
			
			array_push($arrNoteDays,date("j",$arrNote["date"]));
				
			if($iFirstNote == -1)
			{
				$iFirstNote = $arrNote["id"];
			}
			
			if($USE_ABSOLUTE_URLS)
			{
				if($BLOG_URL_FORMAT == 1)
				{
					$str_link = "http://".$user.".".$BLOG_DOMAIN."/n".$arrNote["id"]."-".format_str($arrNote["title"]).".html";
				}
				else
				{
					$str_link = "http://www.".$BLOG_DOMAIN."/".$user."/n".$arrNote["id"]."-".format_str($arrNote["title"]).".html";
				}
			}
			else
			{
			
				$str_link = "site.php?user=".$user."&news=".$arrNote["id"];
			}
			
			$recent_notes 
				.= "<li><a href=".$str_link.">".stripslashes($arrNote["title"])."</a></li><br>";
			
						
			$iNotesCounter++;
		}
		
		
		if(!isset($note)&&!isset($photo)&&!isset($image))
		{
			$note = $iFirstNote;
		}
	/// recent_notes


	/// albums

		$albums = "";
		
		$tablePhotos=DataTable("photo","WHERE user='$user' ORDER BY id DESC");

		while($arrPhoto = mysql_fetch_array($tablePhotos))
		{
		
			$albums .= "
				<a href=\"".CreateLink_Note("photo_id/".$arrPhoto["id"],$arrPhoto["name"])."\">
				".$arrPhoto["name"]."
				</a><br>
			";
		}
		
		//my files
		if(SQLCount_Query("SELECT * FROM ".$DBprefix."blog_documents,".$DBprefix."blog_files WHERE ".$DBprefix."blog_documents.file_id=".$DBprefix."blog_files.file_id AND ".$DBprefix."blog_documents.user='".$user."' AND ".$DBprefix."blog_documents.file_id>1") > 0)
		{
						$albums .= "<br><br><span class=header_title>".$MY_FILES2."</span>";
						$tableDocuments = DataTable_Query("SELECT * FROM ".$DBprefix."blog_documents,".$DBprefix."blog_files WHERE ".$DBprefix."blog_documents.file_id=".$DBprefix."blog_files.file_id AND ".$DBprefix."blog_documents.user='".$user."' AND ".$DBprefix."blog_documents.file_id>1");
						$hasFiles = false;
						while($arrDocument = mysql_fetch_array($tableDocuments))
						{
							$albums .= "<br>
								<a href=\"".CreateLink2("file/".$arrDocument["id"])."\">
								".stripslashes($arrDocument["title"])."
								</a>
							";
							$hasFiles = true;
						}
						if(!$hasFiles)
						{
							$albums .= "<br>";
						}
		}
		// end my files
		
				
		$albums .= "<br>";
		
		
	/// albums



	$recent_photos = "";						
	/// recent photos
		$tableImages=DataTable("image","WHERE user='$user' ORDER BY image_id DESC");
		$imageCounter = 0;
		$recent_photos .= "<table width=120>";
		while($arrImage = mysql_fetch_array($tableImages))
		{
		
			if($imageCounter==0||$imageCounter%2==0)
					{
						$recent_photos .= "<tr>";
					}
			
			$recent_photos .= "
			<td>
			<a href=\"".ImageURL($arrImage["image_id"],"","",$user)."\" target=_blank>
			".ShowImage($arrImage["image_id"],$user,$arrImage["image_type"],"50","50")."
			</a></td>";
			
																		
					if($imageCounter!=0&&($imageCounter+1)%2==0)
					{
						$recent_photos .= "</tr>";
					}
			$imageCounter++;
		}
		$recent_photos .= "</table>";
	/// end recent photos		



	/// start contact link
	$contact_link = "";
	
	if($arrContactSettings["show_contact_link"] == 1)
	{
		$contact_link .= "<a href=\"".CreateLink2("contact")."\"><b>".$CONTACT_THE_AUTHOR."</b></a><br>";
	
	}
	if($arrAdminUser["card_exp_year"]=="1")
	{
		$contact_link .= "<br style='line-height:8px'><a href=\"http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&imprint=1\"><b>".$M_IMPRINT."</b></a>";
	}
	if($arrAdminUser["profile_blog"]=="1")
	{
		$contact_link .= "<br><br style='line-height:8px'><a href=\"http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&profile=1\"><b>".$M_PROFILE."</b></a>";
	}
	/// end contact link
	?>


	<?php
	
	
	if(strpos($STR_TEMPLATE, "<wsa share_icons/>") !== false)
	{
		$str_current_url=current_url();
		
		$share_icons_html = '
		<span style="position:relative;left:6px;top:-2px"><g:plusone></g:plusone></span>
		
		<a href="http://www.facebook.com/sharer.php?u='.$str_current_url.'" target="_blank"><img border="0" src="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'images/facebook_icon.gif"/></a>
		<a href="http://www.twitter.com/intent/tweet?text='.urlencode(strip_tags(stripslashes(current_page_name()))).'&url='.$str_current_url.'" target="_blank"><img border="0" src="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'images/twitter_icon.gif" style="margin-left:7px"/></a>
		<a href="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").$user.'.rss"><img border="0" src="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'images/rss_icon.gif" style="margin-left:7px"/></a>
		<a href="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").$user.'.atom"><img border="0" src="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'images/atom_icon.gif" style="margin-left:7px"/></a>

		';
	
		$STR_TEMPLATE = str_replace("<wsa share_icons/>",$share_icons_html,$STR_TEMPLATE);
			
	}	
	
	if(isset($logo))
	{
		$STR_TEMPLATE = str_replace("Company Name","<wsa logo/>",$STR_TEMPLATE);
		
		$STR_TEMPLATE = str_replace("<wsa logo/>", $logo ,$STR_TEMPLATE);
	}


	$STR_TEMPLATE = str_replace("<wsa author_description/>", $arrWeblog["author"] ,$STR_TEMPLATE);
	
	$STR_TEMPLATE = str_replace("<wsa contact_link/>", $contact_link ,$STR_TEMPLATE);
	
	
	$menu_position = strpos($STR_TEMPLATE, "<wsa menu/>");
	if($menu_position !== false) 
	{
		$STR_TEMPLATE = str_replace("<wsa menu/>", $menu_html_code  ,$STR_TEMPLATE);
	}
	else
	{
		$STR_TEMPLATE = str_replace("<wsa categories/>", $menu_html_code ,$STR_TEMPLATE);
	}
	
	$STR_TEMPLATE = str_replace("<wsa bottom_menu/>", $bottom_menu_html  ,$STR_TEMPLATE);
	
	
	if(isset($albums))
	{
		if(strpos($STR_TEMPLATE, "<wsa albums/>") !== false)
		{
			$STR_TEMPLATE = str_replace("<wsa albums/>", $albums ,$STR_TEMPLATE);
		}
		else
		{
			
			if(strpos($STR_TEMPLATE, "{PHOTO_ALBUMS}") !== false)
			{
				$contact_link = $albums."<br><br>".$contact_link;
			}
			else
			{
				$contact_link = "<br><h".(strpos($STR_TEMPLATE ,"h2")!==false?"2":"3").">".$M_PHOTOS_FILES."</h".(strpos($STR_TEMPLATE ,"h2")!==false?"2":"3").">".$albums."<br><br>".$contact_link;
			}
		}
	}
	
	$STR_TEMPLATE = str_replace("<wsa news/>", "<wsa recent_notes/>" ,$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("<wsa recent_notes/>", $recent_notes.$contact_link ,$STR_TEMPLATE);
	
	
	
	$STR_TEMPLATE = str_replace("<wsa content/>", "<div id=\"main_content\">".$content."</div>" ,$STR_TEMPLATE);
	
	
	$STR_TEMPLATE = str_replace("<wsa recent_photos/>", $recent_photos ,$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("{HEADER_BGCOLOR}",  $arrWeblog["header_background_color"] ,$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("{MAIN_AREA_BGCOLOR}",  $arrWeblog["main_area_background_color"] ,$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("{BLOG_DOMAIN}",  $BLOG_DOMAIN ,$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("{ABOUT_AUTHOR}",  $ABOUT_AUTHOR ,$STR_TEMPLATE);
	
	$STR_TEMPLATE = str_replace("{CATEGORIES}", $M_MENU  ,$STR_TEMPLATE);
	
	
	$STR_TEMPLATE = str_replace("{LATEST_NOTES}", $LATEST_NOTES  ,$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("{PHOTO_ALBUMS}", $PHOTO_ALBUMS  ,$STR_TEMPLATE);
	$STR_TEMPLATE = str_replace("{LATEST_PHOTOS}", $LATEST_PHOTOS  ,$STR_TEMPLATE);


	$STR_TEMPLATE = str_replace("calendar.js","",$STR_TEMPLATE);
	

	if(strtoupper($arrAdminUser["blog_lang"])=="SA")
	{
		$STR_OUTPUT= '<html dir="rtl">';
	}
	else
	{
		$STR_OUTPUT= '<html>';
	}


	$STR_OUTPUT .='<head>';

	include("include/encodings.php");
	echo '<meta http-equiv="Content-Type" content="text/html;'.(isset($arrEncodings[strtoupper($arrAdminUser["blog_lang"])])?$arrEncodings[strtoupper($arrAdminUser["blog_lang"])]:"charset=iso-8859-1").'">';	

	if(isset($arrPage) && trim($arrPage["name_en"]) != "")
	{
		$STR_OUTPUT.= ' <title>'.stripslashes(strip_tags($arrPage["name_en"])).'</title>';
	}
	else
	if(isset($arrGlobalNote["title"]))
	{
		$STR_OUTPUT.= ' <title>'.stripslashes(strip_tags($arrGlobalNote["title"])).'</title>';
	}
	else
	{
		$STR_OUTPUT.= ' <title>'.stripslashes(strip_tags($arrWeblog["meta_title"])).'</title>';
	}
	 
	if(isset($arrPage) && trim($arrPage["description_en"]) != "")
	{
		$STR_OUTPUT.= '<meta name="description" content="'.stripslashes(strip_tags($arrPage["description_en"])).'">';
	}	
	else
	{
		$STR_OUTPUT.= '<meta name="description" content="'.stripslashes(strip_tags($arrWeblog["meta_description"])).'">';
	}
	
	if(isset($arrPage) && trim($arrPage["keywords_en"]) != "")
	{
		$STR_OUTPUT.= '<meta name="keywords" content="'.stripslashes(strip_tags($arrPage["keywords_en"])).'">';
	}	
	else
	{
		$STR_OUTPUT.= '<meta name="keywords" content="'.stripslashes(strip_tags($arrWeblog["meta_keywords"])).'">';
	}
	  
	  $STR_OUTPUT .='
	  <script>
		function PopUp(x)
		{
			window.open("'.($USE_ABSOLUTE_URLS==1?"http://www.".$BLOG_DOMAIN."/":"").'include/send_email.php?comment="+x,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=500,height=380,left=0,top=0");
		}
	  </script>
	  ';
	  
	
	$STR_OUTPUT .= '<style>
	#main_content{width:100%;  min-height:350px;height:auto !important;height:350px; text-align:left;font-family:'.$arrWeblog["font_family"].';color:'.$arrWeblog["font_color"].';font-size:'.$arrWeblog["font_size"].'px}
	td,div,span{font-family:'.$arrWeblog["font_family"].';color:'.$arrWeblog["font_color"].';font-size:'.$arrWeblog["font_size"].'px}
	a{color:'.$arrWeblog["links_color"].'}.hdiv{display:none}

	</style>';
	

	$STR_OUTPUT .= '
	<script>
	function ShowHide(x)
	{
		if(document.getElementById(x).style.display=="none")
		{
			document.getElementById(x).style.display="block";
		}
		else
		{
			document.getElementById(x).style.display="none";
		}
	}

	function Flag()
	{
		if(confirm("Notify the '.$BLOG_DOMAIN.' administrators about objectionable content"))
		{
			document.getElementById("flag_url").value=document.location.href;
			document.getElementById("flag_form").submit();
		}
		
	}
	</script>

	</head>';

	
	if(trim($arrNoteSettings["background"]) != "")
	{
		
		$STR_OUTPUT .= "<body leftmargin=\"0\" topmargin=\"0\" bottommargin=\"0\" rightmargin=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"background-image:url('".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."images/backgrounds/".$arrNoteSettings["background"]."') !important\" background=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."images/backgrounds/".$arrNoteSettings["background"]."\">";
	}
	else
	{
		$STR_OUTPUT .= '<body leftmargin="0" topmargin="0" bottommargin="0" rightmargin="0" marginheight="0" marginwidth="0" bgcolor="'.$arrWeblog["background_color"].'">';
	}


	//false &&
	if( $SHOW_TOP_BAR_ON_THE_BLOGS)
	{
		include("include/top_bar.php");
	}


	$strAdv1 = "";
	$strAdv2 = "";
	$strAdv3 = "";
	$strAdv4 = "";

	if(file_exists('include/1.htm'))
	{
		 $strAdv1 = addslashes(implode('', file('include/1.htm')));
		 
	}
	else
	{
		$strAdv1 = aParameter(1501);
	}

	if(file_exists('include/2.htm'))
	{
		 $strAdv2 = addslashes(implode('', file('include/2.htm')));
	}
	else
	{
		$strAdv2 = aParameter(1502);
	}

	if(file_exists('include/3.htm'))
	{
		 $strAdv3 = addslashes(implode('', file('include/3.htm')));
	}
	else
	{
		$strAdv3 = aParameter(1503);
	}

	if(file_exists('include/4.htm'))
	{
		 $strAdv4 = addslashes(implode('', file('include/4.htm')));
	}
	else
	{
		$strAdv4 = aParameter(1504);
	}


	if($arrPackage["adv"] == 1)
	{

	}
	else
	{
		$strAdv1="";$strAdv2="";$strAdv3="";$strAdv4="";
	}

	if($arrWeblog["zone1"]!=""&&$strAdv1=="") $strAdv1=$arrWeblog["zone1"];
	if($arrWeblog["zone2"]!=""&&$strAdv2=="") $strAdv2=$arrWeblog["zone2"];
	if($arrWeblog["zone3"]!=""&&$strAdv3=="") $strAdv3=$arrWeblog["zone3"];
	if($arrWeblog["zone4"]!=""&&$strAdv4=="") $strAdv4=$arrWeblog["zone4"];


	if($strAdv1!=""||$strAdv2!=""||$strAdv3!=""||$strAdv4!="")
	{

					$STR_OUTPUT .= '
					<center>
					'.$strAdv1.'
					</center>
					<table cellpadding="0" cellspacing="0"  summary="" border="0" width=100% height=100%>
						<tr>
							<td valign="top">'.$strAdv4.'</td>
							<td align=center valign=top>
								<br>
								
									'.$STR_TEMPLATE.'
									
							
							</td>
							<td valign="top">'.$strAdv2.'</td>
						</tr>
					</table>
					<center>
					'.$strAdv3.'
					</center>
					</body>
					</html>
					';
	}
	else
	{
					$STR_OUTPUT .= '
					<table cellpadding="0" cellspacing="0" summary="" border="0" width="100%" height="100%">
						<tr>
							<td align="center" valign="top">
								<br>
								
									'.$STR_TEMPLATE.'
							
							</td>
						</tr>
					</table>';
	}

	if($METER_USER_BAND)
	{
		$OUTPUT_SIZE += strlen($STR_OUTPUT);

		if(sizeof($OUTPUT_IMAGES) > 1)
		{
			$strImgList="";
			$bFirstImg = true;
			foreach($OUTPUT_IMAGES as $O_IMAGE)
			{
				if(!$bFirstImg)
				{
					$strImgList .= ",";
				}
				$strImgList .= $O_IMAGE;
				$bFirstImg = false;
			}
			$OUTPUT_SIZE += SQLSum(
						"image WHERE image_id IN ($strImgList)",
						"image_size"
					);
		}
	}

	if($METER_USER_BAND)
	{
		SQLInsert
		(
			"blog_band",
			array("date","user","size","ip"),
			array(time(),$user,$OUTPUT_SIZE,$IP)
		);
	}

	if($KEEP_USER_STATISTICS)
	{
		SQLInsert
		(
			"user_statistics",
			array("user","date","host","referer","page"),
			array($user,date("F j, Y, g:i a"),$_SERVER["REMOTE_HOST"],(isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:""),(isset($page)?$page:"home"))
		);
	}

	$STR_OUTPUT = stripslashes($STR_OUTPUT);

	
	if($USE_ABSOLUTE_URLS)
	{
		$STR_OUTPUT = str_replace("show_file.php","http://www.".$BLOG_DOMAIN."/show_file.php", $STR_OUTPUT);
		$STR_OUTPUT = str_replace("../image.php","http://www.".$BLOG_DOMAIN."/image.php", $STR_OUTPUT);
		$STR_OUTPUT = str_replace("../blog_images/","http://www.".$BLOG_DOMAIN."/blog_images/", $STR_OUTPUT);

		$STR_OUTPUT = str_replace("USERSADMIN/images/","images/", $STR_OUTPUT);
		$STR_OUTPUT = str_replace("=images/","=http://www.".$BLOG_DOMAIN."/images/", $STR_OUTPUT);
		$STR_OUTPUT = str_replace("=\"images/","=\"http://www.".$BLOG_DOMAIN."/images/", $STR_OUTPUT);
		$STR_OUTPUT = str_replace("url(images/","url(http://www.".$BLOG_DOMAIN."/images/", $STR_OUTPUT);
		$STR_OUTPUT = str_replace("url('images/","url('http://www.".$BLOG_DOMAIN."/images/", $STR_OUTPUT);
		$STR_OUTPUT = str_replace("url(\"images/","url(\"http://www.".$BLOG_DOMAIN."/images/", $STR_OUTPUT);
	}
	else
	{
		$STR_OUTPUT = str_replace("../image.php","image.php", $STR_OUTPUT);
		$STR_OUTPUT = str_replace("../blog_images/","blog_images/", $STR_OUTPUT);
	}

	if(isset($USE_REPLACE_WORDS)&&$USE_REPLACE_WORDS)
	{
		$arrReplaceWords = array();
		$arrReplaceWordLines = explode("\n", implode('', file('include/replace_words.php')));
		
		foreach($arrReplaceWordLines as $arrReplaceWordLine)
		{
			if(trim($arrReplaceWordLine) == "")
			{
				continue;		
			}
			$arrReplaceItems = explode("|",$arrReplaceWordLine);
			if(sizeof($arrReplaceItems) == 2)
			{
				$arrReplaceWords[$arrReplaceItems[0]] = $arrReplaceItems[1];
			}
			
		}
			
		$STR_OUTPUT = strtr($STR_OUTPUT, $arrReplaceWords);
		
	}

	echo $STR_OUTPUT;

}
?>