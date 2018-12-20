<?php
header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
session_start();
$_SESSION['safari'] = 1;
$redirectTo = $_REQUEST['redirect'] ?? '/index.php';
header('location:'.$redirectTo);
?>
