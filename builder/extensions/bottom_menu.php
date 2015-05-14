<?php
$HTML = '';

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
				
				'.(!$bFFlag?'&nbsp; : &nbsp;':'').'
				
				<a href="'.GenerateLink(aParameter(1111),aParameter(1112),$lang,stripslashes($arrPage[2])).'" class="bottom_menu_link"><span class="bottom_menu_link">'.$arrPage[2].'</span></a>
			';
			
			$bFFlag = false;

		}
	}
}

?>