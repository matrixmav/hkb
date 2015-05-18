<br><br><br>

<div class="container">

<script>
function ShowFaq(x)
{
	if(document.getElementById("faq"+x).style.display=="none")
	{
		document.getElementById("faq"+x).style.display="block";
	}
	else
	{
		document.getElementById("faq"+x).style.display="none";
	}
}
</script>
<b><?php echo $M_FAQ;?></b>
<br><br>
<?php
$faqTable = DataTable("faq","ORDER BY date");

$iFaqCounter = 0;

while($faqArray = mysql_fetch_array($faqTable))
{
	$iFaqCounter++;
	
	echo $iFaqCounter.". <a href='javascript:ShowFaq(".$iFaqCounter.")'>".$faqArray["title"]."</a>";	
	
	echo "
	<br>
		<div id=faq".$iFaqCounter." style='display:none'>
		<br>
		".$faqArray["html"]."
		<br>
		</div>
		<br>
	";
}
?>
</div>