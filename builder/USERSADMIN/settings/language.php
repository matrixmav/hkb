<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0">
		<tr>
			<td><img src="images/icons/globe.png" width="48" height="48" alt="" border="0"></td>
			<td class="blog_admin_header"><?php echo $SELECT_BLOG_LNG;?></td>
		</tr>
	  </table>
		
		
		
		<center>
		
		<form action="index.php" method="post">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<br>
		<table>
		<?php
		
		if(get_param("blog_lang") != "")
		{
			SQLUpdate_SingleValue
			(
				"admin_users",
				"username",
				"'".$AuthUserName."'",
				"blog_lang",
				get_param("blog_lang")				
			);
		}
		
		$arrAdminUser = DataArray("admin_users","username='$AuthUserName'");
		
		
		$iLCounter = 0;
		 $tableLanguages=DataTable("languages","WHERE active=1");
		 
		while($arrSupportedLanguage=mysql_fetch_array($tableLanguages))
		{
		
			if(($iLCounter % 5) == 0)
			{
				echo "<tr height=40>";
			}
		
			echo 
			"
					<td width=30><input type=radio name=blog_lang value=\"".strtolower($arrSupportedLanguage["code"])."\" ".($arrAdminUser["blog_lang"]==strtolower($arrSupportedLanguage["code"])?"checked":"")."></td>
					<td width=50><img src=\"../include/flags/".strtoupper($arrSupportedLanguage["code"]).".gif\"></td>
					<td><b>".$arrSupportedLanguage["name"]."</b></td>
					<td width=60>&nbsp;</td>
			";	
			
			if(( ($iLCounter+1) % 5) == 0)
			{
				echo "</tr>";
			}
		
			$iLCounter++;
		
		}
		
		?>
		</table>
		
		</center>
		<br>
		
		
		<table summary="" border="0" width="100%">
  	<tr>
  		<td align="left">
		
		<input type=submit value="<?php echo $SAUVEGARDER;?>" class="adminButton">
		
		</td>
  	</tr>
  </table>
		
			
		</form>
		
		
		
		</td>
	</tr>
</table>


<script>
var HTType="2";
var HTMessage="<?php echo $T_LANGUAGE_SETTINGS;?>";
document.onmousedown = HTMouseDown;
</script>
