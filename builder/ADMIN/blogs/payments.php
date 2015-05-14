<?php
if(isset($Delete) && isset($CheckList) && sizeof($CheckList)>0)
{
	foreach($CheckList as $CheckId)
	{
		ms_i($CheckId);
		$arrPayment = DataArray("blog_payments","id=".$CheckId);
		
		if($arrPayment["user"]!="")
		{
		
				$arrBlogger = DataArray("admin_users","username='".$arrPayment["user"]."'");
				
				if($arrBlogger["plan"] != 0 && $arrBlogger["new_plan"] != 0 && $arrBlogger["new_plan"]!=$arrBlogger["plan"])
				{
					$arrNewBloggerPackage = DataArray("blog_packages","id=".$arrBlogger["new_plan"]);	
					
					if($arrPayment["amount"] == $arrNewBloggerPackage["price"])	
					{
							SQLUpdate_SingleValue
							(
								"admin_users",
								"username",
								"'".$arrPayment["user"]."'",
								"plan",
								$arrBlogger["new_plan"]
							);
							
							SQLUpdate_SingleValue
							(
								"admin_users",
								"username",
								"'".$arrPayment["user"]."'",
								"blog_active",
								"1"
							);
					}
										
				}
				
				$arrPackage = DataArray("blog_packages","id=".$arrBlogger["plan"]);
				
				
								$expires_date  = mktime(0, 0, 0, date("m")+$arrPackage["billed"]  , date("d"), date("Y"));
								
								SQLUpdate_SingleValue
								(
												"admin_users",
												"id",
												$arrBlogger["id"],
												"blog_expires",
												$expires_date
								);
								
								SQLUpdate_SingleValue
								(
												"blog_payments",
												"id",
												$CheckId,
												"validated",
												"1"
								);
								
								SQLUpdate_SingleValue
								(
												"admin_users",
												"username",
												"'".$arrPayment["user"]."'",
												"blog_active",
												"1"
								);
				
				
		}
	}
}
?>

<table summary="" border="0" width="100%">
	<tr>
		<td width="40"><img src="images/icons2/reports.gif" width="39" height="40" alt="" border="0"></td>
		<td><b>Validate the bank transfer and cheque payments</b></td>
	</tr>
</table>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td><a href="index.php?category=blogs&folder=payments&page=ipn" style="font-size:11;font-weight:800">[Click here to consult the PayPal IPN report]</a></td>
	</tr>
</table>
<br><br>
<table summary="" border="0" width="100%">
	<tr>
		<td><a href="index.php?category=blogs&folder=payments&page=validated" style="font-size:11;font-weight:800">[Click here to consult the validated cheque/bank transfer payments]</a></td>
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
	
	"WHERE user<>'' AND method<>'paypal'  AND validated=0 ORDER BY ID desc",
	"Validate",
	"id",
	"index.php?action=".$action."&category=".$category
);
?>
