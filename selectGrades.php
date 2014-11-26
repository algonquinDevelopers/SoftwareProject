<?php
include("connect.php");


	// $error = $name;
// $name = $_GET['studentName'];
$query = "select e.course_no, c.course_name, e.grade, e.a_level
							from student_enrollment e, course c, student s
							where e.course_no = c.course_no
							and e.student_no = s.student_no
							and s.student_no = (?)
							and e.grade != ''
							order by e.a_level";
                            //Include level when ready


if ($stmt = $db->prepare($query)) {

    $studentNum = $_GET['student_no'];
    $level = $_GET['level'];

    $stmt -> bind_param("s", $studentNum);
    $stmt->execute();

}

$result = $stmt->get_result();

$rows = array();


while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

header('Content-type: application/json');
echo json_encode($rows);
?>
