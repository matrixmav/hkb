<?php
include("ADMIN/Utils.php");
include("include/Page.class.php");
include("config.php");
EnsureParams();
include("include/init.php");
include("include/page_init.php");
if(isset($num)) $no_cache=true;
if($ENABLE_FRONT_SITE_CACHE&&!isset($no_cache)&&$_SERVER["REQUEST_METHOD"]=="GET")
{
	$proceedMainFlag = false;
	
	$filename = "null";
	$url_to_load="";
	
	if(isset($news_id))
	{
		ms_i($news_id);
		$filename = "cache/news_".$news_id.".php";
		$url_to_load='index.php?news_id='.$news_id.'&no_cache=1';
	}
	else
	if(isset($cat))
	{
		ms_i($cat);
		$filename = "cache/cat_".$cat.".php";
		$url_to_load='index.php?mod=home&cat='.$cat.'&no_cache=1'.(isset($parent_cat)?'&parent_cat='.$parent_cat:'');
	}
	else
	if(isset($page))
	{
		$filename = "cache/".$page.".php";
		$url_to_load='index.php?page='.$page.'&no_cache=1';
	}
	else
	if(isset($mod))
	{
		$filename = "cache/mod_".$mod.".php";
		$url_to_load='index.php?mod='.$mod.'&no_cache=1';
	}
	
	
	$proceedFlag = true;
	
	if(file_exists($filename) &&  filesize($filename) > 0 &&  (filemtime($filename)+$FRONT_SITE_CACHE_EXPIRE_TIME*60) > time())
	{
		include($filename);
		$proceedFlag = false;
	}
		
	if($proceedFlag)
	{
	    if (!$handle = fopen($filename, 'w')) 
		{
			$proceedMainFlag = true;
      	}

		$content = implode('', file('http://www.'.$BLOG_DOMAIN.'/'.$url_to_load));

    	if (fwrite($handle, $content) === FALSE) 
		{
			$proceedMainFlag = true;
        }

		fclose($handle);
                    
		if(file_exists($filename))
		{
			$proceedFlag = false;
	 		include($filename);
		}				
		
	}
	
}

if($proceedMainFlag)
{
	$currentPage = new Page();

	if(isset($page_id) && $page_id == -1)
	{
		$currentPage->isBlank = true;
	}

	$currentPage->LoadPageDataMySQLByPageParam($page);
	include("include/Page.php");
	include("include/texts_".strtolower($LANG).".php");

	$currentPage->templateHTML = stripslashes($templateArray["html"]);
	include("include/encodings.php");
	include("include/PageForm.php");


	if(isset($news_id))
	{
		ms_i($news_id);
		$arrNews = DataArray("news","id=".$news_id." ");
		if(!isset($arrNews["id"])) die("");	
		$NEWS = "<br><div class=\"container\">".date($PHP_DATE_FORMAT,$arrNews["date"])."<br>";
		$NEWS .= "<b style=\"font-size:14px\">".$arrNews["title"]."</b><br><br>";
		$NEWS .= str_replace("../image.php?id=","image.php?id=",stripslashes($arrNews["html"]));
		$NEWS .= "</div>";
		$currentPage->pageHTML = str_replace("<wsa title/>",limit_text(stripslashes($arrNews["title"]),70,false), $currentPage->pageHTML);
		$currentPage->pageHTML = str_replace("<wsa description/>",limit_text(stripslashes(strip_tags($arrNews["html"])),160,false), $currentPage->pageHTML);
		echo str_replace("<wsa content/>", "<div style='margin-top:5px;margin-left:10px;margin-right:10px'>".$NEWS."</div>", $currentPage->pageHTML);
	}
	else
	if(isset($news_id))
	{
		ms_i($news_id);
		$arrNews = DataArray("news","id=".$news_id);
		
		$NEWS = "<br>".date($PHP_DATE_FORMAT,$arrNews["date"])."<br><br>";
		$NEWS .= "<b>".$arrNews["title"]."</b>";
		$NEWS .= "<center><hr width=100%></center>";
		$NEWS .= str_replace("../image.php?id=","image.php?id=",$arrNews["html"]);
		
		echo str_replace("<wsa form/>", $NEWS, $currentPage->pageHTML);
		
	}
	else
	if(isset($mod))
	{
		if(!file_exists("extensions/".$mod.".php"))
		{
			die("");
		}
		
		$HTML="";
		ob_start();
		include("extensions/".$mod.".php");
		
		if(!isset($HTML)||$HTML=="")
		{
			$HTML = ob_get_contents();
		}
		ob_end_clean();
		
		$currentPage->pageHTML=str_replace("<wsa content/>",$HTML,$currentPage->pageHTML);
		echo $currentPage->pageHTML;
		
	}
	else
	if(substr($currentPage->arrElementsHTML["content"],0,13) == "wsa:extension")
	{

		$modInfo = explode(":",$currentPage->arrElementsHTML["content"]);
		$pageHTML = explode(trim($currentPage->arrElementsHTML["content"]),$currentPage->pageHTML);
		
		echo $pageHTML[0];
		include("extensions/".$modInfo[2].".php");
		echo $pageHTML[1];
	}
	else{
		echo $currentPage->pageHTML;
	}
}

?>