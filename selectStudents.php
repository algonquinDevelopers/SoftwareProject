<?php

// Connect to the MySQL database
include("connect.php");

//Prepared Statements

$limit = $_GET['limit'];

if( (!empty($_GET['name']) && $_GET['name'] != null) && (!empty($_GET['level']) && $_GET['level'] != null) ){

    //Prepared Statement for security and easier "understandability"
    if ($sql = $db->prepare("select distinct s.student_name, s.student_no, e.a_level from student s
			inner join student_enrollment e on e.student_no = s.student_no inner join
			program p on p.program_no = e.program_no where p.program_name = (?)
			and e.a_level = (?)"))
    {
        //echo "In First Prepare";

        //Binds variables to prepd statement
        //"si" means first param is a string, second is an int."
        $sql->bind_param("si", $programName, $programLevel);
    }





}elseif ( (!empty($_GET['name']) && $_GET['name'] != null) && (empty($_GET['level']) || $_GET['level'] == null) ){





}

	$programName = $_GET['name'];
	

	$query = "SELECT distinct s.student_name, s.student_no, e.a_level from student s
			inner join student_enrollment e on e.student_no = s.student_no inner join
			program p on p.program_no = e.program_no where p.program_name = (?)
			and e.a_level = (?)";
	// $stmt = $db->stmt_init();
	if ($stmt = $db->prepare($query))
	{
	    $programName = $_GET['name'];
	    $programLevel = $_GET['level'];
	    $stmt -> bind_param("si", $programName, $programLevel);
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
?>


