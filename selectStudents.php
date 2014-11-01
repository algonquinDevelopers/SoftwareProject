<?php

// Connect to the MySQL database
include("connect.php");

$limit = $_GET['limit'];


$result = mysqli_query($db, "SELECT DISTINCT studentName, studentNumber from studentStats where aLevel = 'A1' LIMIT $limit");

$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

header('Content-type: application/json');
echo json_encode($rows); 

?>


