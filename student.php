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



function umbrellafunction(){
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
    timecheck();
}


function timecheck() {
    $currenthour = date("h");
    echo $currenttime;
    
    $cycquery = "SELECT cycleday FROM days WHERE daate = '$today';";
    mylog($cycquery);
    $cycresult = mysqli_query($db_server, $cycquery);
    if ($cycquery->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $row = mysqli_fetch_array($cycresult, MYSQLI_ASSOC);
    mylog("fetched today's date");
    mysqli_free_result($cycresult);
    $cyclevalue = $row['cycleday'];
    $dayoftheweek = date('D');
    
    $currentminute = date("i");
    
    
    if ($cyclevalue === 'D' || $dayoftheweek === 'W') {
        //check with dday mod times
        $ddaymodquery = "SELECT mo";
    } else {
        //check with normal mod times
    }
    
}



umbrellafunction();

function timemath() {
    $currentminute = date("i");
    $currentminuteroundeddown = $currentminute * .1;
    $currentminuteroundeddowntothewhole = round($currentminuteroundeddown);
    $currentminuteroundedtothetenthofanhour = $currentminuteroundeddowntothewhole * 10;
    echo $currentminuteroundedtothetenthofanhour;
    //$next10mininterval = $currentminute + $differencebetweencurrentminuteandnext10;
    if ($currentminuteroundedtothetenthofanhour = 10 || $currentminuteroundedtothetenthofanhour = 30 || $currentminuteroundedtothetenthofanhour = 50) {
        //then we're good
        return $currentminuteroundedtothetenthofanhour;
    } else {
        $fixednext10mininterval = $currentminuteroundedtothetenthofanhour + 10;
        return $fixednext10mininterval;
    }
}
echo timemath();
















































?>