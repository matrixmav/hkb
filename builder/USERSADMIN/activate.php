<?php
include("../config.php");
include("../ADMIN/Utils.php");
$code=get_param("id");
if(SQLCount_Query("SELECT * FROM ".$DBprefix."admin_users WHERE activation_code ='$code'  ") == 1)
{
	$arrUser = DataArray("admin_users","activation_code ='$code' ");
	
	SQLUpdate_SingleValue
		(
			"admin_users",
			"id",
			$arrUser["id"],
			"blog_active",
			"1"
		);
		
	SQLUpdate_SingleValue
		(
			"admin_users",
			"id",
			$arrUser["id"],
			"activation_code ",
			$arrUser["activation_code"]."_VALIDATED"
		);
		
	$strCookie = $arrUser["username"]."~".$arrUser["password"]."~".(time()+14400);
		
	setcookie("Auth",$strCookie);	
		
	SQLInsert(
						"login_log",
						array("username","ip","date","action","cookie"),
						array($arrUser["username"],$_SERVER["REMOTE_ADDR"],time(),'login',$strCookie)
					);
								
	 
	 echo "
	 	<script>
			alert('Thank you! Your account has been activated successfully!');
			document.location.href='index.php';
		</script>
	 ";

}
else
{
	echo "<h3><font color=red>WRONG ACTIVATION CODE!</font></h3>";
}
?>
