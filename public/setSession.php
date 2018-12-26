<?php
header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
session_start();
$_SESSION['safari'] = 1;

// Redirect page to URL from where the request came
$redirectTo = '/';
if(isset($_REQUEST['redirect'])) {
	$redirectTo = $_REQUEST['redirect'];
} else {
	$redirectTo = '/index.php';
}

header('location:'.$redirectTo);
?>
