
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>



<?php
include("include/languages_menu_processing.php");
?>

<script>
function ComboIndex(combo,index)
{
	document.getElementById(combo).selectedIndex = index;
}
</script>

<?php
include("include/languages_menu.php");
			
$arrImages = array();

mysql_connect($DBHost,$DBUser,$DBPass);
mysql_select_db ($DBName);

$sql = "SELECT * FROM ".$DBprefix."image";
$result = mysql_query ($sql);

while($arrImage = mysql_fetch_array($result))
{
	array_push($arrImages, array($arrImage["image_name"],"image.php?id=".$arrImage["image_id"]));
	
}
mysql_close();


?>



<script>

function ShowHide(x){
	
	var divObject=document.getElementById("menu"+x);
	
	if(divObject.style.display=="none"){
		divObject.style.display="block";
	}
	else{
		divObject.style.display="none";
	}
	
}

</script>


<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
		<b>
		<?php echo $CONSTRUIRE_LE_MENU_PERSONNALISE;?>
		<font color=red>[<?php echo $LANG;?>]</font>
		<?php echo $DU_SITE_WEB;?>
		</b>
		</td>
	</tr>
</table>
<br><br>
<?php



function GenerateComboBox_New2($name,$contains,$folder,$selected){

		global $arrImages;

		$arrSelectedItems = explode("^",$selected);
	
	
		if(sizeof($arrSelectedItems) != 3)
		{
			$arrSelectedItems[1] = "";
			$arrSelectedItems[2] = "";
		}
		
		$strImages = "";
			
		echo "<br><br>
		<table><tr><td width=150>
		Main Image:
		</td><td>
		<select id=\"".$name."\" name=\"".$name."\">
		";
		
		foreach($arrImages as $arrImage) 
		{
			$file = $arrImage[0];
			$f_image = $arrImage[1];
			echo "<option ".($f_image==$arrSelectedItems[0]?"selected":"")." value=\"".$f_image."\">".$file."</option>";
		}
		echo "</select>  </td></tr></table> 
	
		<br>";
		
		
						echo "
						<table><tr><td width=150>
						<input type=checkbox name=".$name."_check_selected value=yes ".($arrSelectedItems[1]==""?"":"checked")."> Image - Selected:
						</td><td>
						";
						echo "<select id=\"".$name."_selected\" name=\"".$name."_selected\">";
						foreach($arrImages as $arrImage) 
						{
							$file = $arrImage[0];
							$f_image = $arrImage[1];
							echo "<option ".($f_image==$arrSelectedItems[1]?"selected":"")." value=\"".$f_image."\">".$file."</option>";
						}
						echo "</select></td></tr></table>   <br>";
						
						
						
						echo "
						<table><tr><td width=150>
						<input type=checkbox name=".$name."_check_over value=yes ".($arrSelectedItems[2]==""?"":"checked")."> Image - Mouse Over:
						</td><td>
						";
						echo "<select id=\"".$name."_over\" name=\"".$name."_over\">";
						foreach($arrImages as $arrImage) 
						{
							$file = $arrImage[0];
							$f_image = $arrImage[1];
							echo "<option ".($f_image==$arrSelectedItems[2]?"selected":"")." value=\"".$f_image."\">".$file."</option>";
						}
						echo "</select> </td></tr></table> <br>";	
		
}


function GenerateComboBox_New($name,$contains,$folder,$selected){

		$strImages = "";
		$handle=opendir($folder);
		
		echo "<select id=\"".$name."\" name=\"".$name."\">";
		
		$iFileIndex = 0;
		
		while ($file = readdir($handle)) {
			
			if($file=="."||$file==".."){
				continue;
			}
			
			if(strtolower($file)=="thumbs.db")
			{
				continue;
			}
			
			if(strstr($file,"_selected"))
			{
				continue;
			}
		
			if($contains=="*"||strtr($file,$contains))
			{
			
				$strImages .="<a href=\"javascript:ComboIndex('".$name."','".$iFileIndex."')\"><img src=\"../buttons/".$file."\" ></a> &nbsp;";
				
				
				echo "<option ".($file==$selected?"selected":"").">".$file."</option>";
			
			}
			
			$iFileIndex++;
			
		}
		
		echo "</select>  
	
		<br><br>";
		
	
		echo $strImages;
		
		closedir($handle);
}

