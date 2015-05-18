<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php

if(isset($Delete)){
	
	if(sizeof(array_diff($CheckList,array("1")))>0){
		
		SQLDelete("login_log","id",array_diff($CheckList,array("1")));
	
		$HISTORY=$PART_LIST_DELETED;
	}

}

?>

<?php
					
	$oCol=array("username","ip","date");
	$oNames=array($UTILISATEUR,$IP_MESSAGE,$DATE_MESSAGE);
	RenderTable("login_log",$oCol,$oNames,750,"WHERE action='login' ORDER BY id desc ","$EFFACER","id","index.php?action=login&category=".$category);
			
?>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_LI_LOGIN;?>";
document.onmousedown = HTMouseDown;
</script>