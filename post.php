<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
include 'cheatsheat.php';
mylog('post begins');
$today = date('Y-m-d');
global $db_server;
#$db_server = new mysqli("localhost", "root", "root", "schedule");
#if ($db_server->connect_errno) {
#    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
#}
$db_server = mysqli_connect("localhost", "root", "root", "schedule");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$newdayoff = $_POST['dayoff'];
mylog('the value insertdays should be getting is ' . $newdayoff);

function checkforinactiveday($dateinquestion){
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    mylog('started to check for inactive day');
    $inactivedaycheck = "SELECT active FROM days WHERE daate = '$dateinquestion';";
    mylog($inactivedaycheck);
    $inactivedaycheckresult = mysqli_query($db_server, $inactivedaycheck);
    mylog('ran the inactive day query');
    if ($inactivedaycheckresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    $row = mysqli_fetch_array($inactivedaycheckresult, MYSQLI_ASSOC);
    mylog("checked inactive day for $dateinquestion");
    }
    mysqli_free_result($inactivedaycheckresult);
    $activestatus = $row['active'];
    mylog("active status for $dateinquestion is $activestatus");
    if ($activestatus === 'y') {
        return 'true';
    mylog("$dateinquestion is active");
    }
    else {
        return 'false';
    }
}

function updaterestoftable($newlyinactivedate, $cycofnewlyinactivedate) {
    $x = 0;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
    $cyc = array_search($cycofnewlyinactivedate, $cyc_array);
    mylog("the letter day now used on the next day is: $cyc");
    while ($x <= 364):
        mylog('while started');
        $newlyinactivedatep1 = date('Y-m-d', strtotime($date));
        mylog($newlyinactivedatep1);
        $newlyinactivedate = date('Y-m-d', strtotime("+ $x day", $newlyinactivedatep1));
        mylog($newlyinactivedate);
        
        //if it's a weekend, skip
        if (date('D' , strtotime("+ $x day")) === "Sun" || date('D' , strtotime("+ $x day")) === "Sat" /*|| $offdayz = 'true'*/){
            $x = $x + 1;
            mylog('weekend or offday removed');
        } else {
            mylog('entered reinsert phase');
            $letter = $cyc_array[$cyc];
            mylog('should be starting with ' . $letter);
            $cyc = ($cyc==5) ? 0 : $cyc + 1;
            mylog("letter is $letter, cyc is $cyc");
            $dayquery = "UPDATE days SET cycleday = '$letter', daymodified = '$today' WHERE 'daate' = '$newlyinactivedate';";
            mylog($dayquery);
            $result = mysqli_query($db_server, $dayquery);       
            if ($result->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            mylog($letter);
            echo "  ";
            echo $letter;
            echo "  ";
            echo $newlyinactivedate;
            echo "</br>";
            $x = $x + 1;
        }
    endwhile;
    echo $b;
    echo "thank you, $newlyinactivedate has been removed from the schedule";
}


function insertdays($date){
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit();
    }
    $today = date('Y-m-d');
    mylog('started to insert days');
    //when a day is added it's posted to offdays
    

    //select cycleday value of day that will be marked inactive
    $grabletterofinactiveday = "SELECT cycleday FROM days WHERE daate = '$date';";
    mylog($grabletterofinactiveday);
    
    if ($grabletterofinactivedayresult = mysqli_query($db_server, $grabletterofinactiveday))
    {
        $row = mysqli_fetch_assoc($grabletterofinactivedayresult);
        mylog("row is " . print_r($row, true));
        $cycledayofinactiveday = $row['cycleday'];
        mylog("this is the cycle day of the posted date: $cycledayofinactiveday");
        mysqli_free_result($grabletterofinactivedayresult);
    }
    else
    {
        mylog('query failed');
    }

    
    //update row of day about to be "removed" to be inactive
    $makedayinactive = "UPDATE days SET active = 'n', daymodified = '$today' WHERE daate = '$date';";
    mylog($makedayinactive);
    $makedayinactiveresult = mysqli_query($db_server, $makedayinactive);
    if ($makedayinactiveresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    } else {
        mylog("made day inactive");
    }
    updaterestoftable($date, $cycledayofinactiveday);
}
    
    //Pull offday list, necessary?
    $offdayssql = array();

insertdays($newdayoff);

?>
