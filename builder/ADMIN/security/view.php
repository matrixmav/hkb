<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
	<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
				<br>
				

				<form action=index.php method=post>
				<input type=hidden name=category value="<?php echo($category);?>">
				<input type=hidden name="action" value="<?php echo($action);?>">
				
				<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<tr>
		<td width=44>
			<img src="images/icons<?php echo $DN;?>/clipboard.gif" border="0" width="40" height="38" alt="">
		</td>
		<td class=basicText>
				<b><?php echo $LOG_FOR_IP;?></b> <input type=text name=UserIp size=20 <?php if(isset($UserIp)) echo "value=\"".$UserIp."\"";?>>
				<input type=submit value=" <?php echo $AFFICHER;?> " class=adminButton>
		
		</td>
	</tr>
</table>

					</form>
				<br>
				
				
				<?php
					$oCol=array("ip","uid","date","ShowUIParams_BO");
					$oNames=array($IP_MESSAGE,$UTILISATEUR,$DATE_MESSAGE,$M_PARAMS);
					
					$strWhere="";
					if(isset($UserIp)){
						$strWhere="where ip='$UserIp'";
					}
					
					$ORDER_QUERY="ORDER BY id desc";
					RenderTable("bo_slog",$oCol,$oNames,750,$strWhere." ","","id","index.php?action=view&category=".$category);
				
				?>
				
				<br>
		</td>
	</tr>
	</table>
	<script>
var HTType="1";
var HTMessage="<?php echo $HT_VIEW_SECURITY_LOG;?>";
document.onmousedown = HTMouseDown;
</script>

