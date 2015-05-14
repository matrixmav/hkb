<table summary="" border="0">
	<tr>
		<td>
		
			<b>
			
			</b>
		
		</td>
	</tr>
</table>

<?php
$SelectWidth=300;
$MessageTDLength=120;
$SubmitButtonText=$SAUVEGARDER;

AddEditForm
	(
	array("$NOM_DUTILISATEUR:",
	
	"Description:","Author","Logo:","Author Image:","Format:",
	"Background Color:","Header Background Bolor:","Links Color:","Font Family:",
	"Font Size:","Main Area Background Color:","Font Color:","Meta Title:","Meta Description:",
	"Meta Keywords:","Header Font Color:","Header Font Size:","Shadows Color:","Author Image Width:",
	"Author Image Height:"
	),
	array("user",
	
	"description","author","logo","author_image","format",
	"background_color","header_background_color","links_color","font_family",
	"font_size","main_area_background_color","font_color","meta_title","meta_description",
	"meta_keywords","header_font_color","header_font_size","shadows_color","author_image_width",
	"author_image_height"
	
	),
	array("user"),
	array("textbox_20",
	
	"textarea_40_5","textarea_40_5 ","textbox_40","textbox_40","textbox_40",
	"textbox_40","textbox_40","textbox_40","textbox_40",
	"textbox_40","textbox_40","textbox_40","textbox_40","textarea_40_5",
	"textarea_40_5","textbox_40","textbox_40","textbox_40","textbox_40",
	"textbox_40"
	),
	"weblog",
	"user",
	"'".$user."'",
	"The values have been modified successfully!"
	);
	
?>


<?php
generateBackLink("user_settings");
?>
