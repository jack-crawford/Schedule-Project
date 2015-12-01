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



$offdaytable = mysqli_query('SELECT * FROM offdays');
if ($offdaytable->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$offdayssql = array();

while($row = mysqli_fetch_array($offdaytable)){
    $offdayssql[] = $row['numdate'];

}

mylog("off day query succeeded");

$x = 1;
$letter = 'A';
$cyc = 1;
while ($x <= 365):
    $date = date('Y-m-d', strtotime("+ $x day"));
  //if it's a weekend, skip
  if (date('D' , strtotime("+ $x day")) === "Sun" or date('D' , strtotime("+ $x day")) === "Sat"){
    $x = $x + 1;
    mylog('weekend removed');
  } elseif (in_array($date, $offdayssql)) {
    $x = $x + 1;
    mylog("offday skipped");
  } else {
  if ($cyc == 1) {

    $letter = "A";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "UPDATE days('cycleday', 'daate') VALUES ('$letter', '$date')";
    //WHERE daate = '$date'";
    mylog($dayquery);
    $result = mysqli_query($dayquery);
      if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
    mylog('A');
    echo "  ";
    echo $letter;
    echo "  ";
    echo $date;
  }
  elseif ($cyc == 2) {
    $letter = "B";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "INSERT INTO days('cycleday', 'daate') VALUES ('$letter','$date')";
    //WHERE daate = '$date'";
    mylog($dayquery);
    $result = mysqli_query($dayquery);
      if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }    mylog('b');
    echo "  ";
    echo $letter;
    echo "  ";
    echo $date;
  }
  elseif ($cyc == 3) {
    $letter = "C";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "INSERT INTO days('cycleday', 'daate') VALUES ('$letter','$date')";
    //WHERE daate = '$date'";
    mylog($dayquery);
    $result = mysqli_query($dayquery);
      if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
    mylog('c');
    echo "  ";
    echo $letter;
    echo "  ";
    echo $date;
  }
  elseif ($cyc == 4) {
    $letter = "D";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "INSERT INTO days('cycleday', 'daate') VALUES ('$letter','$date')";
    //WHERE daate = '$date'";
    mylog($dayquery);
    $result = mysqli_query($dayquery);
      if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
    mylog('d');
    echo "  ";
    echo $letter;
    echo "  ";
    echo $date;
  }
  elseif ($cyc == 5) {
    $letter = "E";
    global $letter;
    $cyc = $cyc + 1;
    $dayquery = "INSERT INTO days('cycleday', 'daate') VALUES ('$letter','$date')";
    //WHERE daate = '$date'";
    mylog($dayquery);
    $result = mysqli_query($dayquery);
      if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
    mylog('e');
    echo "  ";
    echo $letter;
    echo "  ";
    echo $date;
  }
  elseif ($cyc == 6) {
    $letter = "F";
    global $letter;
    $cyc = 1;
    $dayquery = "INSERT INTO days('cycleday', 'daate') VALUES ('$letter','$date')";
    //WHERE daate = '$date'";
    mylog($dayquery);
    $result = mysqli_query($dayquery);
      if ($result->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      } 
    mylog('f');
    echo "  ";
    echo $letter;
    echo "  ";
    echo $date;
  }
  echo $b;
  $x = $x + 1;
  echo $x;
}
endwhile;










































?>
