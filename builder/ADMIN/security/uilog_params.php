<table summary="" border="0" width=750>
	<tr>
		<td class=basictext >
			<b>List of parameters contained in this request</b>
			<br><br>
			<?php
				$oArray=DataArray("slog","id=$id");
				
				$uArray=unserialize($oArray["args"]);
				
				 while (list ($key, $val) = each ($uArray)) {
				 		
						if($key=="_OPS"){
							continue;
						}
						
   						 echo "$key => <font color=red>$val</font><br><br>";
 				}
				
				echo generateBackLink("uilog");
			?>
		</td>
	</tr>
</table>
