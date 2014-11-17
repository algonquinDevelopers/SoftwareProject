<?php
include("connect.php");

// 'Caterina Roberts'
	// $error = $name;
	// $level = $_GET['level'];
	// add A to level
	// $name = 'Anabelle Lynch';
	$name = $_GET['studentName'];

	$result = mysqli_query($db,"SELECT se.grade , se.a_level, c.course_no, c.course_name
								from student_enrollment se, student s, course c
								WHERE s.student_name = '$name' and se.grade != '\r\n' and se.grade is not null and se.student_no = s.student_no and se.course_no = c.course_no");

	$rows = array();

	while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
	}

	

	header('Content-type: application/json');
	echo json_encode($rows); 
?>
