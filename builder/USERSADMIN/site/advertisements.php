<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>
<?php

$strAdv1 = "";
$strAdv2 = "";
$strAdv3 = "";
$strAdv4 = "";

if(file_exists('../include/1.htm'))
{
	 $strAdv1 = addslashes(implode('', file('../include/1.htm')));
	 
}
else
{
	$strAdv1 = aParameter(1501);
}

if(file_exists('../include/2.htm'))
{
	 $strAdv2 = addslashes(implode('', file('../include/2.htm')));
}
else
{
	$strAdv2 = aParameter(1502);
}

if(file_exists('../include/3.htm'))
{
	 $strAdv3 = addslashes(implode('', file('../include/3.htm')));
}
else
{
	$strAdv3 = aParameter(1503);
}

if(file_exists('../include/4.htm'))
{
	 $strAdv4 = addslashes(implode('', file('../include/4.htm')));
}
else
{
	$strAdv4 = aParameter(1504);
}

$str1 = "bgcolor=\"#f0f0f0\" onclick=\"document.location.href='index.php?category=".$category."&folder=".$action."&page=edit&zone=1'\" ";
$str2 = "bgcolor=\"#f0f0f0\" onclick=\"document.location.href='index.php?category=".$category."&folder=".$action."&page=edit&zone=2'\" ";
$str3 = "bgcolor=\"#f0f0f0\" onclick=\"document.location.href='index.php?category=".$category."&folder=".$action."&page=edit&zone=3'\" ";
$str4 = "bgcolor=\"#f0f0f0\" onclick=\"document.location.href='index.php?category=".$category."&folder=".$action."&page=edit&zone=4'\" ";

$arrWeblog = DataArray("weblog","user='".$AuthUserName."'");

if(trim($strAdv1) != "")
{
	$str1 = "bgcolor=\"red\"";
}
else
if(trim($arrWeblog["zone1"]) != "")
{
	$str1 = "bgcolor=\"yellow\" onclick=\"document.location.href='index.php?category=".$category."&folder=".$action."&page=edit&zone=1'\" ";
}

if(trim($strAdv2) != "")
{
	$str2 = "bgcolor=\"red\"";
}
else
if(trim($arrWeblog["zone2"]) != "")
{
	$str2 = "bgcolor=\"yellow\" onclick=\"document.location.href='index.php?category=".$category."&folder=".$action."&page=edit&zone=2'\" ";
}

if(trim($strAdv3) != "")
{
	$str3= "bgcolor=\"red\"";
}
else
if(trim($arrWeblog["zone3"]) != "")
{
	$str3 = "bgcolor=\"yellow\" onclick=\"document.location.href='index.php?category=".$category."&folder=".$action."&page=edit&zone=3'\" ";
}


if(trim($strAdv4) != "")
{
	$str4 = "bgcolor=\"red\"";
}
else
if(trim($arrWeblog["zone4"]) != "")
{
	$str4 = "bgcolor=\"yellow\" onclick=\"document.location.href='index.php?category=".$category."&folder=".$action."&page=edit&zone=4'\" ";
}




?>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td>
		<img src="images/icons/saving.png" width="48" height="48" alt="" border="0">
		</td>
  		<td class="blog_admin_header">
		
		
		<?php echo $M_ADVERTISMENTS_MANAGEMENT;?>
		
		
		</td>
  	</tr>
  </table>
	
	<table summary="" border="0" width="100%">
	<tr>
		<td>
		<br>
		<i><?php echo $M_PLEASE_CLICK_ADV;?>:</i>
		<br><br>
		
		<center>
		
	<table summary="" border="0" width="450">
  	<tr>
  		<td height="60" <?php echo $str1;?> align="center">
		
			<span style="font-size:36px;color:#0175b8">1</span>
		
		</td>
  	</tr>
  	<tr>
  		<td>
		
		<br>
		<table border="0" width="100%" height="190" cellpadding="0" cellspacing="0">
				  	<tr>
						<td <?php echo $str4;?> width="80" align="center">
						
								<span style="font-size:36px;color:#0175b8">4</span>
						
						</td>
				 
				  		<td width="20">&nbsp;</td>
				  		<td bgcolor="#dee2eb" align="center">
						
								<span style="font-size:36px;color:#0175b8"><?php echo strtoupper($M_BLOG);?></span>
						
						</td>
				  		<td width="20">&nbsp;</td>
				  	 	<td <?php echo $str2;?> width="80" align="center">
						
							<span style="font-size:36px;color:#0175b8">2</span>
						
						</td>
				  	</tr>
				  </table>
		
		<br>
		
		
		</td>
  	</tr>
  	<tr>
  		<td height="60" <?php echo $str3;?> align="center">
		
				<span style="font-size:36px;color:#0175b8">3</span>
		
		</td>
  	</tr>
  </table>
		
		</center>
		
		
		</td>
	</tr>
</table>
