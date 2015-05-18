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


<?php
	
	if(isset($CheckList) && sizeof($CheckList)>0)
	{
	
		$arrFileIds = array();
		
		foreach($CheckList as $CheckId)
		{
			ms_i($CheckId);
			$arrDocument = DataArray("blog_documents","id=".$CheckId." AND user='".$AuthUserName."'");
			
			array_push($arrFileIds, $arrDocument["file_id"]);	
			
				foreach($file_types as $file_type)
				{
					if(file_exists("../uploaded_files/".$AuthUserName."/".$arrDocument["file_id"].".".$file_type[1])) 
					{
						unlink("../uploaded_files/".$AuthUserName."/".$arrDocument["file_id"].".".$file_type[1]);
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
	
<table summary="" border="0" width="100%">
<tr>
	<td width="44"><img src="images/icons/file_upload.png" width="48" height="48" alt="" border="0"></td>
	<td class="blog_admin_header"><b>
	
	<?php echo $ADD_NEW_DOCUMENT;?>
	
	</td>
</tr>
</table>
	  <br>

<?php

$SelectWidth = 400;
$arrNames2=array("user");
$arrValues2=array($AuthUserName);

$isBlogFile = true;

if(isset($SpecialProcessAddForm))	
{
	if($_FILES["file_id"]&&$_FILES["file_id"]["tmp_name"]!="")
	{
	
	}
	else
	{
		unset($SpecialProcessAddForm);
	}
}

AddNewForm_BA
(
		array($M_TITLE.":",$DESCRIPTION.":",$FILE.":"),
		array("title","description","file_id"),
		array("textbox_65","textarea_48_6","file"),
		$AJOUTER,
		"blog_documents",
		$DOCUMENT_ADDED_SUCCESSFULY
);
?>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	<TR>
		<td class=basicText>
				<br><br>
				
				
				<table summary="" border="0">
				  	<tr>
				  		
				  		<td class=basictext><i>
						
						<?php echo $LIST_AVAILABLE_DOCUMENTS;?>
						
						</i></td>
				  	</tr>
				  </table>
	  			
				<center>
				<?php
					
					$oCol=array("file_name","title","description","file_id");
					$oNames=array($NOM,$M_TITLE,$DESCRIPTION,$FILE);
					$ORDER_QUERY="";
					RenderTable_BA("blog_documents",$oCol,$oNames,"100%","WHERE ".$DBprefix."blog_documents.user='".$AuthUserName."' ",$EFFACER,"id","index.php?action=$action&category=".$category);
		
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
