<br><br><br>

<div class="container">

<?php

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
	
}

if(get_param("cat") != "")
{
	ms_i(str_replace(".","",get_param("cat")));
	
	
?>
	<table summary="" border="0" width="98%" cellpadding="0">
	<tr>
		<td style="text-align:justify;">

		<?php
		if(file_exists('include/categories_'.strtolower($lang).'.php'))
			$categories_content = file_get_contents('include/categories_'.strtolower($lang).'.php');
		else
			$categories_content = file_get_contents('include/categories_en.php');
	
		function GetCatName($strText , $id)
		{
			$arrLines = explode("\n",$strText);
			foreach($arrLines as $strLine)
			{
				$arrLineItems = explode(". ",$strLine, 2);
				if($arrLineItems[0] == $id)
				{return $arrLineItems[1];}
			}
		}
		function GetSubCats($strText , $id)
		{
			$result=array();
			$arrLines = explode("\n",$strText);
			foreach($arrLines as $strLine)
			{
				if(substr_count($strLine, '.')<2) continue;
				
				$l_items = explode(". ",$strLine);
				$arrLineItems = explode(".",$l_items[0]);
				if($arrLineItems[0] == $id)
				{
					$result[$l_items[0]] = $l_items[1];
				
				}
			}
			return $result;
		}
			
		if(isset($parent_cat))
		{
			
			ms_i(str_replace(".","",$parent_cat));
			$parent_cat_name = GetCatName($categories_content , $parent_cat);
			$current_cat_name = GetCatName($categories_content,$cat);			
			echo "".$M_SELECTED_CATEGORY.": <b><a href=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/cat/".$parent_cat."/".getSePage($parent_cat_name." ".$current_cat_name):"index.php?mod=websites&cat=".$parent_cat)."\">".$parent_cat_name."</a> > ".$current_cat_name."</b>";	
		}
		else
		{
			$current_cat_name = GetCatName($categories_content,$cat);			
			
			echo "".$M_SELECTED_CATEGORY.": <b>".$current_cat_name."</b>";
		}
		
		$currentPage->pageHTML=str_replace("<wsa title/>",trim($current_cat_name)." - ".$BLOG_DOMAIN,$currentPage->pageHTML);
		
		
		$iSubCounter = 1;
		
		$arrBlogSubCategories = GetSubCats($categories_content , $cat);
				
		if(sizeof($arrBlogSubCategories) > 0)
		{
			echo "<br><br>";
			
			echo "<table width=\"100%\"><tr>";
			
			foreach($arrBlogSubCategories as $key=>$value)
			{
					
					
					echo "
								<td width=4>
									<img src=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."images/strel.gif\" width=\"3\" height=\"5\" border=\"0\">
								</td>
								<td >
									<a href=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/cat/".$key."/parent/".$cat."/".getSePage(trim($value)):"index.php?mod=websites&cat=".$key."&parent_cat=".$cat)."\"><b>".$value."</b></a> 
									&nbsp;&nbsp;
								</td>
							";
					
				
					
					$iSubCounter++;
			}
						
			echo "</tr></table>";
			
			
		}
		?>
		
	
		<br>
		<?php
			
		$page_size = 50;
		
		if(!isset($_GET["num"]))
		{
			$num = 0;
		}
		else
		{
			ms_i($_GET["num"]);
			$num = intval($_GET["num"]) - 1;
		}

		ms_i(get_param("cat"));
		$tableBlogs = DataTable("admin_users","WHERE blog_category=".get_param("cat")." AND blog_active=1 ORDER BY id DESC");
		
		$iTotResults = mysql_num_rows($tableBlogs);
		
		if(ceil($iTotResults/$page_size) > 1)
		{
			for($i=1;$i<=ceil($iTotResults/$page_size);$i++)
			{
				echo "<a style=\"margin-right:8px\" href=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."index.php?mod=websites&cat=".$cat."&num=".$i."\"><b>".$i."</b></a> ";
			}
		}
		
		$bColor = false;
		
		$iRCounter = 0;
		
		?>
		
		<br><br>
		
		<table  align="center" width="100%" cellpadding="6" cellspacing="0" >
		
			<tr >
				<td class="table_block_header" >&nbsp;<?php echo $M_BLOG;?></td>
				<td  class="table_block_header" >&nbsp;<?php echo $CREATED_ON;?></td>
				<td  class="table_block_header" >&nbsp;<?php echo $LAST_UPDATED;?></td>
			
			</tr>
		
		
		

