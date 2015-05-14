<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>
		
		<table summary="" border="0" >
	  	<tr>
	  		<td width=40><img src="images/icons<?php echo $DN;?>/email.gif" border="0" width="40" height="34" alt=""></td>
	  		<td class=basictext><b><?php echo $LIST_EXTENSIONS;?></b></td>
	  	</tr>
	  </table>
	<br><br>
		<table>
		<?php
		$handle=opendir('../extensions');

		while ($file = readdir($handle)) 
		{
		    if ($file != "." && $file != "..") 
			{
				echo "<tr height=23>";
				
				echo "
				
				<td width=250>
					<b><font class=hl_text>".strtoupper(str_replace(".php","",$file))."</font></b> &nbsp;&nbsp;&nbsp;
				
				</td>
				<td align=right>
				[".round(filesize("../extensions/".$file)/1000)."KB]
				</td>
				<td width=20>&nbsp;</td>
				<td>
				".date ("F d Y H:i:s.", filemtime('../extensions/'.$file))."
				</td>
				
				";
				
				echo "</tr>";
 		   }
		}
		?>
		</table>
		<br>
		<?php echo $IN_ORDER_TO;?>
		</td>
	</tr>
</table>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_EXTENSIONS;?>";
document.onmousedown = HTMouseDown;
</script>

