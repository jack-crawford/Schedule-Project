<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
include 'cheatsheat.php';
mylog('post begins');
echo "<html>";
$db_server = mysqli_connect("localhost", "root", "root", "schedule");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
global $db_server;
$today = date("Y-m-d");
global $today;
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
    
    
    if ($cyclevalue === 'D' || $dayoftheweek === 'Wed') {
        mylog("entered conditional of timecheck");
        //check with dday mod times
        $nextmodtimefortoday = ddaytimemath();
        $ddaymodquery = "SELECT modd FROM ddaymodtimes WHERE timee = '0000-00-00 $nextmodtimefortoday';";
        $ddaymodqueryresult = mysqli_query($db_server, $ddaymodquery);
        if ($ddayquery->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $row = mysql_fetch_array($ddaymodqueryresult, MYSQLI_ASSOC);
        mysql_free_result($ddaymodqueryresult);
        $mod = $row['modd'];
        echo $mod;
        echo $ddaymodquery;
    } else {
        //check with normal mod times
        $THEformattedtime = date('h:i');
        $THEFORMATTEDNOW = "0000-00-00 $THEformattedtime:00";
        $normalmodquery = "SELECT modd FROM normalmodtimes WHERE timee > '$THEFORMATTEDNOW';";
        $normalmodqueryresult = mysqli_query($db_server, $normalmodquery);
        if ($normalmodquery->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $row = mysql_fetch_array($normalmodqueryresult, MYSQLI_ASSOC);
        mysql_free_result($normalmodqueryresult);
        $mod = $row['modd'];
        echo $mod;
        echo $normalmodquery;
    }
    
}

$b = "</br>";
function ddaytimemath() {
    $currenthour = date('h');
    $currentminute = date("i");
    mylog( "Current minute is $currentminute  ");
    $currentminuteroundeddown = $currentminute * .1;
    mylog( "current minute times .1 is $currentminuteroundeddown  ");
    $currentminuteroundeddowntothewhole = ceil($currentminuteroundeddown);
    mylog("current minute times .1 and rounded is $currentminuteroundeddowntothewhole  ");
    $currentminuteroundedtothetenthofanhour = $currentminuteroundeddowntothewhole * 10;
    mylog("current minute times .1 and rounded times 10 is $currentminuteroundedtothetenthofanhour ");
    if ($currentminuteroundedtothetenthofanhour == 10 || $currentminuteroundedtothetenthofanhour == 30 || $currentminuteroundedtothetenthofanhour == 50) {
        //then we're good
        mylog("rounding resulted in $currentminuteroundedtothetenthofanhour");
        $amorpm = date('A');
        $nextmodtimefordday = "$currenthour:$currentminuteroundedtothetenthofanhour:00 $amorpm";
        echo "the next mod is at  $nextmodtimefordday";
        return $nextmodtimefordday;
    } else {
        $fixednext10mininterval = $currentminuteroundedtothetenthofanhour + 10;
        mylog("it needed to be rounded some more... $fixednext10mininterval");
        $nextmodtimefordday = "$currenthour:$fixednext10mininterval";
        echo "<h2 style='text-align:center'> the next mod is at  $nextmodtimefordday </h2>";
        return $nextmodtimefordday;
    }
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



umbrellafunction();





























echo "</html>";



















?>