<?php
error_reporting(0);
if(isset($_GET)) $HTTP_GET_VARS=$_GET;
if(isset($_POST)) $HTTP_POST_VARS=$_POST;
$ProductName = "Urwebby";

function v($param_name)
{
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;

  $param_value = "NULL";

  if(isset($HTTP_POST_VARS[$param_name]))
  {
    $param_value = $HTTP_POST_VARS[$param_name];
  }
  else
  if(isset($HTTP_GET_VARS[$param_name]))
  {
    $param_value = $HTTP_GET_VARS[$param_name];
  }

  return $param_value;
}
while (list($key, $val) = @each($HTTP_GET_VARS))  $GLOBALS[$key] = $val;
while (list($key, $val) = @each($HTTP_POST_VARS)) $GLOBALS[$key] = $val;
while (list($key, $val) = @each($HTTP_POST_FILES)) $GLOBALS[$key] = $val;
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title><?php echo $ProductName;?> SETUP</title>
<style>
td.basictext{font-family:Arial;font-size:11px;color:#0061D3}
</style>
</head>
<body>
<?php

if(!isset($lang))
{
	$lang = "en";
}

if(!isset($Step))
{
	$Step = 0;
}

?>
<script>

function CheckBoxClicked()
{
	if(document.getElementById("ContinueButton").style.visibility=="hidden")
	{
		document.getElementById("ContinueButton").style.visibility="visible";
	}
	else
	{
		document.getElementById("ContinueButton").style.visibility="hidden";
	}
}
</script>


<table summary="" border="0" width=100% height=100%>
	<tr>
		<td align=center valign=middle>
		
		<table width="650" height="400" border="0" style="border-style:solid;border-color:#2175d9;border-width:1px 1px 1px 1px" cellpadding="0" cellspacing="0">
			<tr height=36 bgcolor=#0061D3>
		  		<td align=left background="images/setup1.gif" width="650" height="36">
				
					<span style="color:white;font-size:21px;font-weight:400;font-family:Arial">&nbsp;<?php echo $ProductName;?> Setup</span>	   
			
				</td>
			</tr>
		  	<tr>
		  		<td>
				
				<?php
				if(file_exists("../config.php") && $Step == 0)
				{
					echo "<center><font color=#00009c face=arial><b>The setup detected that ".$ProductName." was already installed in this folder<br><br>The setup process was aborted</b></center>";
				}
				else
				if($Step == 0)
				{
				?>

				<table summary="" border="0">
			    	<tr>
			    		<td valign=middle>
						<img src="images/icons2/chovek.gif" border="0" width="246" height="272" alt="">
						
						</td>
						<td valign=top style="font-family:tahoma;font-size:11px;color:#0061D3">
						
						<table border="0" cellpadding="0" cellspacing="0" height=310 width=385>
					      	<tr>
					      		<td valign=top style="text-align:justify;font-family:tahoma;font-size:11px;color:#0061D3">
								<br>
								
								<?php
								if($lang == "en")
								{
								?>
								Dear User,
								<br><br>
								
								This setup will guide you through the installation of <?php echo $ProductName;?> to your
								server. Before starting the setup, please make sure that the MySQL
								 server where
								you plan to install the <?php echo $ProductName;?> database is running and 
								
								you have a valid account 
								to access it 
								(you'll be asked for a valid
								username and password to access your MySQL server and also the name of the database where to 
								restore the <?php echo $ProductName;?> primary database).
														
								<br>
								The installation process is simple, it passes through two main steps - 
								the setup of the <?php echo $ProductName;?> database and the main administrator account for
								the application. 
														
								Please don't hesitate to contact us
								if during the installation you experience some technical problems.
								<br>
								<br>
								
									<?php echo strtoupper($ProductName);?> END USER LICENCE AGREEMENT</b>
	<br>
	<textarea rows=3 cols=45>
PLEASE READ THIS CONTRACT CAREFULLY. BY USING ALL OR ANY PORTION OF THE SOFTWARE YOU ACCEPT ALL THE TERMS AND CONDITIONS OF THIS AGREEMENT. YOU AGREE THAT THIS AGREEMENT IS ENFORCEABLE LIKE ANY WRITTEN NEGOTIATED AGREEMENT SIGNED BY YOU. IF YOU DO NOT AGREE, DO NOT INSTALL OR OTHERWISE USE THIS SOFTWARE. 

Custom License Agreements Available
 
If you wish to obtain a custom license agreement with alternate terms and conditions, contact Netart Media Ltd. at info@netartmedia.net for instructions.

Definitions:

This Netart Media Ltd. End-User Software License Agreement ("EULA") is a legal agreement between you (either as an individual user, corporation or single entity) and Netart Media Ltd. ("Netart Media") for the WSCreator, website creation and management software product, or individual software product - which includes computer software, and may include associated media, printed materials, and "online" or electronic documentation ("SOFTWARE PRODUCT" or "SOFTWARE"). If you do NOT agree to the terms of this EULA, you may not install nor use the SOFTWARE PRODUCT. If this is the case, please uninstall the SOFTWARE PRODUCT from your system immediately, and destroy all copies of the SOFTWARE PRODUCT and all of its component parts, source code, associated documentation, and related materials.

SOFTWARE PRODUCT LICENSE:

The SOFTWARE PRODUCT is protected by copyright laws and international copyright treaties, as well as other intellectual property laws and treaties.

1. GRANT OF LICENSE. This EULA grants you the following rights:

You may install and use one (1) copy of the SOFTWARE PRODUCT on a single computer and use the SOFTWARE PRODUCT for one (1) project or one (1) website and a single domain name. 

You are not authorized to extend the SOFTWARE PRODUCT by adding custom extensions and modules, integrate other products and make whatever changes in the original SOFTWARE PRODUCT and source codes provided to you. You agree that you will not assign, sublicense, transfer, pledge, lease, rent, or share your rights under this License Agreement. You agree that you may not reverse assemble, reverse compile, or otherwise derive the source code from the Software. Licensee may not remove or alter any trademark, logo, copyright or other proprietary notices, legends, symbols or labels in the Software.

If Licensee is authorized and has purchased the Enterprise Edition of the SOFTWARE PRODUCT, Netart Media grants Licensee the right to use the product on UNLIMITED number of computers and for UNLIMITED number of websites or projects and to make ALL kind of modifications in the SOFTWARE PRODUCT (which includes the right to remove from the original SOFTWARE PRODUCT the Netart Media references and the SOFTWARE PRODUCT logo and to replace them with these of the Licensee).


2. DESCRIPTION OF OTHER RIGHTS AND LIMITATIONS.

Termination: Without prejudice to any other rights, Netart Media may terminate this EULA if you fail to comply with the terms and conditions of this EULA. In such event, you must destroy all copies of the SOFTWARE PRODUCT and all of its component parts, source code, associated documentation, and related materials.

3. COPYRIGHT.

All title and copyrights in and to the SOFTWARE PRODUCT (including but not limited to 
any images, photographs, animations, video, audio, music and text incorporated into the SOFTWARE PRODUCT), the accompanying printed materials, and any copies of the SOFTWARE PRODUCT are owned by Netart Media. Therefore, you must treat the SOFTWARE PRODUCT like any other copyrighted material.

4.LIMITED WARRANTY.

The user must assume the entire risk of using the SOFTWARE PRODUCT.

NO WARRANTIES. Netart Media expressly disclaims any warranty for the SOFTWARE PRODUCT.

The SOFTWARE PRODUCT and any related documentation is provided "as is" without warranty of any kind, either expressed or implied, including, without limitation, the implied  warranties of merchantability, fitness for a particular purpose, or non-infringement. The entire risk arising out of use or performance of the SOFTWARE PRODUCT remains with you.

Netart Media is not liable for the content of any web site powered by the SOFTWARE PRODUCT.

5. LIMITATION OF LIABILITY.

NO LIABILITY FOR CONSEQUENTIAL DAMAGES. In no event shall Netart Media or its distributors be liable for any damages whatsoever (including, without limitation, damages for loss of business profits, business interruption, loss of business information, or any other pecuniary loss) arising out of the use of or inability to use this Netart Media  product (THE SOFTWARE PRODUCT) and related materials, even if Netart Media has been advised of the possibility of such damages. 

6. ACKNOWLEDGMENT

The Licensee acknowledges that he or she has read this Agreement, understands it, and agrees to be bound by its terms and conditions.  The Licensee further agrees that this is the entire Agreement between the Licensee and Netart Media and that there have been no other warranties, representations, covenants or understandings relating of the subject matter of this Agreement.

7. GENERAL

This Agreement shall be interpreted, construed, and enforced according to the laws of  Republic of Bulgaria. In the event of any action under this Agreement, the parties agree that the courts located in Bulgaria will  have exclusive jurisdiction and that a suit may only be brought in Sofia, Bulgaria and Licensee submits itself for the jurisdiction and venue of the courts located in Sofia, Bulgaria.

If any portion of this Agreement is determined to be legally invalid or unenforceable, such portion will be severed from this Agreement and the remainder of the Agreement will continue to be fully enforceable and valid.

	
	</textarea>
	<br>
	<input type=checkbox onclick="javascript:CheckBoxClicked()"> I agree and accept all the terms and
	conditions of this agreement
								
								<?php
								}
								else
								if($lang == "fr")
								{
								?>
								
								Cher Utilisateur,
								<br><br>
								
								Cette installation va vous guider dans le processus de mettre en 
								ligne <?php echo $ProductName;?> sur votre serveur. Avant de commencer, 
								veuillez vérifier que le serveur MySQL ou vous allez installer la base
								de données marche et que vous avez un compte valide pour 
								l'accéder (lors de l'installation vous serez demande pour le nom 
								d'utilisateur et mot de passe avec lesquels accéder le serveur MySQL 
								).
								
								L'installation de l'application est très simple - elle ne passe que
								par deux pas , l'installation de la base de données et la création du compte
								administrateur principal pour l'application.
								 N'hésitez pas de nous contacter si vous rencontrez 
								des problèmes techniques lors du processus d'installation.
								
								
								<br>
								<br>
								
									<?php echo strtoupper($ProductName);?> END USER LICENCE AGREEMENT</b>
	<br>
	<textarea rows=3 cols=45>
PLEASE READ THIS CONTRACT CAREFULLY. BY USING ALL OR ANY PORTION OF THE SOFTWARE YOU ACCEPT ALL THE TERMS AND CONDITIONS OF THIS AGREEMENT. YOU AGREE THAT THIS AGREEMENT IS ENFORCEABLE LIKE ANY WRITTEN NEGOTIATED AGREEMENT SIGNED BY YOU. IF YOU DO NOT AGREE, DO NOT INSTALL OR OTHERWISE USE THIS SOFTWARE. 

Custom License Agreements Available
 
If you wish to obtain a custom license agreement with alternate terms and conditions, contact Netart Media Ltd. at info@netartmedia.net for instructions.

Definitions:

This Netart Media Ltd. End-User Software License Agreement ("EULA") is a legal agreement between you (either as an individual user, corporation or single entity) and Netart Media Ltd. ("Netart Media") for the <?php echo $ProductName;?> or individual software product - which includes computer software, and may include associated media, printed materials, and "online" or electronic documentation ("SOFTWARE PRODUCT" or "SOFTWARE"). If you do NOT agree to the terms of this EULA, you may not install nor use the SOFTWARE PRODUCT. If this is the case, please uninstall the SOFTWARE PRODUCT from your system immediately, and destroy all copies of the SOFTWARE PRODUCT and all of its component parts, source code, associated documentation, and related materials.

SOFTWARE PRODUCT LICENSE:

The SOFTWARE PRODUCT is protected by copyright laws and international copyright treaties, as well as other intellectual property laws and treaties.

1. GRANT OF LICENSE. This EULA grants you the following rights:

You may install and use one (1) copy of the SOFTWARE PRODUCT on a single computer and use the SOFTWARE PRODUCT for one (1) project or one (1) website and a single domain name. 

You are not authorized to extend the SOFTWARE PRODUCT by adding custom extensions and modules, integrate other products and make whatever changes in the original SOFTWARE PRODUCT and source codes provided to you. You agree that you will not assign, sublicense, transfer, pledge, lease, rent, or share your rights under this License Agreement. You agree that you may not reverse assemble, reverse compile, or otherwise derive the source code from the Software. Licensee may not remove or alter any trademark, logo, copyright or other proprietary notices, legends, symbols or labels in the Software.

If Licensee is authorized and has purchased the Developer Edition of the SOFTWARE PRODUCT, Netart Media grants Licensee the right to add custom extensions and modules and extend the original functionality of the SOFTWARE PRODUCT. 

If Licensee is Authorized and has purchased the Enterprise Edition of the SOFTWARE PRODUCT, Netart Media grants Licensee the right to use the product on UNLIMITED number of computers and for UNLIMITED number of websites or projects and to make ALL kind of modifications in the SOFTWARE PRODUCT (which includes the right to remove from the original SOFTWARE PRODUCT the Netart Media references and the SOFTWARE PRODUCT logo and to replace them with these of the Licensee)

2. DESCRIPTION OF OTHER RIGHTS AND LIMITATIONS.

Termination: Without prejudice to any other rights, Netart Media may terminate this EULA if you fail to comply with the terms and conditions of this EULA. In such event, you must destroy all copies of the SOFTWARE PRODUCT and all of its component parts, source code, associated documentation, and related materials.

3. COPYRIGHT.

All title and copyrights in and to the SOFTWARE PRODUCT (including but not limited to 
any images, photographs, animations, video, audio, music and text incorporated into the SOFTWARE PRODUCT), the accompanying printed materials, and any copies of the SOFTWARE PRODUCT are owned by Netart Media. Therefore, you must treat the SOFTWARE PRODUCT like any other copyrighted material.

4.LIMITED WARRANTY.

The user must assume the entire risk of using the SOFTWARE PRODUCT.

NO WARRANTIES. Netart Media expressly disclaims any warranty for the SOFTWARE PRODUCT.

The SOFTWARE PRODUCT and any related documentation is provided "as is" without warranty of any kind, either expressed or implied, including, without limitation, the implied  warranties of merchantability, fitness for a particular purpose, or non-infringement. The entire risk arising out of use or performance of the SOFTWARE PRODUCT remains with you.

Netart Media is not liable for the content of any web site powered by the SOFTWARE PRODUCT.

5. LIMITATION OF LIABILITY.

NO LIABILITY FOR CONSEQUENTIAL DAMAGES. In no event shall Netart Media or its distributors be liable for any damages whatsoever (including, without limitation, damages for loss of business profits, business interruption, loss of business information, or any other pecuniary loss) arising out of the use of or inability to use this Netart Media  product (THE SOFTWARE PRODUCT) and related materials, even if Netart Media has been advised of the possibility of such damages. 

6. ACKNOWLEDGMENT

The Licensee acknowledges that he or she has read this Agreement, understands it, and agrees to be bound by its terms and conditions.  The Licensee further agrees that this is the entire Agreement between the Licensee and Netart Media and that there have been no other warranties, representations, covenants or understandings relating of the subject matter of this Agreement.

7. GENERAL

This Agreement shall be interpreted, construed, and enforced according to the laws of  Republic of Bulgaria. In the event of any action under this Agreement, the parties agree that the courts located in Bulgaria will  have exclusive jurisdiction and that a suit may only be brought in Sofia, Bulgaria and Licensee submits itself for the jurisdiction and venue of the courts located in Sofia, Bulgaria.

If any portion of this Agreement is determined to be legally invalid or unenforceable, such portion will be severed from this Agreement and the remainder of the Agreement will continue to be fully enforceable and valid.

If you have any questions regarding this End User License Agreement, please write to:

info@netartmedia.net
	</textarea>
	<br>
	<input type=checkbox onclick="javascript:CheckBoxClicked()"> I agree and accept all the terms and
	conditions of this agreement
	
								<?php
								}
								?>
								
								
								</td>
					      	</tr>
					      	<tr>
					      		<td>
								&nbsp;
								</td>
					      	</tr>
							<!--
					      	<tr>
					      		<td>
								<img src="images/icons2/settings2.gif" border="0" width="41" height="41" alt="">
								</td>
					      	</tr>
					      	<tr>
					      		<td>
								<img src="images/icons2/users2.gif" border="0" width="39" height="38" alt="">
								</td>
					      	</tr>
							-->
							<tr>
							<form action="setup.php" method=post>
							<input type=hidden name=lang value="<?php echo $lang;?>">
							<input type=hidden name=Step value=1>
					      		<td align=right valign=bottom>
								
								<div id="ContinueButton" style="visibility:hidden">
								<?php
								if($lang == "fr")
								{
								?>
									<input type=image src="images/continuer.gif" onmouseout="this.src='images/continuer.gif'" onmouseover="this.src='images/continuer2.gif'" border="0" width="100" height="25" alt=""> 
								<?php
								}
								else
								{
								?>
									<input type=image src="images/continue.gif" onmouseout="this.src='images/continue.gif'" onmouseover="this.src='images/continue2.gif'" border="0" width="100" height="25" alt=""> 
								<?php
								}
								?>
								</div>
								
								</td>
							</form>
					      	</tr>
					      </table>
      
						</td>
			    	</tr>
			    </table>
    				
				
				<?php
				}
				?>
				
				
						<?php
				if($Step == 1)
				{
				?>

				<table summary="" border="0">
			    	<tr>
					
						<form action="setup.php" method=post>
						<input type=hidden name=lang value="<?php echo $lang;?>">
					
							
			    		<td valign=middle><img src="images/icons2/chovek.gif" border="0" width="246" height="272" alt=""></td>
						<td valign=top >
						
						<table border="0" cellpadding="0" cellspacing="0" height=310 width=385>
					      	
					      	<tr>
					      		<td valign=top class=basictext>
								
									<br>
									<table summary="" border="0">
							         	<tr>
							         		<td width=49 class=basictext>
												<img src="images/icons2/settings2.gif" border="0" width="41" height="41" alt="">		
											</td>
							           		<td class=basictext>
													<?php
													if($lang == "fr")
													{
													?>
														<b>Installation de la base de données 	<?php echo $ProductName;?> principale</b>
													<?php
													}
													else
													{
													?>
														<b>Setup the main <?php echo $ProductName;?> database</b>											
													<?php
													}
													?>
											</td>
							         	</tr>
							         </table>
									 
		
		
									 
									 
									 <?php
						if(!isset($ProceedMySQLServer))
						{
							echo "<input type=hidden name=ProceedMySQLServer>";
							echo "<input type=hidden name=Step value=1>";
							
						?>	
							 <br>
								<?php
									if(isset($error))
									{
										if($lang == "fr")
										{
											echo "<b><font color=red>Erreur lors de la connection au serveur MySQL avec l'utilisateur et le mot de passe que vous avez entré. 
											<br><br>SVP vérifiez le nom du serveur, le nom d'utilisateur et le mot de passe.</font></b><br><br>";
										
										}
										else
										{
											echo "<b><font color=red>Error while trying to connect to the MySQL Server with the credentials you provided. 
											<br><br>Please make sure that the the name of the server, the username and password are correct.</font></b><br><br>";
										}
									}
								?>	 
         					<table border="0" cellpadding="2">
			              	<tr>
			              		<td class=basictext>
								<?php
								if($lang == "fr")
								{
								?>
									Serveur MySQL: 
								<?php
								}
								else
								{
								?>
									MySQL Server: 
								<?php
								}
								?>
								
								</td>
			              		<td class=basictext>
									<input type=text name=mysql_server size=20 value="<?php if(isset($mysql_server)) echo $mysql_server;else echo "localhost";?>">
								</td>
			              	</tr>
			              	<tr>
			              		<td class=basictext>
								<?php
								if($lang == "fr")
								{
								?>
									Utilisateur MySQL: 
								<?php
								}
								else
								{
								?>
									MySQL User: 
								<?php
								}
								?>
								
								</td>
			              		<td class=basictext>
								<input type=text name=mysql_user size=20 value="<?php if(isset($mysql_user)) echo $mysql_user;?>">
								</td>
			              	</tr>
			              	<tr>
			              		<td class=basictext>
								<?php
								if($lang == "fr")
								{
								?>
									Mot de passe MySQL: 
								<?php
								}
								else
								{
								?>
									MySQL Password: 
								<?php
								}
								?>
								
								</td>
			              		<td class=basictext>
								<input type=password name=mysql_password size=20>
								</td>
			              	</tr>
			              </table>
						  
						  <br>
						  
						<?php	
						}
						else
						{
						?>
						<br>
						<table border="0" cellpadding="2">
			              	<tr>
			              		<td class=basictext>
								<i><?php
								if($lang == "fr")
								{
								?>
									Serveur MySQL: 
								<?php
								}
								else
								{
								?>
									MySQL Server: 
								<?php
								}
								?></i>
								</td>
			              		<td class=basictext>
									<?php echo $mysql_server;?>
								</td>
			              	</tr>
			              	<tr>
			              		<td class=basictext>
								<i><?php
								if($lang == "fr")
								{
								?>
									Utilisateur MySQL: 
								<?php
								}
								else
								{
								?>
									MySQL User: 
								<?php
								}
								?></i>
								</td>
			              		<td class=basictext>
								<?php echo $mysql_user;?>
								</td>
			              	</tr>
			              	<tr>
			              		<td class=basictext>
								<i><?php
								if($lang == "fr")
								{
								?>
									Mot de passe MySQL: 
								<?php
								}
								else
								{
								?>
									MySQL Password: 
								<?php
								}
								?></i>
								</td>
			              		<td class=basictext>
								******
								</td>
			              	</tr>
			              </table>
						  <br>
							<input type=hidden name=Step value=2>
							<input type=hidden name=ProceedMySQLDatabase>
							
							<input type=hidden name=mysql_server value="<?php  echo $mysql_server;?>">
							<input type=hidden name=mysql_user value="<?php  echo $mysql_user;?>">
							<input type=hidden name=mysql_password value="<?php  echo $mysql_password;?>">
							
							<input type=radio name=db_name value="new" checked>
							<b>
							<?php
								if($lang == "fr")
								{
								?>
									Création d'une nouvelle base de données MySQL: 
								<?php
								}
								else
								{
								?>
								</b>
									Create new MySQL database (recommended)
								<?php
								}
								?>
							<br><br>
							
							<?php
								if($lang == "fr")
								{
								?>
									Nom de la base de données: 
								<?php
								}
								else
								{
								?>
								</b>
									Database name:
								<?php
								}
								?>
							 <input type=text name=new_db_name style="width:200" value="wscreator">
		
							<br><br>
							
							<input type=radio name=db_name value="existant">
							<b>
							<?php
								if($lang == "fr")
								{
								?>
									Utiliser une base de données existante: 
								<?php
								}
								else
								{
								?>
								</b>
									Use an existant database
								<?php
								}
								?>
							</b>
							<br><br>
							<?php
								if($lang == "fr")
								{
								?>
									Nom de la base de données: 
								<?php
								}
								else
								{
								?>
								</b>
									Database name:
								<?php
								}
								?>
							<?php
							
							$list_code="";
							
							
							$link = mysql_connect($mysql_server, $mysql_user , $mysql_password) 
							or die("<script>document.location.href=\"setup.php?Step=1&error=yes&mysql_server=".$mysql_server."&mysql_user=".$mysql_user."\"</script>");
							
							$db_list = mysql_list_dbs($link);
							
						
							while ($row = mysql_fetch_object($db_list)) 
							{
							  $list_code .= "<option>".$row->Database ."</option>";
							}
							
							
							if($list_code == "")
							{
								echo "<input type=text name=selected_db_name  style=\"width:200px\">";
							}
							else
							{
								echo "<select name=selected_db_name  style=\"width:200px\">";
								echo $list_code;
								echo "</select>";
							}
							
							mysql_close();
							?>
							
						<?php	
						}
						?>
						
						
									 
									
              		
									
									
									
									
								</td>
					      	</tr>
					      	<tr>
					      		<td>
								
								</td>
					      	</tr>
							<tr>
						
					      		<td align=right valign=bottom>
								<?php
								if($lang == "fr")
								{
								?>
									<input type=image src="images/continuer.gif" onmouseout="this.src='images/continuer.gif'" onmouseover="this.src='images/continuer2.gif'" border="0" width="100" height="25" alt=""> 
								<?php
								}
								else
								{
								?>
									<input type=image src="images/continue.gif" onmouseout="this.src='images/continue.gif'" onmouseover="this.src='images/continue2.gif'" border="0" width="100" height="25" alt=""> 
								<?php
								}
								?>
								</td>
							</form>
					      	</tr>
					      </table>
      
						</td>
			    	</tr>
			    </table>
    				
				
				<?php
				}
				?>
				
				
				
				<?php
				if($Step == 2)
				{
				?>

				<table summary="" border="0">
			    	<tr>
			    		<td><img src="images/icons2/chovek.gif" border="0" width="246" height="272" alt=""></td>
						<td valign=top style="font-family:tahoma;font-size:11px;color:#0061D3">
						
						<table border="0" cellpadding="0" cellspacing="0" height=310 width=385>
					      	
							
					      	<tr>
					      		<td valign=top class=basictext>
								
								
									 
									 <?php
									 $mysql_database="";
								
									 if($db_name=="new")
									 {
										
										 $mysql_database=$new_db_name;		
										 
										 mysql_connect($mysql_server, $mysql_user , $mysql_password);
										
										
										mysql_query("CREATE DATABASE ".$mysql_database)
										or die("<font color=red><b>Creation of database ".$mysql_database." failed.<br><br>You have no privilegies to create a new database or a database with this name already exists!</font></b>");
							
										mysql_close();				 
										
									 }
									 else
									 {
									 	 $mysql_database=$selected_db_name;						 
									 }
							 
									
									
								$lines4 = @file("db.sql");
								
							
								
								$strText = "";
								foreach($lines4 as $line4)
								{
								
									if(substr($line4,0,2) == "--")
									{
									
									}
									else
									if(substr($line4,0,12) == "CREATE TABLE")
									{
										$strText .= str_replace("CREATE TABLE","^^^^^"."CREATE TABLE",$line4);
									}
									else
									if(substr($line4,0,11) == "INSERT INTO")
									{
										$strText .= str_replace("INSERT INTO","^^^^^"."INSERT INTO",$line4);
									}
									else
									{
										$strText .= $line4;
									}
								
								}
								
								
									$arrLines = explode("^^^^^", $strText);
									
									mysql_connect($mysql_server, $mysql_user , $mysql_password);
									mysql_select_db ($mysql_database) or die ("DB access denied");
									
									foreach($arrLines as $strLine)
									{
										if(trim($strLine) != "")
										{ 
											mysql_query(''.trim($strLine).'') or die("<b>The installation of ".$ProductName." failed.<br><br>Error: ".mysql_error()."</b>");
										}
									
									}
									
									mysql_close();
		 
									 
								
$filename = '../config.php';
$contentConfig =
'<?php
$BLOG_DOMAIN = "urwebby.com";

//MYSQL DATABASE ACCESS SETTINGS
$DBHost="'.$mysql_server.'";
$DBUser="'.$mysql_user.'";
$DBPass="'.$mysql_password.'";
$DBName="'.$mysql_database.'";
$DBprefix="websiteadmin_";

//ACCEPTED IMAGE TYPES FOR THE BLOGGERS
$image_types = Array 
(
		array("image/jpeg","jpg"),
		array("image/pjpeg","jpg"),
		array("image/bmp","bmp"),
		array("image/gif","gif"),
		array("image/x-png","png")
);		

//ACCEPTED FILE TYPES FOR UPLOAD BY THE BLOGGERS
$file_types = Array 
(
		array("image/jpeg","jpg"),
		array("image/pjpeg","jpg"),
		array("image/bmp","bmp"),
		array("image/gif","gif"),
		array("image/x-png","png"),
		array("application/msword","doc"),
		array("application/pdf","pdf"),
		array("application/vnd.ms-excel","xls"),
		array("application/rtf","rtf"),
		array("video/x-ms-wmv","wmv"),
		array("video/mpeg","mpg"),
		array("video/x-msvideo","avi"),
		array("text/plain","txt"),
		array("audio/mpeg","mp3"),
		array("text/html","html"),
		array("audio/x-wav","wav")
);

//PLEASE KEEP THIS ALWAYS TO FALSE
$SYSTEM_DEBUG_MODE=false;

//THE EMAIL ADDRESS FROM WHICH THE ACTIVATION CODE WILL BE SENT
$SYSTEM_EMAIL_ADDRESS = "info@urwebby.com";

//THE "FROM FIELD" FOR THE ACTIVATION EMAIL IF EMAIL VALIDATION IS SET TO TRUE
$SYSTEM_EMAIL_FROM = "urwebby.com";
?>';

$fileCreatedSuccess=true;
		
							if (!$handle = fopen($filename, 'w')) {
						      
								 $fileCreatedSuccess=false;
						   }
							if (is_writable($filename)) 
							{

							   if (fwrite($handle, $contentConfig) === FALSE) {
							      
								   $fileCreatedSuccess=false;
							   }
				
							   fclose($handle);
							
							}
							
							 else 
							{
								 $fileCreatedSuccess=false;
							
							}
							?> 
							
							
						
							
								<?php
								
								
								 if($fileCreatedSuccess)
								 {
								?>
										<?php
										if($lang == "fr")
										{
										?>
											<br><br>
											<b>La base de données principale a été créée avec succès</b>
											<br><br>
										<?php
										}
										else
										{
										?>
										</b>
										<br><br>
											<b>The main <?php echo $ProductName;?> database has been created successfully!</b>							 
										<br><br>
										<b>
													The setup process completed successfully.
													</b>
										<?php
										}
										?>
								 <?php
								 }
								 else
								 {
								 ?>
								 <b><font >IMPORTANT!
								 <br>
								 The process running PHP on this computer doesn't have permissions
								 to create and write the configuration file to the root folder of the installation.
								 <br><br>
								 You need to create it manually. Please create a file named "config.php" 
								 with the following content:<br>
								 <center>
										<form>
											<textarea cols=50 rows=25 style="font-family:Courier;font-size:11px"><?php echo trim($contentConfig);?></textarea>
										</form>						
								</center>
								<br>
									and put it in the root folder where you uploaded the <?php echo $ProductName;?> files.
									If you experience any problems with this, please don't hesitate to <a href="http://www.netartmedia.net/en_Contact.html" target=_blank>contact</a> our support
									center.
									<br><br>
									After you upload the file "config.php" in the root folder,
									the setup will be completed successfully.
									
									
									</font></i><br></font></b>
								<?php
								}
								?>
								
								
					      		</td>
			    	</tr>
			    </table>
							
      
						</td>
			    	</tr>
			    </table>
    				
				
				<?php
				}
				?>
				
				
				
					<?php
				if($Step == 3)
				{
				?>

				<table summary="" border="0">
			    	<tr>
			    		<td><img src="images/icons2/chovek.gif" border="0" width="246" height="272" alt=""></td>
						<td valign=top>
						
						<table border="0" cellpadding="0" cellspacing="0" height=330 width=385>
					      	
					      	<tr>
					      		<td class=basictext valign=top>
									
									
									
												
											
													<b>
													The setup process completed successfully.
													</b>
													<br><br>
													
												
												
										
										
								</td>
					      	</tr>
				
					      </table>
      
						</td>
			    	</tr>
			    </table>
    				
				
				<?php
				}
				?>
				<br>
				</td>
		  	</tr>
			<tr height=25 bgcolor=#0061D3 >
		  		<td align="center" valign="middle" background="images/setup2.gif">
				
				<span style="font-family:Arial;font-size:11px;color:white">
				<?php echo $ProductName;?> is a product of <a href="http://www.netartmedia.net" target="_blank" style="color:white;text-decoration:none">NetArt Media</a>
				</span>
				
				
		   
		   
		   </td>
			</tr>
		  </table>
  
		
		</td>
	</tr>
</table>

</body>
</html>
