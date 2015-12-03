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



$offdaytable = mysqli_query($db_server, 'SELECT * FROM offdays');
if ($offdaytable->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$offdayssql = array();

while($row = mysqli_fetch_array($offdaytable)){
    $offdayssql[] = $row['numdate'];

}

mylog("off day query succeeded");

$x = 0;
$cyc = 2;
$cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
while ($x <= 364):
    $date = date('Y-m-d', strtotime("+ $x day"));
  //if it's a weekend, skip
  if (date('D' , strtotime("+ $x day")) === "Sun" or date('D' , strtotime("+ $x day")) === "Sat"){
    $x = $x + 1;
    mylog('weekend removed');
  } elseif (in_array($date, $offdayssql)) {
    $x = $x + 1;
    mylog("offday skipped");
  }
  else {
    $letter = $cyc_array[$cyc];
    $cyc = ($cyc==5) ? 0 : $cyc + 1;
    mylog("letter is $letter, cyc is $cyc");
  
    $dayquery = "UPDATE days SET cycleday = '$letter' WHERE daate = '$date';";
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
    echo $b;
    $x = $x + 1;

  }
endwhile;
    












































?>
