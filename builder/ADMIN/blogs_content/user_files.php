<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
if(isset($Delete))
{
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDelete("blog_files","file_id",$CheckList);
	}
	
	
	foreach($CheckList as $id)
	{
		foreach($file_types as $file_type)
		{
			if(file_exists("../uploaded_files/".$id.".".$file_type[1])) 
			{
					
					unlink("../uploaded_files/".$id.".".$file_type[1]);
					
			}
		}
	}
	
}
?>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td width="45">
		<img src="images/icons2/email.gif" width="40" height="34" alt="" border="0">
		</td>
		<td>
		<b>Manage the files uploaded by the users</b>
		</td>
	</tr>
</table>
<br>


<br>

<?php


RenderTable
(
	"blog_files",
	array("user","file_name","file_date","file_size","file_id"),
	array("User",$NOM,$DATE_MESSAGE,$SIZE,"File"),
	"100%",
	"WHERE user<>'' AND user<>'administrator' ORDER BY file_id DESC",
	$EFFACER,
	"file_id",
	"index.php?action=".$action."&category=".$category
);
?>


