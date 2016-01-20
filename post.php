<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
include 'cheatsheat.php';
mylog('post begins');

global $db_server;

$db_server = mysqli_connect("localhost", "root", "root", "schedule");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

echo "<link rel='stylesheet' type='text/css' href='style.css'>
    <title> HH Admin Page </title>
    <div id = 'header'> <a href='schoollogo.jpeg'> </a>hhcyclr  </div>  ";





$newdayoff = $_POST['dayoff'];
mylog('the value insertdays should be getting is ' . $newdayoff);


function isNOTactiveweekday($datesaftergiven, $formatteddateforcondish, $activeday) {
            if (date('D' , strtotime("+ $x days", "$datesaftergiven")) === "Sun" || date('D' , strtotime("+ $x days", "$datesaftergiven")) === "Sat"){
                mylog("IN isNOTactiveweekday, $datesaftergiven IS EITHER A SATURDAY OR A SUNDAY");
                return true; 
            }
                if ($activeday === 'n') {
                    mylog("isNOTactiveweekday went to checking if $activeday is a no!");
                    if ($datesaftergiven != $formatteddateforcondish) {
                        mylog("isNOTactiveweekday went to checking if $datesaftergiven is not $formatteddateforcondish");
                        return true;
                    }
                }   
            else {
                return false;
            }
        }


function checkforinactiveday($dateinquestion){
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    //mylog('started to check for inactive day');
    //THIS QUERY RUNS!!!!!!
    $inactivedaycheck = "SELECT active FROM days WHERE daate = '$dateinquestion';";
    mylog($inactivedaycheck);
    $inactivedaycheckresult = mysqli_query($db_server, $inactivedaycheck);
    //mylog('ran the inactive day query');
    if ($inactivedaycheckresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        $row = mysqli_fetch_array($inactivedaycheckresult, MYSQLI_ASSOC);
        mylog("THE QUERY ON LINE 28 RESPONDED WITH: $dateinquestion");
    }
    
    $resultrow = mysqli_fetch_array($inactivedaycheckresult, MYSQLI_ASSOC);
    $activestatus = $resultrow["active"];
    mylog("active status for $dateinquestion is $activestatus");
   
    if ($activestatus === 'y') {
        return 'y';
    mylog("$dateinquestion is active");
    }
    else {
        return 'n';
        mylog("$dateinquestion is inactive");
    }
}

function updaterestoftable($newlyinactivedate, $cycofnewlyinactivedate, $startingvalue) {
    $today = date('Y-m-d');
    mylog("ENTERED UPDATE CYCLE!!!!!! with $newlyinactivedate, $cycofnewlyinactivedate, $startingvalue");
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $x = $startingvalue;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
    $cyc = array_search($cycofnewlyinactivedate, $cyc_array);
    //mylog("the letter day now used on the next day is: $letter");
    while ($x <= 10):
    
    
        $dategivenbyadmin = strtotime($newlyinactivedate);
        $formatteddateforcondish = date('Y-m-d', $dategivenbyadmin);
        mylog("$dategivenbyadmin is the DATE GIVEN BY ADMIN");
        $datesaftergiven = date('Y-m-d', strtotime("+ $x days", "$dategivenbyadmin"));
        mylog("$datesaftergiven p2");
        
        $activeday = checkforinactiveday($datesaftergiven);
        
        
        //if it's a weekend, skip
        if (isNOTactiveweekday($datesaftergiven, $formatteddateforcondish, $activeday)){
            mylog("$datesaftergiven IS NOT ACTIVE WEEKDAY");
            $x = $x + 1;
        } else {
            $letter = $cyc_array[$cyc];
            //mylog("should be starting with $letter");
            $cyc = ($cyc==5) ? 0 : $cyc + 1;
            //mylog("letter is $letter, date is: $newlyinactivedatep2");
            $dayquery = "UPDATE days SET cycleday = '$letter', daymodified = '$today' WHERE daate = '$datesaftergiven';";
            mylog("update query looks like $dayquery");
            $dayqueryresult = mysqli_query($db_server, $dayquery);
            mylog('ran the inactive day query');
            if ($dayqueryresult->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            mylog("THE QUERY ON LINE 81 BROUGHT: $letter");
            echo "  ";
            echo $letter;
            echo "  ";
            echo $newlyinactivedatep2;
            echo "</br>";
            $x = $x + 1;
        }
        
    endwhile;
    echo $b;
    echo "thank you, $newlyinactivedate has been removed from the schedule";
}


function alterdays($date){
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit();
    }
    $today = date('Y-m-d');
    mylog('started to insert days');
    $activeday = checkforinactiveday($date);
    mylog("$date, according to line ONE HUNDRED AND NINE, is $activeday");
    //if day input is a weekend, ignore;
    
    if ($activeday === "n") {
    //if day entered by admin is active
        mylog("stayed in if");
        $givendatep1 = strtotime($date);
        $givendatep2 = date('Y-m-d', strtotime("+ 1 day", "$givendatep1"));
        $grabletterofnextday = "SELECT cycleday FROM days WHERE daate = '$givendatep2';";
        mylog($grabletterofnextday);
        if ($grabletterofnextdayresult = mysqli_query($db_server, $grabletterofnextday)){
            $row = mysqli_fetch_assoc($grabletterofnextdayresult);
            mylog("row is " . print_r($row, true));
            $cycledayofnextday = $row['cycleday'];
            mylog("this is the cycle day of the posted date: $cycledayofnextday");
            mysqli_free_result($grabletterofnextdayresult);
        }
        else {
        mylog('query failed');
        }
        //update row of day about to be "removed" to be inactive
        $makedayactive = "UPDATE days SET active = 'y', daymodified = '$today' WHERE daate = '$date';";
        mylog($makedayactive);
        $makedayactiveresult = mysqli_query($db_server, $makedayactive);
        if ($makedayactiveresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        } 
        mylog("THESE ARE FED TO THE UPDATE CYCLE IF THE DAY IS ACTIVE: $date, $cycledayofnextday");
        updaterestoftable($date, $cycledayofnextday, 0);
    }
    else {
        mylog("went to else");
        //select cycleday value of day that will be marked inactive
        $grabletterofinactiveday = "SELECT cycleday FROM days WHERE daate = '$date';";
        mylog($grabletterofinactiveday);
        if ($grabletterofinactivedayresult = mysqli_query($db_server, $grabletterofinactiveday)) {
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
        $makedayactive = "UPDATE days SET active = 'n', daymodified = '$today' WHERE daate = '$date';";
        mylog($makedayactive);
        $makedayactiveresult = mysqli_query($db_server, $makedayactive);
        if ($makedayactiveresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        mylog("THESE ARE FED TO THE UPDATE CYCLE IF THE DAY IS INACTIVE:$date, $cycledayofinactiveday");
        updaterestoftable($date, $cycledayofinactiveday, 1);
    }
    
}
alterdays($newdayoff);
?>