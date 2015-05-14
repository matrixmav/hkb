
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
$iUniques = 0;
$iReloads = 0;
$iTotal = 0;

$strServerName=$_SERVER["SERVER_NAME"];

if(isset($ProceedFilter))
{
	
	
	if($stat_day=="All"&&$stat_month=="All"&&$stat_year=="All")
	{
		$strWhereQuery = "";
	}
	else
	if($stat_day!="All"&&$stat_month!="All"&&$stat_year!="All")
	{
		$strWhereQuery = "WHERE date like '".$stat_month." ".$stat_day.", ".$stat_year."%'";
	}
	else
	if($stat_day!="All"&&$stat_month=="All"&&$stat_year=="All")
	{
		$strWhereQuery = "WHERE date like '% ".$stat_day.",%'";
	}
	else
	if($stat_day=="All"&&$stat_month!="All"&&$stat_year=="All")
	{
		$strWhereQuery = "WHERE date like '".$stat_month."%'";
	}
	else
	if($stat_day=="All"&&$stat_month=="All"&&$stat_year!="All")
	{
		$strWhereQuery = "WHERE date like '%".$stat_year."%'";
	}
	else
	if($stat_day!="All"&&$stat_month!="All"&&$stat_year=="All")
	{
		$strWhereQuery = "WHERE date like '".$stat_month." ".$stat_date."%'";
	}
	else
	if($stat_day!="All"&&$stat_month=="All"&&$stat_year!="All")
	{
		$strWhereQuery = "WHERE date like '%".$stat_day.", ".$stat_year."%'";
	}
	else
	if($stat_day=="All"&&$stat_month!="All"&&$stat_year!="All")
	{
		$strWhereQuery = "WHERE date like '".$stat_mont."%".$stat_year."%'";
	}
	
	
		if(trim($strWhereQuery)!="")
	{
	
		$iTotal=SQLCount("statistics",$strWhereQuery);
		$iUniques = SQLCount("statistics",$strWhereQuery." AND referer NOT LIKE '%".$strServerName."%' ");
		$iReloads = $iTotal - $iUniques;
	}
	else
	{
		$iTotal=SQLCount("statistics",$strWhereQuery);
		$iUniques = SQLCount("statistics","WHERE referer NOT LIKE '%".$strServerName."%' ");
		$iReloads = $iTotal - $iUniques;
	}
}
else
{
	$iTotal=SQLCount("statistics","");
	$iUniques = SQLCount("statistics"," WHERE referer NOT LIKE '%".$strServerName."%' ");
	$iReloads = $iTotal - $iUniques;
}

?>

