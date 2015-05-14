<?php
$lang = $LANGUAGE2;
$arrPages = array();
	
$dataTable = DataTable_Query("SELECT * FROM ".$DBprefix."pages"." WHERE active_".$lang."=1 ORDER BY parent_id,id");
				
while ($row = mysql_fetch_array($dataTable))
{
	//array_push($arrPages, array($row['id'], $row['parent_id'], $row["link_".$lang], $row["custom_link_".$lang]));
}

$HTML = '<center>';

$bFFlag = true;

if(isset($arrPages))
{
	foreach($arrPages as $arrPage)
	{
	
		if(trim($arrPage[2])==""){
			continue;
		}

		if($arrPage[1]=="0")
		{

			$HTML.='
				
				'.(!$bFFlag?'<img src="images/spacer.gif" width="12" height="1">:<img src="images/spacer.gif" width="12" height="1">':'').'
				
					<a href="../index.php?page='.$lang.'_'.$arrPage[2].'" style="text-decoration:none;" class="block-div" ><font color=#6b6d73>'.$arrPage[2].'</font></a>
			';
			
			$bFFlag = false;

		}
	}
}

$HTML .= "</center>";

?>