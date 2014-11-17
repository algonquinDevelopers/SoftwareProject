<?php
	include("connect.php");

	$name = $_GET['studentName'];
// 'Caterina Roberts'
	// $error = $name;
	$level = $_GET['level'];
	// add A to level
	
	//with sproject database
	//$result = mysqli_query($db,"SELECT courseNumber, courseName, grade , aLevel
	//						from studentStats WHERE studentName = '$name' AND aLevel = 'A$level' AND grade != '' ORDER BY aLevel ");

	//with softwareproject database (new)
	if ($level == null){
		$result = mysqli_query($db, "select e.course_no, c.course_name, e.grade, e.a_level
							from student_enrollment e, course c, student s
							where e.course_no = c.course_no
							and e.student_no = s.student_no
							and s.student_name = '$name'
							and e.grade != ''
							order by e.a_level");
	}
	else{
		$result = mysqli_query($db, "select e.course_no, c.course_name, e.grade, e.a_level
							from student_enrollment e, course c, student s
							where e.course_no = c.course_no
							and e.student_no = s.student_no
							and s.student_name = '$name'
							and e.a_level = '$level'
							and e.grade != ''
							order by e.a_level");
							//and e.a_level = '$level' //there is no a_level = A1, so exclude from the query for now
	}
	
	$rows = array();

	while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
	}

	header('Content-type: application/json');
	echo json_encode($rows); 
?>
