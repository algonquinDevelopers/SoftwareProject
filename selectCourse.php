<?php

// Connect to the MySQL database
include("connect.php");

$sql = "SELECT courseName, courseCode, courseLevel FROM course";

$result = mysqli_query($db,$sql);

$rows = array();
while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
    }

// CLOSE CONNECTION
	header('Content-type: application/json');
	echo json_encode($rows); 
?>
