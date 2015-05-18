<?php

if(isset($ProceedChangeLanguage)){
	$lang=strtolower($ProceedChangeLanguage);
	$LANG=$ProceedChangeLanguage;
	SQLUpdate_SingleValue(
				"admin_users",
				"username",
				"'".$AuthUserName."'",
				"bo_lang",
				$ProceedChangeLanguage
			);
}
else{
	$lArray=DataArray("admin_users","username='$AuthUserName'");
	$lang=strtolower($lArray["bo_lang"]);
	$LANG=strtoupper($lArray["bo_lang"]);
}


?>