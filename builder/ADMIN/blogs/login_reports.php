<?php
if(isset($EFFACER) && isset($CheckList))
{
	
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDelete("login_log","id",$CheckList);
	}

}
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="40">
		<img src="images/icons2/erase.gif" width="38" height="41" alt="" border="0">
		</td>
		<td>&nbsp;
		<b>
		View the users login report
		</b>
		</td>
	</tr>
</table>
<br>
<?php

$arrTDSizes = array("50","100","*","100","100");

RenderTable
(
	"login_log",
	array("username","ip","date","action"),
	array("User","IP","Date","Action"),
	"100%",
	"WHERE username<>'administrator' AND username<>'' ",
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category
);
?>
