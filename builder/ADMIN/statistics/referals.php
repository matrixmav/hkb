
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
$strWhereQuery="";

$strServerName=$_SERVER["SERVER_NAME"];

if(isset($ProceedFilter))
{
	
	
	if($stat_day=="All"&&$stat_month=="All"&&$stat_year=="All")
	{
		
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
		$strWhereQuery = "WHERE date like '".$stat_month."%".$stat_year."%'";
	}
	
	if($strWhereQuery=="")
	{
		$strWhereQuery .= "WHERE referer <> '' AND referer NOT LIKE '%$strServerName%' ";
	}
	else
	{
		$strWhereQuery .= "AND referer <> ''  AND referer NOT LIKE '%$strServerName%' ";
	}
}

?>

<table summary="" border="0" width=100%>
	<tr>
		
		<td class=basictext>
		
		
		<b>
		
		
		
			<form action="index.php" method=post>
			<input type=hidden name=ProceedFilter>
			<input type=hidden name=category value="<?php echo $category;?>">
			<input type=hidden name=action value="<?php echo $action;?>">
			
			
			<?php echo $FILTER_REFERALS;?>: &nbsp;
			
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
			<input type=submit value=" <?php echo $FILTER;?> " class=adminButton>
			
			</form>
		</b>
		</td>
	</tr>
</table>
<br>
<?php

$arrTDSizes=array(250,"*");
RenderTable
(
	"statistics",
	array("previous_date","referer"),
	array($DATE_MESSAGE,$REFERER),
	"100%",
	($strWhereQuery!=""?$strWhereQuery:"WHERE trim(referer) <> ''  AND referer NOT LIKE '%$strServerName%'") ,
	"",
	"",
	"index.php?category=statistics&action=referals"
);
?>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_STAT_REFERALS;?>";
document.onmousedown = HTMouseDown;
</script>
