
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php

if(isset($ProceedSave)){

if($TemplateType=="1"){


	
	 SQLInsert(
	 
	 "templates",array("name","description","html"),
	 
	 array($template_name,
	 			$template_description,
				'
				<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<title><wsa title/></title>
					<meta name="description" content="<wsa description/>">
					<meta name="keywords" content="<wsa keywords/>">
					</head>
					<body rightmargin="0" bottommargin="0" leftmargin="0" topmargin="0">
					
								
					  			
						<table border="0" width="100%" height="100%"  cellpadding="0" cellspacing="0">
							  	<tr>
							  		<td valign=top>
									
									<table bgcolor="'.($top_bgcolor!=""?$top_bgcolor:'white').'" border="0" width="100%" height=100 cellpadding="0" cellspacing="0" >
								    	<tr>
											<td height=10 align=right><wsa languages_menu/>&nbsp;&nbsp;&nbsp;</td>
										</tr>
										<tr>
								    		<td  valign=top >
												'.($logo_image_id!=""?'<img src="image.php?id=>'.$logo_image_id:'').'
											</td>
								    	</tr>
								    </table>
					    			
									
									<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" >
								    	<tr>
								    		<td  bgcolor="'.($left_bgcolor!=""?$left_bgcolor:'white').'" width=185  valign=top>&nbsp;
											
											<br>
											<wsa menu/>
											
											</td>
											<td valign=top bgcolor="'.($main_bgcolor!=""?$main_bgcolor:'white').'"  >
											<br>
											&nbsp;
											<wsa content/>
											<wsa form/>
											</td>
								    	</tr>
								    </table>
									
									</td>
							  	</tr>
							  </table>
					
					
					</body>
					</html>

				'
	 ));
	

}
else{


	 SQLInsert("templates",array("name","description","html"),
	 array($template_name,
	 			$template_description,
				'
				<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<title><wsa title/></title>
					<meta name="description" content="<wsa description/>">
					<meta name="keywords" content="<wsa keywords/>">
					</head>
					<body rightmargin="0" bottommargin="0" leftmargin="0" topmargin="0">
					
								
					  			
						<table border="0" width="100%" height="100%"  cellpadding="0" cellspacing="0">
							  	<tr>
							  		<td valign=top>
									
									<table bgcolor="'.($top_bgcolor!=""?$top_bgcolor:'white').'" border="0" width="100%" height=100 cellpadding="0" cellspacing="0" >
								    	<tr>
											<td height=10 align=right><wsa languages_menu/>&nbsp;&nbsp;&nbsp;</td>
										</tr>
										<tr>
								    		<td  valign=top >
												"'.($logo_image_id!=""?'<img src="image.php?id=>'.$logo_image_id:'').'"
											</td>
								    	</tr>
								    </table>
					    			
									
									<table border="0" bgcolor="'.($main_bgcolor!=""?$main_bgcolor:'white').'" width="100%" height="100%" cellpadding="0" cellspacing="0" >
								    	<tr height=20>
								    		<td valign=top>
											
											<wsa menu/>
											
											</td>
										</tr>
										<tr>
											<td valign=top   >
											<br>
											&nbsp;
											<wsa content/>
											<wsa form/>
											</td>
								    	</tr>
								    </table>
									
									</td>
							  	</tr>
							  </table>
					
					
					</body>
					</html>

				'
	 ));

	
}

	 
	 echo '
	 <table summary="" border="0" width=100%>
	  	<tr>
	  		<td class=basictext><font color=red><b>'.$THE_TEMPLATE.' "<i>'.$template_name.'</i>" '.$WAS_ADDED_TMPL.'!</font></b><br><br></td>
	  	</tr>
	  </table>
  		';

	 $HISTORY=$NEW_TEMPLATE_ADDED;


}

?>

<script>
function OpenTemplateEditor(x){
	window.open("template.php","title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}

function AddLogo(){
	document.getElementById("UploadIframe").style.visibility="visible";
}

function InsertImage(x){
	document.getElementById("TopBgColor").innerHTML+="<img height=75 src='../image.php?id="+x+"' >";
	document.getElementById("logo_image_id").value=""+x;
	document.getElementById("UploadIframe").style.visibility="hidden";
}

function LoadTemplate1(){
	document.getElementById("TemplateType").value="1";
	document.getElementById("WorkArea").innerHTML=document.all.Template1.innerHTML;
	document.getElementById("Template1").innerHTML="";
}

function LoadTemplate2(){
	document.getElementById("TemplateType").value="2";
	document.getElementById("WorkArea").innerHTML=document.all.Template2.innerHTML;
	document.getElementById("Template2").innerHTML="";
}
</script>
	<div id="ColorsMenu" style="visibility:hidden;position:absolute;top:140;left:500">
		<?php
			include("colorPicker.php");
		?>
	</div>
	
	
<iframe id="UploadIframe" name="UploadIframe" src="insertImage.php?LANG=<?php echo $LANGUAGE2;?>" style="visibility:hidden;position:absolute;top:200px;left:330px;border-style:solid;border-color:#00309c;border-style:solid;border-width:1px 1px 1px 1px" width="390" height="140" framespacing="0" frameborder="0"> </iframe>


<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext>
		
		
		<table summary="" border="0">
		   	<tr>
		   		<td width=49><img src="images/icons<?php echo $DN;?>/write.gif" border="0" width="49" height="45" alt=""></td>
		   		<td class=basictext><b><?php echo $ADD_TEMPLATE_HTML;?></font></b></td>
		
		   	</tr>
		   </table>
		   
				
		</td>
	</tr>
</table>

<div id="AddTemplate" >
<br>
<?php
AddNewForm(
		array($NOM.":",$DESCRIPTION.":","HTML: "),
		array("name","description","html"),
		array("textbox_94","textbox_94","textarea_70_15"),
		" $ADD_TEMPLATE ",
		"templates",
		$TEMPLATE_AJOUTE_SUCCES
	);

?>	
<br>
</div>
<br>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_ADD_TEMPLATE;?>";
document.onmousedown = HTMouseDown;
</script>
<?php
if($AuthUserName != "administrator")
{
	$DBprefix = $DBprefix_;
}
?>
