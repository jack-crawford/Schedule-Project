<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
include 'cheatsheat.php';

if (!$db_server) die("Unable to connect at line 7" . $mysqli->error);

mysqli_select_db($db_database)
  or die('unable to select database: ' . $mysqli->error);
mysqli_select_db($db_database, $db_server) or die("unable to connect at line 7 " . $mysqli->error);

$newdayoff = $_POST['dayoff'];

//when a day is added it's posted to offdays
$adddayoff = "INSERT INTO offdays(numdate) VALUES ('$newdayoff') EXCEPT SELECT numdate FROM offdays";
$dayoffresult = mysqli_query($adddayoff);
if(!$dayoffresult) die ('database access failed: . ' . $mysqli->error);

//When days are added to offdays they are deleted from days
$deletedaysofffromdays = "DELETE FROM days WHERE numdate = '$newdayoff'";
$deletedaysofffromdaysresult = mysqli_query($deletedaysofffromdays);
if(!$deletedaysofffromdaysresult) die ('database access failed: . ' . $mysqli->error);

$offdays = array('11.25.15','11.26.15','11.27.15');
$offdayssql = array();

while($row = mysqli_fetch_array($offdaytable)){
    $offdayssql[] = $row['numdate'];

}


?>
