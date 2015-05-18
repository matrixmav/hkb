<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}

function renderCompositeTable_Expand($strQuery,$barFields,$barNames,$barCheckBoxes,$PrimaryField,$arrTypes,$arrTitles,$arraysFields,$arraysNames){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix,$AuthUserName;global $action,$category,$ProceedCompositeTable,$Publish,$Delete,$Delivered,$Approve_Payment;global $PageSize,$PageNumber,$doNotGeneratePDFExportLink,$Pharmacy,$PAGE_SIZE;if(!isset($PageSize)){$PageSize=10;}if(!isset($PageNumber)){$PageNumber=1;}echo "<script>var strCompositeMode='Expand'; function CompositeTROver(x,trobject){if(strCompositeMode=='Frame'){var oTR=eval('document.all.CompositeTR'+x);trobject.style.background='#ffcf00';document.all.CompositeContainerTR.innerHTML='<table width=100% ><tr>'+oTR.innerHTML.replace(\"'none'\",\"'block'\")+'</tr></table>';}}function CompositeTROut(x,trobject,trcolor){if(strCompositeMode=='Frame'){trobject.style.background=trcolor;}}function ManageCompositeTR(x){var oTR=eval('document.all.CompositeTR'+x);/*if(strCompositeMode=='Frame'){document.all.CompositeContainerTR.innerHTML='<table width=100% ><tr>'+oTR.innerHTML.replace(\"'none'\",\"'block'\")+'</tr></table>';}else{*/document.all.CompositeContainerTR.innerHTML='';if(oTR.style.display=='none'){oTR.style.display='block';}else{}}function ChangeDisplayMode(x){if(x==1){document.all.divDisplayMode.innerHTML=\"Display Mode: <a href='javascript:ChangeDisplayMode(2)' style='color:#ff9e00;text-decoration:none'>Expand</a>\";strCompositeMode='Expand';}else{document.all.divDisplayMode.innerHTML=\"Display Mode: <a href='javascript:ChangeDisplayMode(1)' style='color:#ff9e00;text-decoration:none'>Frame</a>\";strCompositeMode='Frame';}}function GeneratePDF(x){var oHTML=eval('document.all.OutputHTML'+x);document.all.html.value=oHTML.value;document.all.PDF_FORM.submit();}function ChangePageSize(x){var category='$category';var action='$action';var newSize=10;if(x==0){newSize=5;}else if(x==1){newSize=10;}else if(x==2){newSize=20;}else if(x==3){newSize=50;}else if(x==4){newSize=100;}document.location.href='index.php?category=$category&action=$action&PageSize='+newSize+'';}</script>";$iTotalResults=SQLCount_Query($strQuery);if($iTotalResults==0){global $NO_PHOTO_ALBUMS_AVAILABLE ;echo "<table width=100%><tr><td class=basictext><br><i><a href=\"index.php?category=albums&action=create\">".$NO_PHOTO_ALBUMS_AVAILABLE ."</a></i></td></tr></table>";return;}mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$oDataTable=mysql_query($strQuery." LIMIT ".(($PageNumber-1)*$PageSize).",".($PageSize)."") or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());echo "<form action=index.php method=post>";echo "<input type=hidden name=action value=$action>";echo "<input type=hidden name=category value=$category>";echo "<input type=hidden name=ProceedCompositeTable value=\"\">";echo "<table width=100%><tr><td class=basictext><table><tr><td class=basicText><b>$PAGE_SIZE: </b></td><td class=basicText><select onchange='javascript:ChangePageSize(this.selectedIndex)'><option ".($PageSize==5?"selected":"").">5</option><option ".($PageSize==10?"selected":"").">10</option><option ".($PageSize==20?"selected":"").">20</option><option ".($PageSize==50?"selected":"").">50</option><option ".($PageSize==100?"selected":"").">100</option></select> </td> <td class=basictext> &nbsp;&nbsp;&nbsp;&nbsp;<b>";for($f=1;$f<=ceil($iTotalResults/$PageSize);$f++){echo "<a href='index.php?category=$category&action=$action&PageSize=$PageSize&PageNumber=$f'>$f</a>";echo "&nbsp;&nbsp;";}echo " </b> </td> </tr> </table> </td><td class=basictext align=right><b><div id=divDisplayMode style='display:none'>Display Mode: <a href='javascript:ChangeDisplayMode(1)' style='color:#ff9e00;text-decoration:none'>Frame</a></div></b></td></tr></table><br>";echo "<table celpading=2 cellspacing=0 width=100% style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>";$iRowsCounter=0;while($oRow=mysql_fetch_array($oDataTable)){$strOutputHTML="";$iRowsCounter++;echo "<tr id=CompositeHeadTR".$iRowsCounter." bgcolor=".($iRowsCounter%2==1?"#f7f7f7":"#cecfce")." height=20 nowrap onmouseover=\"javascript:CompositeTROver(".$iRowsCounter.",this)\" onmouseout=\"javascript:CompositeTROut(".$iRowsCounter.",this,'".($iRowsCounter%2==1?"#f7f7f7":"#cecfce")."')\" onclick=\"javascript:ManageCompositeTR(".$iRowsCounter.")\">";global $editOnClick;echo "<td class=oHeader ".(isset($editOnClick)?"ondblclick='document.location.href=\"index.php?category=$category&folder=$action&page=edit&id=".$oRow["id"]."\"'":"")."><b>&nbsp;&nbsp;";global $arrCountImages;for($q=0;$q<sizeof($barFields);$q++){if($barNames[$q] == "date"){global $PHP_DATE_FORMAT;echo "&nbsp;&nbsp;&nbsp;&nbsp;Last modified: ".date($PHP_DATE_FORMAT,$oRow["date"])."";}else if($barNames[$q] == "PhotosCount"){if(isset($arrCountImages[$oRow["id"]])){echo "&nbsp;&nbsp;&nbsp;&nbsp;Photos: ".$arrCountImages[$oRow["id"]];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;Photos: 0";}}else{echo $barNames[$q].": ".$oRow[$barFields[$q]];echo "&nbsp;&nbsp;";$strOutputHTML.="<b>".$barNames[$q].": ".$oRow[$barFields[$q]]."</b><br><br>";}}echo "</b></td>";echo "<td class=oHeader align=right valign='middle'>";echo "<table height=30><tr>";global $EFFACER;echo "<td class=oHeader><a href=index.php?category=$category&action=$action&del=".$oRow["id"].">[".strtoupper($EFFACER)."]</a></td>";echo "</tr></table>";if(isset($doNotGeneratePDFExportLink)){}else{echo '<a href="javascript:GeneratePDF('.$iRowsCounter.')"><img src="images/pdf.gif" border="0" width="16" height="16" alt=""></a>';}echo "</td>";echo "</tr>";echo "<tr id=CompositeTR".$iRowsCounter." style='display:block'>";echo "<td colspan=2 align=center class=basictext >";for($i=0;$i<sizeof($arrTitles);$i++){if($arrTypes[$i]=="fieldset"||$arrTypes[$i]=="sql"||$arrTypes[$i]=="sql2"){echo "<table width=700><tr><td class=basictext>";$strOutputHTML.="<br><b>".$arrTitles[$i]."</b><br><br>";

echo "<fieldset style=\"width:800px\"><legend><b><span class=basictext ><font color=#666666>".$arrTitles[$i]."</font></span></b></legend> <div  id=\"div".$iRowsCounter."".$i."\" ".(isset($editOnClick)?"onmousedown='document.location.href=\"index.php?category=$category&folder=$action&page=edit".($i+1)."&id=".$oRow["id"]."\"'":"")." onmouseover='this.style.background=\"#ffcf00\"' onmouseout='this.style.background=\"#ffffff\"'>";if($arrTypes[$i]=="fieldset"){$arrFields=$arraysFields[$i];$arrNames=$arraysNames[$i];echo "<table width=100%>";echo "<tr>";for($j=0;$j<sizeof($arrFields);$j++){if($arrFields[$j]!=""){echo "<td valign=top width=".(680/sizeof($arrFields))." align=left class=basictext >";if($arrFields[$j] == "AlbumSettings"){global $MANAGE_PARAMS;echo "[".$MANAGE_PARAMS."]";}else 

if($arrFields[$j] == "AlbumPhotos"){

if(!isset($arrCountImages[$oRow["id"]])){
global $TOTAL_N_IMAGES;echo strtolower($TOTAL_N_IMAGES).": <b>0</b>";}
else{global $TOTAL_N_IMAGES;echo strtolower($TOTAL_N_IMAGES).
": <b>".$arrCountImages[$oRow["id"]]."</b>";}
global $CLICK_HERE_MANAGE_PHOTOS;echo "<br><br>[<a href=\"index.php?category=albums&folder=list&page=edit1&id=".$oRow["id"]."\">".$CLICK_HERE_MANAGE_PHOTOS."</a>]";}
else if($arrFields[$j] == "AlbumFormat"){
global $arrAlbumFormatDescription,$M_FORMAT;echo '<table summary="" border="0" width=600> <tr><td width=50 valign=top>'.$M_FORMAT.':</td> <td width=100><img src="images/format/format_albums/'.$oRow["album_format"].'.gif" width="92" height="74" alt="" border="0"></td> <td valign=top>'.$arrAlbumFormatDescription[$oRow["album_format"]].'</td> </tr> </table>';}else if($arrFields[$j] == "HomePageFormat"){global $arrHomeAlbumFormatDescription,$M_FORMAT;echo '<table summary="" border="0" width=600> <tr><td width=50 valign=top>'.$M_FORMAT.':</td> <td width=100><img src="images/format/format_home_albums/'.$oRow["home_page_format"].'.gif" width="92" height="74" alt="" border="0"></td> <td valign=top>'.$arrHomeAlbumFormatDescription[$oRow["home_page_format"]].'</td> </tr> </table>';}else if(isset($oRow[$arrFields[$j]])){if(substr($arrFields[$j], 0 , 5) == "image"){echo $arrNames[$j].": <a href='../image.php?id=".$oRow[$arrFields[$j]]."' target=_blank><img src='../image.php?id=".$oRow[$arrFields[$j]]."' width=150 height=120 border=0></a>";}else{echo "".$arrNames[$j].($arrNames[$j]!=""?": ":" ").$oRow[$arrFields[$j]]."";}}echo "</td>";if(isset($oRow[$arrFields[$j]])){$strOutputHTML.=$arrNames[$j].": ".$oRow[$arrFields[$j]]."<br>";}}}echo "</tr>";echo "</table>";}else if($arrTypes[$i]=="sql2"){$strSubQuery=$arraysFields[$i];ereg( "@@@([A-Za-z]+)@@@", $strSubQuery, $regs );$strSubQuery=str_replace("@@@".$regs[1]."@@@",$oRow[$regs[1]],$strSubQuery);$arrSubRow=mysql_query($strSubQuery);echo "<table width=100% cellspacing=0>";$iSubRowsCounter=0;$strBGColor="";while($oSubRow=mysql_fetch_array($arrSubRow)){$iSubRowsCounter++;if(true){if($iSubRowsCounter%2==0){$strBGColor="#ffffff";}else{$strBGColor="#fff7ef";}}else{if($iSubRowsCounter%2==0){$strBGColor="#e7dfef";}else{$strBGColor="#ecdfef";}}echo "<tr bgcolor=$strBGColor height=20>";foreach($arraysNames[$i] as $strSubName){list($z1,$z2)=explode("~",$strSubName);echo "<td class=basictext>";echo $z1.": ".$oSubRow[$z2];echo "</td>";$strOutputHTML.=$oSubRow[$z2]."<br>";}echo "</tr>";}echo "</table>";}else if($arrTypes[$i]=="sql"){$strSubQuery=$arraysFields[$i];ereg( "@@@([A-Za-z]+)@@@", $strSubQuery, $regs );$strSubQuery=str_replace("@@@".$regs[1]."@@@",$oRow[$regs[1]],$strSubQuery);$arrSubRow=mysql_query($strSubQuery);echo "<table width=100% cellspacing=0>";$iSubRowsCounter=0;$strBGColor="";while($oSubRow=mysql_fetch_array($arrSubRow)){$iSubRowsCounter++;if(true){if($iSubRowsCounter%2==0){$strBGColor="#ffffff";}else{$strBGColor="#fff7ef";}}else{if($iSubRowsCounter%2==0){$strBGColor="#e7dfef";}else{$strBGColor="#ecdfef";}}echo "<tr bgcolor=$strBGColor height=20>";foreach($arraysNames[$i] as $strSubName){echo "<td class=basictext>";echo $oSubRow[$strSubName];echo "</td>";$strOutputHTML.=$oSubRow[$strSubName]."<br>";}echo "</tr>";}echo "</table>";}echo "</div></fieldset>";echo "</td></tr></table>";}}echo "</td>";echo "</tr>";echo "<input type=hidden id=OutputHTML".$iRowsCounter." name=OutputHTML".$iRowsCounter." value=\"".str_replace("\"","",$strOutputHTML)."\">";}echo "</table>";if(sizeof($barCheckBoxes)>0){echo "<br><table width=100%><tr><td align=right>";echo "<input type=submit value=\" Submit \" class=adminButton>";echo "</td></tr></table>";}echo "</form>";echo "<div id=CompositeContainerTR></div>";echo "<form id=PDF_FORM target=_blank action=pdf/generate.php method=post><input type=hidden id=html name=html value=''></form>";mysql_close();}

