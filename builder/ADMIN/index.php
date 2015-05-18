<?php
if(isset($_POST["Export"])||isset($_GET["doExport"])||(isset($_GET["category"])&&$_GET["category"]=="exit")||(isset($_GET["action"])&&$_GET["action"]=="exit")) ob_start();
include("../config.php");
include("Utils.php");
EnsureParams();
include("security.php");
include("../include/init.php");
include("include/page_init.php");
include("../include/texts_en.php");
include("texts_en.php");
include("pages_structure.php");
include("include/page_init2.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php //echo($ProductName);?>Web - Builder</title>
<link href="images/style.css" rel="stylesheet" type="text/css">
	<script src="include/ContextMenu.js"></script>
	<script type="text/javascript">
function noerror(){
return true
}
window.onerror=noerror;
</script>
</head>
<body leftmargin="0" topmargin="0"  bgcolor="#f9f9f9" marginheight="0" marginwidth="0">
<?php
include("include/help_tips.php");
?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  	<tr>
		<td align="center" valign="top">
		<div align="center">
			<table align="center" border="0" cellpadding="0" cellspacing="0" height="54" width="1000">
				<tbody>
				<tr>
					<td colspan="3" height="19" align="center">
						<table border="0" width="985" cellspacing="0"  height="19">
						 	<tr>
								<td align="left" valign="bottom">
							
								</td>
						 		<td align="right" valign="bottom" width="200"> 
								
									
								<?php
								if($AuthUserName == "administrator")
								{
								?>
								<a href="../index.php" target=_blank >[open the website]</a>
								<?php
								}
								?>
								
								&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?action=exit" >[<?php echo strtolower($M_LOGOUT);?>]</a>&nbsp;&nbsp;
									
									
								</td>
									
						 	</tr>
						 </table>
		
		</td>
      </tr>
      <tr>
			<td height="36" valign="top" align="right"><img src="images2/table-left.gif" alt="" height="36" ></td>
			<td background="images2/table-back.gif"><?php include("menus/main.php"); ?></td>
			<td width="23"><img src="images2/table-right.gif" alt="" height="36" width="6"></td>
		</tr>
	  
       
    </tbody>
	
	</table>
	<br><br>
	
	</td>
  </tr>
  
  <tr class="full" height="440">
    <td align="center" valign="top">      

	<table  width="1000" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top">

					<?php include_once("menus/navigation.php");?>

			</td>
		</tr>
		<tr>
			<td align="align">
			<img src="images2/gray.gif" width="980" height="1">
				
			</td>
		</tr>
		<tr>
			<td align="center"  width="1000" style="text-align:center">
				<center>
				<br>
	

<?php
	if(isset($folder))
	{
		ms_w($folder);
		ms_w($page);
	
		if(!file_exists($category."/".$folder."_".$page.".php"))
		{
			die("");
		}
		include($category."/".$folder."_".$page.".php");
	}
	else{
		ms_w($action);
		if(!file_exists($category."/".$action.".php"))
		{
			die("");
		}
		include($category."/".$action.".php");
	}
?>

	
	</CENTER>
														
			<br>
			</td>
		</tr>

	</table>
	
	<br><br>
	
	
	</td>
  </tr>
   <tr>
    <td align="center">      
	<br>
	<table class="Footer" border="0" cellpadding="0" cellspacing="0" width="1000">
        <tr>
			<td>
				<img src="images2/gray.gif" width="1000" height="1">
				<br><br>
				 <div style="float:left"> 
					&nbsp;&nbsp;<a href="http://www.urwebby.com"><?php //echo $ProductName;?>Urwebby.com</a>&nbsp; </span>
				</div>
				
				
				<div style="float:right"> 
				
				<a href="http://www.urwebby.com" target=_blank>
					<img src="images/LOGO.gif" width="124" height="70" alt="" border="0" style="position:relative;top:2px">
				</a>
				</div>
			</td>
        </tr>
     
    </table>
	
    <br>
	
	</td>
  </tr>
</tbody>
</table>
</body>

</html>

<?php
if(isset($_POST["Export"])||isset($_GET["doExport"])||(isset($_GET["category"])&&$_GET["category"]=="exit")||(isset($_GET["action"])&&$_GET["action"]=="exit")) ob_end_flush();
?>