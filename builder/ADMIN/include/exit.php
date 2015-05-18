<?php setcookie("Auth","",time()+1);
			
		?>
		
			<table summary="" border="0" height=200>
   					<tr>
   						<td class=basicText valign=middle> 
						<b>
						Thank you for using the administration module!
						<br><br>
						After 5 seconds you'll be redirected to the home page!
						<script>
						
							setTimeout("document.location.href='../index.php'",5000);
						</script>
						
						</td>
   						
   					</tr>
   			</table>
