<?php
// TEST for auto grade select with php and sql
// Connect to the MySQL database
include("connect.php");

$name = $_GET['name'];

$result = mysqli_query($db, "SELECT grade, courseNumber from studentStats WHERE studentName = 'qfnwl0, pqtuq' AND grade NOT IN ('F', 'W')");




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

//THIS DOESN"T WORK. 
    //IT WILL ONLY WORK IF THE COURSE CODE INCREMENT BY 1 PER LEVEL
    function courseTableSelect(row){
        var data = $('#course-table-javascript').bootstrapTable('getData');    

        var studentCourseCode = row.course_no; 

        for(var i in data){
            var table_row = data[i];
            // get the char at the end as a int of incr and select the next course
            var ccn = parseInt(studentCourseCode.slice(-1));
            // get the rest except the end 
            //eg MAT8051 this get the MAT805
            var ccl = studentCourseCode.slice(0, -1);

            //some courses end with a letter. 
            if(isNaN(ccn)) continue;

            // CAD8407 Architectural CAD I goes from 07 to 09 at level 2
            if(studentCourseCode === "CAD8407" || studentCourseCode === "ENG4001"){
                ccn+=2;
            }else{
                ccn++;
            } 

            var target_course = ccl + ccn;
            if(table_row.course_no === target_course){
                var $tr = $("#course-table-javascript .bs-checkbox input[data-index='"+ i +"']");
                // click row table row to check the check box
                $tr.trigger("click");
            }
        }
    }

    // old code to check fail causes like F or other grade codes
    function checkForFailed(fail_cases, row){
        for(var i in fail_cases){
            var gradeLetter = row.grade;
            if(gradeLetter == fail_cases[i]){
               return false;
            }
            return true;
        }
    }

