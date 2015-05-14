
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}

ms_i($id);
?>


<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>
		<b>
		<?php
		if(isset($ProceedSave))
		{
		
			SQLUpdate_SingleValue(
				"pages",
				"id",
				$id,
				"html_".$lang,
				$html
			);
			
			
			echo $VALEURS_MODFIEES_SUCCESS."<br><br>";
		}
		?>
		</b>

		<form action="index.php" method=post>
		<input type=hidden name=category value="site_management">
		<input type=hidden name=folder value="pages_pro">
		<input type=hidden name=page value="html">
		<input type=hidden name=ProceedSave >
		<input type=hidden name=id value="<?php echo $id;?>">
		<input type=hidden name=lang value="<?php echo $lang;?>">
		
		<?php
		$arrPage=DataArray("pages","id=".$id);

		?>
		
		<textarea name="html" cols="80" rows="22"><?php echo stripslashes($arrPage["html_".$lang]);?></textarea>
		
		<br><br>
		<input type=submit class=adminButton value=" <?php echo $SAUVEGARDER;?>">
		</form>
		
		</td>
	</tr>
</table>
<br><br>
<?php
generateBackLink("pages_pro");
?>
