<?php
include("connect.php");
/**
$program = $_GET['name'];

if (!empty($_GET['name'])){
	$sql = "select distinct e.a_level 
			from student_enrollment e, program p
			where e.program_no = p.program_no
			and p.program_name = '$program'
			order by e.a_level";
} else {
	$sql = "SELECT distinct a_level from student_enrollment order by a_level";
}
**/

$sql = "SELECT distinct a_level from student_enrollment order by a_level";

$result = mysqli_query($db,$sql);
while ( $row = mysqli_fetch_array($result))
{
	echo "<li><a role=\"menuitem\" href=\"javascript:void(0)\" value=\"$row[0]\">$row[0]</a></li>";
}

?>