<?php
include('../gb-includes/sessions.inc.php');
session_start();
session_destroy();
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
header('Location: ' . $home_url);
?>