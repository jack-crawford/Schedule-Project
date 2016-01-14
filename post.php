<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
include 'cheatsheat.php';
mylog('post begins');

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
        return 'active';
    mylog("$dateinquestion is active");
    }
    else {
        return 'inactive';
    }
}

function updaterestoftable($newlyinactivedate, $cycofnewlyinactivedate, $startingvalue) {
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $x = $startingvalue;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
    $cyc = array_search($cycofnewlyinactivedate, $cyc_array);
    mylog("the letter day now used on the next day is: $letter");
    while ($x <= 2):
        mylog('while started');
        $newlyinactivedatep1 = strtotime($newlyinactivedate);
        mylog("$newlyinactivedatep1 p1");
        $newlyinactivedatep2 = date('Y-m-d', strtotime("+ $x days", "$newlyinactivedatep1"));
        mylog("$newlyinactivedatep2 p2");
        
        
        //if it's a weekend, skip
        if (date('D' , strtotime("+ $x days", "$newlyinactivedatep1")) === "Sun" || date('D' , strtotime("+ $x days", "$newlyinactivedatep1")) === "Sat"){
            mylog("$newlyinactivedatep2 is a weekend or offday removed");
        } else {
            $letter = $cyc_array[$cyc];
            mylog('should be starting with ' . $letter);
            $cyc = ($cyc==5) ? 0 : $cyc + 1;
            mylog("letter is $letter, date is: $newlyinactivedatep2");
            $dayquery = "UPDATE days SET cycleday = '$letter', daymodified = now() WHERE daate = '$newlyinactivedatep2';";
            mylog($dayquery);
            $result = mysqli_query($db_server, $dayquery);       
            if ($result->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            mylog($letter);
            echo "  ";
            echo $letter;
            echo "  ";
            echo $newlyinactivedatep2;
            echo "</br>";
            
        }
    $x = $x + 1;    
    endwhile;
    
    echo $b;
    echo "thank you, $newlyinactivedate has been removed from the schedule";
}


/*function alterdays($date){
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit();
    }
    $today = date('Y-m-d');
    mylog('started to insert days');
    $activeday = checkforinactiveday($date)
    //if day input is a weekend, ignore;
    if (strcmp($activeday, "active")) {
    //select cycleday value of day that will be marked inactive
        $dayafterselectedday = date('Y-m-d', strtotime("+ 1 day", "$date"));
        $grabletterofnextday = "SELECT cycleday FROM days WHERE daate = '$dayafterselectedday';";
        mylog($grabletterofnextday);
        if ($grabletterofnextdayresult = mysqli_query($db_server, $grabletterofnextday)){
        $row = mysqli_fetch_assoc($grabletterofnextdayresult);
        mylog("row is " . print_r($row, true));
        $cycledayofnextday = $row['cycleday'];
        mylog("this is the cycle day of the posted date: $cycledayofnextday");
        mysqli_free_result($grabletterofnextdayresult);
        }
        else
        {
        mylog('query failed');
        }
        
        
        //update row of day about to be "removed" to be inactive
        $makedayactive = "UPDATE days SET active = 'y', daymodified = '$today' WHERE daate = '$date';";
        mylog($makedayactive);
        $makedayactiveresult = mysqli_query($db_server, $makedayactive);
        if ($makedayactiveresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        } else {
        mylog("made day inactive");
        }
        mylog("$date, $cycledayofactiveday");
        updaterestoftable($date, $cycledayofnexrday, 0);
    }
    else {
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
        mylog("$date, $cycledayofinactiveday");
        updaterestoftable($date, $cycledayofinactiveday, 1);
    }
    
    //Pull offday list, necessary?
    $offdayssql = array();
}*/
//alterdays($newdayoff);
checkforinactiveday($newdayoff);
?>