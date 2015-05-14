<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
if(isset($Delete)){
	SQLDelete("admin_users_type","id",$CheckList);

	$HISTORY=$THE_GROUP." ".$HAS_BEEN_DELETED;
}
?>
	
<?php
if(isset($ProceedAddNewGroup)){

		SQLInsert("admin_users_type",
		array("type"),
		array($newtype));

		$HISTORY=$THE_NEW_GROUP." ".strtoupper($newtype)." ".$HAS_BEEN_ADDED;
		
		
}

?>

<form action="index.php" method=post>
<input type=hidden name=category value="<?php echo $category;?>">
<input type=hidden name=action value="<?php echo $action;?>">

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
		
		<table summary="" border="0">
	  	<tr>
	  		<td width=39><img src="images/icons<?php echo $DN;?>/users.gif" border="0" width="39" height="38" alt=""></td>
	  		<td class=basictext><b><?php echo $AJOUTER_NOUVEL_PROFIL;?></b>	</td>
	  	</tr>
	  </table>
  
			
		<br><br>
		
	<table summary="" border="0">
  		<tr>
  			<td class=basicText><?php echo $NOM;?>: </td>
  			<td class=basicText><input type=text size=30 name=newtype></td>
  		</tr>
    </table>
  
		
		</td>
	</tr>
</table>
<br>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
			<input type=submit value=" <?php echo $AJOUTER;?> " class=adminButton>
		</td>
	</tr>
</table>

<input type=hidden name=ProceedAddNewGroup>
</form>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
				<br>
				<b><?php echo $LISTE_PROFILS_EXISTANTS;?> </b>
				<br><br>
				<center>
				<?php
				
					$arrTDSizes = array("50","*");
					$oCol=array("id","type");
					$oNames=array($ID_MESSAGE,$PROFIL);
					
					$ORDER_QUERY="ORDER BY id asc";
					
					RenderTable(
					"admin_users_type",$oCol,$oNames,450,
					" ",
					$EFFACER,
					"id",
					"index.php?action=types&category=".$category);
					
				?>
				</center>
				<br>
		</td>
	</tr>
	</table>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_ADD_GROUP;?>";
document.onmousedown = HTMouseDown;
</script>

