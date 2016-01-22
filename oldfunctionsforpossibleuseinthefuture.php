<?php


function updaterestoftable($newlyinactivedate, $cycofnewlyinactivedate, $startingvalue, $thisdayisnowactiveornot) {
    $today = date('Y-m-d');
    mylog("ENTERED UPDATE CYCLE!!!!!! with $newlyinactivedate, $cycofnewlyinactivedate, $startingvalue");
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    if ($thisdayisnowactiveornot === 'y') {
        //pull cyc val of previous day on 
        
    }
    $x = $startingvalue;
    $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
    $cyc = array_search($cycofnewlyinactivedate, $cyc_array);
    echo ("the letter day now used on the next day is: $letter");
    while ($x <= 200):
    
    
        $dategivenbyadmin = strtotime($newlyinactivedate);
        $formatteddateforcondish = date('Y-m-d', $dategivenbyadmin);
        mylog("$dategivenbyadmin is the DATE GIVEN BY ADMIN");
        $datesaftergiven = date('Y-m-d', strtotime("+ $x days", "$dategivenbyadmin"));
        mylog("$datesaftergiven p2");
        
        $activeday = checkforinactiveday($datesaftergiven);
        
        
        //if it's a weekend, skip
        if (isNOTactiveweekday($datesaftergiven, $formatteddateforcondish, $activeday)){
            mylog("$datesaftergiven IS NOT ACTIVE WEEKDAY");
            $x = $x + 1;
        } else {
            $letter = $cyc_array[$cyc];
            //mylog("should be starting with $letter");
            $cyc = ($cyc==5) ? 0 : $cyc + 1;
            //mylog("letter is $letter, date is: $newlyinactivedatep2");
            $dayquery = "UPDATE days SET cycleday = '$letter', daymodified = '$today' WHERE daate = '$datesaftergiven';";
            mylog("update query looks like $dayquery");
            $dayqueryresult = mysqli_query($db_server, $dayquery);
            mylog('ran the inactive day query');
            if ($dayqueryresult->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            mylog("THE QUERY ON LINE 81 BROUGHT: $letter");
            echo "  ";
            echo $letter;
            echo "  ";
            echo $newlyinactivedatep2;
            echo "</br>";
            $x = $x + 1;
        }
        
    endwhile;
}


function alterdays($date){
    if (empty($date)) {
        mylog("No dates were removed today");
    }
    else {
        $db_server = mysqli_connect("localhost", "root", "root", "schedule");
        if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
        }
        $today = date('Y-m-d');
        mylog('started to insert days');
        $activeday = checkforinactiveday($date);
        mylog("$date, according to line ONE HUNDRED AND NINE, is $activeday");
        //if day input is a weekend, ignore;
        
        if ($activeday === "n") {
        //if day entered by admin is active
            mylog("stayed in if");
            $givendatep1 = strtotime($date);
            $givendatep2 = date('Y-m-d', strtotime("+ 1 day", "$givendatep1"));
            echo "$givendatep2";
            echo "</br>";
            $nextdayletterquery = "SELECT cycleday FROM days WHERE daate = '$givendatep2';";
            echo "$nextdayletterquery </br>";
            $nextdayletterqueryresult = mysqli_query($db_server, $nextdayletterquery);
            if ($nextdayletterquery->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            $row = mysqli_fetch_array($nextdayletterqueryresult, MYSQLI_ASSOC);
            $nextdaylettervalue = $row['cycleday'];
            echo "$nextdaylettervalue IS THE CYCLEDAY OF $givendatep2 WHICH SHOULD BE USED ON $givendatep1 </br>";
            
            //update row of day about to be "removed" to be inactive
            $makedayactive = "UPDATE days SET active = 'y', daymodified = '$today' WHERE daate = '$date';";
            mylog($makedayactive);
            $makedayactiveresult = mysqli_query($db_server, $makedayactive);
            if ($makedayactiveresult->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            } 
            mylog("THESE ARE FED TO THE UPDATE CYCLE IF THE DAY IS ACTIVE: $date, $cycledayofnextday");
            updaterestoftable($date, $cycledayofnextday, 0, 'y');
            echo "thank you, $date has been returned to the schedule";
        }
        else {
            mylog("went to else");
            //select cycleday value of day that will be marked inactive
            $grabletterofinactiveday = "SELECT cycleday FROM days WHERE daate = '$date';";
            mylog($grabletterofinactiveday);
            if ($grabletterofinactivedayresult = mysqli_query($db_server, $grabletterofinactiveday)) {
                $row = mysqli_fetch_assoc($grabletterofinactivedayresult);
                mylog("row is " . print_r($row, true));
                $cycledayofinactiveday = $row['cycleday'];
                mylog("this is the cycle day of the posted date: $cycledayofinactiveday");
                mysqli_free_result($grabletterofinactivedayresult);
            } else {
                mylog('query failed');
            }
            echo "THIS IS THE CYCLE DAY THAT SHOULD BE FED TO THE NEXT DAY $cycledayofinactiveday";
            //update row of day about to be "removed" to be inactive
            $makedayactive = "UPDATE days SET active = 'n', daymodified = '$today' WHERE daate = '$date';";
            mylog($makedayactive);
            $makedayactiveresult = mysqli_query($db_server, $makedayactive);
            if ($makedayactiveresult->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            mylog("THESE ARE FED TO THE UPDATE CYCLE IF THE DAY IS INACTIVE:$date, $cycledayofinactiveday");
            updaterestoftable($date, $cycledayofinactiveday, 1, 'n');
            echo "thank you, $date has been removed from the schedule";
        }
    }
}
function updatecycleV2($startdate) {
    $today = date('Y-m-d');
    mylog("ENTERED UPDATE CYCLE!!!!!! with $startdate");
    $db_server = mysqli_connect("localhost", "root", "root", "schedule");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    $x = $startingvalue;
    $j = 1;
    
    
    
    if (checkforinactiveday($startdate) === 'y') {
        //the day fed to the function is active, so we want the cycle value to be translated to the next ACTIVE SCHOOLDAY
        $currentday = "SELECT cycleday FROM days WHERE daate = '$startdate';";
        $currentdayresult = mysqli_query($db_server, $currentday);
        if ($currentday->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        //mylog("THE NORMAL MOD QUERY SHOULD BE: $currentday");
        $row = mysqli_fetch_array($currentdayresult, MYSQLI_ASSOC);
        mysqli_free_result($currentdayresult);
        $currentdaycycle = $row['cycleday'];
        mylog("$startdate WAS A VALID DAY AND IT IS $currentdaycycle");
        $makedayactive = "UPDATE days SET active = 'n', daymodified = '$today' WHERE daate = '$startdate';";
        mylog($makedayactive);
        $makedayactiveresult = mysqli_query($db_server, $makedayactive);
        if ($makedayactiveresult->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        
    }
    elseif (checkforinactiveday($startdate === 'n')) {
        while($j <= 3):
            $nextday = date('Y-m-d', strtotime("+ $j day", "$startdate"));
            //checking if the next day is a day that should also be skipped, or if it's the day we want to take the cycle value from
            if (checkforinactiveday($nextday) === 'y') {
                $nextcycday = "SELECT cycleday FROM days WHERE daate = '$nextday';";
                $nextcycdayresult = mysqli_query($db_server, $nextcycday);
                if ($nextcycday->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                }
                $row = mysqli_fetch_array($nextcycdayresult, MYSQLI_ASSOC);
                mysqli_free_result($nextcycdayresult);
                //if the next day is active, use its cyc
                $currentdaycycle = $row['cycleday'];
                mylog("$nextday IS A VALID DAY WITH $currentdaycycle");
                $makedayactive = "UPDATE days SET active = 'y', daymodified = '$today' WHERE daate = '$nextday';";
                mylog($makedayactive);
                $makedayactiveresult = mysqli_query($db_server, $makedayactive);
                if ($makedayactiveresult->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                } 
            }
            elseif (date('D' , strtotime("$nextday")) === "Sun" || date('D' , strtotime("$nextday")) === "Sat"){
                mylog(" $nextday IS EITHER A SATURDAY OR A SUNDAY");
                $j = $j + 1;
            }
            else {
                $j = $j + 1;    
            }
        endwhile;     
    }
    //now we SHOULD have a correct cycle value to work with
    echo ("$currentdaycycle </br>");
    $x = 1;
    while ($x <= 10):
        $cyc_array = array('A', 'B', 'C', 'D', 'E', 'F');
        $cyc = array_search($currentdaycycle, $cyc_array);
        $letter = $cyc_array[$cyc];
        echo ("the letter day now used on the next day is: $letter </br>");
        $dategivenbyadmin = strtotime($startdate);
        $formatteddateforcondish = date('Y-m-d', $dategivenbyadmin);
        mylog("ON LINE 314 THE DATE FORMATTED FOR THE ACTIVE CHECK SHOULD BE $formatteddateforcondish");
        mylog("$dategivenbyadmin is the DATE GIVEN BY ADMIN");
        $datesaftergiven = date('Y-m-d', strtotime("+ $x days", "$dategivenbyadmin"));
        mylog("ON LINE 316 $datesaftergiven is $x days after $dategivenbyadmin");
        
        $activeday = checkforinactiveday($datesaftergiven);
        mylog("ON 321 $datesaftergiven is $activeday");
        
        //if it's a weekend, skip
        if ($activeday === 'n'){
            mylog("$activeday IS A NO FOR $datesaftergiven");
            $x = $x + 1;
            mylog("added 1 to $/x, is now $x");
        } else {
            $letter = $cyc_array[$cyc];
            //mylog("should be starting with $letter");
            $cyc = ($cyc==5) ? 0 : $cyc + 1;
            //mylog("letter is $letter, date is: $newlyinactivedatep2");
            $dayquery = "UPDATE days SET cycleday = '$letter', daymodified = '$today' WHERE daate = '$datesaftergiven';";
            //mylog("update query looks like $dayquery");
            $dayqueryresult = mysqli_query($db_server, $dayquery);
            //mylog('ran the inactive day query');
            if ($dayqueryresult->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            mylog("THE QUERY ON LINE 337 BROUGHT: $letter");
            echo "  ";
            echo $letter;
            echo "  ";
            //echo $newlyinactivedatep2;
            echo "</br>";
            $x = $x + 1;
        }
        $x = $x + 1;
    endwhile;
}



function isNOTactiveweekday($datesaftergiven, $formatteddateforcondish, $activeday) {
            if (date('D' , strtotime("+ $x days", "$datesaftergiven")) === "Sun" || date('D' , strtotime("+ $x days", "$datesaftergiven")) === "Sat"){
                mylog("IN isNOTactiveweekday, $datesaftergiven IS EITHER A SATURDAY OR A SUNDAY");
                return true; 
            }
                if ($activeday === 'n') {
                    mylog("isNOTactiveweekday went to checking if $activeday is a no!");
                    if ($datesaftergiven != $formatteddateforcondish) {
                        mylog("isNOTactiveweekday went to checking if $datesaftergiven is not $formatteddateforcondish");
                        return true;
                    }
                }   
            else {
                return false;
            }
        }


?>