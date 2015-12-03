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
mylog("removed $newdayoff");
//When days are added to offdays they are deleted from days
$deletedaysofffromdays = "DELETE FROM days WHERE daate = '$newdayoff'";
$deletedaysofffromdaysresult = mysqli_query($db_server, $deletedaysofffromdays);
if ($deletedaysofffromdaysresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
mylog("$deletedaysofffromdays");
$offdays = array('11.25.15','11.26.15','11.27.15');
$offdayssql = array();

while($row = mysqli_fetch_array($offdaytable)){
    $offdayssql[] = $row['numdate'];

}
echo "thank you, $newdayoff has been removed from the schedule"

?>
