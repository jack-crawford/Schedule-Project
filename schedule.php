<?php
date_default_timezone_set('America/Chicago');
include 'cheatsheat.php';
require_once 'login.php';
$db_server = new mysqli("localhost", "root", "root", "schedule");
if ($db_server->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$letter = "D";
$x = 1;
$cyc = 1;
$today = date('Y-m-d');

//theoretically add days to offdays array
echo "Add days off: <form action='post.php' method='post'><input type='text' name='dayoff' /><input type='submit' /> </form> ";

$todayquery = "SELECT cycleday FROM days WHERE daate = '$today'";
mylog($todayquery);
$todayresult = mysqli_query($db_server, $todayquery);
if ($todayresult->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$row = mysqli_fetch_array($todayresult, MYSQLI_ASSOC);
mylog("fetched today's date");
mysqli_free_result($todayresult);
printf($row['cycleday']);
<<<<<<< Updated upstream
=======

function regenschedule(){
    $x = 0;
    $cyc = 2;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');

    while ($x <= 364):
        mylog('while started');
        $date = date('Y-m-d', strtotime("+ $x day"));
        mylog($date);
        //$offdayz = checkforinactiveday($date);
        //mylog($offdayz);
        //if it's a weekend, skip
        if (date('D' , strtotime("+ $x day")) === "Sun" || date('D' , strtotime("+ $x day")) === "Sat" /*|| $offdayz = 'true'*/){
            $x = $x + 1;
            mylog('weekend or offday removed');
        } else {
            mylog('entered reinsert phase');
            $letter = $cyc_array[$cyc];
            mylog('should be starting with ' . $letter);
            $cyc = ($cyc==5) ? 0 : $cyc + 1;
            mylog("letter is $letter, cyc is $cyc");
            $dayquery = "INSERT INTO days(cycleday, daate, active, daymodified) VALUES ('$letter','$date', 'y', '$today');";
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
            echo "</br>";
            $x = $x + 1;
        }
    endwhile; 
}

>>>>>>> Stashed changes

mysqli_close($db_server);

?>
