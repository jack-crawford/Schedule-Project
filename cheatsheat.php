<?php
//Jack's cheat sheet of stuff he doesn't like typing

$b = "</br>";
$db_hostname = "localhost";
$db_username = "root";
$db_password = "root";
$db_table = "schedule";


function mylog($message) {
date_default_timezone_set('America/Chicago');
$logtime = date("Y-m-d H:i:s");
$file = fopen( 'logfile.txt', "a");
fwrite ($file, "$logtime: $message\n");
fclose($file);
}
?>
