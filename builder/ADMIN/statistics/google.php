
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
include("include/languages_menu_processing.php");
	 $strServer = $_SERVER["SERVER_NAME"];
	 

	$strDefaultPageId=Parameter(1);
?>
<?php
		
		?>

<table summary="" border="0" width=100%>
	<tr>
		<td width=130>
		<img src="images/google.gif" border="0" width="129" height="38" alt="">
		</td>
		<td class=basictext>
		<b><?php echo $SUBMIT_THE_PAGES;?></b>
		</td>
	</tr>
</table>

				<?php
		include("include/languages_menu.php");
?>

<?php
if(isset($ProceedSubmit))
{
?>

<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext>

			<?php
			foreach($pages as $page)
			{
				
			
				
				$strFolder = $_SERVER['PHP_SELF'];
				
				$strPageUrl = GenerateLink(aParameter(1111),aParameter(1112),$lang,$page);
				
				$strURLToLoad = $strPageUrl;
						
				$data = @implode('', @file("http://www.google.com/addurl?q=".$strURLToLoad."&dq="));
				
				echo "<b>".$strURLToLoad.", ";
				
				if(strlen($data)>0)
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$STATUS: <font color=red>OK</font>";
				}
				else
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$STATUS: <font color=red>$ERROR</font>";
				}
				
				echo "</b><br><br>";
			}
			?>
		</td>
	</tr>
</table>

<?php
}
else
{
?>
<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext>
		
			<form action="index.php" method="post">
				<input type=hidden name=category value="<?php echo $category;?>">
				<input type=hidden name=action value="<?php echo $action;?>">
				<input type=hidden name=ProceedSubmit>
				
		<table>
		<?php
		
		$arrPages = DataTable("pages","ORDER BY id,parent_id");
	
		while($arrPage = mysql_fetch_array($arrPages))
		{
		
		
			if(trim($arrPage["link_".$lang]) == "")
			{
			
				echo 
			"
				<tr height=25>
					<td class=basictext>
						
					</td>
					<td class=basictext>
			
			";		
			
				echo "		<b>[".$str_BlankPage."]</b>
					</td>
					<td class=basictext>
					
					";
			}
			else
			{	
			
				echo 
			"
				<tr height=25>
					<td class=basictext>
						<input type=checkbox name=pages[] value=\"".$arrPage["link_".$lang]."\">
					</td>
					<td class=basictext>
			
			";		
					
				echo "		<b>".$arrPage["link_".$lang]."</b>
					</td>
					<td class=basictext>
					<a target='_blank' href='http://www.google.com/search?hl=en&q=allinurl%3A".$strServer."/index.php?page=".urlencode($lang."_".$arrPage['link_'.$lang])."&btnG=Google+Search' >
					<font >[$CHECK_CURRENT_STATUS_IN_GOOGLE]</a>
					</a>	
					";
			}
					
			echo "	</td>
				</tr>		
			";
				
		}	
		?>
		</table>
		<br>
		<input type=submit value=" <?php echo $SUBMIT;?> " class=adminButton>
		</form>
		
		</td>
	</tr>
</table>

<?php
}
?>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_GOOGLE;?>";
document.onmousedown = HTMouseDown;
</script>
