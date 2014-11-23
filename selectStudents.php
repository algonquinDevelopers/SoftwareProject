<?php

// Connect to the MySQL database
include("connect.php");

//Prepared Statements
if( !empty($_GET['name']) && !empty($_GET['level']) && !empty($_GET['limit']) ){
  
	$programName = $_GET['name'];
	$programLevel = $_GET['level'];
	$limit = $_GET['limit'];

    //Prepared Statement for security and easier "understandability"
	$query = "SELECT distinct s.student_name, s.student_no, e.a_level from student s
			inner join student_enrollment e on e.student_no = s.student_no inner join
			program p on p.program_no = e.program_no where p.program_name = (?)
			and e.a_level = (?)
			LIMIT (?)";

	if ($stmt = $db->prepare($query)) {
		//Binds variables to prepd statement
        //"si" means first param is a string, second is an int."
	    $stmt->bind_param("sii", $programName, $programLevel, $limit);
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


