
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
if(isset($Delete))
{
	if(sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDelete("notes","id",$CheckList);
	}
}
?>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	<TR>
		<td class=basicText>
			<br>
			
			
			<table summary="" border="0">
				<tr>
					<td width=38><img src="images/icons<?php echo $DN;?>/erase.gif" border="0" width="38" height="41" alt=""></td>
					<td class=basictext><b>List of the user news</b></td>
				</tr>
			  </table>
  
			<br><br>
			<center>
			<?php
				
				$arrTDSizes = array("50","100","100","*");
				$oCol=array("user","date","title","html");
				$oNames=array("User","Date","Title","Text");
				$ORDER_QUERY="ORDER BY id DESC";
				RenderTable("notes",$oCol,$oNames,"100%","WHERE user<>'administrator'  ",$EFFACER,"id","index.php?action=$action&category=".$category);
	
			?>
			</center>
			<br>
		</td>
	</tr>
	</table>

