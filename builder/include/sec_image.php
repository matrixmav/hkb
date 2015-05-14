<?php
   require('security_image.php');
   $CAPTCHA_SALT="AX42FQ";
   session_start();
    function rotate($string, $n) {
   
    $length = strlen($string);
    $result = '';
   
    for($i = 0; $i < $length; $i++) {
        $ascii = ord($string{$i});
       
        $rotated = $ascii;
       
        if ($ascii > 64 && $ascii < 91) {
            $rotated += $n;
            $rotated > 90 && $rotated += -90 + 64;
            $rotated < 65 && $rotated += -64 + 90;
        } elseif ($ascii > 96 && $ascii < 123) {
            $rotated += $n;
            $rotated > 122 && $rotated += -122 + 96;
            $rotated < 97 && $rotated += -96 + 122;
        }
       
        $result .= chr($rotated);
    }
   
    return $result;
}
                                                                                                                                                                                                                  
   $oSecurityImage = new SecurityImage(200, 50);
   
   
   if ($oSecurityImage->Create()) 
   {
	   $_SESSION['code'] = md5($CAPTCHA_SALT.$oSecurityImage->GetCode().$CAPTCHA_SALT);
	
	   $_SESSION[md5($CAPTCHA_SALT."A".floor(time() / 3600))] = md5($CAPTCHA_SALT."B".floor(time() / 3600));
   }
    else 
	{
      echo 'Image GIF library is not installed.';
   }
?>