<?php
if($iTotal != 0)
{
?>
<script>
function getChart() { 
	
	if(document.all)
	{
		document.all.piechart.setVariable("chart", "p=rere,<?php echo round(($iUniques*100)/$iTotal,2);?>,#FF9E00p=koko,<?php echo round(($iReloads*100)/$iTotal,2);?>,#C2CEE7"); 
		document.all.piechart.Play(); 
	}
	else
	{
		window.document.myFlash.setVariable("chart", "p=rere,<?php echo $iUniques;?>,#FF9E00p=koko,<?php echo $iReloads;?>,#C2CEE7"); 
		window.document.myFlash.Play(); 
		chartdata = "" 
	}
}
</script>
<?php
}
?>
<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext>
		<br>
		<b><?php echo $TOTAL_VISITS;?></b>
		<br><br>
		<table summary="" border="0" width=100%>
	  	<tr>
			
			<script>
			
			if(document.all)
			{
				document.write("<td class=basictext width=200>");
			}
			else
			{
				document.write("<td class=basictext width=1 style='display:none'>");
			}
			</script>
	  		
			
			<?php
			if($iTotal == 0)
			{
				echo "<font color=red><i>$NO_VISITS_FOR</i></font>";
			}
			else
			{
			?>
			<OBJECT  id="piechart" codeBase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" height="100" width="180" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" VIEWASTEXT>
				<PARAM NAME="_cx" VALUE="4763">
				<PARAM NAME="_cy" VALUE="2646">
				<PARAM NAME="FlashVars" VALUE="4763">
				<PARAM NAME="Movie" VALUE="swf/piechart.swf">
				<PARAM NAME="Src" VALUE="swf/piechart.swf">
				<PARAM NAME="WMode" VALUE="Transparent">
				<PARAM NAME="Play" VALUE="-1">
				<PARAM NAME="chart" VALUE="p=rere,100,#000000p=koko,20,#ee0000">
				<PARAM NAME="Loop" VALUE="-1">
				<PARAM NAME="Quality" VALUE="High">
				<PARAM NAME="SAlign" VALUE="">
				<PARAM NAME="Menu" VALUE="0">
				<PARAM NAME="Base" VALUE="">
				<PARAM NAME="Scale" VALUE="ShowAll">
				<PARAM NAME="DeviceFont" VALUE="0">
				<PARAM NAME="EmbedMovie" VALUE="0">
				<PARAM NAME="BGColor" VALUE="#ffffff">
				<PARAM NAME="SWRemote" VALUE="">
				<embed  name="myFlash" FlashVars="chart=p=rere,100,#000000p=koko,20,#ee0000"   bgcolor="#ffffff" src="swf/piechart.swf" width="260" height="200" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent">
				
				</embed>
			</OBJECT>
			<?php
			}
			?>
			
			
			</td>
	  		<td class=basictext align=left  valign=top>
			
			<form action="index.php" method=post>
			<input type=hidden name=ProceedFilter>
			<input type=hidden name=category value="<?php echo $category;?>">
			<input type=hidden name=action value="<?php echo $action;?>">
			
			
			<?php echo $STATISTICS_FOR;?>:
			
			<select name=stat_day>
				<option>All</option>
				<option <?php if(isset($stat_day)&&$stat_day==1) echo "selected";?>>1</option>
				<option <?php if(isset($stat_day)&&$stat_day==2) echo "selected";?>>2</option>
				<option <?php if(isset($stat_day)&&$stat_day==3) echo "selected";?>>3</option>
				<option <?php if(isset($stat_day)&&$stat_day==4) echo "selected";?>>4</option>
				<option <?php if(isset($stat_day)&&$stat_day==5) echo "selected";?>>5</option>
				<option <?php if(isset($stat_day)&&$stat_day==6) echo "selected";?>>6</option>
				<option <?php if(isset($stat_day)&&$stat_day==7) echo "selected";?>>7</option>
				<option <?php if(isset($stat_day)&&$stat_day==8) echo "selected";?>>8</option>
				<option <?php if(isset($stat_day)&&$stat_day==9) echo "selected";?>>9</option>
				<option <?php if(isset($stat_day)&&$stat_day==10) echo "selected";?>>10</option>
				<option <?php if(isset($stat_day)&&$stat_day==11) echo "selected";?>>11</option>
				<option <?php if(isset($stat_day)&&$stat_day==12) echo "selected";?>>12</option>
				<option <?php if(isset($stat_day)&&$stat_day==13) echo "selected";?>>13</option>
				<option <?php if(isset($stat_day)&&$stat_day==14) echo "selected";?>>14</option>
				<option <?php if(isset($stat_day)&&$stat_day==15) echo "selected";?>>15</option>
				<option <?php if(isset($stat_day)&&$stat_day==16) echo "selected";?>>16</option>
				<option <?php if(isset($stat_day)&&$stat_day==17) echo "selected";?>>17</option>
				<option <?php if(isset($stat_day)&&$stat_day==18) echo "selected";?>>18</option>
				<option <?php if(isset($stat_day)&&$stat_day==18) echo "selected";?>>19</option>
				<option <?php if(isset($stat_day)&&$stat_day==20) echo "selected";?>>20</option>
				<option <?php if(isset($stat_day)&&$stat_day==21) echo "selected";?>>21</option>
				<option <?php if(isset($stat_day)&&$stat_day==22) echo "selected";?>>22</option>
				<option <?php if(isset($stat_day)&&$stat_day==23) echo "selected";?>>23</option>
				<option <?php if(isset($stat_day)&&$stat_day==24) echo "selected";?>>24</option>
				<option <?php if(isset($stat_day)&&$stat_day==25) echo "selected";?>>25</option>
				<option <?php if(isset($stat_day)&&$stat_day==26) echo "selected";?>>26</option>
				<option <?php if(isset($stat_day)&&$stat_day==27) echo "selected";?>>27</option>
				<option <?php if(isset($stat_day)&&$stat_day==28) echo "selected";?>>28</option>
				<option <?php if(isset($stat_day)&&$stat_day==29) echo "selected";?>>29</option>
				<option <?php if(isset($stat_day)&&$stat_day==30) echo "selected";?>>30</option>
				<option <?php if(isset($stat_day)&&$stat_day==31) echo "selected";?>>31</option>
				
			</select>
			/
			<select name=stat_month>
				<option>All</option>
				<option <?php if(isset($stat_month)&&$stat_month=="January") echo "selected";?>>January</option>
				<option <?php if(isset($stat_month)&&$stat_month=="February") echo "selected";?>>February</option>
				<option <?php if(isset($stat_month)&&$stat_month=="March") echo "selected";?>>March</option>
				<option <?php if(isset($stat_month)&&$stat_month=="April") echo "selected";?>>April</option>
				<option <?php if(isset($stat_month)&&$stat_month=="May") echo "selected";?>>May</option>
				<option <?php if(isset($stat_month)&&$stat_month=="June") echo "selected";?>>June</option>
				<option <?php if(isset($stat_month)&&$stat_month=="July") echo "selected";?>>July</option>
				<option <?php if(isset($stat_month)&&$stat_month=="August") echo "selected";?>>August</option>
				<option <?php if(isset($stat_month)&&$stat_month=="September") echo "selected";?>>September</option>
				<option <?php if(isset($stat_month)&&$stat_month=="Octobery") echo "selected";?>>October</option>
				<option <?php if(isset($stat_month)&&$stat_month=="November") echo "selected";?>>November</option>
				<option <?php if(isset($stat_month)&&$stat_month=="December") echo "selected";?>>December</option>
			</select>
			/
			<select name=stat_year>
				<option>All</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2005") echo "selected";?>>2005</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2006") echo "selected";?>>2006</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2007") echo "selected";?>>2007</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2008") echo "selected";?>>2008</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2009") echo "selected";?>>2009</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2010") echo "selected";?>>2010</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2011") echo "selected";?>>2011</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2012") echo "selected";?>>2012</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2013") echo "selected";?>>2013</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2014") echo "selected";?>>2014</option>
				<option <?php if(isset($stat_year)&&$stat_year=="2015") echo "selected";?>>2015</option>
			</select>
			
			&nbsp;
			<input type=submit value=" Display " class=adminButton>
			
			</form>
			
				<?php
			if($iTotal != 0)
			{
			?>
				<i><?php echo $TOTAL;?>:</i> <b><?php echo $iTotal;?></b>
				<br><br>
				<i><?php echo $UNIQUES;?>:</i> <b><font color=#FF9E00><?php echo $iUniques;?> [<?php echo round(($iUniques*100)/$iTotal,2)."%";?>]</font></b>
				<br><br>
				<i><?php echo $RELOADS;?>:</i> <b><font color=#C2CEE7><?php echo $iReloads;?> [<?php echo round(($iReloads*100)/$iTotal,2)."%";?>]</font></b>
			<?php
			}
			?>
			</td>
	  	</tr>
	  </table>
  		
		<br><br>
		<form action="index.php" method=post>
		<input type=hidden name=category value="<?php echo $category;?>">
		<input type=hidden name=action value="<?php echo $action;?>">
		
		<?php echo $SHOW_CHART_FOR;?>: 
		
		<input type=radio name=chart_type value="days" <?php  if(!isset($chart_type)||(isset($chart_type)&&$chart_type!="months")) echo "checked";?>>
		<?php echo $FOR_THE_LAST;?> <input type=text size=4 name="number_days" value="<?php echo (isset($number_days)?$number_days:"10");?>"> <?php echo $DAYS;?>
		&nbsp;&nbsp;
		<input type=radio name=chart_type <?php  if(isset($chart_type)&&$chart_type=="months") echo "checked";?> value="months">
		<?php echo $PER_MONTHS;?>
		&nbsp;&nbsp;
		
		<input type=checkbox name=check_all <?php if(isset($check_all)||!isset($chart_type)) echo "checked";?>><?php echo $SHOW_UNIQUE;?>
		&nbsp;&nbsp;
		<input type=submit value=" <?php echo $DISPLAY;?> " class=adminButton>
		</form>
		
		<br>
		
		<?php
		if(isset($chart_type))
		{
		?>
		<center>
		<table bgcolor="#EFEFFF" border="0"   width=500  style="border-width:1px 1px 1px 1px;border-style:solid;border-color:black" cellpadding="0" cellspacing="0">
		  	<tr>
		  		<td align=center>
				<br>
				<?php
				if($chart_type=="days")
				{
				
					$tableStat = DataTable("statistics","");	
			
					$arrStatValues	= array();
					$arrStatValues2	= array();
					
					$iScale = 1;
					
					
					while($arrStat = mysql_fetch_array($tableStat))
					{
						
						
						$arrInfo = explode(",", $arrStat["date"]);	
						
						if(array_key_exists($arrInfo[0], $arrStatValues))
						{
						
							if(isset($check_all))
							{
								if(strstr($arrStat["referer"],$strServerName))
								{
									$arrStatValues2[$arrInfo[0]] ++;
								}
								else
								{
									$arrStatValues[$arrInfo[0]] ++;					
								}
							}
							else
							{
								
								$arrStatValues[$arrInfo[0]] ++;
							}
							
							
							
							if(isset($check_all) && $arrStatValues2[$arrInfo[0]] > $iScale)
							{
								$iScale = $arrStatValues2[$arrInfo[0]];				
							}
							
							if($arrStatValues[$arrInfo[0]] > $iScale)
							{
								$iScale = $arrStatValues[$arrInfo[0]];				
							}
						}
						else
						{
						
							if(sizeof($arrStatValues) == $number_days)
							{
								break;			
							}
							
							
							
							if(isset($check_all))
							{
								if(strstr($arrStat["referer"],$strServerName))
								{
									$arrStatValues2[$arrInfo[0]] = 1;
									$arrStatValues[$arrInfo[0]] = 0;					
								}
								else
								{
									$arrStatValues[$arrInfo[0]] = 1;	
									$arrStatValues2[$arrInfo[0]] = 1;				
								}
							}
							else
							{
								
								$arrStatValues[$arrInfo[0]] = 1;
							}
						}
					
					
						
						
						
					}
					
					
					
					
					
						$arrStatKeys = array_keys($arrStatValues);
						
						for($i=0;$i<sizeof($arrStatValues);$i++)
						{
							
							$strCurrentKey = $arrStatKeys[$i];
							
							echo "<table width=500  cellpadding=\"0\" cellspacing=\"0\"><tr><td width=410 class=basictext width=\"".round($arrStatValues[$strCurrentKey] * (400/$iScale))."\">";				
							echo "<img src=\"images/t3_0.gif\" border=\"0\" width=\"".round($arrStatValues[$strCurrentKey] * (400/$iScale))."\" height=\"17\" alt=\"\">";
							echo "<img src=\"images/t3_1.gif\" border=\"0\" width=\"3\" height=\"17\" >";
							
							if(isset($check_all))
							{
								echo "<br><img src=\"images/t1_0.gif\" border=\"0\" width=\"".round($arrStatValues2[$strCurrentKey] * (400/$iScale))."\" height=\"17\" alt=\"\">";
								echo "<img src=\"images/t1_1.gif\" border=\"0\" width=\"3\" height=\"17\" >";
							}
							
							if(isset($check_all))
							{
								echo "</td><td class=basictext width=90><b><a href=\"index.php?category=statistics&folder=reports&page=day&key=".urlencode($strCurrentKey)."\"><font color=#00039c>[".$strCurrentKey."]</font></a><br></b><i>$UNIQUES:</i> <b><font color=#ff9a00>".$arrStatValues[$strCurrentKey]."</font></b><br> <i>$RELOADS:</i> <b><font color=#ff9a00>".$arrStatValues2[$strCurrentKey]."</font></b></td></tr></table><br>";		
							}
							else
							{
								echo "</td><td class=basictext width=90><b><a href=\"index.php?category=statistics&folder=reports&page=day&key=".urlencode($strCurrentKey)."\"><font color=#00039c>[".$strCurrentKey."]</font></a></b><br><i>$TOTAL:</i><b><font color=#ff9a00>".$arrStatValues[$strCurrentKey]."</font></b></td></tr></table><br>";		
							}
						}		
				}
				?>
				
				<?php
				if($chart_type=="months")
				{
				
				
					$tableStat = DataTable("statistics","");	
			
					$arrStatValues	= array();
					$arrStatValues2	= array();
					
					$iScale = 1;
					
					
					while($arrStat = mysql_fetch_array($tableStat))
					{
						
						
						$arrInfo = explode(" ", $arrStat["date"]);	
						
						if(array_key_exists($arrInfo[0], $arrStatValues))
						{
						
							if(isset($check_all))
							{
								if(strstr($arrStat["referer"],$strServerName))
								{
									$arrStatValues2[$arrInfo[0]] ++;
								}
								else
								{
									$arrStatValues[$arrInfo[0]] ++;					
								}
							}
							else
							{
								
								$arrStatValues[$arrInfo[0]] ++;
							}
							
							
							
							if(isset($check_all) && $arrStatValues2[$arrInfo[0]] > $iScale)
							{
								$iScale = $arrStatValues2[$arrInfo[0]];				
							}
							
							if($arrStatValues[$arrInfo[0]] > $iScale)
							{
								$iScale = $arrStatValues[$arrInfo[0]];				
							}
						}
						else
						{
						
							if(sizeof($arrStatValues) == $number_days)
							{
								break;			
							}
							
							
							
							if(isset($check_all))
							{
								if(strstr($arrStat["referer"],$strServerName))
								{
									$arrStatValues2[$arrInfo[0]] = 1;
									$arrStatValues[$arrInfo[0]] = 0;					
								}
								else
								{
									$arrStatValues[$arrInfo[0]] = 1;	
									$arrStatValues2[$arrInfo[0]] = 1;				
								}
							}
							else
							{
								
								$arrStatValues[$arrInfo[0]] = 1;
							}
						}
					
					
						
						
						
					}
					
					
					
					
					
						$arrStatKeys = array_keys($arrStatValues);
						
						for($i=0;$i<sizeof($arrStatValues);$i++)
						{
							
							$strCurrentKey = $arrStatKeys[$i];
							
							echo "<table width=500  cellpadding=\"0\" cellspacing=\"0\"><tr><td width=410 class=basictext width=\"".round($arrStatValues[$strCurrentKey] * (400/$iScale))."\">";				
							echo "<img src=\"images/t3_0.gif\" border=\"0\" width=\"".round($arrStatValues[$strCurrentKey] * (400/$iScale))."\" height=\"17\" alt=\"\">";
							echo "<img src=\"images/t3_1.gif\" border=\"0\" width=\"3\" height=\"17\" >";
							
							if(isset($check_all))
							{
								echo "<br><img src=\"images/t1_0.gif\" border=\"0\" width=\"".round($arrStatValues2[$strCurrentKey] * (400/$iScale))."\" height=\"17\" alt=\"\">";
								echo "<img src=\"images/t1_1.gif\" border=\"0\" width=\"3\" height=\"17\" >";
							}
							
							if(isset($check_all))
							{
								echo "</td><td class=basictext width=90><b><a href=\"index.php?category=statistics&folder=reports&page=day&key=".urlencode($strCurrentKey)."\"><font color=#00039c>[".$strCurrentKey."]</font></a><br></b><i>$UNIQUES:</i> <b><font color=#ff9a00>".$arrStatValues[$strCurrentKey]."</font></b><br> <i>$RELOADS:</i> <b><font color=#ff9a00>".$arrStatValues2[$strCurrentKey]."</font></b></td></tr></table><br>";		
							}
							else
							{
								echo "</td><td class=basictext width=90><b><a href=\"index.php?category=statistics&folder=reports&page=day&key=".urlencode($strCurrentKey)."\"><font color=#00039c>[".$strCurrentKey."]</font></a></b><br><i>$TOTAL:</i><b><font color=#ff9a00>".$arrStatValues[$strCurrentKey]."</font></b></td></tr></table><br>";		
							}
						}		
				
				}
				?>
				</td>
		  	</tr>
		  </table>
  		</center>
		<?php
		}
		?>
		
		</td>
	</tr>
</table>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_STAT_REPORT;?>";
document.onmousedown = HTMouseDown;
</script>
