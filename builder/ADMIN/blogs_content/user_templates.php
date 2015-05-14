<table summary="" border="0" width="100%">
	<tr>
		<td width="45">
		<img src="images/icons2/monitor.gif" width="33" height="42" alt="" border="0">
		</td>
		<td>
		<b>Modify the current user templates</b>
		</td>
	</tr>
</table>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		
				<?php
					
					$oCol=array("blogger_template","username");
					$oNames=array("Template",$UTILISATEUR);
					$ORDER_QUERY="ORDER BY type";
					
					
					RenderTable("admin_users",$oCol,$oNames,"100%","WHERE username<>'administrator'  ","","id","index.php?action=$action&category=".$category);
		
				?>
			
		</td>
	</tr>
</table>
