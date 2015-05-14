<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>
<table summary="" border="0" width=100%>
	<tr>
		<td width=41><img src="images/icons/folder_download.png" width="48" height="48" alt="" border="0"></td>
		<td class="blog_admin_header">
		
		<?php echo $BANDWIDTH_INFORMATION;?>
		
		</td>
	</tr>
</table>

<?php
$arrSpace = array();
$arrLimit = array();
$arrPackages = array();

$tablePackages = DataTable("blog_packages","");

while($tablePackage = mysql_fetch_array($tablePackages))
{
	$arrPackages[$tablePackage["id"]] = $tablePackage["space"];
}

$tableUsers = DataTable("admin_users","WHERE username = '$AuthUserName' ");

while($tableUser = mysql_fetch_array($tableUsers))
{
	$arrSpace[$tableUser["username"]] = 0;
	$arrLimit[$tableUser["username"]] = $arrPackages[$tableUser["plan"]];

}

$strWhere = "";

if(isset($ProceedApply))
{
	ms_i($code);
 	if($code == "1")
	{
	
	}
	else
	if($code == "2")
	{
		$strWhere = " WHERE date>=".mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))." ";
	}
	else
	if($code == "3")
	{
		$strWhere = " WHERE date>=".mktime(0, 0, 0, date("m")-2, date("d"),   date("Y"))." AND date<= ".mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))."";
	}
	else
	if($code == "4")
	{
		$strWhere = " WHERE date>=".strtotime("-1 month")."";
	}
	else
	if($code == "5")
	{
		$strWhere = " WHERE date>=".strtotime("-1 week")."";
	}
	else
	if($code == "6")
	{
		$strWhere = " WHERE date>=".strtotime("-1 day")."";
	}
}

$tableBands = DataTable("blog_band",$strWhere);

while($tableBand = mysql_fetch_array($tableBands))
{

	if (array_key_exists($tableBand["user"], $arrSpace)) 
	{
		$arrSpace[$tableBand["user"]] += $tableBand["size"];
	}
}



?>

<form action="index.php" method="post">
<input type=hidden name=ProceedApply>
<input type=hidden name=action value="<?php echo $action;?>">
<input type=hidden name=category value="<?php echo $category;?>">

<table summary="" border="0" width=100%>
	<tr>
		<td>
		<br><br>
		<i><?php echo $TIME_PERIOD;?>:

		
		<select name="code">
			<option value="1" <?php if(isset($code)&&$code==1) echo "selected";?>><?php echo $M_ALL;?></option>
			<option value="2" <?php if(isset($code)&&$code==2) echo "selected";?>><?php echo $THIS_CM;?></option>
			<option value="3" <?php if(isset($code)&&$code==3) echo "selected";?>><?php echo $PREVIOUS_CM;?></option>
			<option value="4" <?php if(isset($code)&&$code==4) echo "selected";?>><?php echo $LAST_1_MONTH;?></option>
			<option value="5" <?php if(isset($code)&&$code==5) echo "selected";?>><?php echo $LAST_1_WEEK;?></option>
			<option value="6" <?php if(isset($code)&&$code==6) echo "selected";?>><?php echo $LAST_1_DAY;?></option>
		</select>
		&nbsp;&nbsp;
		<input type=submit value=" <?php echo $AFFICHER;?> " class=adminButton>
		</i>
		</form>
		<br><br><br><br><br>
		

		<font color=#636563>		
		
		<b>
		<?php echo $TOTAL_TRAFFIC;?>: 
		
		<font color=#ff9608>
		<?php
		echo round($arrSpace[$AuthUserName]/1024);
		?>
		<?php echo $M_KB;?>
		</font>
		</b>
		</font>
		<br><br><br><br><br>
<?php
/*
?>		
<br><br>
		<br><br>
		<B><?php echo $DETAILED_TRAFFIC_REPORT;?>:</B>
		</td>
	</tr>
</table>
<br>







<?php

RenderTable
(
	"blog_band",
	array("date","size","ip"),
	array($DATE_MESSAGE,$SIZE,$IP_MESSAGE),
	"100%",
	($strWhere==""?"WHERE user='$AuthUserName'":$strWhere." AND user='$AuthUserName'")." ORDER BY id DESC",
	"",
	"",
	"index.php?category=$category&action=$action".(isset($code)?"&ProceedApply=1&code=".$code:"")
);
*/
?>

<script>
var HTType="2";
var HTMessage="<?php echo $T_BANDWIDTH;?>";
document.onmousedown = HTMouseDown;
</script>
