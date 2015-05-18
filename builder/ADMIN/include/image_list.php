var tinyMCEImageList = new Array(

<?php
include("../db_config.php");

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db ($DBName) or die ("DB does not exist or access is denied!");

$sql = "SELECT * FROM ".$DBprefix."image";

$result = mysql_query ($sql);

$bFirst = true;

while($arrImage = mysql_fetch_array($result))
{
	if(!$bFirst) echo ",";
	
	echo "[\"".$arrImage["image_name"]."\", \"../image.php?id=".$arrImage["image_id"]."\"]";
	
	
	$bFirst = false;	
}

mysql_close();
?>

);
