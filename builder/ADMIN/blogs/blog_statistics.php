<table summary="" border="0" width="100%">
	<tr>
		<td>
		
						<font color=#636563>
						<b>
						SITES
						</b>
						</font>
						
						<hr width=100% color=#636563>
						<br>
						
						TOTAL NUMBER OF SITES:
						<font color=#db3800><b>
						<?php
						echo SQLCount("admin_users","WHERE username<>'administrator'");
						?>
						</b></font>
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						ACTIVE SITES:
						
						<font color=#db3800><b>
						<?php
						echo SQLCount("admin_users","WHERE blog_active=1 AND  username<>'administrator'");
						?>
						</b></font>
						&nbsp;&nbsp;&nbsp;
						[<a href="index.php?category=blogs&folder=blog_statistics&page=list&list_type=a" style="font-size:11px">VIEW THE LIST</a>]
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						NOT ACTIVE SITES:
						
						<font color=#db3800><b>
						<?php
						echo SQLCount("admin_users","WHERE blog_active=0 AND username<>'administrator'");
						?>
						</b></font>
						&nbsp;&nbsp;&nbsp;
						[<a href="index.php?category=blogs&folder=blog_statistics&page=list&list_type=n" style="font-size:11px">VIEW THE LIST</a>]
						<br><br>
						
						<b>SITES PER PACKAGES</b>
						
						<br><br>
						
						<table width="350">
						<?php
						
						$tablePackages = DataTable_Query
						("
								SELECT name, ".$DBprefix."blog_packages.id idp, count( * ) pc
								FROM ".$DBprefix."admin_users,".$DBprefix."blog_packages
								WHERE plan<>0 AND ".$DBprefix."admin_users.plan=".$DBprefix."blog_packages.id
								GROUP BY plan
								ORDER BY pc DESC
						");
						
						while($arrPackage = mysql_fetch_array($tablePackages))
						{
									echo "
									<tr height=30>
										<td width=80>".strtoupper($arrPackage["name"]).": </td>
										<td><b><font color=#db3800>".$arrPackage["pc"]."</font></b></td>
										<td><a href='index.php?category=blogs&folder=blog_statistics&page=list&list_type=".$arrPackage["idp"]."'>[VIEW THE LIST]</a></td>
									</tr>
									";	
						}
						
						?>
						</table>
						
						
						
						
						
						
		</td>
	</tr>
</table>
