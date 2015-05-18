<?php
include("config.php");
include("ADMIN/Utils.php");
$log_file = "blog_files/IPN_REPORT.php";   

$writeToLog = true;

if (!$file_handle = fopen($log_file,"a")) 
{
	 mail($SYSTEM_EMAIL_ADDRESS,"Blog System IPN Warning","The system has failed to create the IPN log file.");
	 $writeToLog = false;
}
else
{
	fclose($file_handle); 
}


function WriteToIPNLog($strText)
{
	global $writeToLog,$log_file,$SYSTEM_EMAIL_ADDRESS;
	if($writeToLog)
	{
		
		if (!$file_handle = fopen($log_file,"a")) 
		{
			 mail($SYSTEM_EMAIL_ADDRESS,"Blog System IPN Warning","The system has failed to open the IPN log file.");
			 return;
		}  
		
		if (!fwrite($file_handle, $strText)) 
		{ 
			 mail($SYSTEM_EMAIL_ADDRESS,"Blog System IPN Warning","The system has failed to write the following data to the IPN log file:\n\n".$strText);
		}  
		fclose($file_handle); 
	}
}



$req = 'cmd=_notify-validate';

$logVars ="";

foreach ($_POST as $key => $value) 
{
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
	$logVars .= $key.">>".$value." ";
}



WriteToIPNLog
	(
		"NEW IPN REPORT ".date("F j, Y, g:i a")."\n".
		"********************\n".
		$logVars."\n"
	);
	
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n"; 
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";

	$fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);

	if (!$fp) 
	{
		WriteToIPNLog
		(
			"System failed to connect to paypal!\n"
		);
		 mail($SYSTEM_EMAIL_ADDRESS,"Blog System IPN Warning (PayPal connection failure)","The system has failed to connect to PayPal!");
	} 
	else 
	{

		  fputs ($fp, $header . $req);
	
			$strReport = "";
			
 			 while (!feof($fp)) 
 			 {

			    $res = fgets ($fp, 1024);
				
				$strReport .= $res;
		
    			if (strcmp ($res, "VERIFIED") == 0) 
				{

			      	$username = $_POST["custom"];
					$arrBlogger = DataArray("admin_users","username='".$username."'");
					$arrPackage = DataArray("blog_packages","id=".$arrBlogger["plan"]);

				      if(SQLCount("admin_users","WHERE username='".$username."' ")==1) 
					  {
				
				   
				        if(isset($_POST["txn_type"]) &&strtolower($_POST["txn_type"]) == "subscr_payment") 
						{
								
								
								if($arrBlogger["plan"] != 0 && $arrBlogger["new_plan"] != 0 && $arrBlogger["new_plan"]!=$arrBlogger["plan"])
								{
									
											SQLUpdate_SingleValue
											(
												"admin_users",
												"username",
												"'".$username."'",
												"plan",
												$arrBlogger["new_plan"]
											);
											$arrPackage = DataArray("blog_packages","id=".$arrBlogger["plan"]);
											
								}
								
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
											"admin_users",
											"id",
											$arrBlogger["id"],
											"blog_active",
											"1"
								);
								
								SQLInsert
								( 
												"blog_payments",
												array("date","user","method","validated","amount"),
												array(time(),$username,"paypal","1",$arrPackage["price"])
								);
								
								WriteToIPNLog
								(
									"successful payment for user: ".$username."\n"
								);
				
				        } 
						else
						 if(
						 	isset($_POST["txn_type"]) 
							 &&
						 	(
								strtolower($_POST["txn_type"]) == "subscr_cancel"
								||
								strtolower($_POST["txn_type"]) == "subscr_failed"
							) 
							)
						{
				
				         	$arrFreePackage = DataArray("blog_packages","price='0.00'");
							
							if(isset($arrFreePackage["id"]))
							{
								SQLUpdate_SingleValue
								(
											"admin_users",
											"id",
											$arrBlogger["id"],
											"blog_active",
											"1"
								);
								
								SQLUpdate_SingleValue(
												"admin_users",
												"id",
												$arrBlogger["id"],
												"plan",
												$arrFreePackage["id"]
								);
								
								WriteToIPNLog
								(
									"txn_type: ".$_POST["txn_type"]." user:".$username."\n"
								);
								
							}
				
				    } 

     	 }

    } 
	else if(strcmp ($res, "INVALID") == 0) 
	{

    			WriteToIPNLog
				(
					">>>INVALID<<<\n".$strReport."\n"
				);

    }

  } 

}

WriteToIPNLog
	(
		"END IPN REPORT\n\n"
	);
?>
