<script>
function DeletePage(x){

	if(confirm("Are you sure that you want to delete this page from the web site?")){
		document.location.href=x;
	}
}

function StartWizard(x){

	window.open("../main.php?page="+x,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}
</script>
<?php

$oCol=array("ShowPageLink","ShowEditLink","ShowDeleteLink","name","description","link","parent_id");
$oNames=array("Preview","Edit","Delete","Page Name","Page Description","Link","Parent");
$strHTML=renderSQLTable("pages",$oCol,$oNames,800,"");

echo $strHTML;

?>