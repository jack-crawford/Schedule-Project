<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
include 'cheatsheat.php';
mylog('post begins');

$db_server = mysqli_connect("localhost", "root", "root", "schedule");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$today = date("Y-m-d");

function display() {
    $today = date("Y-m-d");
    $todaycycquery = "SELECT cycleday FROM days WHERE daate = '$today'";
    mylog($todaycycquery);
    $todaycycresult = mysqli_query($db_server, $todaycycquery);
    if ($todaycycresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $row = mysqli_fetch_array($todaycycresult, MYSQLI_ASSOC);
    mylog("fetched today's date");
    mysqli_free_result($todaycycresult);
    $cyclefortoday = $row['cycleday'];   
    echo "<h2 style='text-align:center'> TODAY IS </h2><h1 style='text-align:center'> $cyclefortoday DAY</h1> ";
}

$todayactivequery = "SELECT active FROM days WHERE daate = '$today'";
mylog($todayactivequery);
$todayactiveresult = mysqli_query($db_server, $todayactivequery);
if ($todayactivequery->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$row = mysqli_fetch_array($todayactiveresult, MYSQLI_ASSOC);
mylog("fetched today's date");
mysqli_free_result($todayactiveresult);
$active = $row['active'];


if ($active === 'y') {
    display();
} else {
    echo "<h2 style='text-align: center'> We appreciate the enthusiasm, but today isn't a school day!</h2>";
}
























































?>