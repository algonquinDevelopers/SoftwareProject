<?php
// TEST for auto grade select with php and sql
// Connect to the MySQL database
include("connect.php");

$name = $_GET['name'];

$result = mysqli_query($db, "SELECT grade, courseNumber from studentStats WHERE studentName = 'qfnwl0, pqtuq' AND grade NOT IN ('F', 'W')");

$rows = array();
while($r = mysqli_fetch_array($result)) {
	// if(check_grades($r)){
	// }
	array_push($rows, $r);
	echo $r ['grade'];
}


// CLOSE CONNECTION
	header('Content-type: application/json');
	echo json_encode($rows); 

function check_grades($r){
	$fail_case = array("A", "A-");
	for ($i=0; $i < count($fail_case); $i++) { 
	    if($fail_case[$i] == $r ['grade']){
           return false;
        }
    	return true;
	}
}

?>
