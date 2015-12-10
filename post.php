<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
include 'cheatsheat.php';

$today = date('Y-m-d');
<<<<<<< Updated upstream

$db_server = new mysqli("localhost", "root", "root", "schedule");
if ($db_server->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$newdayoff = $_POST['dayoff'];
mylog('the value insertdays should be getting is ' . $newdayoff);

=======
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

>>>>>>> Stashed changes
function checkforinactiveday($dateinquestion){
    mylog('started to check for inactive day');
    $inactivedaycheck = "SELECT active FROM days WHERE daate = '$dateinquestion';";
    mylog($inactivedaycheck);
    $inactivedaycheckresult = mysqli_result($db_server, $inactivedaycheck);
    mylog('ran the inactive day query');
    if ($inactivedaycheckresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    $row = mysqli_fetch_array($inactivedaycheckresult, MYSQLI_ASSOC);
    mylog("checked inactive day for $dateinquestion");
    }
    mysqli_free_result($inactivedaycheckresult);
    $activestatus = $row['active'];
    if ($activestatus === 'y') {
        return 'true';
    mylog("$dateinquestion is active");
    }
    else {
        return 'false';
    }
}



function insertdays($date){
    $today = date('Y-m-d');
<<<<<<< Updated upstream
    mylog('value that insert days is actually getting is ' . $date);
    //when a day is added it's posted to offdays
    $adddayoff = "INSERT INTO offdays(numdate) VALUES ('$date') EXCEPT SELECT numdate FROM offdays";
    $dayoffresult = mysqli_query($db_server, $adddayoff);
    if ($dayoffresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    //select cycleday value of day that will be marked inactive
    /*$grabletterofinactiveday = "SELECT cycleday FROM days WHERE daate = '$date'";
    mylog($grabletterofinactivedayresult);
    $grabletterofinactivedayresult = mysqli_query($db_server, $grabletterofinactiveday);
    if ($grabletterofinactivedayresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $row = mysqli_fetch_array($grabletterofinactivedayresult, MYSQLI_ASSOC);
    mylog("fetched $date's row");
    mysqli_free_result($grabletterofinactivedayresult);
    $letterofinactiveday = $row['cycleday'];
    mylog("the cycle day that will now be built off of is: $letterofinactiveday");

=======
    mylog('started to insert days');
    //when a day is added it's posted to offdays
    

    //select cycleday value of day that will be marked inactive
    $grabletterofinactiveday = "SELECT cycleday FROM days WHERE daate = '$date';";
    mylog($grabletterofinactiveday);
    
    #$grabletterofinactivedayresult = mysqli_query($db_server, $grabletterofinactiveday);
    #if ($grabletterofinactivedayresult->connect_errno) {
    #echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    #}
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
    
>>>>>>> Stashed changes
    //update row of day about to be "removed" to be inactive
    $makedayinactive = "UPDATE days SET active = 'n', daymodified = '$today' WHERE daate = '$date';";
    mylog($makedayinactive);
    $makedayinactiveresult = mysqli_query($db_server, $makedayinactive);
    if ($makedayinactiveresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    //Pull offday list, necessary?
    $offdayssql = array();

    while($row = mysqli_fetch_array($offdaytable)){
        $offdayssql[] = $row['numdate'];

    }

<<<<<<< Updated upstream
    mylog("off day query succeeded");
=======
    mylog('made it through queries');
>>>>>>> Stashed changes
    

    //bug to fix later: queries don't run inside function
    //set cyc to value corresponding with the current day 
    //make day that was added to the days off list an inactive day

    //updating, reinserting the new data
<<<<<<< Updated upstream
    */
=======
    
>>>>>>> Stashed changes
    $x = 0;
    $cyc = 5;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
    echo $date;
    echo $b;
    echo $letterofinactiveday;
    echo $b;
<<<<<<< Updated upstream
    /*mylog('made it to 89');
    $truncate = "TRUNCATE TABLE days;";
    mylog($truncate);
    $result = mysqli_query($db_server, $truncate);       
    if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    mylog('got past truncate, unsure if working');*/
=======

>>>>>>> Stashed changes
    while ($x <= 364):
        mylog('while started');
        $date = date('Y-m-d', strtotime("+ $x day"));
        mylog($date);
        $offdayz = checkforinactiveday($date);
        mylog($offdayz);
        //if it's a weekend, skip
        if (date('D' , strtotime("+ $x day")) === "Sun" || date('D' , strtotime("+ $x day")) === "Sat" || $offdayz = 'true'){
            $x = $x + 1;
            mylog('weekend or offday removed');
        } else {
            mylog('entered reinsert phase');
            $letter = $cyc_array[$cyc];
            mylog('should be starting with ' . $letter);
            $cyc = ($cyc==5) ? 0 : $cyc + 1;
            mylog("letter is $letter, cyc is $cyc");
            $dayquery = "INSERT INTO days(cycleday, daate, active, daymodified) VALUES ('$letter','$date', 'y', '$today');";
            mylog($dayquery);
            $result = mysqli_query($db_server, $dayquery);       
            if ($result->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            mylog($letter);
            echo "  ";
            echo $letter;
            echo "  ";
            echo $date;
            echo "</br>";
            $x = $x + 1;
        }
    endwhile; 
    echo "thank you, $date has been removed from the schedule";
}


insertdays($newdayoff);

?>
