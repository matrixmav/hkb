<?php
$ProductName="WSCreator v2.0";

$oLinkTexts=array($M_HOME,$M_INFORMATION,$PARAMETRES,$M_MY_SITE,$M_NEWS_MANAGER,$M_PHOTOS_FILES);
$oLinkActions=array("home","info","settings","site","notes","albums");

$info_oLinkTexts=array($M_INFORMATION_BOARD,$M_PACKAGE2,$SPACE_OCCUPIED,$BANDWIDTH,$M_STATISTICS,$M_LOGIN_REPORT,$M_CONTACT);
$info_oLinkActions=array("profil","package","space","bandwidth","statistics","connections","contact");

$notes_oLinkTexts=array($M_NEW_POST,$M_MANAGE_POSTS,$M_MANAGE_COMMENTS,$M_NEW_COMMENT);
$notes_oLinkActions=array("add","list","comments","new_comment");

$albums_oLinkTexts=array($PHOTO_ALBUMS,$M_NEW_ALBUM,$M_MY_PICTURES);
$albums_oLinkActions=array("list","create","pictures");

if($WEBSITE_MULTILANGUAGE )
{
	$settings_oLinkTexts=array($M_LANGUAGE,$M_CHANGE_PASSWORD,$M_CONTACT,$M_META_TAGS,$M_PASSWORD_PROTECT);
	$settings_oLinkActions=array("language","change_password","contact","meta_tags","password");
}
else
{
	$settings_oLinkTexts=array($M_CHANGE_PASSWORD,$M_CONTACT,$M_META_TAGS,$M_PASSWORD_PROTECT);
	$settings_oLinkActions=array("change_password","contact","meta_tags","password");
}
$exit_oLinkTexts=array($M_THANK_YOU);
$exit_oLinkActions=array("exit");

$home_oLinkTexts=array($M_WELCOME);
$home_oLinkActions=array("welcome");

$site_oLinkTexts=array($M_MY_SITE,$M_DESIGN,$M_LOGO,$M_ADVERTISEMENTS,$MY_FILES2);
$site_oLinkActions=array("my_site","format","logo","advertisements","files");
?>