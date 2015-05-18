<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>

<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>

<?php
if(OverQuota())
{
?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<br><br>
		<span class="redtext">
		
		<?php
		echo $M_USER_OVER_QUOTA;
		?>
		
		</span>
		</td>
	</tr>
</table>

<?php
}
else
{
?>


<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
	theme_advanced_buttons2 : "fontselect,fontsizeselect,forecolor",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",

	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>
<?php
	
	if(isset($CheckList) && sizeof($CheckList)>0)
	{
	
		$arrFileIds = array();
		
		foreach($CheckList as $CheckId)
		{
			$arrDocument = DataArray("blog_documents","id=".$CheckId." AND user='".$AuthUserName."'");
			
			array_push($arrFileIds, $arrDocument["file_id"]);	
			
				foreach($file_types as $file_type)
				{
	
					if(file_exists($UPLOAD_DIR_FILES.$arrDocument["file_id"].".".$file_type[1])) 
					{
								unlink($UPLOAD_DIR_FILES.$arrDocument["file_id"].".".$file_type[1]);
					}
				}
		}
	
		if(sizeof($arrFileIds) > 0)
		{
			SQLDeletePlus("blog_files","file_id",$arrFileIds);
		}
		
		SQLDeletePlus("blog_documents","id",$CheckList);
	
	}


?>
	<br>
				<table summary="" border="0" width=100%>
				  	<tr>
				  		<td width="44"><img src="images/icons/open.gif" width="44" height="32" alt="" border="0"></td>
				  		<td class=basictext><b>
						
						<?php echo $ADD_NEW_DOCUMENT;?>
						
						</b></td>
				  	</tr>
				  </table>
	  <br>

<?php

$SelectWidth = 200;
$arrNames2=array("user");
$arrValues2=array($AuthUserName);

$isBlogFile = true;
AddNewForm
(
		array($M_TITLE.":",$DESCRIPTION.":",$FILE.":"),
		array("title","description","file_id"),
		array("textbox_54","textarea_40_10","file"),
		$AJOUTER,
		"blog_documents",
		$DOCUMENT_ADDED_SUCCESSFULY
);
?>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=100%>
	<TR>
		<td class=basicText>
				<br><br>
				
				
				<table summary="" border="0">
				  	<tr>
				  		
				  		<td class=basictext><b>
						
						<?php echo $LIST_AVAILABLE_DOCUMENTS;?>
						
						</b></td>
				  	</tr>
				  </table>
	  			<br>
				<center>
				<?php
					
					$oCol=array("file_name","title","description","file_id");
					$oNames=array($NOM,$M_TITLE,$DESCRIPTION,$FILE);
					$ORDER_QUERY="";
					RenderTable("blog_documents,".$DBprefix."blog_files",$oCol,$oNames,680,"WHERE ".$DBprefix."blog_documents.user='".$AuthUserName."' AND ".$DBprefix."blog_documents.file_id=".$DBprefix."blog_files.file_id ",$EFFACER,"id","index.php?action=$action&category=".$category);
		
				?>
				</center>
				<br>
		</td>
	</tr>
	</table>
<script>
var HTType="2";
var HTMessage="<?php echo $T_FILES;?>";
document.onmousedown = HTMouseDown;
</script>

<?php
}
?>
