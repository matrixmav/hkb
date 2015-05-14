<?php
if(!isset($iKEY)||$iKEY!="AZ8007")
{
	die("ACCESS DENIED");
}
?>
<?php
if(isset($Delete)&&isset($CheckList))
{
	ms_ia($CheckList);
	SQLDelete("list","id",$CheckList);
	
}
?>

<table summary="" border="0" width="100%">
	<tr>
		<td width="45">
		<img src="images/icons2/write.gif" width="49" height="45" alt="" border="0">
		</td>
		<td>
		<b>Manage the user lists</b>
		</td>
	</tr>
</table>
<br>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	<TR>
		<td class=basicText>
			
			<center>
			<?php
				
				$oCol=array("ListPreview","name","user");
				$oNames=array("Preview","Name","User");
						
				RenderTable("list",$oCol,$oNames,"100%","  ",$EFFACER,"id","index.php?action=$action&category=".$category);
	
			?>
			</center>
			<br>
		</td>
	</tr>
	</table>

