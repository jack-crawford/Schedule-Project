<?php
date_default_timezone_set('America/Chicago');
include 'cheatsheat.php';
require_once 'login.php';
$db_server = new mysqli("localhost", "root", "root", "schedule");
if ($db_server->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$letter = "D";
$x = 1;
$cyc = 1;
$today = '12.12.15';
//date('m.d.y');

//theoretically add days to offdays array
echo "Add days off: <form action='post.php' method='post'><input type='text' name='dayoff' /><input type='submit' /> </form> ";

$todayquery = "SELECT cycleday FROM days WHERE numdate = '$today'";
$todayresult = mysqli_real_query($db_server, $todayquery);

if ($todayresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
print $todayresult;
var_dump($todayresult);
?>
