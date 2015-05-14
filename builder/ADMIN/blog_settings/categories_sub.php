<?php 
if(isset($CheckList)&&sizeof($CheckList)>0)
{
	ms_ia($CheckList);
	SQLDelete("blog_categories","id",$CheckList);

}

include("include/languages_menu_processing.php");

?>
<table summary="" border="0" width="100%">
	<tr>
		<td>
			<?php
			
			$arrCategory = DataArray("blog_categories","id=".$id);
			
			?>
			<b>Selected category: <font color=red><?php echo $arrCategory["name"];?></font></b>
		
		</td>
	</tr>
</table>
<br>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
			<b>Add a new sub category</b>
		
		</td>
	</tr>
</table>
<br>

<?php
$strSpecialHiddenFieldsToAdd = "<input type=hidden name=id value=\"".$id."\">";
$arrNames2=array("parent_id","lang");
$arrValues2=array($id,$lang);

AddNewForm
	(
		array("Name:"),
		
		array("name"),

		array("textbox_60"),

		" Add ",
		"blog_categories",
		"<b>The new sub category has been added succesfully.</b>
		"
	);
	
?>


<br><br>

<?php
					
				
					
					
					RenderTable
					(
						"blog_categories",
						array("EditCar","name"),
						array("Modify","Name"),
						"100%",
						"WHERE name<>'' AND parent_id=".$id,
						$EFFACER,
						"id",
						"index.php?category=$category&folder=".$folder."&page=".$page."&id=".$id
					);
		
?>
<br><br>
<?php
generateBackLink("categories");
?>
