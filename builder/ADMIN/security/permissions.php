<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php

$ShowFrm=true;

if(isset($ProceedApplyPermissions)){

	SQLQuery("delete from ".$DBprefix."admin_users_permissions");
	
	$queryToExecute="";
	
	while (list($k, $v) = each($_POST)){
        
		if(substr($k, 0, 1)=="@"){
		
						
			$queryToExecute="
			INSERT INTO 
			".$DBprefix."admin_users_permissions(permission)
			VALUES('".strtr($k,"%%"," ")."');";
			
			SQLQuery($queryToExecute);
			
		}
    }
	
	echo "<table width=750><tr><td class=basictext><b>$NOUVEAUX_DROITS_ACCES_ENREGISTRES!</b></td></tr></table>";
	echo "".generateBackLink("permissions");
	$ShowFrm=false;
	

	$HISTORY=$MODIFICATION_DROITS_ACCES;

}



?>

<?php
if($ShowFrm){
?>

<form action="index.php" method=post>
<input type=hidden name=ProceedApplyPermissions value="">
<input type=hidden name=category value=<?php echo $category;?>>
<input type=hidden name=action value=<?php echo $action;?>>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
		
		<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td width=44>
		<img src="images/icons<?php echo $DN;?>/open.gif" border="0" width="44" height="32" alt="">
		</td>
		<td class=basicText>
		<b><?php echo $GROUPS_PERMISSIONS_MANAGEMENT;?></b>
		
		</td>
	</tr>
</table>
	
		<br><br>
<?php


$arrGroups=array ();
$Groups=DataTable("admin_users_type","");
$iGroupsCount=mysql_num_rows($Groups);


		while($oGroup=mysql_fetch_array($Groups)){
				array_push($arrGroups, $oGroup["type"]);
		}

array_multisort($arrGroups);
		
echo "<table width=750 celpadding=0 cellspacing=0 style='border-style:solid;border-color:#cecfce;border-width:1px 1px 1px 1px'>";

for($i=0;$i<sizeof($oLinkTexts);$i++){
	
	$strLink=$oLinkActions[$i];
	$strText=$oLinkTexts[$i];
	
	echo "<tr height=20 bgcolor=#cecfce>
					<td class=basictext>
						<font color=white>&nbsp;<b>$strText</b></font>
					</td>";
					
	foreach($arrGroups as $strGroup){
			echo "<td class=basictext>
							<font color=white>$strGroup</font>
					</td>";
		}
					
	echo"</tr>";
	
	eval("\$evSubLinks=\$".$strLink."_oLinkActions;");
	eval("\$evSubTexts=\$".$strLink."_oLinkTexts;");
	
	$boolColor=true;
	
	for($j=0;$j<sizeof($evSubLinks);$j++){
	
		$strSubLink=$evSubLinks[$j];
		$strSubText=$evSubTexts[$j];
	
		echo "<tr height=20 bgcolor=".($boolColor?"#ffffff":"#efefef").">";
		
		if($boolColor){
			$boolColor=false;
		}
		else{
			$boolColor=true;
		}
		
	
		echo "<td class=basictext>&nbsp;$strSubText</td>";
		
		foreach($arrGroups as $strGroup){
			echo "<td width=150  class=basictext>";
			
			if($strGroup=="Administrators"){
				echo "<input type=checkbox checked disabled>";
			}
			else{
			
				if(array_search("@$strGroup@$strLink@$strSubLink",$arrPermissions,false)){
				
					echo "<input type=checkbox checked name=\"".strtr("@$strGroup@$strLink@$strSubLink"," ","%%")."\">";
					
				}
				else{
					
				
					echo "<input type=checkbox name=\"".strtr("@$strGroup@$strLink@$strSubLink"," ","%%")."\">";
				}
			}
			
			echo "</td>\n";
		}
	
		echo "</tr>\n";
				
	}
	
	
}

echo "</table>";

?>		
		</td>
	</tr>
</table>

<br>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
			<input type=submit value=" <?php echo $APPLY_PERMISSIONS; ?> " class=adminButton>
		</td>
	</tr>
</table>
</form>
<?php
}
?>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_USER_PERMISSIONS;?>";
document.onmousedown = HTMouseDown;
</script>

