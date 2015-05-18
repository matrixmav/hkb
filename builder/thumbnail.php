<?php
include("config.php");

///KEEP ASPECT RATIO PARAMETER
/// IF SET TO TRUE, WILL KEEP THE ASPECT RATIO OF THE GENERATED THUMBNAILS
$KEEP_ASPECT_RATIO = true;
///END KEEP ASPECT RATIO

$user="";
$id=$_GET["id"];
if(isset($_GET["user"])) $user=$_GET["user"];
if(!is_numeric($id)) die("");

if($user!=""&&file_exists("uploaded_images/".$user."/thumb_".$id.".jpg"))
{
	header('Content-type: image/jpeg');
	$handle = fopen("uploaded_images/".$user."/thumb_".$id.".jpg", "rb");
	$contents = fread($handle, filesize( "uploaded_images/".$user."/thumb_".$id.".jpg" ));
	fclose($handle);
	print $contents;	
	
}
else
{
	if(isset($_GET["w"])) $w=$_GET["w"];
	if(isset($_GET["h"])) $h=$_GET["h"];


	$flag=true;

	foreach($image_types as $image_type)
	{

		if(file_exists("uploaded_images/".($user!=""?$user."/":"").$id.".".$image_type[1])) 
		{	
			$strURL = "uploaded_images/".($user!=""?$user."/":"").$id.".".$image_type[1];
			$flag=false;
			
		}
	}

	if($flag)
	{
		$strURL= ($BLOG_DOMAIN==""||$BLOG_DOMAIN=="localhost"?"":"http://www.".$BLOG_DOMAIN."/")."image.php?id=".$id;
	}

	$filename =$strURL;
	$percent = 0.5;

	list($width, $height,$type) = getimagesize($filename);


	if(!isset($w)||$w=="")
	{
		 $newwidth =120;
	}
	else
	{
		$newwidth = $w;
	}

	if(!isset($h)||$h=="")
	{
		 $newheight =160;
	}
	else
	{
		$newheight = $h;
	}

	if($newwidth > $width)
	{
		$newwidth = $width;
	}

	if($newheight > $height)
	{
		$newheight = $height;
	}


	if($KEEP_ASPECT_RATIO)
	{
		$newheight = $newwidth * ($height / $width);
	}

	function imagecreatefrombmp($dir) {
		$bmp = "";
		if (file_exists($dir)) {
			$file = fopen($dir,"r");
			while(!feof($file)) $bmp .= fgets($file,filesize($dir));
			if (substr($bmp,0,2) == "BM") {
			 
				$header = unpack("vtype/Vlength/v2reserved/Vbegin/Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant", $bmp);
				extract($header);
			  
				$im = imagecreatetruecolor($width,$height);
				$i = 0;
				$diff = floor(($imagesize - ($width*$height*($bits/8)))/$height);
				for($y=$height-1;$y>=0;$y--) {
					for($x=0;$x<$width;$x++) {
						if ($bits == 32) {
							$b = ord(substr($bmp,$begin+$i,1));
							$v = ord(substr($bmp,$begin+$i+1,1));
							$r = ord(substr($bmp,$begin+$i+2,1));
							$i += 4;
						} else if ($bits == 24) {
							$b = ord(substr($bmp,$begin+$i,1));
							$v = ord(substr($bmp,$begin+$i+1,1));
							$r = ord(substr($bmp,$begin+$i+2,1));
							$i += 3;
						} else if ($bits == 16) {
							$tot1 = decbin(ord(substr($bmp,$begin+$i,1)));
							while(strlen($tot1)<8) $tot1 = "0".$tot1;
							$tot2 = decbin(ord(substr($bmp,$begin+$i+1,1)));
							while(strlen($tot2)<8) $tot2 = "0".$tot2;
							$tot = $tot2.$tot1;
							$r = bindec(substr($tot,1,5))*8;
							$v = bindec(substr($tot,6,5))*8;
							$b = bindec(substr($tot,11,5))*8;
							$i += 2;
						}
						$col = imagecolorexact($im,$r,$v,$b);
						if ($col == -1) $col = imagecolorallocate($im,$r,$v,$b);
						imagesetpixel($im,$x,$y,$col);
					}
					$i += $diff;
				}
			 
				return $im;
				imagedestroy($im);
			} else return false;
		} else return false;
	}


	if(!function_exists('image_type_to_extension'))
	{
	   function image_type_to_extension($imageType,$includeDot=false)
	   {
	   
		 $dot = $includeDot ? '.' : '';
		   $ext = false;
		   if(!empty($imageType)) 
		   {
		   
		 
			 switch($imageType) 
			 {
				 case IMAGETYPE_GIF    : $ext = $dot.'gif'; break;
				 case IMAGETYPE_BMP    : $ext = $dot.'bmp'; break;
				 case IMAGETYPE_JPEG    : $ext = $dot.'jpg'; break;
				 case IMAGETYPE_PNG    : $ext = $dot.'png'; break;
				 case IMAGETYPE_SWF    : $ext = $dot.'swf'; break;
				 case IMAGETYPE_PSD    : $ext = $dot.'psd'; break;
				 case IMAGETYPE_WBMP    : $ext = $dot.'wbmp'; break;
				 case IMAGETYPE_XBM    : $ext = $dot.'xbm'; break;
				 case IMAGETYPE_TIFF_II : $ext = $dot.'tiff'; break;
				 case IMAGETYPE_TIFF_MM : $ext = $dot.'tiff'; break;
				 case IMAGETYPE_IFF    : $ext = $dot.'aiff'; break;
				 case IMAGETYPE_JB2    : $ext = $dot.'jb2'; break;
				 case IMAGETYPE_JPC    : $ext = $dot.'jpc'; break;
				 case IMAGETYPE_JP2    : $ext = $dot.'jp2'; break;
				 case IMAGETYPE_JPX  : $ext = $dot.'jpf'; break;
				 case IMAGETYPE_SWC    : $ext = $dot.'swc'; break;
			 }
	   }
	   

	   return $ext;
	   }
	}

	$thumb = imagecreatetruecolor($newwidth, $newheight);

	$type = image_type_to_extension($type);


	if($type == "gif")
	{
		imagesavealpha($thumb,true);
		$trans = imagecolorallocatealpha($thumb,255,255,255,127);
		imagefill($thumb,0,0,$trans);
	}

	if($type=="") $type="jpg";
	$type=str_replace(".","",$type);
	if($type == "jpg" && !function_exists('imagecreatefromjpg'))
	{
		$type = "jpeg";
	}


	eval("global \$filename; \$source = imagecreatefrom$type(\$filename);");




	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


	if($user!=""&&!file_exists("uploaded_images/".$user."/thumb_".$id.".jpg"))
	{
		if(is_writable("uploaded_images/".$user."/thumb_".$id.".jpg"))
		{
			imagejpeg($thumb, "uploaded_images/".$user."/thumb_".$id.".jpg");
		}
	}
		
	if($type == "gif"||$type == "bmp")
	{
		header('Content-type: image/gif');
		
		imagegif($thumb);
	}
	else
	{
		header('Content-type: image/jpeg');
		
		imagejpeg($thumb);
	}
	
}
?>