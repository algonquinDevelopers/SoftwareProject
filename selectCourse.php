<?php

// Connect to the MySQL database
include("connect.php");

// if ( $_GET['name'] != null && $_GET['level'] != null ){
	
// 	$program = $_GET['name'];
// 	$courseLevel = $_GET['level'];
	
// 	$query = "SELECT distinct c.course_name, c.course_no, c.course_level
// 			from course c, program p, program_course a
// 			where c.course_no = a.course_no
// 			and p.program_no = a.program_no
// 			and p.program_name = (?)
// 			and c.course_level = (?)
// 			order by c.course_level desc";

// 	if ($stmt = $db->prepare($query)) {
// 	    $stmt -> bind_param("si", $programName, $courseLevel);
// 	    $stmt->execute();
// 	}

// 	$result = $stmt->get_result();

// 	$rows = array();
// 	while($r = $result->fetch_assoc()) {
// 	    array_push($rows, $r);
// 	}

// 	header('Content-type: application/json');
// 	echo json_encode($rows); 
// }

?>
