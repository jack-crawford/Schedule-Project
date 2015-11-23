<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
include 'cheatsheat.php';

if (!$db_server) die("Unable to connect at line 7" . mysql_error());

mysql_select_db($db_database)
  or die('unable to select database: ' . mysql_error());
mysql_select_db($db_database, $db_server) or die("unable to connect at line 7 " . mysql_error());
$x = 1;
$cyc = 1;
echo $letter;

//theoretically add days to offdays array
echo "Add days off: <form action='post.php' method='post'><input type='text' name='dayoff' />  <input type='submit' /> </form> ";

$today = date('m.d.y');
//starting letter
$letter = "D";
//extrapolate to 30 days
while ($x === 365):
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
      }
      elseif ($cyc == 2) {
        echo "- B Day ";
        $letter = "B";
        global $letter;
        $cyc = $cyc + 1;
      }
      elseif ($cyc == 3) {
        echo "- C Day ";
        $letter = "C";
        global $letter;
        $cyc = $cyc + 1;
      }
      elseif ($cyc == 4) {
        echo "- D Day, Short Classes ";
        $letter = "D";
        global $letter;
        $cyc = $cyc + 1;
      }
      elseif ($cyc == 5) {
        echo "- E Day ";
        $letter = "E";
        global $letter;
        $cyc = $cyc + 1;
      }
      elseif ($cyc == 6) {
        echo "- F Day ";
        $letter = "F";
        global $letter;
        $cyc = 1;
      }
      $dayquery = "INSERT INTO days VALUES ('$formattedextrapolateddate','$letter') EXCEPT SELECT * FROM days";
      $result = mysql_query($dayquery);
      if(!$result) die ('database access failed: . ' . mysql_error());
echo $b;
$x = $x + 1;

}
endwhile;
$todayquery = "SELECT cycleday FROM days WHERE numdate = '$today'";

$todayresult = mysql_query($todayquery);
if(!$todayresult) die ('database access failed: . ' . mysql_error());
echo mysql_result($todayresult, 0);

?>
