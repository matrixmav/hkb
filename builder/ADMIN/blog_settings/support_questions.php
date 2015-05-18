<?php
if(isset($Delete)&&isset($CheckList)&&sizeof($CheckList)>0)
{
	ms_ia($CheckList);
	SQLDelete("support_questions","id",$CheckList);
}

?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
			<b>Reply the support questions sent by the users</b>
		
		</td>
	</tr>
</table>


<br><br>

<?php
	$arrTDSizes=array("20","100","50","200","*");
	
	RenderTable
	(
		"support_questions",
		array("EditCar","date","user","question","answer"),
		array("Reply","Date","User","Question","Answer"),
		"950",
		"ORDER BY id DESC",
		$EFFACER,
		"id",
		"index.php?action=$action&category=".$category
	);
?>