function GenerateComboBox($name,$contains,$folder,$selected){

		$handle=opendir($folder);
		
		echo "<select id=\"".$name."\" name=\"".$name."\">";
		
		while ($file = readdir($handle)) {
			
			if($file=="."||$file==".."){
				continue;
			}
			
			if(strtolower($file)=="thumbs.db")
			{
				continue;
			}
			
			if(strstr($file,"_selected"))
			{
				continue;
			}
		
			if($contains=="*"||strtr($file,$contains)){
			
				echo "<option ".($file==$selected?"selected":"").">".$file."</option>";
			
			}
			
		}
		
		echo "</select>";
		
		closedir($handle);
}
?>

<?php
if(isset($ProceedSaveCustom)){
	$table=DataTable("pages","WHERE parent_id=0  and active_".$lang."=1");
	
	while($arrPage=mysql_fetch_array($table)){
			
			$updateString="";
			
			
			$cType = get_param("type".$arrPage["id"]);
			$cCombo = get_param("combo".$arrPage["id"]);
			$cHtml = get_param("html".$arrPage["id"]);
			
			if($cType=="none")
			{
				$updateString="";
			}
			else
			if($cType=="image")
			{
			
				$strSelected = "";
				$strOver = "";
				
				if(get_param("combo".$arrPage["id"]."_check_selected") != "")
				{
					$strSelected = get_param("combo".$arrPage["id"]."_selected");
				}

				if(get_param("combo".$arrPage["id"]."_check_over") != "")
				{
					$strOver = get_param("combo".$arrPage["id"]."_over");
				}
							
				$updateString=$cType."_".$cCombo."^".$strSelected."^".$strOver;
				
				
			}
			else{
				$updateString=$cType."_".addslashes($cHtml);
			}
			
		
			
			 SQLUpdate_SingleValue(
				"pages",
				"id",
				$arrPage["id"],
				"custom_link_".$lang,
				$updateString
			);
		
	}
	
}
?>

<form action="index.php" method="post">
<input type="hidden" name="category" value="site_management">
<input type="hidden" name="folder" value="menu">
<input type="hidden" name="page" value="construct">
<input type="hidden" name="ProceedSaveCustom">

<?php
$oTable=DataTable("pages","WHERE id>0  and active_".$lang."=1 ORDER BY parent_id,id");

echo "<table width=\"100%\"><tr><td class=basictext>";

while($oArray=mysql_fetch_array($oTable)){

	$arrCustomLink=explode("_",$oArray["custom_link_".$lang],2);

echo "
		<b>
		<a href=\"javascript:ShowHide(".$oArray["id"].")\">
		[".(stripslashes($oArray["link_".$lang])!=""?stripslashes($oArray["link_".$lang]):"Blank")."]
		</a>
		</b>
		
			<div id=menu".$oArray["id"]." style='display:none'>
			
			<br>
			
					<input type=radio class=basictext ".($oArray["custom_link_".$lang]==""?"checked":"")." value=none name=\"type".$oArray["id"]."\">
					
					<b>".strtoupper($AUCUN)."</b>
					 ";
					 
				 
					
		echo "			
					<br><br>
					<input type=radio class=basictext ".($arrCustomLink[0]=="html"?"checked":"")." value=html name=\"type".$oArray["id"]."\"> 
					
					
					
					<b>HTML</b>
					<br>
					<textarea cols=50 rows=4 name=\"html".$oArray["id"]."\"  >".($arrCustomLink[0]=="html"?stripslashes(stripslashes($arrCustomLink[1])):"")."</textarea>
					
					
					
			</div>
				<br>	<br>	
			
	";


}


echo "
	<br><br>
	<input type=submit value='         $SAUVEGARDER          ' class=adminButton>

";

echo "</td></tr></table>";

?>

</form>
<br>

<?php
generateBackLink("menu");
?>
<br>

