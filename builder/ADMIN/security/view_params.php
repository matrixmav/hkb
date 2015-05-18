<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<table summary="" border="0" width=750>
	<tr>
		<td class=basictext >
			<b><?php echo $LIST_PARAMETERS_REQUEST;?></b>
			<br><br>
			<?php
				$oArray=DataArray("bo_slog","id=$id");
				
				$uArray=unserialize($oArray["args"]);
				
				 while (list ($key, $val) = each ($uArray)) {
				 		
						if($key=="_OPS" || $key=="Auth"){
							continue;
						}
						
   						 echo "$key => <font color=red>$val</font><br><br>";
 				}
				
				echo generateBackLink("view");
			?>
		</td>
	</tr>
</table>
