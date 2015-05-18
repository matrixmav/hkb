<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php

if(isset($Delete)){
	
	if(sizeof(array_diff($CheckList,array("1")))>0){
	
		SQLDelete("admin_users","id",array_diff($CheckList,array("1")));
	
	}

}

?>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
				<br>
				
				
				<table summary="" border="0">
				  	<tr>
				  		<td width=38><img src="images/icons<?php echo $DN;?>/erase.gif" border="0" width="38" height="41" alt=""></td>
				  		<td class=basictext><b><?php echo $LISTE_DES_UTILISATEURS;?></b></td>
				  	</tr>
				  </table>
	  
				<br><br>
				<center>
				<?php
					
					$oCol=array("ShowModifierUtilisateur","username","type","email");
					$oNames=array($MODIFIER,$UTILISATEUR,$PROFIL,$EMAIL);
					$ORDER_QUERY="ORDER BY type";
					RenderTable("admin_users",$oCol,$oNames,550,"  ",$EFFACER,"id","index.php?action=admin&category=".$category);
		
				?>
				</center>
				<br>
		</td>
	</tr>
	</table>

