<?php
$ttl = 60;
session_start();
session_destroy();
header('location:/KeepDocs/index.php');
?>