?>

<?php

if(get_param("del") != "")
{
	ms_i(get_param("del"));
	if(SQLCount("photo","WHERE user='$AuthUserName' AND id=".get_param("del")) > 0)
	{
		SQLQuery("DELETE FROM ".$DBprefix."photo WHERE user='$AuthUserName' AND id=".get_param("del"));
		SQLQuery("DELETE FROM ".$DBprefix."photo_images WHERE photo_id=".get_param("del"));
	}
}

$tableCountImages= DataTable_Query("SELECT count( * ) cc, photo_id
FROM ".$DBprefix."photo_images
GROUP BY photo_id");

$arrCountImages = array();

while($arrCountImage = mysql_fetch_array($tableCountImages))
{
	$arrCountImages[$arrCountImage["photo_id"]] = $arrCountImage["cc"];
}

$arrHomeAlbumFormatDescription = array();
$arrHomeAlbumFormatDescription[1] = $THUMB_ONLY;
$arrHomeAlbumFormatDescription[2] = $THUMB_DESC;
$arrHomeAlbumFormatDescription[3] = $PH_INTRODUCTION;
$arrHomeAlbumFormatDescription[4] = $NO_START_PAGE;

$arrAlbumFormatDescription = array();
$arrAlbumFormatDescription[1] = $THUMB_IND_PAGES;
$arrAlbumFormatDescription[2] = $PAGES_1_COL;
$arrAlbumFormatDescription[3] = $PAGES_2_COL;
$arrAlbumFormatDescription[4] = $NO_PAGES;

	$editOnClick = "yes";
	$doNotGeneratePDFExportLink=true;
		renderCompositeTable_Expand
		(
			"SELECT 
			id,
			home_thumbnails_columns ,
			home_thumbnails_size ,
			thumbnails_size,
			show_title,
			show_date,
			show_legende,
			show_place,
			show_description,

			album_format,
			home_page_format,
			description,
			date,
			name
			 FROM ".$DBprefix."photo WHERE user='$AuthUserName' 
			 ORDER BY id DESC",
			array("name","date","PhotosCount"),
			array($NOM,"date","PhotosCount"),
			array(),
			"id",
			array("fieldset","fieldset","fieldset","fieldset","fieldset"),
			array($M_PHOTOS,$HOME_PAGE,$M_FORMAT,$M_PARAMETERS,$M_INFORMATION),
			array
			(
				array("AlbumPhotos"),
				array("HomePageFormat"),
				array("AlbumFormat"),
				array("AlbumSettings"),
				array("description")
				
			),
			array(
				
				array($NOM),
				array($NOM),
				array($NOM),
				array($NOM),
				array($DESCRIPTION)							
			)
		);

?>
<script>
var HTType="2";
var HTMessage="<?php echo $T_ALBUMS_GENERAL;?>";
document.onmousedown = HTMouseDown;
</script>
