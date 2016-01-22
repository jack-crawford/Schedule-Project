<?php
//Jack's cheat sheet of stuff he doesn't like typing

$b = "</br>";
$db_hostname = "localhost";
$db_username = "root";
$db_password = "root";
$db_table = "schedule";


function mylog($message) {
date_default_timezone_set('America/Chicago');
$logtime = date("Y-m-d H:i:s");
$file = fopen( 'logfile.txt', "a");
fwrite ($file, "$logtime: $message\n");
fclose($file);
}


//generic query formula
$result_of_query = mysqli_query($db_server, $querystring);
//mylog('ran the inactive day query');
if ($result_of_query->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    //And when pulling a row, use this part
    $row = mysqli_fetch_array($result_of_query, MYSQLI_ASSOC);
}

$resultrow = mysqli_fetch_array($result_of_query, MYSQLI_ASSOC);
$actual_result_future_jack_probably_wanted = $resultrow["result column we want"];





?>
