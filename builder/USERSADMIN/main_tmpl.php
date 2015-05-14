<?php
include("../config.php");
include_once("Utils.php");
include_once("security.php");

if(!isset($page)){
	$page="0";
}
include("../ADMIN/texts_en.php");
$oPage=DataArray("re_users","username='$AuthUserName'");
$HTMLCODE = $oPage['template'];	

				$arrI1 = explode("<body",$HTMLCODE,2);
				$arrI2 = explode(">",$arrI1[1],2);
				
				$topHTML = $arrI1[0]."<body".$arrI2[0].">";
				$middleHTML = $arrI2[1];
				
				$middleHTML = ereg_replace("<wsa ([a-z_]+)/>","[WSA TAG: \\1]",$middleHTML);

?>
<html>
<head>
<script>
function pageSaved()
{
	alert("The template has been saved successfully!");
}
</script>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../ADMIN/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,searchreplace,print,contextmenu,paste,directionality",
		theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		content_css : "include/example_full.css",
	    plugin_insertdate_dateFormat : "%Y-%m-%d",
	    plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "table[width|height|cellspacing|cellpadding|bgcolor|background|class|style],td[bgcolor|class|width|height|colspan|rowspan|background|align|valign|style],a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],div[class|align|style]",
		external_link_list_url : "include/example_link_list.php",
		external_image_list_url : "include/image_list.php",
		flash_external_list_url : "include/example_flash_list.js",
		file_browser_callback : "fileBrowserCallBack"
	});

	function fileBrowserCallBack(field_name, url, type) 
	{

	}
</script>
<!-- /tinyMCE -->

</head>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<iframe id="opIframe" name="opIframe" src="blank.html" style="position:absolute;top:0px;left:0px;visibility:hidden" width="1" height="1"> </iframe>
<form method="post"  action="saveTemplate.php" target="opIframe">
<input type=hidden  name="page" value="<?php echo($page);?>">
<textarea id="strCode" name="strCode" rows="15" cols="80" style="height:100%;width: 100%;background:white">
<?php echo(str_replace("=\"images/","=\"../images/", stripslashes($middleHTML) ));?>
</textarea>
</form>

</body>
</html>