<?php

	while($arrBlog = mysql_fetch_array($tableBlogs))
	{
	
		if($iRCounter>=(intval($num)*$page_size)&&$iRCounter<((intval($num)+1)*$page_size))
		{
			echo "
			<tr bgcolor=".($bColor?'#f1f5fa':'#ffffff').">
				<td><a href='".BlogUrl($arrBlog["username"])."' target=_blank>".str_replace("http://","",BlogUrl($arrBlog["username"]))."</a></td>
				<td>".date($PHP_DATE_FORMAT, $arrBlog["blog_created"])."</td>
				<td>".date($PHP_DATE_FORMAT, $arrBlog["last_update"])."</td>
			</tr>
			";
			$bColor = !$bColor;
		}
		$iRCounter++;
	}
?>
		</table>
		

		</td>
	</tr>
</table>
<?php
}
else

if(get_param("search_box") != "")
{
	ms_ew(get_param("search_box"));
?>
	<br>

<?php

	$tableNotes = 
	DataTable_Query
	("
		SELECT author_image, date, ".$DBprefix."weblog.user, title, ".$DBprefix."notes.id 
		FROM ".$DBprefix."notes,".$DBprefix."weblog,".$DBprefix."admin_users WHERE ".$DBprefix."notes.user=".$DBprefix."weblog.user 
		AND ".$DBprefix."notes.user=".$DBprefix."admin_users.username
		 AND blog_active=1
		AND category_id<>-1 
		".($SHOW_ONLY_NOTES_WITH_PHOTO?"AND author_image<>0":"")."
		AND active='YES' 
		AND 
		(".$DBprefix."notes.title LIKE '%".get_param("search_box")."%' 
		OR 
		".$DBprefix."notes.html LIKE '%".get_param("search_box")."%'
		OR 
		".$DBprefix."notes.user LIKE '%".get_param("search_box")."%'
		)
		ORDER BY date DESC
	");

	$bColor = true;
	
	if(mysql_num_rows($tableNotes) == 0)
	{
		echo "<i>".$NO_RESULTS_CRITERIA."</i>";
	}
	else
	{
	?>
	<table  align="center" width="100%" cellpadding="6" cellspacing="0" >
		
		<tr >
			<td class="table_block_header" >&nbsp;<?php echo $M_HOUR;?></td>
			<td  class="table_block_header" >&nbsp;<?php echo $M_TITLE;?></td>
			<td  class="table_block_header" >&nbsp;<?php echo $M_WEBLOG;?></td>
			<td  class="table_block_header" >&nbsp;<?php echo $M_AUTHOR;?></td>
		</tr>
	
	
	<?php
					
		$iCounter = 1;
		while($arrNote = mysql_fetch_array($tableNotes))
		{
			if($arrNote["user"] == "admin")
			{
				continue;
			}
			
			if(trim($arrNote["title"]) == "")
			{
				continue;
			}
			
			if($iCounter > $NUMBER_LATEST_NOTES)
			{
				break;
			}
			
			if($arrNote["author_image"] > 1)
			{
			
				$author = "<a href=\"".BlogUrl($arrNote["user"])."\" target=\"_blank\">";
				 
				 
				$author .= ShowImage($arrNote["author_image"],$arrNote["user"] , "", 45, 60);
			
				$author .= "</a>";
			}
			else
			{
				$author = "<img src=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."images/no_pic.gif\" width=\"45\" height=\"60\">";
			}

			
			$strBlogger = ''.$arrNote["user"].'';
			
			
			if(isset($USE_REPLACE_WORDS)&&$USE_REPLACE_WORDS)
			{
				$strDisplayNoteTitle = strtr($arrNote["title"], $arrReplaceWords);
			}
			else
			{
				$strDisplayNoteTitle = $arrNote["title"];
			}
			
			echo '
						
				<tr bgcolor='.($bColor?'#ffffff':'#f1f1f1').'>
					<td   width="59">'.date($PHP_HOUR_FORMAT,$arrNote["date"]).'</td>
					<td   width="296"><a href="'.(!$USE_ABSOLUTE_URLS?"index.php?user=".$arrNote["user"]."&note=".$arrNote["id"]:CreateLink4($arrNote["user"],'note/'.$arrNote["id"],$arrNote["title"])).'" target=_blank>'.strip_tags(stripslashes($strDisplayNoteTitle)).'</a></td>
					<td  width="99"><a href="'.BlogUrl($arrNote["user"]).'" target=_blank>'.$strBlogger.'</a></td>
					<td width=\"52\">'.$author.'</td>
				</tr>
			';
			
			$iCounter++;
			
			$bColor = !$bColor;
		}
		?>
		
			</tbody>
		</table>
		
		<?php
	}

?>
	
	
	<br>
<?php
}
else
{
?>
<div style="width:800px">
	<span class="big_font">
	<?php echo $BROWSE_BLOGS_BY_CATEGORY;?>
	</span>
	<br><br>
	<img src="images/gray_pixel.gif" height="1" width="100%">
	<br><br><br>
<?php	
	if(file_exists('include/categories_'.strtolower($lang).'.php'))
		$categories_content = file_get_contents('include/categories_'.strtolower($lang).'.php');
	else
		$categories_content = file_get_contents('include/categories_en.php');


	$arrCategories = explode("\n", trim($categories_content));

	MySQL_OC();
	
	$blogsCount = DataTable_Query_OC
	("
		SELECT count(id) as bc,blog_category FROM ".$DBprefix."admin_users
		WHERE blog_active=1
		GROUP BY blog_category
	"); 	
	MySQL_CC();
	
	$count_array=array();
	
	while($b_count = mysql_fetch_array($blogsCount))
	{
		$c_items = explode(".",$b_count["blog_category"]);
		if(isset($count_array[$c_items[0]]))
		{
			$count_array[$c_items[0]] += $b_count["bc"];
		}
		else
		{
			$count_array[$c_items[0]] = $b_count["bc"];
		}
	}
	
	$bF = true;$bC=0;$iCatC=0;

	foreach($arrCategories as $strCategory)
	{
		
		if(substr_count($strCategory, '.')==1)
		{
			$category = explode(".",$strCategory);
			
			if($iCatC!=0) echo "\n</div>";
			
			if($iCatC%3==0) echo "<div class=\"clear\"></div>";
			
			echo "\n<div style=\"float:left;width:33%;height:45px\">";
			echo "\n<a class=\"category_text\" href=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/cat/".trim($category[0])."/".getSePage(trim($category[1])):"index.php?mod=websites&cat=".trim($category[0]))."\">".trim($category[1])."</a> <span style=\"category_text_count\">(".(isset($count_array[trim($category[0])])?$count_array[trim($category[0])]:"0").")</span>";
			echo "\n<br>";
			$bF = true;$bC=0;$iCatC++;
		}
		else
		{
			$category = explode(".",$strCategory);
			if(sizeof($category)<2) continue;
			
			
			if($bC<5)
			{
				if(!$bF) echo ", ";
														
				echo "\n<span class=\"sub_category_text\">".$category[sizeof($category)-1]."</span>";
			}
			if($bC==5) echo ", ...";
			$bF = false;
			$bC++;
		}
		
	}

	echo "</div><div class=\"clear\"></div>";

	?>
	<br>				
	<div style="float:left;width:48%;">
		<br>
		<span style="float:left;" class="big_font"><?php echo $NEW_BLOGS;?></span>
		<br><br>
		<img src="images/gray_pixel.gif" height="1" width="100%">
		<br><br>
		
		<?php
		$tableLastBlogs = DataTable_Query("SELECT blog_created,username FROM ".$DBprefix."admin_users WHERE username<>'administrator'  AND blog_active=1 ORDER BY blog_created DESC LIMIT 0,10");

		while($arrLastBlog = mysql_fetch_array($tableLastBlogs))
		{
			echo '
				<div class="block_item">
				<span style="float:left">
				<a href="'.BlogUrl($arrLastBlog["username"]).'" target="_blank"><b>'.$arrLastBlog['username'].'</a></b>
				</span>
				<span style="float:right">'.date($PHP_DATE_FORMAT, $arrLastBlog['blog_created']).'</span>
				</div>
				
				';
			
		}
		?>
	</div>
	
	<div style="float:left;margin-left:30px;width:48%;">
		<br>
		<span style="float:left;" class="big_font"><?php echo $MOST_VISITED;?></span>
		<br><br>
		<img src="images/gray_pixel.gif" height="1" width="100%">
		<br><br>
		
		<?php
		$tableLastBlogs = DataTable_Query("SELECT username,visits FROM ".$DBprefix."admin_users WHERE username<>'administrator'  AND blog_active=1 ORDER BY visits DESC LIMIT 0,10");

		while($arrLastBlog = mysql_fetch_array($tableLastBlogs))
		{
			if($arrLastBlog['visits']==0) continue;
			echo '
				<div class="block_item">
				
				<span style="float:left">
					
					
					<a href="'.BlogUrl($arrLastBlog["username"]).'" target="_blank"><b>'.$arrLastBlog['username'].'</a></b>
					</span>
					
					
					<span style="float:right;font-size:13px;font-weight:800">'.$arrLastBlog['visits'].'</span>
				</div>
				
				';
			
		}
		?>
		
	</div>
	<?php


	
									
	$bColor = true;
	$iCounter = 1;
	

	//END HOME PAGE
}

?>
</div>
<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
<br><br>