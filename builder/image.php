<?php
include("config.php");
$id=$_GET["id"];
if(!is_numeric($id)) die("");
$flag = true;

if(isset($_GET["user"])&&isset($_GET["name"]))
{
	foreach($image_types as $image_type)
	{
		if(file_exists("uploaded_images/".$_GET["user"]."/".$_GET["name"].$image_type[1])) 
		{
			header ("Content-type: ".$image_type[0]);
			$handle = fopen("uploaded_images/".$_GET["user"]."/".$_GET["name"].$image_type[1], "rb");
			$contents = fread($handle, filesize("uploaded_images/".$_GET["user"]."/".$_GET["name"].$image_type[1]));
			fclose($handle);
			print $contents;
			$flag=false;
		}
	}

}
else
{
	foreach($image_types as $image_type)
	{
		if(file_exists("uploaded_images/".$id.".".$image_type[1])) 
		{
			header ("Content-type: ".$image_type[0]);
			$handle = fopen("uploaded_images/".$id.".".$image_type[1], "rb");
			$contents = fread($handle, filesize("uploaded_images/".$id.".".$image_type[1]));
			fclose($handle);
			print $contents;
			$flag=false;
		}
	}
}

if($flag)
{
	if($ENTERPRISE_PREFIX)
	{
		$DBprefix = $DBprefix2;
	}
	
	mysql_connect($DBHost,$DBUser,$DBPass);
	mysql_select_db ($DBName) or die ("DB does not exist or access is denied!");
	
	$sql = "SELECT * FROM ".$DBprefix."image WHERE image_id=".$id;
	
	$result = mysql_query ($sql) or die("<script>document.location.href='index.php';</script>");
	
	if (mysql_num_rows ($result)>0) 
	{
		$row = @mysql_fetch_array ($result);
		$image_type = $row["image_type"];
		$image = $row["image"];
		header ("Content-type: $image_type");
		print $image;
	}
	else
	{
		header ("Content-type: image/gif");
		$handle = fopen("images/spacer.gif", "rb");
		$contents = fread($handle, filesize("images/spacer.gif"));
		fclose($handle);
		print $contents;
	}
	mysql_close();
}

?>
