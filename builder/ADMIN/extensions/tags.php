<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<script>
function DeleteTag(strTag)
{
	if(confirm("Are you sure that you want to delete this tag?"))
	{
		document.location.href="index.php?category=extensions&action=tags&ProceedDelete="+strTag;
	}
	
}
</script>
<?php

//echo "<h1>".serialize(array(array("","")))."</h1>";

if(isset($ProceedDelete))
{
	$arrTags = unserialize(aParameter(100));
	$arrNewTags = array();
	
	foreach($arrTags as $arrTag)
	{
		if(strtolower($arrTag[0]) != strtolower($ProceedDelete))
		{
			array_push($arrNewTags, $arrTag);	
		}
	}
	SetParameter(100, serialize($arrNewTags));
}
else
if(isset($ProceedAdd))
{
	$arrTags = unserialize(aParameter(100));
	array_push($arrTags, Array($tag_name,"none"));	
	SetParameter(100, serialize($arrTags));
	
}

if(isset($ProceedChange))
{
	$arrTags = Array();
	
	for($i=0;$i<sizeof($tag_name);$i++)
	{
		array_push($arrTags,Array($tag_name[$i],$file_to_use[$i]));
	}
	SetParameter(100, serialize($arrTags));
}
?>
<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
	
	<table summary="" border="0">
	 	<tr>
	 		<td class=basictext><img src="images/icons<?php echo $DN;?>/erase.gif" border="0" width="38" height="41" alt=""></td>
	 		<td class=basictext><b><?php echo $ADD_NEW_TAG;?></b></td>
	 		<td class=basictext></td>
	 	</tr>
	 </table>
	<br>
	
	<table summary="" border="0">
	 	<tr>
	 		<form action="index.php" method=post>
			<input type=hidden name=ProceedAdd>
			<input type=hidden name=category value="<?php echo $category;?>">
			<input type=hidden name=action value="<?php echo $action;?>">
			
	 		<td class=basictext><?php echo $TAG_NAME;?>:
			<br>
			<!--[One word only]-->
			</td>
	 		<td class=basictext><input type=text name="tag_name" size=20> </td>
			<td><input type=submit value=" <?php echo $AJOUTER;?> " class=adminButton></td>
			</form>
	 	</tr>
	 </table>
 
	 
	<br><br>
		<b><?php echo $LIST_CUSTOM_TAGS;?></b>
<br><br><br>
<center>
<form action="index.php" method=post>
			<input type=hidden name=ProceedChange>
			<input type=hidden name=category value="<?php echo $category;?>">
			<input type=hidden name=action value="<?php echo $action;?>">
			
<?php

$selectHTML ="<option>none</option>";
$arrFiles = array("none");
$handle=opendir('../extensions');
		
		while ($file = readdir($handle)) 
		{
		    if ($file != "." && $file != "..") 
			{
				//$selectHTML .= "<option>".$file."</option>";
				array_push($arrFiles, $file);
		   }
		}
EnsureParams();
$arrTags = unserialize(aParameter(100));

foreach($arrTags as $arrTag)
{

	if(trim($arrTag[0]) == "")
	{
		continue;
	}
	echo "
				
					<table width=700>
						<tr>
						<td class=basictext><img src=\"images/icons".$DN."/settings.gif\" border=\"0\" width=\"41\" height=\"41\" alt=\"\"></td>
							<td class=basictext width=150><b><font color=\"#1183c9\">".strtoupper($arrTag[0])."</font></b></td> 
							<td width=220><font face=Courier color=black>&lt;wsa ".$arrTag[0]."/></font></td>
							<td class=basictext>$FILE: 
							<input type=hidden name=\"tag_name[]\" value=\"".$arrTag[0]."\">
							<select name=file_to_use[]>
			";
					foreach($arrFiles as $strFile)
					{
						echo "<option ".($strFile==$arrTag[1]?"selected":"").">".$strFile."</option>";
					}						
							
			echo "		</select></td>
							<td width=30 align=right valign=middle>
							<a href=\"javascript:DeleteTag('".$arrTag[0]."')\"><img src=\"images/cancel.gif\" alt=\"delete the custom tag\" width=21 height=20 border=0></a>
							</td>
						</tr>
					</table>
					<br><br>
				
			";
			
}

if(sizeof($arrTags) < 1)
{
	echo "<font color=#ff6500><b>".$NO_CUSTOM_TAGS_AV."</b></font>";
}
?>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
			<input type=submit value=" <?php echo $SAUVEGARDER;?> " class=adminButton>		
		</td>
	</tr>
</table>


</form>
</center>
<br>
<b><?php echo $LIST_STANDART_TAGS;?></b>
<br><br>
<table summary="" border="0" width="100%">
	<tr>
		<td width=215><font face=Courier color=black>&lt;wsa title/></font></td>
		
		<td class=basictext><?php echo $TITLE_OF_THE_PAGE;?></td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;wsa description/></font></td>
		
		<td class=basictext> <?php echo $META_DESCRIPTION_PAGE;?></td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;wsa keywords/></font></td>
		
		<td class=basictext><?php echo $META_KEYWORDS_PAGE;?></td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;wsa menu/></font></td>
		
		<td class=basictext><?php echo $MAIN_N_MENU;?></td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;wsa languages_menu/></font></td>
		
		<td class=basictext><?php echo $LANGUAGES_MENU_WEBSITE;?> </td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;wsa content/></font></td>
		
		<td class=basictext><?php echo $MAIN_CONTENT_PAGE;?> </td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;wsa form/></font></td>
		
		<td class=basictext><?php echo $CUSTOM_SS_FORMS;?></td>
	</tr>
	
</table>

		</td>
	</tr>
</table>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_CUSTOM_TAGS;?>";
document.onmousedown = HTMouseDown;
</script>

