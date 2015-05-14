<?php
include("../config.php");
include("Utils.php");
include_once("security.php");

$strCode= addslashes(str_replace("=\"../images/","=\"images/",stripslashes($strCode)));
$strCode=str_replace("border: 1px dotted rgb(191, 191, 191);","",$strCode);
$strCode=str_replace("BORDER-RIGHT: #bfbfbf 1px dotted; BORDER-TOP: #bfbfbf 1px dotted; BORDER-LEFT: #bfbfbf 1px dotted; BORDER-BOTTOM: #bfbfbf 1px dotted","",$strCode);
$strCode=str_replace("#bfbfbf 1px dotted","#bfbfbf 0px dotted",$strCode);
$strCode=str_replace("^","",$strCode);
  
 

$oPage=mysql_fetch_array(DataTable("re_users","WHERE username=$AuthUserName"));


				$HTMLCODE = $oPage['html'];	
				
				$arrI1 = explode("<body",$HTMLCODE,2);
				$arrI2 = explode(">",$arrI1[1],2);
				
				$topHTML = $arrI1[0]."<body".$arrI2[0].">";
				
				$strCode = ereg_replace("\[WSA TAG: ([a-z_]+)\]","<wsa \\1/>",$strCode);
				$strCode = $topHTML.$strCode."</body></html>";



SQLUpdate_SingleValue
		(
			"re_users",
			"username",
			"'".$AuthUserName."'",
			"template",
			$strCode
		);
		

?>

<script>
parent.pageSaved();
</script>
