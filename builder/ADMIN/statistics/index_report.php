
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php

include("include/languages_menu_processing.php");
	$strDefaultPageId=Parameter(1);
?>

<?php


function reg_fetch($source, $reg_exp, $fail) {
	$data = @implode('', @file($source));
	$data = strip_tags($data);
	$data = strtolower($data);
	$data = str_replace("\n", '', $data);
	$data = str_replace("\r", '', $data);
	
	
	if(substr_count($data, $fail)) {
		return 0;
	} else {
		

		preg_match($reg_exp,$data, $matches);
		
		if(!isset($matches[1]))
		{
			return "";
		}
		else
		return $matches[1];
	}
}

function fetch($source, $start, $smlen, $stop, $fail) {
	$data = @implode('', @file($source));
	$data = strip_tags($data);
	$data = strtolower($data);
	$data = str_replace("\n", '', $data);
	
	if(substr_count($data, $fail)) 
	{
		return 0;
	} 
	else 
	{
		$data = substr($data, strpos($data, $start)+$smlen);
		$data = substr($data, 0, strpos($data, $stop));
		return trim($data);
	}
}


	$data = array();
	$links = array();
	
if(isset($ProceedReport)) 
{

$target = trim(eregi_replace('http://', '', $_POST["target"])); 

	$source = 'http://www.google.com/search?hl=en&lr=&q=site%3A'.$target.'&btnG=Search';
	$data['Google'] = array(fetch($source, 'of about', 9, 'from', 'did not match any documents'), $source);
	$links['Google'] = $source;
	
	$source = 'http://search.msn.com/results.aspx?q=site%3A'.$target.'&FORM=QBNO';
	$data['MSN'] = array(fetch($source, 'web results1-', 18, 'containing', "couldn't find any results containing"), $source);
	$links['MSN'] = $source;
	
	$source = 'http://search.yahoo.com/search?p=site%3A'.$target.'&ei=UTF-8&fr=FP-tab-web-t&fl=0&x=wrt';
	$data['Yahoo'] = array(fetch($source, 'of about', 9, 'for', "did not find results for"), $source);
	$links['Yahoo'] = $source;
	

	
	$source = 'http://www.alltheweb.com/search?cat=web&cs=utf8&q='.$target.'+domain%3A'.$target.'&rys=0&_sb_lang=any';
	$data['AlltheWeb'] = array(reg_fetch($source, "/(\d+)\D*results for/i", "no web pages found that match your query"), $source);
	$links['AlltheWeb'] = $source;
	

}
?>


<?php
		include("include/languages_menu_processing.php");
		?>
	
<table summary="" border="0" width=100%>
	<tr>
		<td width=40>
		<img src="images/icons<?php echo $DN;?>/find.gif" border="0" width="42" height="43" alt="">
		</td>
		<td class=basictext><b><?php echo $CHECK_SEARCH_ENGINES_INDEX;?></b></td>
	</tr>
</table>

	<?php
		include("include/languages_menu.php");
?>

<script>
var strUser="<?php echo $AuthUserName;?>";
var previousSender = null;
var strFolder = "<?php echo $_SERVER['PHP_SELF'];?>";
function PageClicked(iPageID, sender, strURL)
{
	var strServer="<?php echo $_SERVER['SERVER_NAME'];?>";
	
	if(previousSender != null)
	{
	
		previousSender.style.background = "url(images/pro_bg.jpg)";

	}
	
	sender.style.background = "#ffd7c6";
	
	document.getElementById("target").value = strURL;
	
	previousSender = sender;
	
}
</script>


<?php
	$strDefaultPageId=Parameter(1);
?>







	<table summary="" border="0" width=100%>
   		<tr>
   			<td class=basictext >
				<form action="index.php" method="post">
				<input type=hidden name=category value="<?php echo $category;?>">
				<input type=hidden name=action value="<?php echo $action;?>">
				<input type=hidden name=ProceedReport>
				
				<?php echo $PAGE_URL;?>:
				<input type="text" id="target" name="target"  size=62>
			
				<input type=submit value=" <?php echo $PROCEED;?> " class=adminButton>
			</form>
				
			</td>
  	 	</tr>
   </table>		
			<br><br>
			
	<table summary="" border="0" width=100%>
   		<tr>
   			<td class=basictext>
		
				
			<?php
			
				if(isset($ProceedReport))
				{
			?>
				<b><?php echo $LINK_POP;?></b>
				<br><br>
			
				
				<table width=450>
			<?php
						foreach($data as $engine => $result) 
						{			
								echo "
									<tr height=50>
										<td class=basictext width=135>
												<a href=\"".$links[$engine]."\" target=_blank><img src=\"images/".strtolower($engine).".gif\" border=\"0\" width=\"129\" height=\"38\"></a>								
										</td>
										<td class=basictext>
											&nbsp;&nbsp;<b><span style=\"font-size:14;color:red\">".($result[0]?$result[0]."</span></b> &nbsp;<i>$PAGES</i>":"</b><i><font color=red>$NOT_AVAILABLE</font>")."</i>
											
										</td>	
										<td class=basictext target=_blank>	
											&nbsp;&nbsp;<a href=\"".$links[$engine]."\" ><font color=#00039c><b>[$CLICK_HERE_FOR_DETAILS]</b></font></a></a>
										</td>
									</tr>						
								
								";				
						}
			?>
			</table>
			</center>
			
			</td>
  	 	</tr>
   </table>
			<?php		
				}
			
			?>
			
	
			<?php
			
				if(!isset($ProceedReport))
				{
			?>
<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext>
		<b><?php echo $CLICK_ON_A_PAGE_FROM;?> <a href="index.php?category=site_management&action=pages"> [<?php echo $HERE;?>]</font></b></a></i>
		</td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="0" width=100%>
	<tr>
		<td width=25 background="images/website_structure_bg.gif" valign=middle bgcolor=#f9f2f9 style='border-style:solid;border-color:#CECFCE;border-width:1px 0px 1px 1px'>
		<img src="images/website_structure.gif" width="25" height="227" alt="" border="0">
		</td>
		<td valign=top>

		
<?php

include("expert.php");

WriteLevel("0", 0);

?>
	</td>
	
	
	<td width=200>
			&nbsp;
	</td>
	</tr>
</table>
<br>
<?php		
				}
			
			?>



   
	

</div>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_INDEX_REPORT;?>";
document.onmousedown = HTMouseDown;
</script>

