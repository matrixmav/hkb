

<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<table summary="" border="0" width=100%>
	<tr>
		<td width=44><img src="images/icons<?php echo $DN;?>/open.gif" border="0" width="44" height="32" alt=""></td>
		<td class=basictext><b><?php echo $TEMPLATE_CHOICE;?></b></td>
	</tr>
</table>
<br>
<?php
if(isset($CheckList)){
	SetParameter(10,$CheckList);

	$HISTORY=$USER_MODIFIED_TEMPLATE;
}

$IS_RADIO=true;
$RADIO_VALUE=Parameter(10);

$arrTDSizes = array("400","*");

RenderTable
(
	"templates",
	array("name","description"),
	array($NOM,$DESCRIPTION),
	"100%",
	"",
	$M_SELECT,
	"id",
	"index.php?action=".$action."&category=".$category
);
?>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_SELECT_TEMPLATE;?>";
document.onmousedown = HTMouseDown;
</script>
