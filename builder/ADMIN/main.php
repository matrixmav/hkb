<?php
include("../config.php");
include_once("Utils.php");
include_once("security.php");

if(!isset($page)){
	$page="0";
}

if(stristr($_SERVER['HTTP_USER_AGENT'],"MSIE"))
{
	$N="IE";
}
else
{
	$N="FF";
}

if(isset($param))
{

}
else
if(!isset($LANG)){
	echo "The language is not set!";
	exit();
}

include("texts_en.php");

$HTMLCODE="";



if(isset($editspecial))
{
	$arrItem = DataArray($type,"id=$id");
	
	$HTMLCODE = $arrItem["html"];
}
else
if(isset($param))
{

	$HTMLCODE = Parameter($param);
}
else
{
	$oPage=mysql_fetch_array(DataTable("pages","where id=$page"));
	$HTMLCODE = $oPage['html_'.$LANG];	
}

?>


<html>
<head>
<script>
function pageSaved()
{
	alert("The new content has been saved successfully!");
}
</script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">
WYSIWYG.attach('strCode', full);
</script>	

</head>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<iframe id="opIframe" name="opIframe" src="blank.html" style="position:absolute;top:0px;left:0px;visibility:hidden" width="1" height="1"> </iframe>
<form method="post"  action="savePage.php" target="opIframe">


<?php
if(isset($editspecial))
{
?>
<input type=hidden  name="type" value="<?php echo($type);?>">
<input type=hidden  name="id" value="<?php echo($id);?>">
<input type=hidden  name="editspecial" value="yes">
<?php
}
else
if(isset($param))
{
?>
<input type=hidden  name="param" value="<?php echo($param);?>">
<?php
}
else
{
?>
<input type=hidden  name="page" value="<?php echo($page);?>">
<?php
}
?>

<input type=hidden  name="LANG" value="<?php echo($LANG);?>">


<textarea id="strCode" name="strCode" rows="15" cols="80" style="height:510px;width:1015px;background:white">

<?php echo(str_replace("=\"images/","=\"../images/", stripslashes($HTMLCODE) ));?>
	
</textarea>
</form>

</body>
</html>
