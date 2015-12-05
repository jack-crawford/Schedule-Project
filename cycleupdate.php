<?php
date_default_timezone_set('America/Chicago');
include 'cheatsheat.php';
include 'login.php';
mylog("started");
$db_server = new mysqli("localhost", "root", "root", "schedule");
if ($db_server->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
mylog("connected to server");












































?>
