<?php
session_start();
$_SESSION['auth'] = null;
$_SESSION['log'] = null;
$_SESSION['id'] = null;
$_SESSION['status'] = null;
header('Location: index.php');
?>
