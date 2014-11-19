<?php
// && isset($_GET['searchRadio']
if( isset($_GET['searchInput']) ) // hit return or click the search button to activate
{
	// Connect to the MySQL database
	include("connect.php");
	
	$table = 'student';
	$searchInput = $_GET['searchInput'];
	$searchInput = stripslashes($searchInput);
	$searchInput = htmlspecialchars($searchInput);
	$searchInput = mysqli_real_escape_string($db, $searchInput);
	
	$sql = "SELECT studentName, studentNumber FROM " . $table . " WHERE student_name LIKE '%" . $searchInput . "%'";
}
	// if($_GET['searchRadio'] == "name") // check if the student name radio button was selected
	// {
	// 	$sql = "SELECT student_no, student_first_name, student_last_name FROM " . $table . " WHERE student_name LIKE '%" . $searchInput . "%'";
	// } 
	// elseif($_GET['searchRadio'] == "number" && !empty($searchInput)) // check the student number instead
	// {
	// 	$searchInput = (int) $searchInput;
	// 	$sql = "SELECT student_no, student_first_name, student_last_name FROM " . $table . " WHERE student_no = " . $searchInput;
	// } 
	// else // if the input is empty, show all students
	// {
	// 	$sql = "SELECT student_no, student_first_name, student_last_name FROM " . $table . " WHERE student_name LIKE '%" . $searchInput . "%'";
	// }

	$result = mysqli_query($db, $sql);

	$rows = array();
	while($r = mysqli_fetch_array($result)) {
		    array_push($rows, $r);
	}

	header('Content-type: application/json');
	echo json_encode($rows); 
?>