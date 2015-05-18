
<table summary="" border="0" width=100%>
	<tr>
		<td width="44"><img src="images/icons/email_open.png" width="48" height="48" alt="" border="0"></td>
		<td class=blog_admin_header>
		
		<?php echo $CONTACT_MESSAGES;?>
		
		</td>
	</tr>
  </table>
	  <br>
<?php

if(isset($Delete))
{
	
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDeletePlus("contact","id",$CheckList);
	
	}

}

?>
<?php

if(SQLCount("contact","WHERE user='".$AuthUserName."'") == 0)
{
	echo '
	<br><table summary="" border="0" width="100%">
 	<tr>
 		<td><i>'.$M_ANY_CONTACT_MESSAGES.'</i></td>
 	</tr>
 </table>
	
	';

}
else
{

$arrTDSizes=array("100","100","100","*");
RenderTable_BA
(
	"contact",
	array("date","name","email","message"),
	array($DATE_MESSAGE,$NOM,$EMAIL,$MESSAGE2),
	700,
	"WHERE user='".$AuthUserName."'",
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category
);
}
?>

<br><br>


<script>
var HTType="2";
var HTMessage="<?php echo $T_CONTACT_PAGE;?>";
document.onmousedown = HTMouseDown;
</script>
