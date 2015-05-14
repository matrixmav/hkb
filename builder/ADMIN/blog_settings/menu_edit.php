<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>




<script>

function ShowHide(x){
	

	
	if(document.getElementById("menu"+x).style.display=="none"){
		document.getElementById("menu"+x).style.display="block";
	}
	else{
		document.getElementById("menu"+x).style.display="none";
	}
	
}

</script>


<table summary="" border="0" width="100%">
	<tr>
		<td width=49>
		<img src="images/icons<?php echo $DN;?>/tools.gif" border="0" width="45" height="43" alt="">
		</td>
		<td class=basictext>
		<b><?php echo $MENU_CREATION;?></b>	
		</td>
	</tr>
</table>
<br>

<?php

function GenerateComboBox($name,$contains,$folder,$selected)
{

		$handle=opendir($folder);
		
		echo "<select name=\"".$name."\">";
		
		while ($file = readdir($handle)) {
			
			if($file=="."||$file==".."){
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
if(isset($ProceedSaveCustom))
{
	$table=DataTable("languages","");
	
	while($arrPage=mysql_fetch_array($table)){
			
			$updateString="";
		
			
			$cCombo=get_param("combo".$arrPage["id"]);
			$cHtml=get_param("html".$arrPage["id"]);
			$cType=get_param("type".$arrPage["id"]);
			
			if($cType == "")
			{
				$cType = "none";
			}
			
			if($cType=="none"){
				$updateString="";
			}
			
			else{
				$updateString=$cType."_".addslashes($cHtml);
			}
						
			 SQLUpdate_SingleValue(
				"languages",
				"id",
				$arrPage["id"],
				"html",
				$updateString
			);
		
	}
	
	$HISTORY=$A_NEW_CUSTOM_MENU_SAVED;
	
}
?>

<form action=index.php method=post>
<input type=hidden name=category value=<?php echo $category;?>>
<input type=hidden name=folder value=menu>
<input type=hidden name=page value=edit>
<input type=hidden name=ProceedSaveCustom>

<?php
$oTable=DataTable("languages","");

echo "<table width=\"100%\"><tr><td class=basictext>";

while($oArray=mysql_fetch_array($oTable)){

	$arrCustomLink=explode("_",$oArray["html"],2);

	echo "
		<b><br>
		<a href=\"javascript:ShowHide(".$oArray["id"].")\">
		[".stripslashes($oArray["name"])."]</font>
		</a>
		</b>
		
			<div id=menu".$oArray["id"]." >
			
			<br><br>
			
			
					<input type=radio class=basictext checked value=html name=\"type".$oArray["id"]."\"> 
					
					HTML
					<input type=text size=60 name=\"html".$oArray["id"]."\" value=\"".($arrCustomLink[0]=="html"?$arrCustomLink[1]:"")."\">
					<br>
			</div>
				<br>
			
	";

}

echo "
	
	<input type=submit value=' $SAUVEGARDER ' class=adminButton>

";

echo "</td></tr></table>";

?>

</form>


<?php
generateBackLink("menu");
?>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_LANGUAGES_MENU;?>";
document.onmousedown = HTMouseDown;
</script>


