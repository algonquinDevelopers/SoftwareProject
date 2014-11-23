<?php
	include("connect.php");
	
	// TODO: remove the delete and use a query that does the same thing

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$courseCode = $_POST['course_no'];
		$studentNum = $_POST['student_no'];

		if(isset($_POST['student_no_to_delete'])){
			$studentNum = $_POST['student_no_to_delete'];
			$delete = "DELETE FROM plan where student_no = $studentNum";
			mysqli_query($db, $delete);
		}

		// doesn't work for some reason
		// $query = "insert into plan (course_no, student_no, plan_version) VALUES ('$courseCode', $studentNum, 0)"
					// ON DUPLICATE KEY UPDATE course_no='$courseCode', student_no='$studentNum', plan_version=1, term='2013F'";
		if(isset($courseCode) && isset($studentNum)){
			$insertQuery = "INSERT INTO plan (course_no, student_no, plan_version) 
							VALUES ('$courseCode', $studentNum, 1)";
			$results1 = mysqli_query($db, $insertQuery);
		}

	}
	

	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$studentNum = $_GET['student_no'];

		$sql = "SELECT p.student_no, p.course_no, p.plan_version, c.course_name 
				FROM plan p , course c 
				where p.student_no = $studentNum 
				and p.course_no = c.course_no";

		$results = mysqli_query($db, $sql);
		$rows = array();
		
		while($r = mysqli_fetch_array($results)) {
			array_push($rows, $r);
		}

		header('Content-type: application/json');
		echo json_encode($rows);
	}
	
?>

