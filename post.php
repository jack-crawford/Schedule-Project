<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
include 'cheatsheat.php';

if (!$db_server) die("Unable to connect at line 7" . $mysqli->error;);

mysqli_select_db($db_database)
  or die('unable to select database: ' . $mysqli->error;);
mysqli_select_db($db_database, $db_server) or die("unable to connect at line 7 " . $mysqli->error;);

$newdayoff = $_POST['dayoff'];

//when a day is added it's posted to offdays
$adddayoff = "INSERT INTO offdays(numdate) VALUES ('$newdayoff') EXCEPT SELECT numdate FROM offdays";
$dayoffresult = mysqli_query($adddayoff);
if(!$dayoffresult) die ('database access failed: . ' . $mysqli->error;);

//When days are added to offdays they are deleted from days
$deletedaysofffromdays = "DELETE FROM days WHERE numdate = '$newdayoff'";
$deletedaysofffromdaysresult = mysqli_query($deletedaysofffromdays);
if(!$deletedaysofffromdaysresult) die ('database access failed: . ' . $mysqli->error;);

$offdays = array('11.25.15','11.26.15','11.27.15');
$offdayssql = array();

while($row = mysqli_fetch_array($offdaytable)){
    $offdayssql[] = $row['numdate'];

}

//updatedays() writes an $x's worth of values to days
<<<<<<< HEAD
function updatedays($x){
  $offdaytable = mysqli_query('SELECT * FROM offdays');
  if(!$offdaytable) die ('database access failed: . ' . $mysqli->error;);
  while ($x === 365):
  //if it's a weekend, skip
    if (date('D' , strtotime("+ $x day")) === "Sun" or date('D' , strtotime("+ $x day")) === "Sat"){
=======

$offdaytable = mysql_query('SELECT * FROM offdays');
if(!$offdaytable) die ('database access failed: . ' . mysql_error());
    //if it's a weekend, skip
  if (date('D' , strtotime("+ $x day")) === "Sun" or date('D' , strtotime("+ $x day")) === "Sat"){
>>>>>>> origin/master
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
<<<<<<< HEAD
      $dayquery = "INSERT INTO days VALUES ('$formattedextrapolateddate','$letter') EXCEPT SELECT numdate, cycleday FROM days";
      $result = mysqli_query($dayquery);
      if(!$result) die ('database access failed: . ' . $mysqli->error;);
=======
      elseif ($cyc == 6) {
        echo "- F Day ";
        $letter = "F";
        global $letter;
        $cyc = 1;
        $dayquery = "UPDATE days(cycleday) VALUES ('$letter')";
        $result = mysql_query($dayquery);
        if(!$result) die ('database access failed: . ' . mysql_error());
      }

>>>>>>> origin/master
        echo $b;
        $x = $x + 1;
      }
endwhile;




?>
