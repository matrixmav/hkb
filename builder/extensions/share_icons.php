<span style="position:relative;left:6px;top:-2px"><g:plusone></g:plusone></span>
<?php $str_current_url=current_url();?>
<a href="http://www.facebook.com/sharer.php?u=<?php echo $str_current_url;?>" target="_blank"><img border="0" src="images/facebook_icon.gif"/></a>
<a href="http://www.twitter.com/intent/tweet?text=<?php echo urlencode(strip_tags(stripslashes(current_page_name())));?>&url=<?php echo $str_current_url;?>" target="_blank"><img border="0" src="images/twitter_icon.gif" style="margin-left:7px"/></a>
<a href="<?php if($USE_MOD_REWRITE) echo "http://www.".$DOMAIN_NAME."/";?>rss.php?type=rss20"><img border="0" src="images/rss_icon.gif" style="margin-left:7px"/></a>
<a href="<?php if($USE_MOD_REWRITE) echo "http://www.".$DOMAIN_NAME."/";?>atom.php?type=jobs20"><img border="0" src="images/atom_icon.gif" style="margin-left:7px"/></a>
