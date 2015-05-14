<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>

<table summary="" border="0" width="100%">
	<tr>
		<td align="right">
		<br>
				<table summary="" border="0">
				  	<tr>
				  		<td><img src="images/edit.gif" width="16" height="16" alt="" border="0"></td>
				  		<td><b><a href="index.php?category=notes&action=populate" style="text-decoration:none"><?php echo $M_POPULATE_YOUR_BLOG_USING_EXTERNAL;?></a></b></td>
				  	</tr>
				  </table>
		
		</td>
	</tr>
</table>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<br>
		<b><?php echo $M_YOUR_BLOG_FEEDS;?></b>
		<hr width=100% color=#636563>
		<br>
		
				<table summary="" border="0">
				  	<tr>
				  		<td><img src="../images/rss2.gif" width="80" height="15" alt="" border="0"></td>
				  		<td> &nbsp;&nbsp;<b>http://www.<?php echo $BLOG_DOMAIN;?>/<?php echo $AuthUserName;?>.rss</b></td>
				  	</tr>
					<tr>
						<td colspan="2"><br></td>
					</tr>
				  	<tr>
				  		<td><img src="../images/atom.png" width="80" height="15" alt="" border="0"></td>
				  		<td> &nbsp;&nbsp;<b>http://www.<?php echo $BLOG_DOMAIN;?>/<?php echo $AuthUserName;?>.atom</b></td>
				  	</tr>
				  </table>
  
  		<br><br>
		<b><?php echo strtoupper($BLOG_DOMAIN);?> <?php echo strtoupper($M_FEEDS);?></b>
		<hr width=100% color=#636563>
		<br>
		
		<i><?php echo strtolower($LATEST_NOTES);?></i>
		<br><br>
				<table summary="" border="0">
				  	<tr>
				  		<td><img src="../images/rss2.gif" width="80" height="15" alt="" border="0"></td>
				  		<td> &nbsp;&nbsp;<b>http://www.<?php echo $BLOG_DOMAIN;?>/notes.rss</b></td>
				  	</tr>
					<tr>
						<td colspan="2"><br></td>
					</tr>
				  	<tr>
				  		<td><img src="../images/atom.png" width="80" height="15" alt="" border="0"></td>
				  		<td> &nbsp;&nbsp;<b>http://www.<?php echo $BLOG_DOMAIN;?>/notes.atom</b></td>
				  	</tr>
				  </table>
				  
		
		<br><br>
		
		<i><?php echo strtolower($LAST_UPDATED_BLOGS);?></i>
		<br><br>
				<table summary="" border="0">
				  	<tr>
				  		<td><img src="../images/rss2.gif" width="80" height="15" alt="" border="0"></td>
				  		<td> &nbsp;&nbsp;<b>http://www.<?php echo $BLOG_DOMAIN;?>/blogs.rss</b></td>
				  	</tr>
					<tr>
						<td colspan="2"><br></td>
					</tr>
				  	<tr>
				  		<td><img src="../images/atom.png" width="80" height="15" alt="" border="0"></td>
				  		<td> &nbsp;&nbsp;<b>http://www.<?php echo $BLOG_DOMAIN;?>/blogs.atom</b></td>
				  	</tr>
				  </table>
				  
		
		<br><br>
		
		
		
		
		
		</td>
	</tr>
</table>
