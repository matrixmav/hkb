<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>




<?php

if(isset($Delete))
{
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDelete("newsletter_log","id",$CheckList);
	}
}
?>

<?php
		$oCol=array("email","date","newsletter_id","status");
		$oNames=array($EMAIL,$DATE_MESSAGE,$NEWSLETTER_ID,$STATUS);

		RenderTable("newsletter_log",$oCol,$oNames,"100%","ORDER BY id desc  ","$EFFACER","id","index.php?action=$action&category=".$category);
?>
