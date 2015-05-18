<?php
function BlogUrl_BA($user){global $USE_ABSOLUTE_URLS,$BLOG_URL_FORMAT,$BLOG_DOMAIN;if(!$USE_ABSOLUTE_URLS){return "../site.php?user=".strtolower($user);}else if($BLOG_URL_FORMAT == 1){return "http://".strtolower($user).".".$BLOG_DOMAIN;}else if($BLOG_URL_FORMAT == 2){return "http://"."www.".$BLOG_DOMAIN."/".strtolower($user);}else{return "[blog format not defined]";}}

$HTML='
<span class="login-label">
	<a href="'.BlogUrl_BA($AuthUserName).'"  target=_blank style="text-decoration:none;color:white;">[ '.strtolower($VIEW_BLOG).' ]</a>
	<a href="logout.php"  style="margin-left:20px;text-decoration:none;color:white;">[ '.strtolower($M_LOGOUT).' ]</a>
</span>
';
?>