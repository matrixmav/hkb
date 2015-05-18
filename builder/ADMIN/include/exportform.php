<?php
include_once("../Utils.php");
header("Content-type: application/mail");
header("Content-Disposition: attachment; filename=data.".($type=="csv"?"csv":"xls"));


mysql_connect("$DBHost", "$DBUser", "$DBPass");
	mysql_select_db($DBName);
		
	$dataTable=mysql_query("select * from $DBprefix"."forms_data"." WHERE form_id=$form_id");
			
	
		while($arrData=mysql_fetch_array($dataTable)){
		
		
			
			$arrValues=unserialize($arrData["data"]);
			
			
			
			foreach($arrValues as $key=>$value){
				
				if(trim($value)!=""){
				
					if($type == "tdf")
					{
						echo $value."\t";
					}
					else
					if($type == "csv")
					{
					 	echo "\"".$value."\",";
					}
					
				}
			}
			
			echo "\n";
		}
	
	mysql_close();

?>
