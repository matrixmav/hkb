<?php
if($AuthGroup !="Administrators")
{
	die("");
}
?>

<script>
function DeleteBlog(x)
{
	if(confirm("Are you sure you want to delete this site and all the information associated to it?"))
	{
		document.location.href="index.php?category=<?php echo $category;?>&action=<?php echo $action;?>&dr="+x;
	}
}
</script>

<?php

if(isset($ur))
{
	SQLUpdate_SingleValue
	(
				"admin_users",
				"username",
				"'".$ur."'",
				"card_type",
				""
	);

}

if(isset($dr))
{
	SQLQuery("DELETE FROM ".$DBprefix."admin_users WHERE username='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."uploaded_files WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."contact WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."contact_settings WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."design WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."list WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."note_categories WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."note_settings WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."notes WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."photo WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."user_notes WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."user_statistics WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."user_templates WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."votes WHERE user='".$dr."'");
	SQLQuery("DELETE FROM ".$DBprefix."weblog WHERE user='".$dr."'");
}

?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		
		<table summary="" border="0" width=100%>
	<tr>
		<td width="45">
	<img src="images/icons2/zoomin.gif" width="34" height="37" alt="" border="0">
		</td>
		<td>
		<b>User sites content warnings</b>
		</td>
	</tr>
</table>
<br>
		
		<?php
		
		$tableBloggers = DataTable("admin_users","WHERE card_type<>''");
		?>
		
		<table width="100%" cellspacing="0">
		<tr height="24">
			<td><i>Ignore</i></td>
			 <td><i>User</i></td>
			<td><i>Reported URL</i></td>
			
			<td align="center"><i>Delete the site</i></td>
		</tr>
		<?php
		while($arrBlogger = mysql_fetch_array($tableBloggers))
		{
		?>
		<tr height="5">
			<td colspan="5"><img src="images/spacer.gif" width="1" height="1" alt="" border="0"></td>
		</tr>
		<tr height="30" bgcolor="#eeeeee" onmouseover="this.style.background='#dddddd'" onmouseout="this.style.background='#eeeeee'">
			<td>
					
					<a href="index.php?category=<?php echo $category;?>&action=<?php echo $action;?>&ur=<?php echo $arrBlogger["username"];?>"><img src="images/cancel.gif" width="21" height="20" alt="" border="0">
			
			</td>
			<td>
			
				<a href="http://www.<?php echo $BLOG_DOMAIN;?>/blog.php?user=<?php echo $arrBlogger["username"];?>" style="font-size:11px;color:#cf6e2f;text-decoration:underline"><?php echo $arrBlogger["username"];?></a>
			
			</td>
			<td>
			
				<a href="<?php echo $arrBlogger["card_type"];?>" target="_blank" style="font-size:11px;color:#cf6e2f;text-decoration:underline"><?php echo $arrBlogger["card_type"];?></a>
			
			</td>
			<td align="center">
			
			<a href="javascript:DeleteBlog('<?php echo $arrBlogger["username"];?>')"><img src="images/cut.gif" width="20" height="20" alt="" border="0"></a>
			
			</td>
			
		
		</tr>
		
		<?php
		}
		?>
		
		</table>
		
		
		
		</td>
	</tr>
</table>