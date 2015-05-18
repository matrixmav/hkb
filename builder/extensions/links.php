<?php
if(SQLCount("lm_categories","") == 0)
{
?>

<b><?php echo $M_LINKS;?>:</b>
<br><br>
<?php
$linksTable = DataTable("linksmanager","ORDER BY rank DESC");

$iCounter = 0;

while($arrLink = mysql_fetch_array($linksTable))
{
	
	$iCounter++;

	echo $iCounter.") <a href=\"".$arrLink["url"]."\" target=_blank><b>".$arrLink["title"]."</b></a> (".str_replace("</p>","",str_replace("<br>","",str_replace("<p>","",$arrLink["short_description"]))).")
	<br>
	<center><hr width=100%></center>

	".str_replace("<br>","",str_replace("</p>","",str_replace("<p>","",$arrLink["long_description"])))."
	<br><br><br>
	";
}

?>

<?php
}
else
{
				
	if(isset($cat))
	{
		ms_i($cat);
		$arrCategory = DataArray("lm_categories","id=".$cat);
	
		echo "<br><b>".$arrCategory["name_en"].":</b><br><br><br>";
	
		$linksTable = DataTable("linksmanager","WHERE cat=".$cat." ORDER BY rank DESC");
		
		$iCounter = 0;
		
		while($arrLink = mysql_fetch_array($linksTable))
		{
			
			$iCounter++;
		
			echo $iCounter.") <a href=\"".$arrLink["url"]."\" target=_blank><b>".$arrLink["title"]."</b></a> (".str_replace("</p>","",str_replace("<br>","",str_replace("<p>","",$arrLink["short_description"]))).")
			<br>
			<center><hr width=\"100%\"></center>
		
			".str_replace("<br>","",str_replace("</p>","",str_replace("<p>","",$arrLink["long_description"])))."
			<br><br><br>
			";
		}
		
		echo "<a href=\"index.php?mod=links\">Go back</a>";
		
	}
	else
	{
	
		echo "<br><b>".$CATEGORIES.":</b><br><br><br>";
		
		$tableCategories = DataTable("lm_categories","");
		
		$iCounter = 0;
		
		while($arrCategory = mysql_fetch_array($tableCategories))
		{
			$iCounter++;
			
			echo $iCounter.") <b><a href=\"index.php?mod=links&cat=".$arrCategory["id"]."\">".$arrCategory["name_en"]."</a></b>";
			echo "<hr width=100%>";
			
			echo str_replace("</p>","",str_replace("<p>","",$arrCategory["description_en"]));
				
			echo "<br><br><br>";
				
		}
	}
}
?>