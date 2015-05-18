<?php
include("Utils.php");
include("login_config.php");
include("security.php");
if(isset($proceed)){



	$ir=rand(200,100000000);

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db($DBName);


	if ($_FILES) {



		$image_types = Array ("image/bmp",
		"image/jpeg",
		"image/pjpeg",
		"image/gif",
		"image/x-png");

	$userfile = addslashes (fread (fopen ($_FILES["userfile"]["tmp_name"], "r"), filesize ($_FILES["userfile"]["tmp_name"])));
	$file_name = $_FILES["userfile"]["name"];
	$file_size = $_FILES["userfile"]["size"];
	$file_type = $_FILES["userfile"]["type"];

	if($file_size!=0){

	if (in_array (strtolower ($file_type), $image_types)) {
		$sql = "INSERT INTO ".$DBprefix."image (image_id,image_type, image, image_size, image_name, image_date) ";
		$sql.= "VALUES (";
		$sql.= "$ir,'{$file_type}', '{$userfile}', '{$file_size}', '$file_name', NOW())";


		mysql_query ($sql);
	}
	else{

			echo "<font face=verdana color=red size=2><b>The file you attempt to upload is not an image! (only the following file formats are accepted: image/jpeg, image/pjpeg, image/gif, image/x-png)</font>";

			exit();

	}

	}

}

/*
echo '
<table summary="" border="0" width=100% height=100%>
	<tr>
		<td align=center valign=middle style="font-size:11;font-family:Verdana;color:#00309c;font-weight:800">

';
echo "<font face=verdana color=red>The image is uploaded successfully!<br></font>";

echo '
		</td>
	</tr>
</table>
';
*/

echo '
<script>
parent.InsertImage("'.$ir.'");
</script>
';
}

?>
<html>
<!-- Creation date: 11/2/2003 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Insert Image</title>

</head>
<body bgcolor=#efebde>
<table summary="" border="0" width=100% height=100%>
	<tr>
		<td align=center valign=middle style="font-size:11;font-family:Verdana;color:#000000;font-weight:800">

				<form action="insertImage.php" METHOD="POST" ENCTYPE="multipart/form-data">
						Please select an image (.gif, .jpg, or .png)<br>
		<br>
						<INPUT NAME="userfile" TYPE="file" size="28">
						<input type=hidden name=proceed value="">

						<br><br>
						<img src="../images/spacer.gif" border="0" width="190" height="1" alt=""><INPUT TYPE="submit" NAME="Submit" VALUE=" Upload " >
				</form>

		</td>
	</tr>
</table>
</body>
</html>
