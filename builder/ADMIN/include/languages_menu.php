	<script>
	function SwitchHolder()
	{
		document.getElementById('LinkHolder').style.display='none';
		document.getElementById('ContentHolder').style.display='block';
	}
	</script>

	<div id="ContentHolder" style="position:relative;top:-45px;left:-15px;float:right">
	<?php
		$tableLanguages=DataTable("languages","");
		
		echo "<table ><tr>";
		
		$strLink="";
		
		if(isset($action)){
			$strLink="action=".$action."&category=".$category."&";
		}
		else{
			$strLink="folder=".$folder."&page=".$page."&category=".$category."&";
		}
		
		while($arrLanguages=mysql_fetch_array($tableLanguages)){
		
			echo "
					<td valign=top><font color=red>
						<a href=\"index.php?".$strLink."ProceedChangeLanguage=".$arrLanguages["code"]."".(isset($MMODE)?"&MMODE=".$MMODE:"")."".(isset($id)?"&id=".$id:"")."\">
							<img   ".(strtolower($arrLanguages["code"])==strtolower($lang)?"border=0 style=\"border-color:#e7dfef\"":"border=0 ")." src=\"../include/flags/".$arrLanguages["code"].".gif\" width=22 height=14>
						</a>
					</td>
			";	
		
		}
		
		echo "</tr></table>";
		
		?>
		</div>
