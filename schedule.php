<?php
date_default_timezone_set('America/Chicago');
include 'cheatsheat.php';
require_once 'login.php';
$db_server = new mysqli("localhost", "root", "root", "schedule");
if ($db_server->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

echo "<link rel='stylesheet' type='text/css' href='style.css'>
    <title> HH Admin Page </title>
    <div id = 'header'> <a href='schoollogo.jpeg'> </a>hhcyclr  </div>  ";






$letter = "D";
$x = 1;
$cyc = 1;
$today = date('Y-m-d');

//turns days off
echo "Add day off: <form action='post.php' method='post'><input type='text' name='dayoff' /><input type='submit' /> </form> ";
echo "Change a date to a short class day: <form action='post.php' method='post'><input type='text' name='special' /><input type='submit' /> </form> ";


function regenschedule(){
    $x = 0;
    $cyc = 2;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');

    while ($x <= 364):
        mylog('while started');
        $date = date('Y-m-d', strtotime("+ $x day"));
        mylog($date);
        
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

function updateschedule($cycofnewlyinactivedate, $newlyinactivedate){
    
    $x = 0;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
    $cyc = array_search($cycofnewlyinactivedate, $cycarray);

    while ($x <= 364):
        mylog('while started');
        $date = date('Y-m-d', strtotime("+ $x day", strtotime($newlyinactivedate)));
        mylog($date);
        
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

//reminder: keep dates in YYYY-MM-DD format




mysqli_close($db_server);

?>
