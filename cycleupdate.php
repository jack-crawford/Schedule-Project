<?php
date_default_timezone_set('America/Chicago');
include 'cheatsheat.php';
include 'login.php';
mylog("started");
$db_server = new mysqli("localhost", "root", "root", "schedule");
if ($db_server->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
mylog("connected to server");



$newdayoff = $_POST['dayoff'];
$offdaytable = mysqli_query('SELECT * FROM offdays');
if ($offdaytable->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
mylog("off day query succeeded");

$x = 1;
$letter = 'F';
$cyc = 6;
while ($x <= 365):

  //if it's a weekend, skip
  if (date('D' , strtotime("+ $x day")) === "Sun" or date('D' , strtotime("+ $x day")) === "Sat"){
    $x = $x + 1;
    mylog('weekend removed');
  } elseif (in_array(date('m.d.y', strtotime("+ $x day")), $offdayssql)) {
    $x = $x + 1;
    mylog("offday skipped");
  } else {
  if ($cyc == 1) {
    $letter = "A";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "UPDATE days(cycleday) VALUES ('$letter') WHERE numdate = $formattedextrapolateddate ";
    $result = mysqli_query($dayquery);
      if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
  }
  elseif ($cyc == 2) {
    $letter = "B";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
    /*$result = mysqli_query($dayquery);
    if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }*/
  }
  elseif ($cyc == 3) {
    $letter = "C";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
    //$result = mysqli_query($dayquery);
    if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
  }
  elseif ($cyc == 4) {
    $letter = "D";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
    //$result = mysqli_query($dayquery);
    if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
  }
  elseif ($cyc == 5) {
    $letter = "E";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
    //$result = mysqli_query($dayquery);
    if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
  }
  elseif ($cyc == 6) {
    $letter = "F";
    global $letter;
    $cyc = 1;
    $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
   //$result = mysqli_query($dayquery);
    if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
  }
  echo $b;
  $x = $x + 1;
  echo "test";
}
endwhile;










































?>
