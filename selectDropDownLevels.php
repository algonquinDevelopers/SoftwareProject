<?php
include("connect.php");

$program = $_GET['programName'];

$sql = "SELECT distinct a_level from student_enrollment WHERE program_no = '$program' order by a_level";

$result = mysqli_query($db,$sql);
$rows = array();

while ( $row = mysqli_fetch_array($result))
{
	array_push($rows, $r)
}

header('Content-type: application/json');
echo json_encode($rows); 
?>