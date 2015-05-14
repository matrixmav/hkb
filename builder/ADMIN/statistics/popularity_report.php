
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
function fetch($source, $start, $smlen, $stop, $fail) {
	$data = @implode('', @file($source));
	$data = strip_tags($data);
	$data = strtolower($data);
	$data = str_replace("\n", '', $data);
	$data = str_replace("\r", '', $data);
		
	if(substr_count($data, $fail)) {
		return 0;
	} else {
	
		$data = substr($data, strpos($data, $start)+$smlen);
			
		$data = substr($data, 0, strpos($data, $stop));
	
		return trim($data);

	}
}

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
		return $matches[1];
	}
}

	$data = array();
	$links = array();
	
if(isset($ProceedReport)) 
{

	$target = trim(eregi_replace('http://', '', $_POST["target"])); 
	$source = 'http://www.google.com/search?hl=en&lr=&ie=UTF-8&q=link%3A'.$target;
	$data['Google'] = array(reg_fetch($source,"/(\d*)\D*linking/i", 'did not match any documents'), $source);
	$links['Google'] = $source;
	

	$source = 'http://search.msn.com/results.aspx?FORM=MSNH&srch_type=0&q=link%3A'.$target;
	$data['MSN'] = array(fetch($source, 'web results1-', 18, 'containing', "couldn't find any results containing"), $source);
	$links['MSN'] = $source;
	
	$source = 'http://search.yahoo.com/search?p=linkdomain%3A'.$target.'&sm=Yahoo%21+Search&fr=FP-tab-web-t&toggle=1';
	$data['Yahoo'] = array(fetch($source, 'of about', 9, 'for', "did not find"), $source);
	$links['Yahoo'] = $source;
	
	$source = 'http://www.alltheweb.com/search?cat=web&cs=utf8&q=link%3A'.$target.'&rys=0&_sb_lang=pref';
	$data['AlltheWeb'] = array(fetch($source, 'audio1 -', 14, 'results', "no web pagesfound that match your query"), $source);
	$links['AlltheWeb'] = $source;

	
}
?>

<?php

$mainFontColor="#3149ad";
$mainTableWidth="575";
$cartHeaderColor="#ceefff";
$cartBackColor1="#ffffff";
$cartBackColor2="#f7fbff";
$textHighLightColor="#3149ad";
?>
<style>
.fcell{border-style:solid;border-color:#ffffff;border-width:1px 1px 1px 1px;background-color:#efefef;height:24;font-size:13;font-family:Verdana;font-weight:800;color:#1C6397}
.ncell{border-style:solid;border-color:#ffffff;border-width:0px 1px 1px 1px;background-color:#efefef;height:24;font-size:13;font-family:verdana;font-weight:800;color:#1C6397}
.scell{border-style:solid;border-color:#ffffff;border-width:0px 1px 1px 1px;background-color:#e7e7ef;height:20;font-size:11;font-family:verdana;font-weight:800;color:#1C6397}
a.mainLink{text-decoration:none;color:#1C6397}
</style>	
<?php
		include("include/languages_menu_processing.php");
		?>
	
<table summary="" border="0" width=100%>
	<tr>
		<td width=40><img src="images/icons<?php echo $DN;?>/download.gif" border="0" width="39" height="39" alt=""></td>
		<td class=basictext><b><?php echo $CHECK_SEARCH_ENGINES_POP;?></b></td>
	</tr>
</table>
			<?php
		include("include/languages_menu.php");
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


<?php
}
?>

<br>













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
			
				
				<table width=100%>
			<?php
						foreach($data as $engine => $result) 
						{			
								echo "
									<tr height=50>
										<td class=basictext width=135>
												<a href=\"".$links[$engine]."\" target=_blank>
												<img src=\"images/".strtolower($engine).".gif\" border=\"0\" width=\"129\" height=\"38\">								
												</a>
										</td>
										<td class=basictext width=120>
											&nbsp;&nbsp;<b><span style=\"font-size:14;color:red\">".($result[0]?$result[0]."</span></b> &nbsp;&nbsp;<i>$INDEXED_LINKS</i>":"<i><font color=red>$NOT_AVAILABLE</font>")."</i>
										</td>	
										<td class=basictext>	
											&nbsp;&nbsp;<a href=\"".$links[$engine]."\" target=_blank><font color=#00039c><b>[$CLICK_HERE_FOR_DETAILS]</b></font></a></a>
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
			
   
	

</div>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_POPULARITY_REP;?>";
document.onmousedown = HTMouseDown;
</script>

