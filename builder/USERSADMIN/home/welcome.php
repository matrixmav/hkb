<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">
WYSIWYG.attach('html', small);
</script>			
<script>
function AddNoteValidate(x)
{


	if(x.title.value == "")
	{
		alert("<?php echo $NOTE_TITLE_EMPTY;?>");
		
		x.title.focus();
		
		return false;
	}
	
	return true;
}
</script>

<br><br>
<div id="div_dashboard" >

	<div class="dashboard-left-column">
	
	
	<span class="big_font" ><?php echo $M_RIGHT_NOW;?></span>
	
	<?php
	MySQL_OC();
	?>
	<br>
	<img src="../images/gray_pixel.gif" width="90%" height="1">
	<br>
	<br>
		
	<a href="index.php?category=site&action=my_site"><?php echo SQLCount_OC("user_pages","WHERE user='".$AuthUserName."'");?></a> <?php echo $M_PAGES;?>
	<br><br>
	<a href="index.php?category=notes&action=list"><?php echo SQLCount_OC("notes","WHERE user='".$AuthUserName."'");?></a> <?php echo $M_NEWS;?>
	<br><br>
	<a href="index.php?category=info&action=contact"><?php echo SQLCount_OC("contact","WHERE user='".$AuthUserName."'");?></a> <?php echo $CONTACT_MESSAGES;?>
	
	<br><br>
	<b><?php echo $lArray["visits"];?></b> <?php echo $M_BLOG_VISITS;?>
	<br><br>
	
	<?php
	$arrWeblog = DataArray_OC("weblog","user='".$AuthUserName."'");
	
	?>
	<br>
	<span class="big_font"><?php echo $M_CURRENT_THEME;?></span>
	<br>
	<img src="../images/gray_pixel.gif" width="90%" height="1">
	<br><br>
	
	<div class="lfloat">
	<?php
	
	if(file_exists("../user_templates/preview/".$arrWeblog["format"].".jpg"))
	{
		echo "<img width=108 src=\"../user_templates/preview/".$arrWeblog["format"].".jpg\"  alt=\"\" border=\"0\">";
	}
	else
	if(file_exists("../user_templates/preview/".$arrWeblog["format"].".png"))
	{
		echo "<img width=108 src=\"../user_templates/preview/".$arrWeblog["format"].".png\"  alt=\"\" border=\"0\">";
	}
	else
	if(file_exists("../user_templates/preview/".$arrWeblog["format"].".gif"))
	{
		echo "<img width=108 src=\"../user_templates/preview/".$arrWeblog["format"].".gif\"  alt=\"\" border=\"0\">";
	}
	?>
	</div>
	<div class="left-margin-10 lfloat">
	<a href="index.php?category=site&folder=format&page=template"><?php echo $M_CHANGE_THEME;?></a>
	<br><br>
	<a href="index.php?category=site&action=format"><?php echo $M_MODIFY_DESIGN;?></a>
	<br><br>
	<a href="index.php?category=site&action=logo"><?php echo $M_LOGO;?></a>
	
	</div>
	<div class="clear"> </div>
	
	<br><br>

	<span class="big_font"><?php echo $M_RECENT_COMMENTS;?></span>
	<br>
	<img src="../images/gray_pixel.gif" width="90%" height="1">
	<br><br>
	
	<?php
	
	$recent_comments = DataTable_Query_OC("SELECT id,title,html FROM ".$DBprefix."comments WHERE user='".$AuthUserName."' ORDER BY id DESC LIMIT 0,2");
	
	if(mysql_num_rows($recent_comments)==0)
	{
		echo "<i>".$M_STILL_NO_COMMENTS."</i>";
	}
	else
	{
		while($recent_comment = mysql_fetch_array($recent_comments))
		{
			echo "<a href=\"index.php?category=notes&action=show_comment&id=".$recent_comment["id"]."\">".stripslashes(strip_tags($recent_comment["title"]))."</a><br>". stripslashes(strip_tags($recent_comment["html"]));
			echo "<br><br style=\"line-height:4px\">";
		}
	
	}
	mysql_free_result($recent_comments);
	

	MySQL_CC();
	?>
	
	
	</div>


	<div class="dashboard-left-column">

	<span class="big_font"><?php echo $M_MY_SITE2;?></span>
	<br>
	<img src="../images/gray_pixel.gif" width="90%" height="1">
	<br><br>
	<img class="lfloat" src="images/my_site_icon.gif" width="79" height="100">
	<div class="lfloat left-margin-40">
		<img src="images/link_arrow.gif" width="16" height="16" class="link-arrow-icon"><a href="index.php?category=site&action=my_site"><?php echo $M_MANAGE_STRUCTURE_CONTENT;?></a>
		<br><br>
		<img src="images/link_arrow.gif" width="16" height="16" class="link-arrow-icon"><a href="index.php?category=site&action=format"><?php echo $M_MODIFY_DESIGN;?>
	</div>
	
	
	
	<div class="clear"></div>
	<br><br><br>
	
	</a><span class="big_font"><?php echo $M_QUICK_POST;?></span>
	<br>
	<img src="../images/gray_pixel.gif" width="90%" height="1">
	<br><br>
	<?php
	
	if(isset($SpecialProcessAddForm))
	{
		SQLUpdate_SingleValue
		(
		"admin_users",
		"username",
		"'$AuthUserName'",
		"last_update",
		time()
		);
		$html = str_replace("ibed","embed",$html);
		
		echo "<i><a href=\"index.php?category=notes&action=list\">".$M_POST_SUCCESS."</a></i><br>";
		
	}
	
	
	
	$SelectWidth = 350;
	$arrNames2=array("date","user");
	$arrValues2=array(time(),$AuthUserName);
	
	$jsValidation = "AddNoteValidate";
	
	AddNewForm_BA
		(
			array($M_TITLE.":",$M_CONTENT.":"),
			
			array("title","html"),
	
			array
			(
				
				"textbox_57",
				"textarea_40_8"
			),
	
			" $M_SUBMIT ",
			"notes",
			""
		);
	?>
	
	<div class="switch-full-link"><a href="index.php?category=notes&action=add"><i><?php echo $M_SWITCH_FULL;?></i></a></div>
	
		
	<div class="clear"></div>
	
	</div>

</div>