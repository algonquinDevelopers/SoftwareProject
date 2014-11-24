<?php
include("connect.php");

$program = $_GET['programName'];

$query = "SELECT distinct e.a_level
        FROM student_enrollment e, program p
        WHERE p.program_name = ?
        and p.program_no = e.program_no
        order by e.a_level";

if ($stmt = $db->prepare($query)) {
	$stmt->bind_param("s", $program);
	$stmt->execute();
}

$result = $stmt->get_result();

$rows = array();
while($r = $result->fetch_assoc()) {
	array_push($rows, $r);
}

header('Content-type: application/json');
echo json_encode($rows); 
?>