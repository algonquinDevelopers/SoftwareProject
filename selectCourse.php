<?php

// Connect to the MySQL database
include("connect.php");

if ( $_GET['name'] != null && $_GET['level'] != null && $_GET['currentLevel'] != null){
	
	$program = $_GET['name'];
	$level = $_GET['level'];
	$current = $_GET['currentLevel'];
	
	$sql = "select distinct c.course_name, c.course_no, c.course_level
			from course c, program p, program_course a
			where c.course_no = a.course_no
			and p.program_no = a.program_no
			and p.program_name = '$program'
			and c.course_level in ($current, $level)
			order by c.course_level desc";
	
}
else if ( $_GET['name'] != null && $_GET['level'] != null ){
	
	$program = $_GET['name'];
	$level = $_GET['level'];
	
	$sql = "select distinct c.course_name, c.course_no, c.course_level
			from course c, program p, program_course a
			where c.course_no = a.course_no
			and p.program_no = a.program_no
			and p.program_name = '$program'
			and c.course_level = $level
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
		$sql = "select distinct course_name, course_no, course_level from course order by course_level";

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
