<?php
include("../config.php");
include("security.php");
include("../ADMIN/Utils.php");
include("../include/texts_en.php");

if(stristr($_SERVER['HTTP_USER_AGENT'],"MSIE"))
{
	$IE=true;
}
else
{
	$IE=false;
}

EnsureParams();
if(aParameter(60) == "NO")
{
				echo 
				"<style>
				td{font-family:".aParameter(61).";font-size:".aParameter(62)."px;color:".aParameter(63)."}
				a:link{color:".aParameter(64)."}
				a:visited{color:".aParameter(65)."}
				a:hover{color:".aParameter(66)."}
				h1,h2,h3,h4,h5,h6{color:".aParameter(67)."}
				</style></head>";
}
$IE = true;

$LANG = $lang="en";
$DN=2;

if(isset($pd_edit_id))
{
//pd edit
				$id = $pd_edit_id;
				$HideFormFlag=false;
				$oArr=DataArray("user_pages"," id=$id AND user='".$AuthUserName."' ");
				
				if(!isset($oArr["id"]))
				{
					die("");
				}
								
				if(isset($Proceed)){
				
				
				
				if(isset($extension) && $extension =="NONE")
				{
					if(substr($oArr["html_".$lang] ,0,14) == "wsa:extension:")
					{
						SQLUpdate_SingleValue(
								"user_pages",
								"id",
								$id,
								"html_".strtolower($lang),
								""
							);
						}
				}
				
				
					$arrNames=array("active_".strtolower($LANG),"name_".strtolower($LANG),"description_".strtolower($LANG),"keywords_".strtolower($LANG),"link_".strtolower($LANG));
					$arrValues=array($active,$pName,$pDescription,$pKeywords,$pLink);
					SQLUpdate("user_pages",$arrNames,$arrValues," id=$id");
					$HideFormFlag=true;
					
				}
				?>
				
			
				
				<?php
				if($HideFormFlag){
				?>
				<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0">
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
				<form action="pgs.php" method="post">
				<input type="hidden" name="pd_edit_id" value="<?php echo $id;?>">

				<table border="0" cellspacing="6">
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
						<td class=basictext valign=top><b><?php echo $str_PageDescriptionPage;?></b></td>
						<td class=basictext>
						<textarea name="pDescription" cols="50" rows="5"><?php echo stripslashes($oArr['description_'.$lang]);?></textarea>
				  
						</td>
					</tr>
					<tr>
						<td class=basictext valign=top><b><?php echo $str_PageKeywordsPage;?></b></td>
						<td class=basictext>
						<textarea name="pKeywords" cols="50" rows="5"><?php echo stripslashes($oArr['keywords_'.$lang]);?></textarea>
				  
						</td>
					</tr>
				
				</table>
				
				<table summary="" border="0" >
					<tr>
						<td class=basictext>
				
				
				<input type="hidden" name="Proceed" value="1">
				<input type="submit" class="adminButton" value="<?php echo $SAUVEGARDER;?>">
						</td>
					</tr>
				</table>
				</form>
				<?php
				}
				?>
				
				<br>
				
				<a href="pgs.php">Go Back</a>
				
				<?php
				
				


//end pg edit
}
else
{




include("../include/user_default_pages.php");

if(SQLCount("user_pages","WHERE user='".$AuthUserName."'") == 0)
{
	foreach($arrDefaultPages as $arrDefaultPage)
	{
		SQLInsert
		(
			"user_pages",
			array("name_en","link_en","html_en","user"),
			array($arrDefaultPage[0],$arrDefaultPage[0],$arrDefaultPage[1],$AuthUserName)
		);
	}
}

if(!isset($MMODE))
{
$MMODE="N";
$bFirstTime=true;
}
else
{
$bFirstTime=false;
}

if(isset($ProceedDeletePage))
{
	ms_i($id);
	SQLQuery("DELETE from ".$DBprefix."user_pages WHERE id='".$id."' AND user='".$AuthUserName."'");
	
}

?>

<?php
if($MMODE=="N")
{
?>
<!-- start normal mode -->

<?php
include("site/sample_content.php");

if(isset($ProceedCMD))
{

	if(substr($cmd1,0,3) == "new" && substr($cmd2,0,2) == "ns")
	{

		$iMaxPage = SQLMaxPlus(
				"user_pages",
				"id",
				"user='".$AuthUserName."' "
			);

		$strPageHtml = $sampleHTML[str_replace("new_page","",$cmd1)];

		$arrNames=array("user","active_".$lang,"parent_id","name_".$lang,"description_".$lang,"keywords_".$lang,"link_".$lang,"html_".$lang);

		$arrValues=array(($AuthUserName=="administrator"?"admin":$AuthUserName),"1",str_replace("ns","",$cmd2),"Page","","","Page ".$iMaxPage,$strPageHtml);
		

		SQLInsert("user_pages",$arrNames,$arrValues);

		

	}

	else
	if(substr($cmd1,0,3) == "new" && substr($cmd2,0,2) == "np")
	{
		$iMaxPage = SQLMaxPlus(
				"user_pages",
				"id",
				"user='".$AuthUserName."' "
			);

			$strPageHtml = $sampleHTML[str_replace("new_page","",$cmd1)];

		$arrNames=array("user","active_".$lang,"parent_id","name_".$lang,"description_".$lang,"keywords_".$lang,"link_".$lang,"html_".$lang);

		$arrValues=array(($AuthUserName=="administrator"?"admin":$AuthUserName),"1","0","Page","","","Page ".$iMaxPage,$strPageHtml);
		

		SQLInsert("user_pages",$arrNames,$arrValues);

	
	}
	else
	if(substr($cmd1,0,2) == "pg" && substr($cmd2,0,2) == "ns")
	{
		$arrPage1 = DataArray("user_pages","id=".str_replace("pg","",$cmd1));
               
		if($arrPage1["parent_id"]=="0")
		{
			
			//echo '<script>HT("2","'.$M_OPERATION_NOT_ALLOWED.'<br>",700,130,0.5,20);</script>';
		}
		else
		{
			$strNewParentId = str_replace("ns","",$cmd2);

			SQLUpdate("user_pages",array("parent_id"),array($strNewParentId),"id=".$arrPage1["id"]);
		}
	}
	else
	if(substr($cmd1,0,2) == "pg" && substr($cmd2,0,2) == "pg")
	{
		$arrPage1 = DataArray("user_pages","id=".str_replace("pg","",$cmd1));
		$arrPage2 = DataArray("user_pages","id=".str_replace("pg","",$cmd2));


		if($arrPage1["parent_id"]==0&&$arrPage2["parent_id"]!=0)
		{
			
			//echo '<script>HT("2","'.$M_OPERATION_NOT_ALLOWED.'<br>",700,130,0.5,20);</script>';
		}
		else
		if($arrPage2["parent_id"]==0&&$arrPage1["parent_id"]!=0)
		{
			
			//echo '<script>HT("2","'.$M_OPERATION_NOT_ALLOWED.'<br>",700,130,0.5,20);</script>';
		}
		else
		if($arrPage1["parent_id"]!=$arrPage2["parent_id"]&&$arrPage1["parent_id"]!="0"&&$arrPage2["parent_id"]!="0")
		{
			$val1=$arrPage1["id"];
			$val2=$arrPage2["id"];
			SQLUpdate("user_pages",array("id"),array("0"),"id=$val1");
			SQLUpdate("user_pages",array("id"),array($val1),"id=$val2");
			SQLUpdate("user_pages",array("id"),array($val2),"id=0");
			SQLUpdate("user_pages",array("parent_id"),array("-2"),"parent_id=$val1");
			SQLUpdate("user_pages",array("parent_id"),array($val1),"parent_id=$val2");
			SQLUpdate("user_pages",array("parent_id"),array($val2),"parent_id=-2");
		}
		else
		if($arrPage1["parent_id"]==$arrPage2["parent_id"])
		{
			$val1=$arrPage1["id"];
			$val2=$arrPage2["id"];
			SQLUpdate("user_pages",array("id"),array("0"),"id=$val1");
			SQLUpdate("user_pages",array("id"),array($val1),"id=$val2");
			SQLUpdate("user_pages",array("id"),array($val2),"id=0");

			SQLUpdate("user_pages",array("parent_id"),array("-2"),"parent_id=$val1");
			SQLUpdate("user_pages",array("parent_id"),array($val1),"parent_id=$val2");
			SQLUpdate("user_pages",array("parent_id"),array($val2),"parent_id=-2");
		}
		else
		{
		
			//echo '<script>HT("2","'.$M_OPERATION_NOT_ALLOWED.'<br>",700,130,0.5,20);</script>';
		}

	}

}
?>
<script>
var accZ = 0;
var arrDrawnObjects = Array();
</script>
<style>
	#root {
		position:absolute;
		height:285px;
		width:150px;
		background-color:#F4F4F4;
		border:1px solid #000000;
		}
</style>

<form action="pgs.php" method="post" id="cmd_form">
<input type=hidden id="cmd1" name="cmd1" value="">
<input type=hidden id="cmd2" name="cmd2" value="">
<input type=hidden name="ProceedCMD" value="">
</form>
<script language="javascript" src="include/utils.js"></script>

<script>
function DeletePage(x)
{
	if(confirm("<?php echo $ETES_VOUS_SUR__DE_VOULOIR_EFFACER;?>")){
		document.location.href="pgs.php?ProceedDeletePage=1&category=site_management&MMODE=<?php echo $MMODE;?>&action=pages&id="+x;
	}

}

function StartWizard(x){
	window.open("main.php?N="+(document.all?"IE":"FF")+"&LANG=<?php echo $lang;?>&page="+x,"title","toolbar=0,status=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}



var iZXStartX = 0;
var iZXStartY = 0;
var strZXElementName = "";

	function reportZXStart(who, x, y)
	{
			strZXElementName = who;
			iZXStartX = x;
			iZXStartY = y;
	}

	function reportZXEnd(who, x, y) {

				bOperation = false;


				if(who.substring(0,3) == "new")
				{
					x = x + parseInt(document.getElementById("root").style.left.replace("px",""));
					y = y + parseInt(document.getElementById("root").style.top.replace("px",""));
				}

				var i=0;
				
				toshow="";
				for(;i<arrDrawnObjects.length;i++)
				{
					//toshow+=arrDrawnObjects[i][0]+" "+(parseInt(arrDrawnObjects[i][1])-15)+"@"+(parseInt(arrDrawnObjects[i][1])+parseInt(arrDrawnObjects[i][3])+0)+" "+(parseInt(arrDrawnObjects[i][2])-15)+"@"+(parseInt(arrDrawnObjects[i][2])+parseInt(arrDrawnObjects[i][4])+0)+"\n";
					  if(
							x>(parseInt(arrDrawnObjects[i][1])-15)
							&&
							x<(parseInt(arrDrawnObjects[i][1])+parseInt(arrDrawnObjects[i][3])+0)
							&&
							y>(parseInt(arrDrawnObjects[i][2])-15)
							&&
							y<(parseInt(arrDrawnObjects[i][2])+parseInt(arrDrawnObjects[i][4])+0)
					  )
					  
					{

						bOperation = true;
						break;
					}
				}

				//alert(x+" "+y+"\n\n"+toshow);
				
				bSpecialOperation = false;

				if(bOperation)
				{

					if(who == "trash" || arrDrawnObjects[i][0] == "trash")
					{
							pageId = "";

						if(who == "trash")
						{
							pageId = arrDrawnObjects[i][0];
						}
						else
						if(arrDrawnObjects[i][0] == "trash")
						{
							pageId = who;
						}

						bSpecialOperation = true;

						if(pageId.substring(0,2) == "pg")
						{
								pageId = pageId.replace("pg","");
								DeletePage(pageId);
						}
						else
						{
						
								<?php
								//echo 'HT("2","'.$M_OPERATION_NOT_ALLOWED.'<br>",700,130,0.5,20);';
								?>
								return;
						}
					}
					else
					if(who == "edit" || arrDrawnObjects[i][0] == "edit")
					{
					
					
						pageId = "";

						if(who == "edit")
						{
							pageId = arrDrawnObjects[i][0];
						}
						else
						if(arrDrawnObjects[i][0] == "edit")
						{
							pageId = who;
						}

						bSpecialOperation = true;

						if(pageId.substring(0,2) == "pg")
						{
								pageId = pageId.replace("pg","");
								StartWizard(pageId);
						}
						else
						{
						
								<?php
								//echo 'HT("2","'.$M_OPERATION_NOT_ALLOWED.'<br>",700,130,0.5,20);';
								?>
								return;
						}
					}
					else
					if(who == "preview" || arrDrawnObjects[i][0] == "preview")
					{
						pageId = "";

						if(who == "preview")
						{
							pageId = arrDrawnObjects[i][0];
						}
						else
						if(arrDrawnObjects[i][0] == "preview")
						{
							pageId = who;
						}

						bSpecialOperation = true;

						if(pageId.substring(0,2) == "pg")
						{
								pageId = pageId.replace("pg","");
								
								window.open("../site.php?user=<?php echo $AuthUserName;?>&page_id="+pageId);
								//,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=1,width=1015,height=640,left=0,top=0");					
						}
						else
						{
						
								<?php
								//echo 'HT("2","'.$M_OPERATION_NOT_ALLOWED.'<br>",700,130,0.5,20);';
								?>
								return;
						}
					}
					else
					if(who == "settings" || arrDrawnObjects[i][0] == "settings")
					{
						pageId = "";

						if(who == "settings")
						{
							pageId = arrDrawnObjects[i][0];
						}
						else
						if(arrDrawnObjects[i][0] == "settings")
						{
							pageId = who;
						}

						//bSpecialOperation = true;

						if(pageId.substring(0,2) == "pg")
						{
								pageId = pageId.replace("pg","");
								
								document.location.href="pgs.php?pd_edit_id="+pageId;
						}
						else
						{
						
								<?php
								//echo 'HT("2","'.$M_OPERATION_NOT_ALLOWED.'<br>",700,130,0.5,20);';
								?>
								return;
						}


					}
					else
					{
						document.getElementById("cmd1").value=who;
						document.getElementById("cmd2").value=arrDrawnObjects[i][0];

						if(who != arrDrawnObjects[i][0])
						{
							document.getElementById("cmd_form").submit();
						}
					}

				}
				else
				{
				
				
				}

				if(bSpecialOperation)
				{
					document.getElementById(strZXElementName).style.left = iZXStartX;
					document.getElementById(strZXElementName).style.top = iZXStartY;
					
				}

				
	}

</script>

<style>
#pg14{}
#pg14_handle{}
</style>
 


<div style="position:absolute;top:40px;left:0px">

<img style="z-index:5000;position:relative;top:-55px;left:95px" src="../images/site-explanation.png" width="400" height="80">

<div style="position:absolute;top:-40px;left:720px" id="trash">
<img src="images/new_icons/delete<?php echo $DN;?>.gif" border="0" width="26" height="41" alt="">
</div>
<div style="position:absolute;top:-40px;left:480px" id="edit">
<img src="images/new_icons/edit<?php echo $DN;?>.gif" border="0" width="43" height="43" alt="">
</div>
<div style="position:absolute;top:-40px;left:840px" id="preview">
<img src="images/new_icons/preview<?php echo $DN;?>.gif" border="0" width="31" height="38" alt="">
</div>
<div style="position:absolute;top:-40px;left:600px" id="settings">
<img src="images/new_icons/settings<?php echo $DN;?>.gif" border="0" width="40" height="41" alt="">
</div>

<script>
var oTrash = document.getElementById('trash');
ZX.init(oTrash);
oTrash.onZXStart = function(x, y) { reportZXStart('trash', x, y); }
oTrash.onZXEnd = function(x, y) { reportZXEnd('trash', x, y); }
arrDrawnObjects.push(Array("trash",650,-40,26,41));

var oEdit = document.getElementById('edit');
ZX.init(oEdit);
oEdit.onZXStart = function(x, y) { reportZXStart('edit', x, y); }
oEdit.onZXEnd = function(x, y) { reportZXEnd('edit', x, y); }
arrDrawnObjects.push(Array("edit",350,-40, 43, 43));

var oPreview = document.getElementById('preview');
ZX.init(oPreview);
oPreview.onZXStart = function(x, y) { reportZXStart('preview', x, y); }
oPreview.onZXEnd = function(x, y) { reportZXEnd('preview', x, y); }
arrDrawnObjects.push(Array("preview",800,-40, 31, 38));

var oSettings = document.getElementById('settings');
ZX.init(oSettings);
oSettings.onZXStart = function(x, y) { reportZXStart('settings', x, y); }
oSettings.onZXEnd = function(x, y) { reportZXEnd('settings', x, y); }
arrDrawnObjects.push(Array("settings",500,-40,40,41));

</script>

<?php

$arrPages = DataTable("user_pages","WHERE parent_id=0 AND user='".($AuthUserName=="administrator"?"admin":$AuthUserName)."'  ORDER BY parent_id,id");

$iPagesCounter = 0;
$userpages = 5;
while($arrPage = mysql_fetch_array($arrPages))
{

	echo "
		<div  style='width:61px;position:absolute;top:".(0 + ($iPagesCounter*90))."px;left:40px;font-family:Arial;font-size:11px'>
			<img src='images/page_icon9.gif' border='0'  width='67' height='51'  >
		</div>
	";

	echo "
		<div id=\"pg".$arrPage["id"]."\" style='width:61px;position:absolute;top:".(0 + ($iPagesCounter*90))."px;left:40px;font-family:Arial;font-size:11px;text-align: center;'>
			<img src='images/page_icon".($arrPage["active_".$lang]==1?"7_2":"9").".gif' border='0'  width='67' height='51'  >
			
			<span style='position:relative;top:-40px'>".$arrPage["link_".$lang]."</span>
		</div>
	";

	echo "
		<script>arrDrawnObjects.push(Array('pg".$arrPage["id"]."',36,".(0 + ($iPagesCounter*90)).",67,51));</script>
	";

	echo
	"
	<script>
		var theHandle".$arrPage["id"]." = document.getElementById('pg".$arrPage["id"]."');\n
		ZX.init(theHandle".$arrPage["id"].");\n
		theHandle".$arrPage["id"].".onZXStart = function(x, y) { reportZXStart('pg".$arrPage["id"]."', x, y); }\n
		theHandle".$arrPage["id"].".onZXEnd = function(x, y) { reportZXEnd('pg".$arrPage["id"]."', x, y); }\n
	</script>
	";

	$arrSubPages = DataTable("user_pages","WHERE  user='".$AuthUserName."' AND  parent_id=".$arrPage["id"]." ORDER BY parent_id,id");

	$iSubPagesCounter = 0;

	while($arrSubPage = mysql_fetch_array($arrSubPages))
	{

		echo "
			<div  style='width:61px;position:absolute;top:".(40 + ($iPagesCounter*90))."px;left:".(174+$iSubPagesCounter*100)."px;font-family:Arial;font-size:11px'>
				<img src='images/page_icon9.gif' border='0'  width='67' height='51'  >
			</div>
		";

		echo "
			<div id=\"pg".$arrSubPage["id"]."\"  style='width:61px;position:absolute;top:".(40 + ($iPagesCounter*90))."px;left:".(174+$iSubPagesCounter*100)."px;font-family:Arial;font-size:11;text-align:center'>
				<img src='images/page_icon".($arrSubPage["active_".$lang]==1?"8":"9").".gif' border='0' width='67' height='51' ondblclick='document.location.href=\"pgs.php?MMODE=".$MMODE."\"'>
				
				<span style='position:relative;top:-40px'>".$arrSubPage["link_".$lang]."</span>
			</div>
		";

		
		echo "
			<script>arrDrawnObjects.push(Array('pg".$arrSubPage["id"]."',".(174+$iSubPagesCounter*95).",".(40 + ($iPagesCounter*90)).",67,51));</script>
		";
		

		echo
		"
		<script>
			var theHandle".$arrSubPage["id"]." = document.getElementById('pg".$arrSubPage["id"]."');\n
			ZX.init(theHandle".$arrSubPage["id"].");\n
			theHandle".$arrSubPage["id"].".onZXStart = function(x, y) { reportZXStart('pg".$arrSubPage["id"]."', x, y); }\n
			theHandle".$arrSubPage["id"].".onZXEnd = function(x, y) { reportZXEnd('pg".$arrSubPage["id"]."', x, y); }\n
		</script>
		";

		$iSubPagesCounter++;

	}

	echo "
			<div  style='width:61px;position:absolute;top:".(40 + ($iPagesCounter*90))."px;left:".(174+$iSubPagesCounter*100)."px;font-family:Arial;font-size:11'>
				<img src='images/page_icon9.gif' border='0'  width='67' height='51'  >
				<br>
				<span style='position:relative;top:".($IE?"-55":"-40")."'></span>
			</div>
		";

		echo "
			<script>arrDrawnObjects.push(Array('ns".$arrPage["id"]."',".(174+$iSubPagesCounter*100).",".(40 + ($iPagesCounter*90)).",67,51));</script>
		";

	$iSubPagesCounter++;





	if($iSubPagesCounter > 0)
	{
	//
		echo
		'
			<img src="images/h_line_icon2.gif" border="0" width="1001" height="22" alt="" style="position:absolute;top:'.(18 + ($iPagesCounter*90)).';left:105px;clip:rect(auto '.(1+$iSubPagesCounter * 100 ).'px auto auto)">
		';
	}


	$iPagesCounter ++;
}
mysql_free_result($arrPages);
mysql_free_result($arrSubPages);

	echo "
		<div  style='width:61px;position:absolute;top:".(0 + ($iPagesCounter*90))."px;left:40px;font-family:Arial;font-size:11'>
			<img src='images/page_icon9.gif' border='0'  width='67' height='51'  >
		</div>
	";

	echo "
			<script>arrDrawnObjects.push(Array('np',36,".(0 + ($iPagesCounter*90)).",67,51));</script>
		";
	$iPagesCounter ++;
?>


<br><br>

<br><br>

<?php
if($IE)
{
?>
<img src="images/v_line_icon.gif" border="0" width="22" height="3000" alt="" style="position:absolute;top:20px;left:19px;clip:rect(auto auto <?php echo (0+$iPagesCounter*90 - 88);?>px auto)">

<?php
}
else{
?>
<img src="images/v_line_icon.gif" border="0" width="22" height="3000" alt="" style="position:absolute;top:20px;left:19px;clip:rect(0px,10px,<?php echo (0+$iPagesCounter*90 - 88);?>px,22px)">

<?php
}

 
if($iPagesCounter < 5)
{?>
<div id="root" style="left:715px; top:40px;">
	<table border="0" id="handle" height="10" width="100%" cellpadding="0" cellspacing="0">
 	<tr>
 		<td class="table_header" align="center" style="font-family:Arial;font-size:12px;" background="images/subhead_bg.gif"><center><b><?php echo $M_ADD_NEW_PAGE;?></b>&nbsp;</center></td>
 	</tr>
 </table>

	 <div id=new_page1 style="position:absolute;top:25px;left:4px;text-align:center;width:67px;height:51px">
	<img src="images/page_icon_t3.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page2 style="position:absolute;top:25px;left:77px;text-align:center;width:67px;height:51px">
	<img src="images/page_icon_t4.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page3 style="position:absolute;top:81px;left:4px;text-align:center;width:67px;height:51px">
	<img src="images/page_icon_t1.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page4 style="position:absolute;top:81px;left:77px;text-align:center;width:67px;height:51px">
	<img src="images/page_icon_t2.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page5 style="position:absolute;top:137px;left:4px;text-align:center;width:67px;height:51px">
	<img src="images/page_icon_t5.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page6 style="position:absolute;top:137px;left:77px;text-align:center;width:67px;height:51px">
	<img src="images/page_icon_t6.gif" border="0" width="67" height="51" alt="">

	</div>
	<div  style="position:absolute;top:196px;left:4px;text-align:justify;width:139px;height:51px;font-size:11px;font-family:Arial">
		<?php echo $M_PAGES_NOTICE;?>

	</div>

</div>
<?php }?>
<script>
var oNewPage1 = document.getElementById('new_page1');
ZX.init(oNewPage1);
oNewPage1.onZXStart = function(x, y) { reportZXStart('new_page1', x, y); }
oNewPage1.onZXEnd = function(x, y) { reportZXEnd('new_page1', x, y); }

var oNewPage2 = document.getElementById('new_page2');
ZX.init(oNewPage2);
oNewPage2.onZXStart = function(x, y) { reportZXStart('new_page2', x, y); }
oNewPage2.onZXEnd = function(x, y) { reportZXEnd('new_page2', x, y); }

var oNewPage3 = document.getElementById('new_page3');
ZX.init(oNewPage3);
oNewPage3.onZXStart = function(x, y) { reportZXStart('new_page3', x, y); }
oNewPage3.onZXEnd = function(x, y) { reportZXEnd('new_page3', x, y); }

var oNewPage4 = document.getElementById('new_page4');
ZX.init(oNewPage4);
oNewPage4.onZXStart = function(x, y) { reportZXStart('new_page4', x, y); }
oNewPage4.onZXEnd = function(x, y) { reportZXEnd('new_page4', x, y); }

var oNewPage5 = document.getElementById('new_page5');
ZX.init(oNewPage5);
oNewPage5.onZXStart = function(x, y) { reportZXStart('new_page5', x, y); }
oNewPage5.onZXEnd = function(x, y) { reportZXEnd('new_page5', x, y); }

var oNewPage6 = document.getElementById('new_page6');
ZX.init(oNewPage6);
oNewPage6.onZXStart = function(x, y) { reportZXStart('new_page6', x, y); }
oNewPage6.onZXEnd = function(x, y) { reportZXEnd('new_page6', x, y); }

var theHandle = document.getElementById("handle");
var theRoot   = document.getElementById("root");
ZX.init(theHandle, theRoot);
</script>

</div>

<!-- end normal mode -->
<?php
}
}
?>