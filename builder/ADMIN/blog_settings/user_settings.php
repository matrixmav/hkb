<table summary="" border="0" width="100%">
	<tr>
		<td>
		<table summary="" border="0">
  	<tr>
  		<td width="45"><img src="images/icons2/tools.gif" width="45" height="43" alt="" border="0"></td>
  		<td><b>Modify the user site settings</b></td>
  	</tr>
  </table>
		
		
		<br>
		
		
		<center>
				<?php
					
					$oCol=array("blogger_blog","blogger_note","blogger_template","username");
					$oNames=array("Website","Site News","Template",$UTILISATEUR);
					$ORDER_QUERY="ORDER BY type";
					
					
					RenderTable("admin_users",$oCol,$oNames,"950","WHERE username<>'administrator'  ","","id","index.php?action=$action&category=".$category);
		
				?>
				</center>
				
		</td>
	</tr>
</table>
