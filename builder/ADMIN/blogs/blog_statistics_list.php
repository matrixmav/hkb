<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	<TR>
		<td class=basicText>
				<?php
				
				$strWhere = "";
				$strMessage = "";
				
				if($list_type == "a")
				{
					$strMessage = "List with the active blogs";
					$strWhere = "WHERE blog_active=1 AND username<>'administrator'";
				}
				else
				if($list_type == "n")
				{
					$strMessage = "List with the not active blogs";
					$strWhere = "WHERE blog_active=0 AND username<>'administrator'";
				}
				else
				{
					$arrPackage = DataArray("blog_packages","id=".$list_type);		
					
					$strMessage = "List with blogs using package: ".$arrPackage["name"];
					$strWhere = "WHERE plan=".$list_type;
						
				}
				
				?>
				
				<table summary="" border="0">
				  	<tr>
				  		<td width=38><img src="images/icons<?php echo $DN;?>/erase.gif" border="0" width="38" height="41" alt=""></td>
				  		<td class=basictext><b><?php echo $strMessage;?></b></td>
				  	</tr>
				  </table>
	  
				<br>
				<center>
				<?php
					
					$oCol=array("username","email","blog_created","last_update","plan");
					$oNames=array($UTILISATEUR,$EMAIL,"Created","Expires","Package");
					$ORDER_QUERY="ORDER BY type";
					
					
					RenderTable("admin_users",$oCol,$oNames,"100%",$strWhere,"","id","index.php?folder=$folder&page=$page&category=".$category."&list_type=".$list_type);
		
				?>
				</center>
				<br>
				<?php
				generateBackLink("blog_statistics");
				?>
		</td>
	</tr>
	</table>
