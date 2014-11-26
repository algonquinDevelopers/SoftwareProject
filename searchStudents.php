<?php

// Connect to the MySQL database
include("connect.php");

$table = "student"; // rename if required



if (!empty($_GET['name'])){

    $query = "SELECT DISTINCT studentName, studentNumber from $table where pgmName = (?) LIMIT (?)";

    if ($stmt = $db->prepare($query))
    {
        $programName = $_GET['name'];
        $limit = $_GET['limit'];
        $stmt -> bind_param("si",$programName, $limit);
        $stmt->execute();
    }



} elseif(!empty($_GET['search'])) {

		$search = $_GET['search'];
		$search = stripslashes($search);
		$search = htmlspecialchars($search);
		$search = mysqli_real_escape_string($db, $search);

	if(is_string($search)) { // search by student name

        $query = "SELECT DISTINCT student_name, student_no from $table WHERE student_name LIKE CONCAT ('%', (?), '%') ORDER BY student_name ASC";

        if($stmt = $db->prepare($query))
        {
            $stmt->bind_param("s", $search);
            $stmt->execute();
        }
	}
	if(is_numeric($search)) { // search by student number

		$query = "SELECT DISTINCT student_name, student_no from $table WHERE student_no LIKE CONCAT ('%', (?), '%') ORDER BY student_name ASC";

        if ($stmt= $db->prepare($query))
        {
            $stmt->bind_param("s", $search );
            $stmt->execute();
        }
	}
} else {
	// this doesn't work. 
	//the course table won't load with this because course table updates based on what is was selected in the level dropdown

    // $query = "SELECT DISTINCT studentName, studentNumber from $table where aLevel = 'A1' LIMIT (?)";

    // if($stmt = $db->prepare($query)) {
// 
        // $stmt->bind_param("i", $limit);
        // $stmt->execute();
    // }
}

$result = $stmt->get_result();


$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

// close connection
header('Content-type: application/json');
echo json_encode($rows); 

?>