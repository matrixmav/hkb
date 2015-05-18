<table summary="" border="0" width="100%">
	<tr>
		<td width="40"><img src="images/icons2/reports.gif" width="39" height="40" alt="" border="0"></td>
		<td><b>PayPal payments report based on IPN</b></td>
	</tr>
</table>

<br>
<?php



RenderTable
(
	"blog_payments",
	array("date","user","method","amount"),
	array("Date","User","Method","Amount"),
	"100%",
	
	"WHERE user<>'' AND method<>'paypal' AND validated=1 ORDER BY ID desc",
	"",
	"id",
	"index.php?action=".$action."&category=".$category
);
?>
