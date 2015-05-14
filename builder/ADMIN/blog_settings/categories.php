<table summary="" border="0" width="100%">
	<tr>
		<td width="48">
		<img src="images/icons2/email.gif" width="40" height="34" alt="" border="0">
		</td>
		<td>
		
			<b>Website Categories</b>
		
		</td>
	</tr>
</table>
<?php
include("include/languages_menu_processing.php");
?>
<?php
include("include/languages_menu.php");
?>



<form action="index.php" method="post">
<input type="hidden" name="category" value="<?php echo $category;?>">

<input type="hidden" name="action" value="<?php echo $action;?>">
<input type="hidden" name="ProceedSend" value="1">

<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
<?php
if(isset($ProceedSend))
{
	$handle = fopen('../include/categories_'.$lang.'.php', 'w');
	fwrite($handle, trim($cats));
	 fclose($handle);
}
	
$code = "";

if(file_exists('../include/categories_'.$lang.'.php'))
{
		
	$lines = file('../include/categories_'.$lang.'.php');
	
	foreach ($lines as $line_num => $line) 
	{
		
			$code .= $line;
		
	}

	?>

	
	<br>
	<textarea name="cats" cols="90" rows="20"><?php echo $code;?></textarea>
	
	
	
	<?php

}
				


?>
<br><br>
<input type="submit" class="adminButton" value=" Save "> 
</form>



</td>
	</tr>
</table>
