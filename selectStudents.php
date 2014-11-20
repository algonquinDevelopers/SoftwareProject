<?php

// Connect to the MySQL database
include("connect.php");

$limit = $_GET['limit'];



if( $_GET['name'] != null && $_GET['level'] != null ){
	$programName = $_GET['name'];
	$programLevel = $_GET['level'];
	
	$max_sql = mysqli_query($db,"select max(e.a_level) as max
								 from student_enrollment e, program p
								 where e.program_no = p.program_no
								 and p.program_name = '$programName'");
	$max= mysqli_fetch_assoc($max_sql);
	$maxLevel = $max['max'];
	$maxStrings = str_split($maxLevel);
	$maxInt = intval($maxStrings[1]);
	
	$level = str_split($programLevel);
	$levelInt = intval($level[1]);
	
	
	if ( $levelInt > $maxInt ){
		
		$sql = "select distinct s.student_name, s.student_no
				from student s
				inner join student_enrollment e on e.student_no = s.student_no
				inner join program p on p.program_no = e.program_no
				where p.program_name = '$programName'
				and e.a_level = '$maxLevel'
				limit $limit";
		
	}else{
	
		$sql = "select distinct s.student_name, s.student_no
				from student s
				inner join student_enrollment e on e.student_no = s.student_no
				inner join program p on p.program_no = e.program_no
				where p.program_name = '$programName'
				and e.a_level = '$programLevel'
				limit $limit";
	
	}
	
}elseif ( $_GET['name'] != null && $_GET['level'] == null ){	
	$programName = $_GET['name'];
	$sql = "select distinct s.student_name, s.student_no 
			from student s
			inner join program p on p.program_no = s.program_no
			where p.program_name = '$programName' 
			LIMIT $limit";
	
}else {
	$sql = "SELECT DISTINCT student_name, student_no from student LIMIT $limit";
	
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


