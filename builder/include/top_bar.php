<?php
$str_current_url=current_url();
			
$STR_OUTPUT .= '
<div style="background:#f9f9f9;height:30px;width:100%">
	
	<a href="'.($USE_ABSOLUTE_URLS?'http://www.'.$BLOG_DOMAIN.'/':'').'index.php?mod=signup"><img src="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'images/get_your_own_site.gif" width="126" height="14" alt="" border="0" style="float:left;margin-top:8px;margin-left:10px"></a>
	<a href="http://www.facebook.com/sharer.php?u='.$str_current_url.'" target="_blank"><img border="0" src="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'images/facebook.gif"  width="18" height="18" style="float:left;margin-top:6px;margin-left:10px"/></a>
	<a href="http://www.twitter.com/intent/tweet?text='.urlencode(strip_tags(stripslashes(current_page_name()))).'&url='.$str_current_url.'" target="_blank"><img border="0" src="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'images/twitter.gif" width="18" height="18" style="float:left;margin-top:6px;margin-left:10px"/></a>

	<div style="float:right;margin-top:8px;margin-right:10px">
		<form id="flag_form" method="post" name="flag_form" action="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'site.php" style="margin-top:0px;margin-bottom:0px">
		<input type="hidden" name="user" value="'.$user.'">
		<input type="hidden" name="flag" value="1">
		<input type="hidden" name="flag_url" id="flag_url" value="">
		</form>
		<a href="javascript:Flag()"><img src="'.($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").'images/flag_button2.gif" width="47" height="14" alt="" border="0"></a>
	</div>
	
</div>';
?>
