<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
include 'cheatsheat.php';

$db_server = new mysqli("localhost", "root", "root", "schedule");
if ($db_server->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$newdayoff = $_POST['dayoff'];


//when a day is added it's posted to offdays
$adddayoff = "INSERT INTO offdays(numdate) VALUES ('$newdayoff') EXCEPT SELECT numdate FROM offdays";
$dayoffresult = mysqli_query($db_server, $adddayoff);
if ($dayoffresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//select cycleday value of day that will be marked inactive
$grabletterofinactiveday = "SELECT cycleday FROM days WHERE daate = '$newdayoff'";
mylog($grabletterofinactivedayresult);
$grabletterofinactivedayresult = mysqli_query($db_server, $grabletterofinactiveday);
if ($grabletterofinactivedayresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$row = mysqli_fetch_array($grabletterofinactivedayresult, MYSQLI_ASSOC);
mylog("fetched $newdayoff");
mysqli_free_result($grabletterofinactivedayresult);
$letterofinactiveday = $row['cycleday'];
mylog("the cycle day that will now be built off of is: $letterofinactiveday");

//update row of day about to be "removed" to be inactive
$makedayinactive = "UPDATE days SET active = 'n' WHERE daate = '$newdayoff';";
mylog($makedayinactive);
$makedayinactiveresult = mysqli_query($db_server, $makedayinactive);
if ($makedayinactiveresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
function checkforinactiveday($date){
    $inactivedaycheck = "SELECT active FROM days WHERE daate = '$date'";
    $inactivedaycheckresult = mysqli_result($db_server, $inactivedaycheck);
    if ($inactivedaycheckresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    $row = mysqli_fetch_array($inactivedaycheckresult, MYSQLI_ASSOC);
    mylog("checked inactive day for $date");
    }
    mysqli_free_result($inactivedaycheckresult);
    $activestatus = $row['active'];
    if ($activestatus === 'y') {
        return true;
    }
    else {
        return false;
    }
}
    

//Pull offday list, necessary?
$offdayssql = array();

while($row = mysqli_fetch_array($offdaytable)){
    $offdayssql[] = $row['numdate'];

}

mylog("off day query succeeded");




//bug to fix later: queries don't run inside function
//set cyc to value corresponding with the current day 
//make day that was added to the days off list an inactive day
$makedayinactive = "UPDATE days(active) VALUES 'y' WHERE daate = '$newdayoff'";
$makedayinactiveresult = mysqli_query($db_server, $makedayinactive);
if ($makedayinactiveresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//updating, reinserting the new data
$x = 0;
$cyc = 0;
$cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
while ($x <= 364):
    $date = date('Y-m-d', strtotime("+ $x day"));
  //if it's a weekend, skip
  if (date('D' , strtotime("+ $x day")) === "Sun" or date('D' , strtotime("+ $x day")) === "Sat"){
    $x = $x + 1;
    mylog('weekend removed');
  } elseif (checkforinactiveday($date)) {
    $x = $x + 1;
    mylog("offday skipped");
  }
  else {
    $letter = $cyc_array[$cyc];
    $cyc = ($cyc==5) ? 0 : $cyc + 1;
    mylog("letter is $letter, cyc is $cyc");
  
    $dayquery = "INSERT INTO days(cycleday, daate, active) VALUES ('$letter','$date', 'y');";
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
}

//insertdays();



echo "thank you, $newdayoff has been removed from the schedule"

?>
