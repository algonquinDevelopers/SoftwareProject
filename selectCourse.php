<?php

// Connect to the MySQL database
include("connect.php");


//$sql = "SELECT courseName, courseCode, courseLevel FROM course WHERE courseLevel = 2";//for fat table
//$sql = "select course_name, course_no, course_level from course where course_level = 02";//for new database


if ( $_GET['name'] != null && $_GET['level'] != null ){
	
	$program = $_GET['name'];
	$level = $_GET['level'];
	$courseLevel = null;
	$next = null;
	
	switch ($level){
		case "A1": 
			$courseLevel = '01';
			$next = '02';
			break;
		case "A2":
			$courseLevel = '02';
			$next = '03';
			break;
		case "A3":
			$courseLevel = '03';
			$next = '04';
			break;
		case "A4":
			$courseLevel = '04';
			$next = '05';
			break;
		case "A5":
			$courseLevel = '05';
			$next = '06';
			break;
		case "A6":
			$courseLevel = '06';
			$next = '07';
			break;
		default:
			break;
	}
	
	$sql = "select distinct c.course_name, c.course_no, c.course_level
			from course c, program p, program_course a
			where c.course_no = a.course_no
			and p.program_no = a.program_no
			and p.program_name = '$program'
			and c.course_level in ($courseLevel, $next)
			order by c.course_level desc";
}
else if ( $_GET['name'] != null && $_GET['level'] == null ){
	$program = $_GET['name'];
	$sql = "select distinct c.course_name, c.course_no, c.course_level
			from course c, program p, program_course a
			where c.course_no = a.course_no
			and p.program_no = a.program_no
			and p.program_name = '$program'
			order by c.course_level desc";
}
else{
	$sql = "select distinct course_name, course_no, course_level from course order by course_level desc";
}


$result = mysqli_query($db,$sql);

$rows = array();
while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
    }

// CLOSE CONNECTION
	header('Content-type: application/json');
	echo json_encode($rows); 
?>
