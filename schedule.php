<?php
date_default_timezone_set('America/Chicago');
require_once 'login.php';
$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
include 'cheatsheat.php';

if (!$db_server) die("Unable to connect at line 7" . $mysqli->error;);

mysqli_select_db($db_database)
  or die('unable to select database: ' . $mysqli->error;);
mysqli_select_db($db_database, $db_server) or die("unable to connect at line 7 " . $mysqli->error;);
$x = 1;
$cyc = 1;
echo $letter;

//theoretically add days to offdays array
echo "Add days off: <form action='post.php' method='post'><input type='text' name='dayoff' />  <input type='submit' /> </form> ";

$today = date('m.d.y');
//starting letter
$letter = "D";


$todayquery = "SELECT cycleday FROM days WHERE numdate = '$today'";

$todayresult = mysqli_query($todayquery);
if(!$todayresult) die ('database access failed: . ' . $mysqli->error;);
echo mysqli_result($todayresult, 0);

?>
