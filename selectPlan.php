<?php

include("connect.php");

$sql = "SELECT DISTINCT s.student_name, s.student_no, se.course_no, c.course_name
        from student s, student_enrollment se, course c
        where se.student_no = s.student_no
        and se.course_no = c.course_no
        LIMIT 1000";



$result = mysqli_query($db, $sql);


$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

// close connection
header('Content-type: application/json');
echo json_encode($rows); 
?>

