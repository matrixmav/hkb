<?php
setcookie("Auth","",time()-3600);
die("<script>document.location.href='../index.php';</script>");
?>