<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}

ms_i($id);

?>
<script>
document.onkeydown=kdown;

function kdown()
{
	
	if(event.keyCode==113){
		
				
		if(DivPreview.style.visibility=="hidden"){
		
			DivPreview.style.visibility="visible";
			DivPreview.innerHTML=document.all.html.value;
			ShowBorders();
		
		}
		else{
				
			DivPreview.style.visibility="hidden";
			DivPreview.innerHTML="";
			
		}
	}
	
	return;

}

function ShowBorders(){
	
		var allTables = document.all.DivPreview.getElementsByTagName("TABLE");
	
		toggle = "off";
				// Do tables
		for (i=0; i < allTables.length; i++) {

		allTables[i].contentEditable = "true"
				if (toggle == "off") {
					allTables[i].runtimeStyle.border = "1px dotted #BFBFBF"

				} else {
					allTables[i].runtimeStyle.cssText = ""
				}

				allRows = allTables[i].rows
				for (y=0; y < allRows.length; y++) {
				 	allCellsInRow = allRows[y].cells
						for (x=0; x < allCellsInRow.length; x++) {
							if (toggle == "off") {

								allCellsInRow[x].runtimeStyle.border = "1px dotted #BFBFBF"

							} else {
								allCellsInRow[x].runtimeStyle.cssText = ""
							}
						}
				}
		}
	}
</script>

<?php
AddEditForm
	(
	array($NOM.":",$DESCRIPTION.":","HTML".":"),
	array("name","description","html"),
	array(),
	array("textbox_60","textbox_60","textarea_80_20"),
	"templates",
	"id",
	$id,
	"".$TEMPLATE_MODIFIE_SUCCES."<br><br>"
	);
	
?>
<br>
<?php
generateBackLink("modify");
?>


<div id="DivPreview" style="zoom:0.66;visibility:hidden;background:#f7f6ff;z-Index:2;position:absolute;top:227;left:270;width:1010;height:492">


</div>

