<html>
<?php
echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
      <link rel='stylesheet' type='text/css' href='css/jquery.countdown.css'> 
      <script type='text/javascript' src='js/jquery.plugin.js'></script> 
      <script type='text/javascript' src='js/jquery.countdown.js'></script>

";
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
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    $today = date("Y-m-d");
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
    echo "<h2 style='text-align:center'> TODAY IS </h2><h1 style='text-align:center'> $cyclevalue DAY</h1> ";
}




function timecheck() {
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    $today = date("Y-m-d");
    $currenthour = date("H");
    echo $currenttime;
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
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
        mylog($ddaymodquery);
        $ddaymodqueryresult = mysqli_query($db_server, $ddaymodquery);
        if ($ddayquery->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $row = mysqli_fetch_array($ddaymodqueryresult, MYSQLI_ASSOC);
        mysqli_free_result($ddaymodqueryresult);
        $mod = $row['modd'];
        echo "<h1 style='text-align: center'> The next mod is: $mod </h1>";
        mylog($ddaymodquery);
    } else {
        $db_server = mysqli_connect("localhost", "root", "root", "schedule");
        //check with normal mod times
        $THEformattedtime = date('H:i');
        $THEFORMATTEDNOW = "0000-00-00 $THEformattedtime:00";
        $normalmodquery = "SELECT modd FROM normalmodtimes WHERE timee > '$THEFORMATTEDNOW' LIMIT 1;";
        $normalmodqueryresult = mysqli_query($db_server, $normalmodquery);
        if ($normalmodquery->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        mylog("THE NORMAL MOD QUERY SHOULD BE: $normalmodquery");
        $row = mysqli_fetch_array($normalmodqueryresult, MYSQLI_ASSOC);
        mysqli_free_result($normalmodqueryresult);
        $mod = $row['modd'];
        echo "<h1 style='text-align: center'> The next mod is: $mod </h1>";
        
        
        $nextmodtimequery = "SELECT timee FROM normalmodtimes WHERE modd = '$mod';";
        $nextmodtimequeryresult = mysqli_query($db_server, $nextmodtimequery);
        if ($nextmodtimequery->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        mylog("THE NEXT MODTIME QUERY SHOULD BE: $nextmodtimequery");
        $row = mysqli_fetch_array($nextmodtimequeryresult, MYSQLI_ASSOC);
        mysqli_free_result($nextmodtimequeryresult);
        $timee = $row['timee'];
        
        
        $substroftime = substr($timee, -8);
        echo "this is the next mod's time $substroftime";
        echo "</br>";
        echo " this is today: $today   ";
        echo "</br>";
        echo " this is the next mod today! $today $substroftime";
        echo "</br>";
        $dateandsubstroftime = $today . $substroftime;
        echo "</br>";
        $astime = strtotime($dateandsubstroftime);
        echo "</br>";
        echo $astime;
        echo "</br>";
        echo date("h:i:s");
        echo "</br>";
        echo date("h:i:s", $astime);
        
        
        echo $interval->format("I:S");
        $timetillnextmod = $interval; //timee minus current time
        
        echo "<script>
                $(function () {
                    var austDay = new Date();
                    austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
                    $('#defaultCountdown').countdown({until: $astime});
                    $('#year').text(austDay.getFullYear());
                });
            </script>";
    }
    
}

$b = "</br>";
function ddaytimemath() {
    $today = date("Y-m-d");
    $currenthour = date('H');
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
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    $today = date("Y-m-d");
    $todayactivequery = "SELECT active FROM days WHERE daate = '$today'";
    mylog($todayactivequery);
    $todayactiveresult = mysqli_query($db_server, $todayactivequery);
    if ($todayactivequery->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $row = mysqli_fetch_array($todayactiveresult, MYSQLI_ASSOC);
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

echo "<script type='text/javascript'>
                $(function () {
                    var austDay = new Date();
                    austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
                    $('#defaultCountdown').countdown({until: austDay});
                    $('#year').text(austDay.getFullYear());
                });
            </script>";

















?>




<script type='text/javascript'>
            $(function () {
                var austDay = new Date();
                austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
                $('#defaultCountdown').countdown({until: austDay});
                $('#year').text(austDay.getFullYear());
                });
            </script>
            
            
            
</html>