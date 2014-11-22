<?php
// TEST for auto grade select with php and sql
// Connect to the MySQL database
include("connect.php");

$name = $_GET['name'];

$result = mysqli_query($db, "SELECT grade, courseNumber from studentStats WHERE studentName = 'qfnwl0, pqtuq' AND grade NOT IN ('F', 'W')");


$rows = array();
while($r = mysqli_fetch_array($result)) {
	// if(check_grades($r)){
	// }
	array_push($rows, $r);
	echo $r ['grade'];
}


// CLOSE CONNECTION
	header('Content-type: application/json');
	echo json_encode($rows); 

function check_grades($r){
	$fail_case = array("A", "A-");
	for ($i=0; $i < count($fail_case); $i++) { 
	    if($fail_case[$i] == $r ['grade']){
           return false;
        }
    	return true;
	}
}

?>


function makeTables(){
            $.ajax({
            type: "GET",
            url: 'selectPlan.php',
            dataType: 'json',
            // get request for student name
            success: function(data){
                var prev_name;
                data.forEach(function(element){
                    if(prev_name !==  element.student_name){
                        console.log(prev_name);

                        $('#plans').append('<h3 style="padding-top: 20px; border-top: 1px solid #ccc;">' + element.student_name +'</h3>');
                        $('#plans').append('<h4>Program: Construction Engineering Technician</h4>');
                        $('#plans').append('<h4>Student Number: ' + element.student_no + '</h4>');
                    }
                    $('#plans').append('<p>' + element.course_no + ' ' + element.course_name + '</p>');
                    prev_name = element.student_name;
               }) 
            }
        });
        }     


dropdown lelvel

<?php
include("connect.php");

$sql = "SELECT distinct a_level from student_enrollment order by a_level";

$result = mysqli_query($db,$sql);
while ( $row = mysqli_fetch_array($result))
{
    echo "<li><a role=\"menuitem\" href=\"javascript:void(0)\" value=\"$row[0]\">$row[0]</a></li>";
}

?>