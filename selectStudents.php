<?php

// Connect to the MySQL database
include("connect.php");

$limit = $_GET['limit'];
$sql = "";



$result = mysqli_query($db, "SELECT DISTINCT studentName, studentNumber from studentStats where aLevel = 'A1' LIMIT $limit");

// if (!empty($_GET['name'])){
// 	$programName = $_GET['name'];
// 	//echo $programName;
// 	$sql = "SELECT DISTINCT studentName from studentStats where pgmName = '$programName' LIMIT $limit";
// 	//echo $sql;
// } else {
// 	$sql = "SELECT DISTINCT studentName from studentStats LIMIT $limit";
// }

// $result = mysqli_query($db, $sql);


$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

// close connection
header('Content-type: application/json');
echo json_encode($rows); 

?>


