<?php

// Connect to the MySQL database
include("connect.php");

$limit = $_GET['limit'];
$sql = "";

if (!empty($_POST['name'])){
	$programName = $_POST['name'];
	$sql = "SELECT DISTINCT studentName from studentStats where pgmName like \"$programName\" LIMIT $limit";
} else {
	$sql = "SELECT DISTINCT studentName from studentStats LIMIT $limit";
}

$result = mysqli_query($db, $sql);

$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

// close connection
header('Content-type: application/json');
echo json_encode($rows); 

?>


