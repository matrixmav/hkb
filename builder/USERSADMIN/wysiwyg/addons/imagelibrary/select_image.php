<?php
/********************************************************************
 * openImageLibrary addon Copyright (c) 2006 openWebWare.com
 * Contact us at devs@openwebware.com
 * This copyright notice MUST stay intact for use.
 ********************************************************************/

$USE_GD=true;
require('config.inc.php');

if((substr($imagebaseurl, -1, 1)!='/') && $imagebaseurl!='') $imagebaseurl = $imagebaseurl . '/';
if((substr($imagebasedir, -1, 1)!='/') && $imagebasedir!='') $imagebasedir = $imagebasedir . '/';
$leadon = $imagebasedir;
if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;

$opendir = $leadon;
if(!$leadon) $opendir = '.';
if(!file_exists($opendir)) {
	$opendir = '.';
	$leadon = $startdir;
}

clearstatcache();
$not_include_cofig=true;
include("../../../../config.php");
include("../../../security.php");

$image_types = Array 
(
		array("image/jpeg","jpg"),
		array("image/pjpeg","jpg"),
		array("image/bmp","bmp"),
		array("image/gif","gif"),
		array("image/x-png","png")
);
function GetExtensionFromType($type)
{
	$result = "jpg";
	
	global $image_types;
	
	foreach($image_types as $image_type)
	{
		if($image_type[0]==$type||$image_type[1]==$type)
		{
			$result = $image_type[1];
			break;
		}
	}
	return $result;
}

mysql_connect($DBHost,$DBUser,$DBPass);
mysql_select_db ($DBName) or die ("DB does not exist or access is denied!");
$sql = "SELECT image_id,image_name,image_type FROM ".$DBprefix."image WHERE user='".$AuthUserName."' ";
$result = mysql_query ($sql);
$bFirst = true;
$n=0;
while($arrImage = mysql_fetch_array($result))
{
	if(!file_exists("../../../../uploaded_images/".$AuthUserName."/".$arrImage["image_id"].".".GetExtensionFromType($arrImage["image_type"])))
	{
		continue;
	}
		
	
	$files[$n] = $arrImage["image_name"];
	$files_url[$n] = "../../../../uploaded_images/".$AuthUserName."/".$arrImage["image_id"].".".GetExtensionFromType($arrImage["image_type"]);
	$n++;
}

mysql_close();

/*
//sort our files
if($_GET['sort']=="date") {
	@ksort($dirs, SORT_NUMERIC);
	@ksort($files, SORT_NUMERIC);
}
elseif($_GET['sort']=="size") {
	@natcasesort($dirs); 
	@ksort($files, SORT_NUMERIC);
}
else {
	@natcasesort($dirs); 
	@natcasesort($files);
}
*/

//print_r($files);
//die("1");


//order correctly
/*
if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}
if($_GET['order']=="desc") {$files = @array_reverse($files);}

*/
$dirs = @array_values($dirs); $files = @array_values($files);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Select Image</title>
<style type="text/css">
body {
	margin: 0px;
}
a {
	font-family: Arial, verdana, helvetica; 
	font-size: 11px; 
	color: #000000;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
</style>
<script type="text/javascript">
	function selectImage(url,width,height) {
		if(parent) 
		{
			parent.document.getElementById("src").value = url;
			
			if(width!=0) parent.document.getElementById("width").value = width;
			if(height!=0) parent.document.getElementById("height").value = height;
		}
	}
	
	if(parent) {
		parent.document.getElementById("dir").value = '<?php echo $leadon; ?>';
	}
	
</script>
</head>
<body>
	<table border="0">
		<tbody>
		 <?php
		 	//$breadcrumbs = split('/', str_replace($basedir."/", "", $leadon));
			$breadcrumbs = explode('/', str_replace("/", "", $leadon));
		  	if(($bsize = sizeof($breadcrumbs)) > 0) {
		  		if(($bsize-1) > 0) {	
			  		echo "<tr><td>";
			  		$sofar = '';
			  		for($bi=0;$bi<($bsize-1);$bi++) {
						$sofar = $sofar . $breadcrumbs[$bi] . '/';
						echo '<a href="'.$_SERVER['PHP_SELF'].'?dir='.urlencode($sofar).'" style="font-size:10px;font-family:Tahoma;">&raquo; '.$breadcrumbs[$bi].'</a><br>';
					}
					echo "</td></tr>";
		  		}
		  	}
		  ?>
		<tr>
			<td>
				  <?php
					$class = 'b';
					if(false) {
					?>
					<a href="<?php echo $_SERVER['PHP_SELF'].'?dir='.urlencode($dotdotdir); ?>"><img src="images/dirup.png" alt="Folder" border="0" /> <strong>..</strong></a><br>
					<?php
						if($class=='b') $class='w';
						else $class = 'b';
					}
					$arsize = sizeof($dirs);
					for($i=0;$i<$arsize;$i++) {
						$dir = substr($dirs[$i], 0, strlen($dirs[$i]) - 1);
					?>
					<a href="<?php echo $_SERVER['PHP_SELF'].'?dir='.urlencode($leadon.$dirs[$i]); ?>"><img src="images/folder.png" alt="<?php echo $dir; ?>" border="0" /> <strong><?php echo $dir; ?></strong></a><br>
					<?php
						if($class=='b') $class='w';
						else $class = 'b';	
					}
					
					$arsize = sizeof($files);
					for($i=0;$i<$arsize;$i++) {
						$icon = 'unknown.png';
						$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
						if(in_array($ext, $supportedextentions)) {
							
							$thumb = '';
							if($filetypes[$ext]) {
								$icon = $filetypes[$ext];
							}
							
							$filename = $files[$i];
							if(strlen($filename)>43) {
								$filename = substr($files[$i], 0, 40) . '...';
							}
							$fileurl = $leadon . $files[$i];
							$filedir = str_replace($imagebasedir, "", $leadon);
							
							$image_width=0;
							$image_height=0;
							
							if($USE_GD&&file_exists($imagebaseurl.$filedir.$AuthUserName."/".$filename))
							{
								list($image_width, $image_height,$image_type) = getimagesize($imagebaseurl.$filedir.$AuthUserName."/".$filename);
							}
							
							if($image_width=="") $image_width=0;
							if($image_height=="") $image_height=0;
							
						if(isset($files_url[$i]) && !file_exists($files_url[$i])) continue;
					?>
					<a href="javascript:void(0)" onclick="selectImage('<?php echo str_replace("../","",$files_url[$i]); ?>',<?php echo $image_width;?>,<?php echo $image_height;?>);"><img src="<?php echo $files_url[$i];?>" width="40" border="0" /> <strong><?php echo $filename; ?></strong></a><br>
					<?php
							if($class=='b') $class='w';
							else $class = 'b';	
						}
					}	
					?>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>