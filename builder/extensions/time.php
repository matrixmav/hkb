<?php
if(isset($lang)&&strtolower($lang)=="en")
$HTML = date("F j, Y, g:i a");
else
if(isset($LANGUAGE2)&&strtolower($LANGUAGE2)=="en")
$HTML = date("F j, Y, g:i a");
else
$HTML = date("d.m.Y, g:i a");
?>