<?php
require_once("init.php");

$nm = generateUserList();
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=userlist.json');
readfile($nm);
exit;
?>
