<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	
	<tr>
		
		<td class=basictext >
		
		<?php
		if(SQLCount("forms_data","") == 0)
		{
			echo "<br><b>No data has been posted yet</b>";
		}
		else
		{
		?>
		
		<b>
		<?php echo $IN_ORDER_TO_SEE;?>:
		</b>
		
		
		<br><br><br>
		
		<center>
		<table width="100%">
		<?php
		$dataTable = DataTable("forms","");
		
		echo "
				<tr>
				<td colspan=2 ><i>DATA POSTED BY USERS</i></td>
				
				<td><i>NAME</i></td>
				<td><i>PAGE</i></td>
		
				<td><i>TOTAL POSTS</i></td>
				<td><i>LAST POST</i></td>
							
				<tr>
			";				
		while($arrTable = mysql_fetch_array($dataTable))
		{
			$arrPageItems = explode("_", $arrTable["page"]);
			
			if(sizeof($arrPageItems) == 2)
			{
			
			}
			else
			{
				continue;
			}
			echo "
				
				<tr>
				
					<td ><a href=\"index.php?category=$category&folder=$action&page=view&id=".$arrTable["id"]."\">[VIEW POSTED DATA]</a></td>
					<td><img src='images/icons".$DN."/email.gif' width=40 height=34 border=0></td>
					<td>".$arrTable["name"]."</td>
					<td><a target=_blank href='".GenerateLink3(aParameter(1111),aParameter(1112),$arrPageItems[0],stripslashes($arrPageItems[1]))."'>[".$arrPageItems[1]."]</a></td>
					
					<td>".SQLCount("forms_data","WHERE form_id=".$arrTable["id"]." ")."</td>
					<td>".getSingleValue("forms_data","form_id",$arrTable["id"]." ORDER BY id desc","date")."</td>
				
				</tr>
			
			";
		}
		
		?>
		
		</table>
		</center>
		
		<?php
		}
		?>
		</td>
	</tr>
	
</table>
<br><br><br>

