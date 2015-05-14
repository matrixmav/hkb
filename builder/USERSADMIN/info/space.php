<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}

MySQL_OC();

$iPagesKB = 0;$iPages = 0;
$iNotesKB = 0;$iNotes = 0;
$iCommentsKB = 0;$iComments = 0;
$iImagesKB = 0;$iImages = 0;
$iFilesKB = 0;$iFiles = 0;
$DisableSearch = true;

$tablePages = DataTable_OC("user_pages","WHERE user = '$AuthUserName'");
$iPages = mysql_num_rows($tablePages);
$iPagesKB=strlen(serialize(mysql_fetch_assoc($tablePages)))."</h1>";


$tableNotes = DataTable_OC("notes","WHERE user = '$AuthUserName'");
$iNotes = mysql_num_rows($tableNotes);
$iNotesKB=strlen(serialize(mysql_fetch_assoc($tableNotes)))."</h1>";

$tableComments = DataTable_OC("comments","WHERE user = '$AuthUserName'");
$iComments = mysql_num_rows($tableComments);
$iCommentsKB=strlen(serialize(mysql_fetch_assoc($tableNotes)))."</h1>";

$tableImages = DataTable_OC("image","WHERE user = '$AuthUserName'");

while($tableImage = mysql_fetch_array($tableImages))
{
	$iImagesKB  += $tableImage["image_size"];
}
mysql_free_result($tableImages);

$tableFiles = DataTable_OC("blog_files","WHERE user = '$AuthUserName'");

while($tableImage = mysql_fetch_array($tableFiles))
{
	$iFilesKB  += $tableImage["file_size"];
}
mysql_free_result($tableFiles);

?>
<br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<font color=#636563>
		<b>
			<?php echo $TOTAL_SPACE;?>: 
			<font >
			<?php echo round(($iPagesKB+$iNotesKB+$iCommentsKB+$iImagesKB+$iFilesKB)/1024); ?>KB
			</font>
		</b>
		</font>




		<br><br>
		<br>
		
		<font color=#636563>
		<b>
			<?php echo $M_PAGES;?>
		</b>
		</font>
		
<hr width="100%" color="#636563">
<br>
<center>
<table border="0" width="100%" cellspacing="0">
	<tr>
		<td width=50%><?php echo $M_TOTAL_NUMBER_PAGES;?>:
		
		&nbsp;
		<font color=#636563><b>
		<?php echo $iPages;?>
		</b></font>
		</td>
		<td width=50% align="right"><?php echo $M_SPACE_OCCUPIED_PAGES;?>:
		&nbsp;
		<font ><b>
		<?php echo round($iPagesKB/1024,2);?>KB
		</b></font>
		
		</td>
		
		
	</tr>
</table>
</center>




		
		
		<br><br>
		<br>
		
		<font color=#636563>
		<b>
			<?php echo $M_NOTES2;?>
		</b>
		</font>
		
<hr width="100%" color="#636563">
<br>
<center>
<table border="0" width="100%" cellspacing="0">
	<tr>
		<td width=50%><?php echo $TOTAL_N_NOTES;?>:
		
		&nbsp;
		<font color=#636563><b>
		<?php echo $iNotes;?>
		</b></font>
		</td>
		<td width=50% align="right"><?php echo $SPACE_O_NOTES;?>:
		&nbsp;
		<font ><b>
		<?php echo round($iNotesKB/1024,2);?>KB
		</b></font>
		
		</td>
		
		
	</tr>
</table>
</center>
<br><br><br>

<font color=#636563>
		<b>
			<?php echo strtoupper($COMMENTS);?>
		</b>
		</font>
		
<hr width=100% color=#636563>
<br>
<center>
<table border="0" width="100%" cellspacing="0">
	<tr>
		<td width=50%>
		<?php echo $TOTAL_NUMBER_COMMENTS;?>:
		
		&nbsp;
		<font color=#636563><b>
		<?php echo $iComments;?>
		</b></font>
		
		</td>
		<td width=50% align="right">
		<?php echo $SPACE_OCCUPIED_COMMENTS;?>:
		&nbsp;
		<font ><b>
		<?php echo round($iCommentsKB/1024,2);?>KB
		</b></font>
		
		</td>
	</tr>
</table>
</center>
<br><br><br>

<font color=#636563>
		<b>
			<?php echo $IMAGES2;?>		
		</b>
		</font>,
		<a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=images"><?php echo $M_CLICK_HERE_TO_SEE_DETAILS;?></a>
		
<hr width=100% color=#636563>
<br>
<center>
<table border="0" width="100%" cellspacing="0">
	<tr>
		<td width=50%>
		<?php echo $TOTAL_N_IMAGES;?>:
		&nbsp;
		<font color=#636563><b>
		<?php echo SQLCount_OC("image","WHERE user='$AuthUserName' ");?>
		</b></font>
		
		</td>
		<td width=50% align="right">
		<?php echo $SPACE_OCCUPIED_IMAGES;?>:
		
		&nbsp;
		<font ><b>
		<?php echo round($iImagesKB/1024,2);?>KB
		</b></font>
		
		</td>
	</tr>
</table>

<br><br>


<?php
MySQL_CC();
?>
<br>
</center>
<font color=#636563>
		<b>
			<?php echo $M_FILES2;?>		
		</b>
		</font>,
		<a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=files"><?php echo $M_CLICK_HERE_TO_SEE_DETAILS;?></a>
<center>		
<hr width=100% color=#636563>
<br>
<center>
<table border="0" width="100%" cellspacing="0">
	<tr>
		<td width=50%>
		<?php echo $TOTAL_N_FILES;?>:
		&nbsp;
		<font color=#636563><b>
		<?php echo SQLCount("blog_files","WHERE user='$AuthUserName' ");?>
		</b></font>
		
		</td>
		<td width=50% align="right">
		<?php echo $SPACE_OCCUPIED_FILES;?>:
		
		&nbsp;
		<font ><b>
		<?php echo round($iFilesKB/1024,2);?>KB
		</b></font>
		
		</td>
	</tr>
</table>

<br><br>

		</td>
	</tr>
</table>
</center>
<script>
var HTType="2";
var HTMessage="<?php echo $T_SPACE;?>";
document.onmousedown = HTMouseDown;
</script>
