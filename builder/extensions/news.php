<?php
$HTML="<br><br><br><div class=\"container\">";
$tableNotes=DataTable("news","WHERE active='YES' ORDER BY id DESC");
$iFirstNote = -1;
$arrNoteDays = array();
array_push($arrNoteDays,-1);

while($arrNote = mysql_fetch_array($tableNotes))
{

	array_push($arrNoteDays,date("j",$arrNote["date"]));
		
	if($iFirstNote == -1)
	{
		$iFirstNote = $arrNote["id"];
	}
	
	$HTML.="[<span style=\"font-size:9px\">".date($PHP_DATE_FORMAT,$arrNote["date"])."]</span><br>";
		
			
	$HTML.="<a href=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/news/".$arrNote["id"]."/".format_str($arrNote["title"]).".html":"index.php?news_id=".$arrNote["id"])."\">".$arrNote["title"]."</a><br><br>";
}

if(!isset($note)&&!isset($photo)&&!isset($image))
{
	$note = $iFirstNote;
}

$HTML .= "</div>";
echo $HTML;
?>