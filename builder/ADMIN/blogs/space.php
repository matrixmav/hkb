<?php
$arrSpace = array();
$arrLimit = array();
$arrPackages = array();

$tablePackages = DataTable("blog_packages","");

while($tablePackage = mysql_fetch_array($tablePackages))
{
	$arrPackages[$tablePackage["id"]] = $tablePackage["space"];
}

$tableUsers = DataTable("admin_users","WHERE username <> 'administrator' ");

while($tableUser = mysql_fetch_array($tableUsers))
{
	$arrSpace[$tableUser["username"]] = 0;
	
	if(isset($arrPackages[$tableUser["plan"]]))
	{
		$arrLimit[$tableUser["username"]] = $arrPackages[$tableUser["plan"]];
	}
	else
	{
		$arrLimit[$tableUser["username"]] = 0;
	}
	

}

$tableNotes = DataTable("notes","");

while($tableNote = mysql_fetch_array($tableNotes))
{

	if (array_key_exists($tableNote["user"], $arrSpace)) 
	{
		$arrSpace[$tableNote["user"]] += strlen($tableNote["html"]);
	}
}

$tableComments = DataTable("comments","");

while($tableComment = mysql_fetch_array($tableComments))
{

	if (array_key_exists($tableComment["user"], $arrSpace)) 
	{
		$arrSpace[$tableComment["user"]] += strlen($tableComment["html"]);
	}
}


$tableImages = DataTable("image","");

while($tableImage = mysql_fetch_array($tableImages))
{

	if (array_key_exists($tableImage["user"], $arrSpace)) 
	{
		$arrSpace[$tableImage["user"]] += $tableImage["image_size"];
	}
}


$tableImages = DataTable("blog_files","");

while($tableImage = mysql_fetch_array($tableImages))
{

	if (array_key_exists($tableImage["user"], $arrSpace)) 
	{
		$arrSpace[$tableImage["user"]] += $tableImage["file_size"];
	}
}

?>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		
		
			<table summary="" border="0">
  				<tr>
  					<td width="40"><img src="images/icons2/reports.gif" width="39" height="40" alt="" border="0"></td>
  					<td><b>Space occupied by the user sites</b></td>
  				</tr>
  			</table>
  
  
		
		<br>
		
		<center>
		<table width="100%" cellspacing="0" cellpadding="2" style="border-width:1px 1px 1px 1px;border-color:#cecfce;border-style:solid">
		<?php
		
		$bFlag = true;
		arsort($arrSpace);
		foreach($arrSpace as $key=>$value)
		{
		
			$iKB= round($value/1024);
			
			$fontColor = "#de4700";
			
			if($iKB > $arrLimit[$key])
			{
							echo 
							"
								<tr height=26 bgcolor=#de4700>
							";
							
							$fontColor = "#000000";
			}
			else
			{
							echo 
							"
								<tr height=26 bgcolor=".($bFlag?"#efebef":"#ffffff").">
							";
			}
			
			echo "
				<td>&nbsp;<b>$key</b></td>
				<td width=150><font color=$fontColor><b>".$iKB."KB</b></font></td>
			</tr>
			";
			
			$bFlag = !$bFlag;
		}
		
		?>
		
		
		</table>
		</center>
		
		</td>
	</tr>
</table>
<br><br>
