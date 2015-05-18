<?php
if(trim($arrUser["template"]) == "")
{
	SQLUpdate_SingleValue
	(
				"re_users",
				"id",
				$arrUser["id"],
				"template",
				aParameter(880)
	);
}
if(trim($arrUser["menu_template"]) == "")
{
	SQLUpdate_SingleValue
	(
				"re_users",
				"id",
				$arrUser["id"],
				"menu_template",
				aParameter(881)
	);
}
?>

<script>
function OpenEditor()
{
	window.open("main_tmpl.php","title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}
</script>
<table summary="" border="0" width=95%>
	<tr>
		<td width=40><img src="images/icons/erase.gif" width="38" height="41" alt="" border="0"></td>
		
		<td class=basictext>
		<b>
			<?php echo $M_MODIFY_DESIGN;?>
		</b>
		</td>
	</tr>
</table>
<br>
<table summary="" border="0" width=95%>
	<tr>
				
		<td class=basictext>
		
		<script>
		function ShowHide(x)
		{
			if(document.getElementById(x).style.display=="none")
			{
				document.getElementById(x).style.display="block";
			}
			else
			{
				document.getElementById(x).style.display="none";
			}
		
		}
		
		</script>
		<br>
		<table>
			<tr>
				<td><img src="images/link_arrow.gif" width="16" height="16"></td>
				<td>
				<a href="javascript:OpenEditor()"><b><?php echo $M_OPEN_WYSIWYG_EDITOR;?></b></a>
				</td>
			</tr>
		</table>
		<br><br>
		
		<table>
			<tr>
				<td><img src="images/link_arrow.gif" width="16" height="16"></td>
				<td>
				<a href="javascript:ShowHide('html_box')"><b><?php echo $M_EDIT_CODE_TEMPLATE;?></b></a>
				</td>
			</tr>
		</table>
		<br>
		<div id="html_box" style="display:<?php if(isset($SpecialProcessEditForm)) echo "block";else echo "none";?>">
<?php
$SubmitButtonText = $SAUVEGARDER;
    
 AddEditForm
	(
	array("Template"),
	array("template"),
	array(),
	array("textarea_60_15"),
	"re_users",
	"id",
	$arrUser["id"],
	$LES_VALEURS_MODIFIEES_SUCCES
	);
?>

	</div>
	
	
		</td>
	</tr>
</table>

