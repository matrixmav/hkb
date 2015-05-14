<?php

include("Utils.php");

$DBprefix_ = $DBprefix;
if($AuthUserName != "administrator")
{
	$DBprefix = $AuthUserName . "_";
}

if(isset($editspecial))
{
		$arrItem = DataArray($type,"id=$id");
		echo(str_replace("=\"images/","=\"../images/", stripslashes($arrItem["html"]) ));

	
}
else
if(isset($param))
{
		echo(str_replace("=\"images/","=\"../images/", stripslashes(Parameter($param)) ));

}
else
{
		list($lang,$link)=explode("_",urldecode($page),2);
		
		$arrPage=DataArray("pages","link_".$lang."='".$link."'");
				
		echo(str_replace("=\"images/","=\"../images/", stripslashes($arrPage['html_'.$lang]) ));
}		

if($AuthUserName != "administrator")
{
	$DBprefix = $DBprefix_;
}

?>
