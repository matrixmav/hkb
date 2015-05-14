<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}

ms_i($id);

	SQLDelete("pages","id",array($id));
?>

<script>

alert("<?php echo $PAGE_EFFACEE_SUCCES;?>!");
document.location.href="index.php?category=site_management&action=pages_pro";
</script>
