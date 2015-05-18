<?php

ms_i($q);


?>


<table summary="" border="0" width="100%">
	<tr>
		<td>
		
				<b>Template code:</b>
				
				<br><br>
		
				<?php
				
				$html = implode('', file('../user_templates/'.$q.'.htm'));
				
				?>
		
				<center>
				<textarea cols="90" rows="40">
				<?php
					echo $html;
				?>
				</textarea>
				</center>
		
		</td>
	</tr>
</table>

<br>


