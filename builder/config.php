<?php
$BLOG_DOMAIN = "urwebby.com";

//MYSQL DATABASE ACCESS SETTINGS
$DBHost="localhost";
$DBUser="root";
$DBPass="";
$DBName="online";
$DBprefix="websiteadmin_";

//ACCEPTED IMAGE TYPES FOR THE BLOGGERS
$image_types = Array 
(
		array("image/jpeg","jpg"),
		array("image/pjpeg","jpg"),
		array("image/bmp","bmp"),
		array("image/gif","gif"),
		array("image/x-png","png")
);		

//ACCEPTED FILE TYPES FOR UPLOAD BY THE BLOGGERS
$file_types = Array 
(
		array("image/jpeg","jpg"),
		array("image/pjpeg","jpg"),
		array("image/bmp","bmp"),
		array("image/gif","gif"),
		array("image/x-png","png"),
		array("application/msword","doc"),
		array("application/pdf","pdf"),
		array("application/vnd.ms-excel","xls"),
		array("application/rtf","rtf"),
		array("video/x-ms-wmv","wmv"),
		array("video/mpeg","mpg"),
		array("video/x-msvideo","avi"),
		array("text/plain","txt"),
		array("audio/mpeg","mp3"),
		array("text/html","html"),
		array("audio/x-wav","wav")
);

//PLEASE KEEP THIS ALWAYS TO FALSE
$SYSTEM_DEBUG_MODE=false;

//THE EMAIL ADDRESS FROM WHICH THE ACTIVATION CODE WILL BE SENT
$SYSTEM_EMAIL_ADDRESS = "info@urwebby.com";

//THE "FROM FIELD" FOR THE ACTIVATION EMAIL IF EMAIL VALIDATION IS SET TO TRUE
$SYSTEM_EMAIL_FROM = "urwebby.com";
?>