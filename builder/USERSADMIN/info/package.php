<?php
if(isset($ProceedChange))
{
?>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td>
		
<?php

$arrPackage = DataArray("blog_packages","id=".$package);

if($arrPackage["price"] == "0.00")
{

	SQLUpdate_SingleValue
			(
								"admin_users",
								"username",
								"'".$AuthUserName."'",
								"plan",
								$package
			);
			
	echo "<b>".$M_PACKAGE_SWITCH." : <span class=redtext>".strtoupper($arrPackage["name"])."</span></b><br><br>";
}
else
{
			SQLUpdate_SingleValue
			(
								"admin_users",
								"username",
								"'".$AuthUserName."'",
								"new_plan",
								$package
			);
			
			
			
			
			SQLUpdate_SingleValue
			(
								"admin_users",
								"username",
								"'".$AuthUserName."'",
								"payment",
								$payment_option
			);			
			
	if(get_param("payment_option") == "paypal")
				{
				
				
							echo "<div style='margin-left:20px;margin-right:5px;font-weight:800'>
								
								".$PLEASE_CLICK_ICON_PAYPAL."
								<br><br>";
								?>
								
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
								<input type="image" src="../images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
								 <input type="hidden" name="cmd" value="_xclick-subscriptions">
								<input type="hidden" name="business" value="<?php echo $PAYPAL_ACCOUNT;?>"> 
								<input type="hidden" name="item_name" value="<?php echo $BLOG_DOMAIN." ".$M_PACKAGE.": ".$arrPackage["id"]; ?>"> 
								<input type="hidden" name="item_number" value="<?php echo $arrPackage["id"]; ?>"> 
								<input type="hidden" name="no_note" value="1"> 
								<input type="hidden" name="currency_code" value="<?php echo $PAYPAL_CURRENCY_CODE; ?>"> 
								<input type="hidden" name="a3" value="<?php echo $arrPackage["price"]; ?>"> 
								<input type="hidden" name="p3" value="<?php echo $arrPackage["billed"]; ?>"> 
								<input type="hidden" name="t3" value="M"> 
								<input type="hidden" name="src" value="1"> 
								<input type="hidden" name="sra" value="1"> 
								<input type="hidden" name="return" value="http://www.<?php echo $BLOG_DOMAIN;?>"> 
								<input type="hidden" name="cancel_return" value="http://www.<?php echo $BLOG_DOMAIN;?>"> 
								<input type="hidden" name="custom" value="<?php echo $AuthUserName; ?>"> 
								<INPUT TYPE="hidden" NAME="first_name" VALUE="<?php echo $lArray["first_name"];?>">
								<INPUT TYPE="hidden" NAME="last_name" VALUE="<?php echo $lArray["last_name"];?>">
								</form>
								
								<?php
								echo "<br><br>".$M_YOUR_PACKAGE_NOT_ACTIVE;
								
								echo "</div>
								";
							
				}
				else
				if(get_param("payment_option") == "cheque")
				{
				
						$strAmount = $CURRENCY_SYMBOL.$arrPackage["price"];
						
											
						SQLInsert
							( 
								"blog_payments",
								array("date","user","method","validated","amount"),
								array(time(),$AuthUserName,"cheque","0",$arrPackage["price"])
							);
									
						echo "<div style='margin-left:20px;margin-right:5px;font-weight:800'>
								
								".str_replace("{AMOUNT}","<span class=redtext>".$strAmount."</span>",$M_PLEASE_SEND_CHECK_TO)."
								<br><br>
								".$CHEQUE_ADDRESS."
								<br><br>
								<span class=redtext>$M_YOUR_PACKAGE_NOT_ACTIVE</span>
								</div>
								";
						
				}
				else
				if(get_param("payment_option") == "bank_wire")
				{
						
						$strAmount = $CURRENCY_SYMBOL.$arrPackage["price"];
						
												
						SQLInsert
							( 
								"blog_payments",
								array("date","user","method","validated","amount"),
								array(time(),$AuthUserName,"bank transfer","0",$arrPackage["price"])
							);
										
						echo "<div style='margin-left:20px;margin-right:5px;font-weight:800'>
								
								".str_replace("{AMOUNT}","<span class=redtext>".$strAmount."</span>",$M_PLEASE_MAKE_TRANSFER)."
								<br><br>
								".$BANK_WIRE_TRANSFER_INFO."
								<br><br>
								<span class=redtext>$M_YOUR_PACKAGE_NOT_ACTIVE</span>
								
								</div>
								";
						
				}
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


<br>
<table summary="" border="0" width="100%">
	<tr>
		<td>

<?php
$arrUser = DataArray("admin_users","username='$AuthUserName'");
$arrPackage = DataArray("blog_packages","id=".$arrUser["plan"]);

if(!isset($arrPackage) || $arrPackage["id"] == "")
{

	echo "<span class=redtext><b>".$M_PACKAGE_DELETED."</b></span><br><br>";

}
else
{
?>
<font color=#636563>
		<b>
		<?php echo $PACKAGE_DETAILS;?>
		</b>
		</font>
		
<hr width=100% color=#636563>
<br>
<?php echo $NOM;?>: <b><?php echo $arrPackage["name"];?></b> 
&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $SPACE;?>: <b><?php echo FormatSpace($arrPackage["space"]);?></b> 
&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $BANDWIDTH;?>: <b><?php echo FormatSpace($arrPackage["traffic"]);?></b> 
<br><br>
<?php echo $arrPackage["description"];?>
<br><br>
<br>
<b>
<?php echo $M_CURRENTLY_YOU_HAVE_USED;?>
<span class=redtext>
<?php
$fSpace = SpaceOccupied();
echo round((($fSpace/$arrPackage["space"])*100),2)."%";
?>
</span>
<?php echo $M_ALLOCATED;?>
</b>
<br><br>
<a href="index.php?category=info&action=space"><?php echo $M_CLICK_HERE_TO_SEE_DETAILS;?></a>
<br><br>
<?php
}
?>

<br><br>
<?php
$has_paid_package = false;
if(!$SERVICE_IS_FREE)
{
?>
<font color=#636563>
		<b>
		<?php echo $M_UPGRADE_PACKAGE;?>
		</b>
		</font>
		
<hr width=100% color=#636563>

<form action="index.php" method="post" style="margin-top:0px;margin-bottom:0px">
<input type=hidden name=action value="<?php echo $action;?>">
<input type=hidden name=category value="<?php echo $category;?>">
<input type=hidden name=ProceedChange value="1">
<br>

		<script>
				function ShowPaymentOptions(x,y)
				{
					for(i=1;i<=iTotalPackages;i++)
					{
						document.getElementById("tr"+i).style.background="#f1f1f1";
						document.getElementById("table"+i).style.display="none";
					}
					
					
					document.getElementById("tr"+x).style.background="#ececec";
					
					
					
					
					var arrItems=y.split("-"); 
					
					if(arrItems.length>1)
					{
									document.getElementById("PaymentOptions").style.display="block";
									
									for(i=0;i<arrItems.length;i++)
									{
										if(arrItems[i] != "")
										{
											document.getElementById("table"+arrItems[i]).style.display = "block";
										}
									}
									
					}
					else
					{
									document.getElementById("PaymentOptions").style.display="none";
					}
				
					
				}
				
				</script>
			
				
				<?php
				$tablePackages = DataTable("blog_packages","ORDER BY price");
				
				echo "<table width=\"100%\" cellpadding=0 cellspacing=0>";
				
					echo "<tr height=30>
								<td width=35></td>	
								<td><i>".strtoupper($NOM)."</i></td>
								<td width=80><i>".strtoupper($SPACE)."</i></td>	
								<td width=80><i>".strtoupper($BANDWIDTH)."</i></td>	
								
							</tr>";
				$iPCounter=1;						
				$bFirst = true;
				$iTotalPackages = 0;
				while($arrCurrentPackage = mysql_fetch_array($tablePackages))
				{
						
						$iTotalPackages++;
						
						$strPaymentOptions = "";
						$strPayments = "";
						
						if($arrCurrentPackage["paypal"] == 1)
						{
							$strPayments .= "<b>".$M_PAYPAL."</b>, ";
							$strPaymentOptions .= "1-";
						}
						
						if($arrCurrentPackage["cheque"] == 1)
						{
							$strPayments .="<b>". $M_CHEQUE."</b>, ";
							$strPaymentOptions .= "2-";
						}
						
						if($arrCurrentPackage["bank_wire"] == 1)
						{
							$strPayments .= "<b>".$M_BANK_WIRE."</b>, ";
							$strPaymentOptions .= "3-";
						}
						
						
						$strPayments = trim($strPayments);
						
						if($arrCurrentPackage["price"] == "0.00" || $arrCurrentPackage["price"] == "")
						{
							$strPaymentOptions = "";
						}
						else
						{
							$has_paid_package = true;
						}
				
					echo "<tr height=35 bgcolor='".($arrCurrentPackage["id"]==$arrPackage["id"]?"#ececec":"#f1f1f1")."' id=\"tr".$iPCounter."\">";
					
					echo "
								<td>
										<input ".($arrCurrentPackage["id"]==$arrPackage["id"]?"checked":"")." onclick=\"javascript:ShowPaymentOptions(".$iPCounter.",'".$strPaymentOptions."')\" type=\"radio\" name=\"package\" value=\"".$arrCurrentPackage["id"]."\">
								</td>
								<td>
										<b>".$arrCurrentPackage["name"]."</b>
								</td>
								<td>
										<b>".FormatSpace($arrCurrentPackage["space"])."</b>
								</td>
								<td>
										<b>".FormatSpace($arrCurrentPackage["traffic"])."</b>
								</td>
								
					
					";	
					
					$bFirst = false;	
						
					echo "</tr>";
					
					echo "
							<tr height=35 bgcolor=#fafafa>
								<td colspan=4>
										<div style='margin-top:10px;margin-left:5px;margin-right:5px;margin-bottom:10px'>
							";
					
					if($arrCurrentPackage["price"] == "0.00" || $arrCurrentPackage["price"] == "")			
					{
						echo "<b>".strtoupper($M_PRICE).":
										<span class=redtext>".$M_FREE."!!!</span></b>";
					
					}
					else
					{
						echo "<b>".strtoupper($M_PRICE_FOR." ".$arrCurrentPackage["billed"]." ".$MM_MONTHS).":
										<span class=redtext>".$CURRENCY_SYMBOL.$arrCurrentPackage["price"]."</span></b>";
						echo "
							<br><i>
							(".$M_PAID_PER." <b>".$arrCurrentPackage["billed"]."</b> ".$MM_MONTHS.", 
							".$M_AVERAGE_PRICE_MONTH.": ".$CURRENCY_SYMBOL.number_format(round($arrCurrentPackage["price"]/$arrCurrentPackage["billed"],2),2,'.','')."</i>)";				
						
						
						
						if(strlen($strPayments)>1)
						{
							$strPayments = substr($strPayments, 0, (strlen($strPayments)-1) );
						}
						
						
						echo "<br><br>".$M_PAYMENTS_BY.": ".$strPayments;
						
						
					}
										
					echo "			<br><br>
										<i>".$arrCurrentPackage["description"]."</i>
										</div>
								</td>
							</tr>
							<tr height=5>
								<td colspan=4>
									&nbsp;
								</td>
							</tr>
					";
					$iPCounter++;
				}
				
				echo "</table>";
				
				echo "
				<script>
				var iTotalPackages=".$iTotalPackages.";
				</script>
				";
				
				?>
				
				<?php
				if($has_paid_package)
				{
				?>
				<div id="PaymentOptions">
				<b><?php echo $M_PLEASE_SELECT_YOUR_PAYMENT;?>:<br></b>
				</div>
				
				<table class=home_table id="table1" style="display:none">
					<tr><td  width="200" valign=middle><input type=radio checked name=payment_option value=paypal> <b><?php echo $M_PAYPAL;?></b> </td><td width=178 valign=middle ><img src='../images/paypal.gif'></td></tr>
				</table>
				
				<table class=home_table id="table2" style="display:none">
						<tr><td  width="200" valign=middle><input type=radio name=payment_option value=cheque> <b><?php echo $M_CHEQUE;?></b> </td><td valign=middle><img src='../images/cheque.gif'></td></tr>
				</table>
				
				<table class=home_table id="table3" style="display:none">
						<tr><td  width="200" valign=middle><input type=radio name=payment_option value=bank_wire> <b><?php echo $M_BANK_WIRE;?></b> </td><td valign=middle><img src='../images/banque.gif'></td></tr>
				</table>
				
				
				<br>
				<br>
				<input type=submit class=adminButton value=" <?php echo $M_NEXT;?> ">

				<?php
				}
				?>
				
				


<br>

</form>


<?php
}
?>


		</td>
	</tr>
</table>
<?php
}
?>

