<!--
<table summary="" border="0" width="100%">
	<tr>
		<td>
			
			
			<b>In order to manage the template settings, please click on it:</b>
			
		</td>
	</tr>
</table>
-->
<br>

<?php
$handle=opendir('../user_templates/preview');

$iCounter = 1;

		while ($file = readdir($handle))
		{
		
		    if ($file != "." && $file != ".." && $file != "Thumbs.db") 
			{
				if (preg_match("/gif|jpg|png/i", $file))
				{
					$fileItems = explode(".",$file);
					echo "\n<a href=\"index.php?category=".$category."&folder=".$action."&page=view&q=".$fileItems[0]."\"><img src=\"../user_templates/preview/".$file."\" border=\"0\" width=\"108\" height=\"74\"></a>&nbsp;";
				
					if(($iCounter%8 ) == 0)
					{
						echo "<br><br>\n";
					}
					
					$iCounter++;
				}
 			}
		   
		   
		}
		
?>
