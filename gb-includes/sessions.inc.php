<?php
function startSession() {
session_start();
ob_start();
// set time limit in seconds
$timelimit = 60*30;
// get the current time
$now = time();
// where to redirect if rejected
$redirect = "/gb-admin/login.php";
// if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !='Jethro Tull') {
	header("Location: $redirect");
	exit;
}
// if time limit has expired, destroy session and redirect
elseif ($now > $_SESSION['start'] + $timelimit) {
	// empty the $_SESSION array
	$_SESSION = array();
	// invalidate session cookie
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400, '/');
	}
	// end session and redirect with query string
	session_destroy();
	header("Location: {$redirect}?expired=yes");
	exit;
}
// if its got this far, its OK so update start time
else {
	$_SESSION['start'] = time();
}
}