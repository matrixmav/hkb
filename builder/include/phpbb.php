<?php
mysql_connect($dbhost,$dbuser,$dbpasswd);
mysql_select_db($dbname);
$max_user=mysql_query
(
	"SELECT MAX(user_id) AS total FROM ".$table_prefix."users"
);
$row = mysql_fetch_array($max_user);
$iUser = $row["total"]+1;
mysql_query
(
"INSERT INTO ".$table_prefix."users	( user_id,username, user_regdate, user_password, user_email )
VALUES ( ".$iUser.",'" . $username . "', " . time() . ", '" . md5($password) . "', '" . $email . "') "
) or die("<font color=red>#1 ".mysql_error());
mysql_query
(
"INSERT INTO ".$table_prefix."groups (group_name, group_description, group_single_user, group_moderator)
VALUES ('', 'Personal User', 1, 0)"
) or die("<font color=blue>#3 ".mysql_error());
$iGroup = mysql_insert_id();
mysql_query
(
"INSERT INTO ".$table_prefix."user_group (user_id, group_id, user_pending)
VALUES (".$iUser.",".$iGroup.", 0)"
) or die("<font color=green>".mysql_error());
mysql_close();
?>
