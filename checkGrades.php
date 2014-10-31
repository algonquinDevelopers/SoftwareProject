<?php

// Connect to the MySQL database
include("connect.php");


$result = mysqli_query($db, "SELECT grade, courseNumber from studentStats WHERE studentName = 'Jerrell Monahan'");



$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

// checkAndSelect($rows);

// echo $rows;
?>
