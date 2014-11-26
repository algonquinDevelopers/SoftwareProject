<?php

// Connect to the MySQL database
include("connect.php");

//Prepared Statements

if( (!empty($_GET['name']) && $_GET['name'] != null) && (!empty($_GET['level']) && $_GET['level'] != null) ){

	$query = "SELECT distinct s.student_name, s.student_no, e.a_level from student s
			inner join student_enrollment e on e.student_no = s.student_no inner join
			program p on p.program_no = e.program_no where p.program_name = ?
			and e.a_level = ?
			LIMIT ?";

	if ($stmt = $db->prepare($query))
	{
	    $programName = $_GET['name'];
	    $programLevel = $_GET['level'];
	    $limit = $_GET['limit'];
	    $stmt -> bind_param("ssi", $programName, $programLevel, $limit);
	    $stmt->execute();
	}

	$result = $stmt->get_result();

	$rows = array();
	while($r = $result->fetch_assoc()) {
	    array_push($rows, $r);
	}

	// close connection
	header('Content-type: application/json');
	echo json_encode($rows); 
}
?>


