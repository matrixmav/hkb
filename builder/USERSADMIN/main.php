<?php
include_once("../ADMIN/Utils.php");
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

$LANG="en";

include("../include/texts_en.php");

$HTMLCODE="";

$oPage=mysql_fetch_array(DataTable("user_pages","where  user='".$AuthUserName."' AND  id=$page"));
$HTMLCODE = $oPage['html_'.$LANG];	
$HTMLCODE = ereg_replace("<wsa ([a-z_]+)/>","[WSA TAG: \\1]",$HTMLCODE);

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

<input type=hidden  name="page" value="<?php echo($page);?>">

<input type=hidden  name="LANG" value="<?php echo($LANG);?>">


<textarea id="strCode" name="strCode" rows="15" cols="80" style="height:510px;width:1015px;background:white">

<?php echo(str_replace("=\"images/","=\"../images/", stripslashes($HTMLCODE) ));?>
	
</textarea>
</form>

</body>
</html>
