<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}

if(isset($Export)){
	header("Location: include/exportform.php?form_id=".$form_id."&type=".$type);
}

?>
<?php

if(isset($ProceedDelete))
{
	ms_i($del_id);
	SQLDelete("forms_data","id",array($del_id));
}

ms_i($id);
$arrForm=DataArray("forms","id='$id'");
$id=$arrForm["id"];

if($id=="")
{

	
}
else
{
	$dataTable=DataTable("forms_data","WHERE form_id=$id");
?>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	<tr>
		<td class=basicText align=right>
		<br>
			<form action="index.php" method=post>
			<input type="hidden" name="form_id" value="<?php echo $id;?>">
			<input type="hidden" name="folder" value="<?php echo $folder;?>">
			<input type="hidden" name="page" value="<?php echo $page;?>">
			<input type="hidden" name="Export" value="">
			<input type=hidden name=category value="<?php echo($category);?>">
			
			
			<input type=radio name=type value="tdf" checked> TDF
			<input type=radio name=type value="csv"> CSV
			
			&nbsp;&nbsp;
			<input type=submit value="Export" class=adminButton>
			</form>
		</td>
	</tr>
</table>

<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext>
		<b>
		Form: <font color=red><?php echo $arrForm["name"];?></font>
		</b>
		<br>
		<?php 
		echo "[";
		
		if(trim($arrForm["description"])!=""){
			echo $arrForm["description"];
		}
		else{
			echo $PAS_DE_DESCRIPTION;
		}
		
		
		echo "]";
		?>
		<br><br>
		
		<table cellpadding=0 cellspacing=0 width=100% style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>
		<tr bgcolor=#efefef height=20>
			<td width=80 class=oHeader>&nbsp;<?php echo $EFFACER;?></td>
			<td width=200 class=oHeader><?php echo $DATE_MESSAGE;?></td>
			<td width=100 class=oHeader><?php echo $IP_MESSAGE;?></td>
			<td width=450 class=oHeader><?php echo $DATA_MESSAGE;?></td>
		</tr>
		<?php
		
		$bColor=true;
		
		while($arrData=mysql_fetch_array($dataTable)){
			echo "<tr bgcolor=".($bColor?"#ffffff":"#e7dfef")." height=22>";
			
			echo "<td  class=oMain valign=top>&nbsp;
			<a href='index.php?category=$category&folder=$folder&page=$page&ProceedDelete=true&id=$id&del_id=".$arrData['id']."' >
			<img src='images/cancel.gif' border=0>
			</a>
			</td>";
			
			echo "<td  class=oMain valign=top>".$arrData["date"]."</td>";
			echo "<td  class=oMain valign=top>".$arrData["ip"]."</td>";
			
			echo "<td  class=oMain valign=top>";
			
			$arrValues=unserialize($arrData["data"]);
			
			echo "<table width=450 cellpadding=0 cellspacing=0>";
			
			$bSColor=true;
			
			foreach($arrValues as $key=>$value){
				
				if(trim($value)!=""){
				
					echo "<tr height=22 bgcolor=".($bColor?($bSColor?"#fff4ff":"#ffffff"):($bSColor?"#e7dfef":"#e8dfef")).">";
					echo "<td class=oMain><i>$key:</i> $value</td>";
					echo "</tr>";
					
					$bSColor=!$bSColor;
					
				}
			}
			
			echo "</table>";
			
			echo "</td>";
			
			echo "</tr>";
			
			$bColor=!$bColor;
		}
		?>
		</table>
		<br><br>
		<?php
		generateBackLink("posted_data");
		?>
		</td>
	</tr>
</table><br>
<?php
}
?>
