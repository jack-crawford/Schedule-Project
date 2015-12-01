<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
$db_server = mysql_connect("localhost", "root", "root");

$offdaytable = mysql_query('SELECT * FROM offdays');
if(!$offdaytable) die ('database access failed: . ' . mysql_error(););
while ($x === 365):
//if it's a weekend, skip
  if (date('D' , strtotime("+ $x day")) === "Sun" or date('D' , strtotime("+ $x day")) === "Sat"){

$offdaytable = mysql_query('SELECT * FROM offdays');
if(!$offdaytable) die ('database access failed: . ' . mysql_error());
  //if it's a weekend, skip
if (date('D' , strtotime("+ $x day")) === "Sun" or date('D' , strtotime("+ $x day")) === "Sat"){
    $x = $x + 1;
} elseif (in_array(date('m.d.y', strtotime("+ $x day")), $offdayssql)) {
    $x = $x + 1;
} else {
    //if it's a weekday, echo it.
  $extrapolateddate = date('l F d ', strtotime("+ $x day"));
  echo $extrapolateddate;
  $formattedextrapolateddate = date('m.d.y', strtotime("+ $x day"));

    if ($cyc == 1) {
      echo "- A Day ";
      $letter = "A";
      global $letter;
      $cyc = $cyc + 1;
      $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
      $result = mysql_query($dayquery);
      if(!$result) die ('database access failed: . ' . mysql_error());
    }
    elseif ($cyc == 2) {
      echo "- B Day ";
      $letter = "B";
      global $letter;
      $cyc = $cyc + 1;
      $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
      $result = mysql_query($dayquery);
      if(!$result) die ('database access failed: . ' . mysql_error());
    }
    elseif ($cyc == 3) {
      echo "- C Day ";
      $letter = "C";
      global $letter;
      $cyc = $cyc + 1;
      $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
      $result = mysql_query($dayquery);
      if(!$result) die ('database access failed: . ' . mysql_error());
    }
    elseif ($cyc == 4) {
      echo "- D Day, Short Classes ";
      $letter = "D";
      global $letter;
      $cyc = $cyc + 1;
      $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
      $result = mysql_query($dayquery);
      if(!$result) die ('database access failed: . ' . mysql_error());
    }
    elseif ($cyc == 5) {
      echo "- E Day ";
      $letter = "E";
      global $letter;
      $cyc = $cyc + 1;
      $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
      $result = mysql_query($dayquery);
      if(!$result) die ('database access failed: . ' . mysql_error());
      }
    $dayquery = "INSERT INTO days VALUES ('$formattedextrapolateddate','$letter') EXCEPT SELECT numdate, cycleday FROM days";
    $result = mysqli_query($dayquery);
    if(!$result) die ('database access failed: . ' . mysql_error(););
    elseif ($cyc == 6) {
      echo "- F Day ";
      $letter = "F";
      global $letter;
      $cyc = 1;
      $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
      $result = mysql_query($dayquery);
      if(!$result) die ('database access failed: . ' . mysql_error());
    }
      echo $b;
      $x = $x + 1;
    }
endwhile;

}

































?>
