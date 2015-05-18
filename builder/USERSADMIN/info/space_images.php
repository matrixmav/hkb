<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>
<script>
function DeleteFile(x)
{
	if(confirm("<?php echo $M_ARE_YOU_SURE;?>"))	
	{
		document.location.href="index.php?category=<?php echo $category;?>&folder=<?php echo $folder;?>&page=<?php echo $page;?>&delfi="+x;
	}
}

function DeleteImage(x)
{
	if(confirm("<?php echo $M_ARE_YOU_SURE;?>"))	
	{
		document.location.href="index.php?category=<?php echo $category;?>&folder=<?php echo $folder;?>&page=<?php echo $page;?>&delim="+x;
	}
}
</script>
<?php

if(isset($delim))
{
	ms_i($delim);
	if(SQLCount("image","WHERE user='$AuthUserName' AND image_id=".$delim) == 1)
	{
		$arr_ids = array();
		array_push($arr_ids, $delim);
		SQLDelete("image","image_id",$arr_ids);
	
		if(!$IMAGES_IN_DB)
		{
			foreach($image_types as $image_type)
			{
					if(file_exists("../blog_images/".$AuthUserName."/".$delim.".".$image_type[1]))
					{
						unlink("../blog_images/".$AuthUserName."/".$delim.".".$image_type[1]);
					}
			}
		}
		
	}
}

if(isset($delfi))
{
	ms_i($delfi);
	if(SQLCount("blog_files","WHERE user='$AuthUserName' AND file_id=".$delfi) == 1)
	{
		$arr_ids = array();
		array_push($arr_ids, $delfi);
		SQLDelete("blog_files","file_id",$arr_ids);
	
		if(!$IMAGES_IN_DB)
		{
			foreach($file_types as $file_type)
			{
					if(file_exists("../blog_files/".$AuthUserName."/".$delfi.".".$file_type[1]))
					{
						unlink("../blog_files/".$AuthUserName."/".$delfi.".".$file_type[1]);
					}
			}
		}
		
	}
}
?>

<?php
$arrTDSizes = array("50","200","200","100","50");

RenderTable_BA
(
	"image",
	array("image_id","image_name","image_date","image_size","delete_image_js"),
	array($M_VIEW,$NOM,$DATE_MESSAGE,$SIZE,$EFFACER),
	"100%",
	"WHERE user='$AuthUserName'",
	"",
	"image_id",
	"index.php?category=$category&action=$action"
);
?>
<br><br>
<?php
echo generateBackLink("space");
?>