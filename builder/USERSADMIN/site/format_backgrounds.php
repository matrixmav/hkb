<?php
if(isset($Proceed))
{

	if($type == "")
	{
			SQLUpdate_SingleValue(
				"weblog",
				"user",
				"'".$AuthUserName."'",
				"background_color",
				"#ffffff"
			);
			
			SQLUpdate_SingleValue(
				"weblog",
				"user",
				"'".$AuthUserName."'",
				"main_area_background_color",
				"#ffffff"
			);
			
			SQLUpdate_SingleValue(
				"weblog",
				"user",
				"'".$AuthUserName."'",
				"shadows_color",
				"#f0f0f0"
			);
	}
	else
	{
			SQLUpdate_SingleValue(
				"weblog",
				"user",
				"'".$AuthUserName."'",
				"background_color",
				""
			);
			
			SQLUpdate_SingleValue(
				"weblog",
				"user",
				"'".$AuthUserName."'",
				"main_area_background_color",
				""
			);
			
			SQLUpdate_SingleValue(
				"weblog",
				"user",
				"'".$AuthUserName."'",
				"shadows_color",
				""
			);
	}
	
	SQLUpdate_SingleValue(
				"note_settings",
				"user",
				"'".$AuthUserName."'",
				"background",
				$type
			);
}
?>

<table summary="" border="0" width=100%>
	<tr>
		<td align=right>
		<a href="index.php?category=site&folder=format&page=backgrounds&Proceed=1&type=">[<?php echo $CLICK_CLEAR_BGR;?>]</a>
		</td>
	</tr>
</table>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<b><?php echo $CURRENT_BACKGROUND_ID;?>:</b>
		<br><br>
		<?php
		$arrNoteSettings = DataArray("note_settings","user='".$AuthUserName."'");
		
		if(trim($arrNoteSettings["background"]) == "")
		{
			echo "<b><font color=red>[".strtoupper($AUCUN)."]</font></b>";
		}
		else
		{
			echo "<img width=100 height=100 src='../images/backgrounds/".$arrNoteSettings["background"]."'>";
		}
		?>
		
		<br><br>
		
		<b><?php echo $CLICK_SET_BGR;?>:</b>
		
		
		</td>
	</tr>
</table>

<br>
<?php
		
		$handle=opendir('../images/backgrounds');
		
		$iFileCounter = 1;
		
		while ($file = readdir($handle)) 
		{
		    if ($file != "." && $file != ".." && $file != "Thumbs.db") 
			{
			
				echo '<a href="index.php?category=site&folder=format&page=backgrounds&Proceed=1&type='.$file.'">';
				
				echo "<img src='../images/backgrounds/".$file."' width=100 height=100 border=0></a> &nbsp;&nbsp;&nbsp;&nbsp;";
			
							
				if($iFileCounter!=0 && $iFileCounter%8==0)	
				{
					echo "<br><br>";
				}
				
				$iFileCounter++;
 		   }
		}
?>
<script>
var HTType="1";
var HTMessage="<?php echo $T_BACKGROUNDS;?>";
document.onmousedown = HTMouseDown;
</script>
