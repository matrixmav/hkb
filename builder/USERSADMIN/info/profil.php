
<br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		<?php
		if(isset($SaveImprint))
		{
			SQLUpdate_SingleValue
			(
				"admin_users",
				"username",
				"'".$AuthUserName."'",
				"card_exp_year",
				$imprint
			);
			
			$lArray=DataArray("admin_users","username='$AuthUserName'");
		}
		?>
		<script>
		function ImprintClicked()
		{
			document.ImprintForm.submit();
		}
		</script>
		
		<form name="ImprintForm" action="index.php" method="post" style="margin-top:0px;margin-bottom:0px">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="SaveImprint" value="1">
		
		<table summary="" border="0" width=100%>
  			<tr>
  				<td>
						<font color=#636563>
						<b>
							<?php echo $PERSONAL_INFORMATION;?>
						</b>
						<i>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $SHOW_THIS_INFO_ON_MY_BLOG;?>: 
						&nbsp;&nbsp;
						<input type="radio" onclick="javascript:ImprintClicked()" name="imprint" value="1" <?php if($lArray["card_exp_year"]=="1") echo "checked";?>> <?php echo $M_YES;?>
						&nbsp;&nbsp;
						<input type="radio" onclick="javascript:ImprintClicked()" name="imprint" value="0" <?php if($lArray["card_exp_year"]=="0"||$lArray["card_exp_year"]=="") echo "checked";?>> <?php echo $M_NO;?>
						&nbsp;&nbsp;
						</i>


						</font>
		
				</td>
				<td align=right>
				
				<a href="index.php?page=edit&folder=profil&category=<?php echo $category;?>">
				[<?php echo strtoupper($MODIFY);?>]
				</a>
				
				</td>
  			</tr>
  		</table>
		
		
<hr width=100% color=#636563>
<br>
<center>
<?php
$SubmitButtonText = "";
 AddEditForm_BA
	(
	array(
		$FIRST_NAME,
		$LAST_NAME,
		$M_COMPANY,
		$TELEPHONE,
		$EMAIL,
		$COUNTRY,
		$ADDRESS1,
		$ADDRESS2,
		$CITY,
		$M_ZIP
	),
	array(
		"first_name",
		"last_name",
		"company",
		"telephone","email","country",
					
				"address_address1",
				"address_address2",
				"address_city",
			
				"address_zip"
	),
	array(
			"first_name",
			"last_name",
			"company",
			"telephone",
			"email",
			"country",
					
				"address_address1",
				"address_address2",
				"address_city",
			
				"address_zip"
	),
	array(
		"textbox_30",
		"textbox_30",
		"textbox_30",
		"textbox_30 ","textbox_30","country",
	
	"textbox_30",
	"textbox_30",
	"textbox_30",
	"textbox_30"
	
	
	
	
	),
	"admin_users",
	"username",
	"'".$AuthUserName."'",
	$LES_VALEURS_MODIFIEES_SUCCES
	);


?>

</center>



<br><br>




		</td>
	</tr>
</table>

<script>
var HTType="1";
var HTMessage="<?php echo $T_INFO_BOARD;?>";
document.onmousedown = HTMouseDown;
</script>
