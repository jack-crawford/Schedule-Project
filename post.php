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
    <div id = 'header'> <a href='schoollogo.jpeg'> </a>hhcycly  </div>  ";





$newdayoff = $_POST['dayoff'];
mylog('the value insertdays should be getting is ' . $newdayoff);


$daytobecomespecial = $_POST['special'];
echo $daytobecomespecial;

function makedayspecial($date) {
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $specialquery = "SELECT specialsched FROM days WHERE daate = '$date';";
    $specialqueryresult = mysqli_query($db_server, $specialquery);
    //mylog('ran the inactive day query');
    if ($specialqueryresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        $row = mysqli_fetch_array($specialqueryresult, MYSQLI_ASSOC);
    }
    
    $resultrow = mysqli_fetch_array($specialqueryresult, MYSQLI_ASSOC);
    $is_spec = $resultrow["specialsched"];
    if (empty($date)){
        mylog('no days were special today :(');
    }
    elseif ($is_spec === 'y') {
        $updatespectonquery = "UPDATE days SET specialsched = 'n' WHERE daate = '$date';";
        $updatespectonqueryresult = mysqli_query($db_server, $updatespectonquery);
        //mylog('ran the inactive day query');
        if ($updatespectonqueryresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        echo "Thank you, $date is no longer a short class day";
    }
    else {
        $updatespectoyquery = "UPDATE days SET specialsched = 'y' WHERE daate = '$date';";
        $updatespectoyqueryresult = mysqli_query($db_server, $updatespectoyquery);
        //mylog('ran the inactive day query');
        if ($updatespectoyqueryresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        echo "Thank you, $date will now be a short class day";
        }   
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
    mylog("THE QUERY ON LINE 98 is $inactivedaycheck");
    $inactivedaycheckresult = mysqli_query($db_server, $inactivedaycheck);
    //mylog('ran the inactive day query');
    if ($inactivedaycheckresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    $resultrow = mysqli_fetch_array($inactivedaycheckresult, MYSQLI_ASSOC);
    $activestatus = $resultrow["active"];
    mylog("active status for $dateinquestion is $activestatus");
   
    return $activestatus;
}




function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}


function alter_activation($date) {
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $specialquery = "SELECT active FROM days WHERE daate = '$date';";
    $specialqueryresult = mysqli_query($db_server, $specialquery);
    //mylog('ran the inactive day query');
    if ($specialqueryresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        $row = mysqli_fetch_array($specialqueryresult, MYSQLI_ASSOC);
    }
    
    $resultrow = mysqli_fetch_array($specialqueryresult, MYSQLI_ASSOC);
    $is_spec = $resultrow["active"];
    if (empty($date)){
        mylog('no days were special today :(');
    }
    elseif ($is_spec === 'y') {
        $updatespectonquery = "UPDATE days SET active = 'n' WHERE daate = '$date';";
        $updatespectonqueryresult = mysqli_query($db_server, $updatespectonquery);
        //mylog('ran the inactive day query');
        if ($updatespectonqueryresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        echo "Thank you, $date will now be an inactive school day";
    }
    else {
        $updatespectoyquery = "UPDATE days SET active = 'y' WHERE daate = '$date';";
        $updatespectoyqueryresult = mysqli_query($db_server, $updatespectoyquery);
        //mylog('ran the inactive day query');
        if ($updatespectoyqueryresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        echo "Thank you, $date will now be an active school day";
        }   
    }   
}




function updatecycleV3() {
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
    }
    $today = date('Y-m-d');
    
    //Here's the goal of V3 - take all inactive days. then run the usual update sequence checking only if a day is a weekend or on the inactive array
    $findoffdays = "SELECT daate FROM days where active = 'n';";
    $offdaysresult = mysqli_query($db_server, $findoffdays);
    if ($findoffdays->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    $offdays_array = mysqli_fetch_all($offdaysresult,MYSQLI_NUM);
    mylog(print_r($offdays_array, true));
    $x = 1;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
    $letter = 'A';
    $cyc = 0;
    while ($x <= 200):
        
        $startdate = "2016-01-04";
        $dategivenbyadmin = strtotime($startdate);
        $formatteddateforcondish = date('Y-m-d', $dategivenbyadmin);
        mylog("$dategivenbyadmin is the DATE GIVEN BY ADMIN");
        $nextday = date('Y-m-d', strtotime("+ $x days", "$dategivenbyadmin"));
        mylog("$x days after $dategivenbyadmin is $nextday");
        
        //$activeday = checkforinactiveday($nextday);
        
        
        //if it's a weekend, skip
        if (date('D' , strtotime("+ $x days", "$dategivenbyadmin")) === "Sun" || date('D' , strtotime("+ $x days", "$dategivenbyadmin")) === "Sat"){
            mylog("$nextday is a weekend 395");
            $x = $x + 1;
        }
        elseif (in_array_r($nextday, $offdays_array, true)) {
            mylog("$nextday is in the $offdays list");
            $x = $x + 1;
        } else {
            $letter = $cyc_array[$cyc];
            //mylog("should be starting with $letter");
            $cyc = ($cyc==5) ? 0 : $cyc + 1;
            mylog("the cyc value for $nextday should be $cyc");
            mylog("the letter value for $nextday should be $letter");
            $dayquery = "UPDATE days SET cycleday = '$letter', daymodified = '$today' WHERE daate = '$nextday';";
            mylog("update query looks like $dayquery");
            $dayqueryresult = mysqli_query($db_server, $dayquery);
            mylog('ran the inactive day query');
            if ($dayqueryresult->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            $x = $x + 1;
            //$cyc = $cyc + 1;
        }
        
    endwhile; 
}




makedayspecial($daytobecomespecial);
alter_activation($newdayoff);
updatecycleV3();




?>