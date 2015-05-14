<?php
include_once("Utils.php");

if((!isset($AuthUserName))||SQLCount("design","WHERE user='$AuthUserName'")==0){
	$arrStyles=DataArray("design","name='Default'");
}
else{
	$arrStyles=DataArray("design","user='$AuthUserName'");
}
?>

td.leftTD{background:<?php echo $arrStyles["leftTD_background"];?>}
<?php
if($arrStyles["leftTD_background"]=="#00309c"){
	echo "img.leftImage{visibility:visible}\n";
}
else{
	echo "img.leftImage{visibility:hidden}\n";
}
?>

.basictext{font-family: <?php echo $arrStyles["basictext_fontfamily"];?>; font-size: <?php echo $arrStyles["basictext_fontsize"];?>; color: <?php echo $arrStyles["basictext_fontcolor"];?>;}
td.top{background-color:<?php echo $arrStyles["tdmenu_top_background"];?>;border-style:solid;border-color:#9c9ace;border-width:1px 1px 1px 1px;}
td.selected{background-color:<?php echo $arrStyles["tdmenu_selected_background"];?>;border-style:solid;border-color:#9c9ace;border-width:1px 1px 0px 1px;}
a.top{color: <?php echo $arrStyles["a_top_color"];?>; font-family: <?php echo $arrStyles["a_top_fontfamily"];?>; font-size: <?php echo $arrStyles["a_top_fontsize"];?>; font-weight: bold; text-decoration: none;}
a.selected{color: <?php echo $arrStyles["a_selected_color"];?>; font-family: <?php echo $arrStyles["a_selected_fontfamily"];?>; font-size: <?php echo $arrStyles["a_selected_fontsize"];?>; font-weight: bold; text-decoration: none;}

.adminButton
{
	font-family:<?php echo $arrStyles["adminButton_fontfamily"];?>;
	font-size:<?php echo $arrStyles["adminButton_fontsize"];?>;
	font-weight:800;
	color:<?php echo $arrStyles["adminButton_color"];?>;
	background-color:<?php echo $arrStyles["adminButton_backgroundcolor"];?>;
}
td.tdSpacer{background-color:#ffffff;border-style:solid;border-color:#9c9ace;border-width:0px 0px 1px 0px;}
td.oHeader{font-family:<?php echo $arrStyles["tdoheader_fontfamily"];?>;color:<?php echo $arrStyles["tdoheader_color"];?>;font-size:<?php echo $arrStyles["tdoheader_fontsize"];?>}
td.oMain{font-family:<?php echo $arrStyles["tdomain_fontfamily"];?>;color:<?php echo $arrStyles["tdomain_color"];?>;font-size:<?php echo $arrStyles["tdomain_fontsize"];?>}
td.leftNavigationSelectedTD{background:<?php echo $arrStyles["leftNavigationSelectedTD_background"];?>}
td.leftNavigationTD{background:<?php echo $arrStyles["leftNavigationTD_background"];?>}
a.leftNavigationSelectedLink{font-family:<?php echo $arrStyles["leftNavigationSelectedLink_fontfamily"];?>;color:<?php echo $arrStyles["leftNavigationSelectedLink_fontcolor"];?>;font-size:<?php echo $arrStyles["leftNavigationSelectedLink_fontsize"];?>;text-decoration:none;font-weight:800}
a.leftNavigationLink:hover {font-family:Verdana;color:orange;font-size:11;text-decoration:underline;}
a.leftNavigationLink {font-family:<?php echo $arrStyles["leftNavigationLink_fontfamily"];?>;color:<?php echo $arrStyles["leftNavigationLink_fontcolor"];?>;font-size:<?php echo $arrStyles["leftNavigationLink_fontsize"];?>;text-decoration:none}