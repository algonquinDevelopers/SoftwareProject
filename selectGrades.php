<?php
	include("connect.php");

	$name = $_GET['studentName'];
// 'Caterina Roberts'
	// $error = $name;
	$level = $_GET['level'];
	// add A to level

	$result = mysqli_query($db,"SELECT courseNumber , courseName, grade , aLevel
							from studentStats WHERE studentName = '$name' AND aLevel = 'A$level' AND grade != '' ");

	$rows = array();

	while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
	}

	header('Content-type: application/json');
	echo json_encode($rows); 
?>
