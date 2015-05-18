<table summary="" border="0" width=100%>
	<tr>
		<td>

<?php
if(get_param("format") != "")
{

	ms_i(get_param("format"));

	if(SQLCount("user_templates","WHERE user='".$AuthUserName."'")==0)
	{
			SQLInsert("user_templates",array("user"),array($AuthUserName));
	}
	
		if(file_exists('../blog_templates/'.$format.'.php'))
		{
						$html = implode('', file('../blog_templates/'.$format.'.php'));
						
						SQLUpdate_SingleValue(
								"weblog",
								"user",
								"'$AuthUserName'",
								"format",
								get_param("format")
							);
							
						SQLUpdate_SingleValue(
								"user_templates",
								"user",
								"'$AuthUserName'",
								"html",
								$html
							);
			
		}
		
		$format = get_param("format");
}
else
{
	$format=getSingleValue(
				"weblog",
				"user",
				"'$AuthUserName'",
				"format"
			);

}



			

?>
<br>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		<b>
		<font color=#fc9b00><b>1) <a href="javascript:ProceedShowHide('format1')">
		<font color=#fc9b00><?php echo $M_STANDARD;?></font></a></b></font> 	</b>
		<br><br>
		<?php echo $STANDARD_EXPL;?>
		
		</td>
	</tr>
</table>


<div id="format1" >

<form action="index.php" method="post">
<input type="hidden" name="ProceedUpdate">
<input type=hidden name="folder" value="<?php echo $folder;?>">
<input type=hidden name="page" value="<?php echo $page;?>">
<input type=hidden name=category value="<?php echo $category;?>">
<br><br>

		<table summary="" border="0" width=100%>
  	<tr>
  		<td>
		
			
			<b><?php echo $SELECT_LAYOUT;?>:</b></td>
  	</tr>
  </table>
		
<table summary="" border="0" width=100%>
	<tr>
		<td width=25% align=center>&nbsp;
	
	
					<table summary="" border="0">
				  	<tr>
				  		<td>
							<input type="radio" name="format" value="1" <?php if($format==1) echo "checked";?>>
						</td>
				  		<td><img src="images/format/1.gif" width="108" height="74" alt="" border="0"></td>
				  	</tr>
				  </table>
		
		
		</td>
		<td width=25% align=center>&nbsp;
		
			<table summary="" border="0">
				  	<tr>
				  		<td>
							<input type=radio name=format value=2 <?php if($format==2) echo "checked";?>>
						</td>
				  		<td><img src="images/format/2.gif" width="108" height="74" alt="" border="0"></td>
				  	</tr>
				  </table>
		</td>
		<td width=25% align=center>&nbsp;
			<table summary="" border="0">
				  	<tr>
				  		<td>
							<input type=radio name=format value=3 <?php if($format==3) echo "checked";?>>
						</td>
				  		<td><img src="images/format/3.gif" width="108" height="74" alt="" border="0"></td>
				  	</tr>
				  </table>
				  
				  
		</td>
		<td width=25% align=center>&nbsp;
		
			<table summary="" border="0">
				  	<tr>
				  		<td>
							<input type=radio name=format value=4  <?php if($format==4) echo "checked";?>>
						</td>
				  		<td><img src="images/format/4.gif" width="108" height="74" alt="" border="0"></td>
				  	</tr>
				  </table>
				  
				
			
				
		</td>
	</tr>
</table>
<br><br>
<table summary="" border="0" width=100%>
	<tr>
		<td align=right>
		
		<input type=submit value="    <?php echo $SAUVEGARDER;?>     " class=adminButton>
		</td>
	</tr>
</table>
<br>


<table summary="" border="0">
	<tr>
		<td><a href="index.php?category=site&folder=format&page=style"><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></a></td>
		<td><a href="index.php?category=site&folder=format&page=style" style="text-decoration:none"><?php echo $M_MODIFY_BLOG_STYLE;?></a></td>
	</tr>
</table>

<br style="line-height:4px">
				
<table summary="" border="0">
	<tr>
		<td><a href="index.php?category=site&folder=format&page=backgrounds"><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></a></td>
		<td><a href="index.php?category=site&folder=format&page=backgrounds" style="text-decoration:none"><?php echo $M_SET_A_DIFFERENT_BACKGROUND;?></a></td>
	</tr>
</table>


	
				
</div>	


	<br><br>
	
	<?php
	generateBackLink("format");
	?>
<script>
var HTType="1";
var HTMessage="<?php echo $T_MANAGE_DESIGN;?>";
document.onmousedown = HTMouseDown;
</script>
