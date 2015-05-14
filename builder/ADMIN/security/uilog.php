
	<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
				<br>
				

				<form action=index.php method=post>
				<input type=hidden name=category value="<?php echo($category);?>">
				<input type=hidden name="action" value="<?php echo($action);?>">
				Display log for IP : <input type=text name=UserIp size=20>
				<input type=submit value="Show" class=adminButton>
				</form>
				<br>
				<b>User tracking list </b>
				<br><br>
				<br><br>
				<?php
					$oCol=array("ip","uid","date","ShowUIParams");
					$oNames=array("IP","Session","Date","Parameters");
					
					$strWhere="";
					if(isset($UserIp)){
						$strWhere="where ip='$UserIp'";
					}
					$ORDER_QUERY="ORDER BY id desc";
					RenderTable("slog",$oCol,$oNames,750,$strWhere." ","Delete","id","index.php?action=view&category=".$category);
					
					
				?>
				
				<br>
		</td>
	</tr>
	</table>
