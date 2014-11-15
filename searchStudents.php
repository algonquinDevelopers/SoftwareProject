<?php

// Connect to the MySQL database
include("connect.php");

$table = "studentstats"; // rename if required

$limit = $_GET['limit'];


if (!empty($_GET['name'])){
	$programName = $_GET['name'];
	//echo $programName;
	$sql = "SELECT DISTINCT studentName, studentNumber from " . $table . " where pgmName = '$programName' LIMIT $limit";
	//echo $sql;
} elseif(!empty($_GET['search'])) {
		$search = $_GET['search'];
		$search = stripslashes($search);
		$search = htmlspecialchars($search);
		$search = mysqli_real_escape_string($db, $search);

	if(is_string($search)) { // search by student name
		
		$sql = "SELECT DISTINCT studentName, studentNumber from " . $table . " WHERE studentName LIKE '%" . $search . "%' ORDER BY studentName ASC";
	}
	if(is_numeric($search)) { // search by student number
		$sql = "SELECT DISTINCT studentName, studentNumber from " . $table . " WHERE studentNumber LIKE '%" . $search . "%' ORDER BY studentName ASC";
	}
	
} else {
	$sql = "SELECT DISTINCT studentName, studentNumber from " . $table . " where aLevel = 'A1' LIMIT $limit";
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


