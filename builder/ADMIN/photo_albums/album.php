<?php

$tableCountImages= DataTable_Query("SELECT count( * ) cc, photo_id
FROM ".$DBprefix."photo_images
GROUP BY photo_id");

$arrCountImages = array();

while($arrCountImage = mysql_fetch_array($tableCountImages))
{
	$arrCountImages[$arrCountImage["photo_id"]] = $arrCountImage["cc"];
}



$arrHomeAlbumFormatDescription = array();
$arrHomeAlbumFormatDescription[1] = $MA1;
$arrHomeAlbumFormatDescription[2] = $MA2;
$arrHomeAlbumFormatDescription[3] = $MA3;
$arrHomeAlbumFormatDescription[4] = $MA4;

$arrAlbumFormatDescription = array();
$arrAlbumFormatDescription[1] = $MA5;
$arrAlbumFormatDescription[2] = $MA6;
$arrAlbumFormatDescription[3] = $MA7;
$arrAlbumFormatDescription[4] = $MA8;

	$editOnClick = "yes";
	$doNotGeneratePDFExportLink=true;
		renderCompositeTable_Expand_Album(
						"SELECT 
						id,
						home_thumbnails_columns ,
						home_thumbnails_size ,
						thumbnails_size,
						show_title,
						show_date,
						show_legende,
						show_place,
						show_description,

						album_format,
						home_page_format,
						description,
						date,
						name
						 FROM ".$DBprefix."photo WHERE user='$AuthUserName'  AND name<>'manager' ",
						array("name","date","PhotosCount"),
						array($NOM,"date","PhotosCount"),
						array(),
						"id",
						array("fieldset","fieldset","fieldset","fieldset","fieldset"),
						array("Info","Home Page","Format","Settings","Photos"),
						array(
							array("description"),
							array("HomePageFormat"),
							array("AlbumFormat"),
							array("AlbumSettings"),
							array("AlbumPhotos")
						),
						array(
							array($DESCRIPTION),
							array($NOM),
							array($NOM),
							array($NOM),
							array($NOM)							
						)
			);

?>


