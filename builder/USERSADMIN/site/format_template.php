<table summary="" border="0" width=100%>
	<tr>
		<td>

<?php


	



if(get_param("format") != "")
{



	if(SQLCount("user_templates","WHERE user='".$AuthUserName."'")==0)
	{
			SQLInsert("user_templates",array("user"),array($AuthUserName));
	}
	
		$template_html_code = "";
		
		if(file_exists('../user_templates/'.$format.'.php'))
		{	
			$template_html_code = implode('', file('../user_templates/'.$format.'.php'));
		}
		if(file_exists('../user_templates/'.$format.'.htm'))
		{	
			$template_html_code = implode('', file('../user_templates/'.$format.'.htm'));
		}
		
		if(file_exists('../user_templates/'.$format.'.html'))
		{	
			$template_html_code = implode('', file('../user_templates/'.$format.'.html'));
		}
		
		
		if($template_html_code != "")
		{
			SQLUpdate_SingleValue
			(
				"weblog",
				"user",
				"'$AuthUserName'",
				"format",
				get_param("format")
			);
				
			SQLUpdate_SingleValue(
					"user_templates",
					"user",
					"'$AuthUserName'",
					"html",
					$template_html_code
				);
				
				$menu_item_html="";
				$menu_item_html = get_string_between($template_html_code, "<!--menu-item", "menu-item-->");

				if(trim($menu_item_html)!="")
				{
					SQLUpdate_SingleValue
					(
						"user_templates",
						"user",
						"'$AuthUserName'",
						"menu",
						$menu_item_html
					);
				}
			
		}
		else
		{
			die("<script>document.location.href='index.php?category=".$category."&folder=".$folder."&page=".$page."';</script>");
		}
			
				
			$format = get_param("format");
}
else
{
	$format=getSingleValue
	(
		"weblog",
		"user",
		"'$AuthUserName'",
		"format"
	);

}



			

?>




<form action="index.php" method="post">
<input type="hidden" name="ProceedUpdate">
<input type="hidden" name="page" value="<?php echo $page;?>">
<input type="hidden" name="folder" value="<?php echo $folder;?>">
<input type="hidden" name="category" value="<?php echo $category;?>">



<div id="format2" >

<table summary="" border="0" width=100%>
	<tr>
		<td align=right>
		
		<input type=submit value="    <?php echo $SAUVEGARDER;?>     " class=adminButton>
		</td>
	</tr>
</table>
<table summary="" border="0" width=100%>
	<tr>
		<td colspan=3>
		
		<i><?php echo $SELECT_TEMPLATE;?>:</i>
		<br><br>
		</td>
	</tr>
	
	<?php   
                 $BLOGGER_TEMPLATES .= '';
                 $arrBloggerTemplates = explode(",",$BLOGGER_TEMPLATES);
		$iTemplateCounter = 1;
		foreach($arrBloggerTemplates as $arrBloggerTemplate)
		{
			if($iTemplateCounter%3 == 1)
			{
				echo "<tr>";
			}
			
				echo "	
				<td width=\"33%\" align=\"center\">
					
						<input type=radio name=format value=\"".$arrBloggerTemplate."\" ".($format==$arrBloggerTemplate?"checked":"").">
						template #".$arrBloggerTemplate."
						<br>
						<a href=\"index.php?category=".$category."&page=".$page."&folder=".$folder."&format=".$arrBloggerTemplate."&ProceedUpdate=1\">
				";
				
				if(file_exists("../user_templates/preview/".$arrBloggerTemplate.".jpg"))
				{
					echo "<img src=\"../user_templates/preview/".$arrBloggerTemplate.".jpg\"  alt=\"\" border=\"0\">";
				}
				else
				if(file_exists("../user_templates/preview/".$arrBloggerTemplate.".png"))
				{
					echo "<img src=\"../user_templates/preview/".$arrBloggerTemplate.".png\"  alt=\"\" border=\"0\">";
				}
				else
				if(file_exists("../user_templates/preview/".$arrBloggerTemplate.".gif"))
				{
					echo "<img src=\"../user_templates/preview/".$arrBloggerTemplate.".gif\"  alt=\"\" border=\"0\">";
				}
				
				echo "
					</a>
				</td>";
		
			if($iTemplateCounter%3 == 0)
			{
				echo "</tr>";
			}
			
			$iTemplateCounter++;
		}
	
	?>
	
	
	
</table>
<br>
</div>
<br><br>

<table summary="" border="0" width=100%>
	<tr>
		<td align="right">
		
		<input type="submit" value="    <?php echo $SAUVEGARDER;?>     " class="adminButton">
		</td>
	</tr>
</table>




</form>


</td></tr></table>


	<br><br>
	
	<?php
	generateBackLink("format");
	?>
	
	
