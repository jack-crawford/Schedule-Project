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
$today = date('Y-m-d');

//theoretically add days to offdays array
echo "Add days off: <form action='post.php' method='post'><input type='text' name='dayoff' /><input type='submit' /> </form> ";

$todayquery = "SELECT cycleday FROM days WHERE daate = '$today'";
mylog($todayquery);
$todayresult = mysqli_query($db_server, $todayquery);
if ($todayresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$row = mysqli_fetch_array($todayresult, MYSQLI_ASSOC);
mylog("fetched today's date");
mysqli_free_result($todayresult);
printf($row['cycleday']);

mysqli_close($db_server);

?>
