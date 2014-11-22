<?php
include("connect.php");




$sql = "SELECT distinct a_level from student_enrollment order by a_level";

$result = mysqli_query($db,$sql);
while ( $row = mysqli_fetch_array($result))
{
	echo "<li><a role=\"menuitem\" href=\"javascript:void(0)\" value=\"$row[0]\">$row[0]</a></li>";
}

?>