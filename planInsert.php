<?php

// Connect to the MySQL database
include("connect.php");

$studentNum = $_GET['studentNum'];
$courseCode = $_GET['courseCode'];

//Queries 
$queryResult = mysqli_query($db, "SELECT COUNT(DISTINCT plan_version) as num from plan where plan_version is not null and student_no = $studentNum");

$testResult = $queryResult->fetch_array(MYSQLI_NUM);
$planVersion = $testResult[0];

// echo $planVersion

$insertQuery = "INSERT INTO `plan`(`course_no`, `student_no`) VALUES ('$courseCode', $studentNum)";
$updateQuery = "UPDATE plan SET student_no=$studentNum, course_no=$courseCode WHERE student_no=$studentNum;";

if (mysqli_fetch_row($result) !== false)
{
    $updateSQL = mysqli_query($db, $updateQuery);
}
else
{
    $insertSQL = mysqli_query($db, $insertQuery);

}

$sql = "SELECT student_no, plan_version FROM plan where student_no = $studentNum;";

$result = mysqli_query($db,$sql);




$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

// CLOSE CONNECTION
header('Content-type: application/json');
echo json_encode($rows);
?>

