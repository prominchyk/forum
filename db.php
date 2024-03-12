<?php

define('MODE', 'dev');

$host = 'localhost';
$user = 'root';
$pass = '';
$name = 'mydb';

$link = mysqli_connect($host, $user, $pass, $name);
mysqli_query($link, "SET NAMES 'utf-8'");



/*define('MODE', 'prod');

$host = 'fdb1032.awardspace.net';
$user = '4454954_forumdb';
$pass = 'bmhV;Hbr3.LTH9t0';
$name = '4454954_forumdb';

$link = mysqli_connect($host, $user, $pass, $name);
//mysqli_query($link, "SET NAMES 'utf-8'");*/


?>