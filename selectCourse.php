<?php

// Connect to the MySQL database
include("connect.php");

// $program = $_GET['name'];
// $currentLevel = $_GET['currentLevel'];
// $nextLevel = $_GET['currentLevel'];

$program = $_GET['name'];
$nextLevel = $_GET['nextLevel'];
$currentLevel = $_GET['currentLevel'];


if ( $_GET['name'] != null && $_GET['nextLevel'] != null && $_GET['currentLevel']  ){

	$query = "SELECT distinct c.course_name, c.course_no, c.course_level
			from course c, program p, program_course a
			where c.course_no = a.course_no
			and p.program_no = a.program_no
			and p.program_name = ?
			and c.course_level in (? , ?)
			order by c.course_level desc";

	if ($stmt = $db->prepare($query)) {
	    $stmt -> bind_param("sii", $program, $currentLevel, $nextLevel);
	    $stmt->execute();
	}

	$result = $stmt->get_result();

	$rows = array();
	while($r = $result->fetch_assoc()) {
	    array_push($rows, $r);
	}

	header('Content-type: application/json');
	echo json_encode($rows); 

} else if( $_GET['name'] != null && $_GET['nextLevel'] != null ){

	$query = "SELECT distinct c.course_name, c.course_no, c.course_level
			from course c, program p, program_course a
			where c.course_no = a.course_no
			and p.program_no = a.program_no
			and p.program_name = ?
			and c.course_level = ?
			order by c.course_level desc";

	if ($stmt = $db->prepare($query)) {
	    $stmt -> bind_param("si", $program, $nextLevel);
	    $stmt->execute();
	}

	$result = $stmt->get_result();

	$rows = array();
	while($r = $result->fetch_assoc()) {
	    array_push($rows, $r);
	}

	header('Content-type: application/json');
	echo json_encode($rows);
}

?>
