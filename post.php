<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
include 'cheatsheat.php';

if (!$db_server) die("Unable to connect at line 7" . mysql_error());

mysql_select_db($db_database)
  or die('unable to select database: ' . mysql_error());
mysql_select_db($db_database, $db_server) or die("unable to connect at line 7 " . mysql_error());
$newdayoff = $_POST['dayoff'];
$offdaytable = mysql_query('SELECT * FROM offdays');
$adddaysoff = "INSERT INTO offdays(numdate) VALUES ('$newdayoff') ON DUPLICATE KEY UPDATE numdate=numdate";
$dayoffresult = mysql_query($adddaysoff);
if(!$dayoffresult) die ('database access failed: . ' . mysql_error());
if(!$offdaytable) die ('database access failed: . ' . mysql_error());


$offdays = array('11.25.15','11.26.15','11.27.15');
$offdayssql = array();

while($row = mysql_fetch_array($offdaytable)){
    $offdayssql[] = $row['numdate'];
}

?>
