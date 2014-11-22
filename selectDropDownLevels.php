<?php
include("connect.php");

$program = $_GET['programName'];

$sql = "SELECT distinct e.a_level
        FROM student_enrollment e, program p
        WHERE p.program_name = '$program'
        and p.program_no = e.program_no
        order by e.a_level";

$result = mysqli_query($db,$sql);
$rows = array();

while ( $r = mysqli_fetch_array($result))
{
	array_push($rows, $r);
}

header('Content-type: application/json');
echo json_encode($rows); 
?>