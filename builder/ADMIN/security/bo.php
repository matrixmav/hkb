<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
	<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
		
				<form action=index.php method=post>
				<input type=hidden name=action value="<?php echo $action;?>">
				<input type=hidden name=category value="<?php echo $category;?>">
				
				<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<tr>
		<td width=49>
			<img src="images/icons<?php echo $DN;?>/write.gif" border="0" width="49" height="45" alt="">
		</td>
		<td class=basicText>
				<b><?php echo $HISTORIQUE_POUR_UTILISATEUR;?>: 
				<?php
					echo HtmlComboBox(
								"admin_users",
								"username",
								"username"
							);
				?>
				</b>
				&nbsp;&nbsp;
				<input type=submit value=" <?php echo $AFFICHER;?> " class=adminButton>
				
		</td>
	</tr>
</table>

			</form>
<br>				
				<br>
				<?php
				$arrTDSizes=array("200","100","*");
					$oCol=array("date","uid","description");
					$oNames=array($DATE_MESSAGE,$UTILISATEUR,$DESCRIPTION);
					
					$strWhere="";
					
					if(isset($username)){
						$strWhere="WHERE uid='$username'";	
					}
					$ORDER_QUERY="ORDER BY id desc";
					RenderTable("bo_history",$oCol,$oNames,750,$strWhere." ","","id","index.php?action=bo&category=".$category);
									
				?>

				<br>
		</td>
	</tr>
	</table>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_HISTORY;?>";
document.onmousedown = HTMouseDown;
</script>

