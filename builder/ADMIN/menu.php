
<?php

	if(!isset($page)){
		$page="-1";
	}

	if(!isset($subpage)){
		$subpage="-1";
	}

	include_once("db_config.php");

	mysql_connect("$DBHost", "$DBUser", "$DBPass");
	mysql_select_db($DBName);

	$oRows=mysql_query("select * from $DBprefix"."pages"." order by id");



	echo "
		<table border=0 width=182 cellpadding=0 cellspacing=0>
	";

	$rCounter=0;

	while ($row = mysql_fetch_array($oRows))
	{

		if($row['parent_id']=="0"){

			echo "
			<tr>
    			<td class=".($rCounter==0?"f":"n")."cell >
				<a href='index.php?page=".$row['id']."' class=".($row['id']==$page&&$subpage=="-1"?"redLink":"mainLink").">
				&nbsp;
				&nbsp;".$row['link_fr']."
				</a>
				</td>
    		</tr>
			";

			$rCounter++;

					if($row['id']==$page||(isset($parent_page)&&$row['id']==$parent_page)){

						$oSubRows=mysql_query("select * from $DBprefix"."pages"." WHERE parent_id='".$row['id']."'");

						while ($subRow = mysql_fetch_array($oSubRows))
							{


									echo "
									<tr>
    									<td class=scell height=20>
										<a href='index.php?page=".$subRow['id']."&parent_page=".$row['id']."' class=".($subRow['id']==$page?"redLink":"mainLink").">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;f".$subRow['link_fr']."
										</a>
										</td>
    								</tr>
									";

							}

					}


		}

	}

	echo '
		</table>
	';


	mysql_close();
?>
