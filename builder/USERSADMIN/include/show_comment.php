
<table summary="" border="0">
	<tr>
		<td style="font-family:Arial;font-size:12px;text-align:justify">
<?php
include("../../blog_config.php");
include("../Utils.php");

$arrComment = DataArray("comments","id=".$id);

echo stripslashes($arrComment["html"]);

?>
		</td>
	</tr>
</table>