<?php
ob_start();
include("config.php");
include("ADMIN/Utils.php");
if(!is_numeric($id)) die("");
$arrFile = DataArray("blog_files","file_id=".$id);
SQLQuery("INSERT INTO ".$DBprefix."blog_band(date, user, size, ip)
VALUES ('".time()."','".$arrFile["user"]."','".$arrFile["file_size"]."','".$_SERVER["REMOTE_ADDR"]."')");
$flag = true;

foreach($file_types as $file_type)
{
	$filename="uploaded_files/".$arrFile["user"]."/".$id.".".$file_type[1];
	if(file_exists($filename)) 
	{
		Header("Content-type: ".$file_type[0]);
		header("Content-Disposition: attachment; filename=".$arrFile["file_name"]);
		$handle = fopen($filename, "rb");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		print $contents;
		$flag=false;
	}
}

if($flag)
{

	mysql_connect($DBHost,$DBUser,$DBPass);
	mysql_select_db ($DBName) or die ("DB does not exist or access is denied!");
	
	$sql = "SELECT * FROM ".$DBprefix."blog_files WHERE file_id=".$id;
	
	$result = mysql_query ($sql);
	
	if (mysql_num_rows ($result)>0) 
	{
		$row = @mysql_fetch_array ($result);
		$file_type = $row["file_type"];
		$content = $row["content"];
		header ("Content-type: $file_type");
		header("Content-Disposition: attachment; filename=". $row["file_name"]);
		print $content;
	}
	mysql_close();
}
ob_end_flush();
?>