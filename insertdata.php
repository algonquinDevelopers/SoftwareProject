<!DOCTYPE html>
<html>
<head>
    <!-- <link rel="stylesheet" href="https://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/master/dist/bootstrap-table.min.css">
<style>

    .content{
        background-color: #eee;
        /*margin-top: -10px;*/
        border-radius: 5px;
    }

    .content #grades{
        font-size: 14px;
        color: #00b0ff;
    }

    .content h1{
        font-size: 16px;
        padding-bottom:5px;
        margin-left: -10px;
        text-transform:uppercase;
    }

    .nav #title{
        /*font-size: 16px;*/
    }

    #allCourses{
        margin-bottom: -15px;
    }

    .navbar{
        border-radius: 0px;
        background-color: #E6E6E6;
        color: #5a5a5a;
        font-size: 11px;
        font-weight: bold;
        text-transform:uppercase;
        /*margin-bottom: 0px;*/
    }

    .navbar form{
        padding-top: 10px;
    }
    .navbar #title{
        font-size: 12px;
    }


    .active1 {
        background-color: #ddd;
    }
   /* .panel-heading{
        background-color: #ddd;
        color: #00b0ff;
    }
*/

    #students{
        margin-left: 10px;
    }
    </style>
</head>

<body>

<div class="nav">
    <div class="container">

    
    <!-- http://getbootstrap.com/components/#navbar-component-alignment -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <ul class="nav navbar-nav pull-left">
                <li id="title"><a href="#">Software Project</a></li>
                <li class="active1"><a href="#">Home</a></li>
                <li data-toggle="dropdown"><a href="#">Programs</a></li>
            </ul>
        </div>    
    </nav>
    </div>
</div>

<div class="content">
    <div class="container">

<?php
include("connect.php");


if (empty($_FILES["uploadFile"]["name"])) {
	echo "Please select a file.";
}

else {
/*upload file code starts */
$target_dir = "upload/";
$target_dir = $target_dir . basename( $_FILES["uploadFile"]["name"]);
$uploadOk=1;

// Only CSV files allowed

$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
if(!in_array($_FILES['uploadFile']['type'],$mimes)){
	echo "Sorry, only csv files are allowed.";
	$uploadOk = 0;

}



// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir)) {
		echo "The file ". basename( $_FILES["uploadFile"]["name"]). " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}
/*upload file code ends */


/*insert data code starts */

define ( 'CSV_PATH', 'C:/wamp/www/SoftwareProjectV1/' );

// path where your CSV file is located

$csv_file = CSV_PATH . $_FILES["uploadFile"]["name"]; // Name of your CSV file

//echo "lkjkl";




if ($uploadOk != 0) {

	insertDeptTable(); 
	insertProgramTable();
	insertCourseTable();
	insertStudentTable();

	insertStudentEnrollmentTable();

	insertProgramCourseTable();
}

}
function insertStudentTable() {

global $db;
global $csv_file;
$csvfile = fopen ( $csv_file, 'r' );

$theData = fgets ( $csvfile );


$i = 0;

while ( ! feof ( $csvfile ) ) {
	
	$csv_data [] = fgets ( $csvfile, 1024 );
	
	$csv_array = explode ( ",", $csv_data [$i] );
	
	$insert_csv = array ();
	
	// $data[$parts[0]] = isset($parts[1]) ? $parts[1] : null;
	
	$insert_csv ['student_no'] = isset ( $csv_array [5] ) ? $csv_array [5] : null;
	
	$insert_csv ['student_last_name'] = isset ( $csv_array [9] ) ? $csv_array [9] : null;
	
	$insert_csv ['student_first_name'] = isset ( $csv_array [10] ) ? $csv_array [10] : null;
	
	$insert_csv ['program_no'] = isset ( $csv_array [2] ) ? $csv_array [2] : null;
	
	//need to change the array number - just for testing purpose
	$insert_csv ['program_version'] = isset ( $csv_array [4] ) ? $csv_array [4] : null;
	
	//$insert_csv ['department_no'] = isset ( $csv_array [1] ) ? $csv_array [1] : null;
	
	$query1 = "select * from student where student_no = '" . $insert_csv ['student_no'] . "'";
	$result = mysqli_query ( $db, $query1 );
	
	if (mysqli_fetch_array($result) == true) {
		//echo "update";
		//mysqli_query($db,"UPDATE student SET Age=36 WHERE FirstName='Peter' AND LastName='Griffin'");
		mysqli_query($db,"UPDATE student SET 
				student_name = '" . $insert_csv ['student_first_name'] . "' '" . $insert_csv ['student_last_name'] . "',
				student_last_name = '" . $insert_csv ['student_last_name'] . "',
				student_first_name = '" . $insert_csv ['student_first_name'] . "',
				program_no = '" . $insert_csv ['program_no'] . "', 
				program_version = '" . $insert_csv ['program_version'] . "',
				where student_no = '" . $insert_csv ['student_no'] . "'");
	}
	else {
		//echo "insert";
		$query2 = "INSERT INTO student(student_no,student_name,student_first_name,student_last_name,program_no,program_version) 
				VALUES('" . $insert_csv ['student_no'] . "',
				'" . $insert_csv ['student_first_name'] . "' '" . $insert_csv ['student_last_name'] . "',
				'" . $insert_csv ['student_first_name'] . "',
				'" . $insert_csv ['student_last_name'] . "',
				'" . $insert_csv ['program_no'] . "', 
				'" . $insert_csv ['program_version'] . "')";	

	
		$insert = mysqli_query ( $db, $query2 );
		
		//mysqli_query($db,"INSERT INTO student(student_no,student_first_name,student_last_name) 
		//VALUES('" . $insert_csv ['student_no'] . "','" . $insert_csv ['student_first_name'] . "','" . $insert_csv ['student_last_name'] . "'");
	}
	//$query = "INSERT INTO student(student_no,student_first_name,student_last_name) 
		//	VALUES('" . $insert_csv ['student_no'] . "','" . $insert_csv ['student_first_name'] . "','" . $insert_csv ['student_last_name'] . "')";
	// mysqli_query($db, "Delete from student");
	
	
	
	$i ++;
	// echo $csv_array [5];
}

fclose ( $csvfile );

echo "File data successfully imported to Student table!!";

}


function insertCourseTable() {
	
	global $db;
	global $csv_file;
	$csvfile = fopen ( $csv_file, 'r' );
	

	$theData = fgets ( $csvfile );


	$i = 0;

	while ( ! feof ( $csvfile ) ) {

		$csv_data [] = fgets ( $csvfile, 1024 );

		$csv_array = explode ( ",", $csv_data [$i] );

		$insert_csv = array ();


		$insert_csv ['course_no'] = isset ( $csv_array [12] ) ? $csv_array [12] : null;
		

		$insert_csv ['course_name'] = isset ( $csv_array [13] ) ? $csv_array [13] : null;

		$query1 = "select * from course where course_no = '" . $insert_csv ['course_no'] . "'";
		$result = mysqli_query ( $db, $query1 );

		if (mysqli_fetch_array($result) == true) {
			//echo "update";
			mysqli_query($db,"UPDATE course SET
				course_name = '" . $insert_csv ['course_name'] . "'
						where course_no = '" . $insert_csv ['course_no'] . "'");
		}
		else {
			//echo "insert";
			$query2 = "INSERT INTO course(course_no,course_name)
				VALUES('" . $insert_csv ['course_no'] . "','" . $insert_csv ['course_name'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		}
		
		$i ++;
		
	}

	fclose ( $csvfile );

	echo "File data successfully imported to Course table!!";

}


/*function insertCourseSectionTable() {

	global $db;
	global $csv_file;
	$csvfile = fopen ( $csv_file, 'r' );

	$theData = fgets ( $csvfile );


	$i = 0;

	while ( ! feof ( $csvfile ) ) {

		$csv_data [] = fgets ( $csvfile, 1024 );

		$csv_array = explode ( ",", $csv_data [$i] );

		$insert_csv = array ();

		$insert_csv ['section_no'] = isset ( $csv_array [14] ) ? $csv_array [14] : null;

		$insert_csv ['course_no'] = isset ( $csv_array [12] ) ? $csv_array [12] : null;
		
		$insert_csv ['level'] = isset ( $csv_array [11] ) ? $csv_array [11] : null;
		
		
		$query1 = "select * from course_section where 
				section_no = '" . $insert_csv ['section_no'] . "'
				and course_no = '" . $insert_csv ['course_no'] . "'
				and level = '" . $insert_csv ['level'] . "'";
		
		$result = mysqli_query ( $db, $query1 );

		if (mysqli_fetch_array($result) == true) {
			//echo "update";
			//mysqli_query($db,"UPDATE student SET Age=36 WHERE FirstName='Peter' AND LastName='Griffin'");
		//	mysqli_query($db,"UPDATE student SET
			//	student_last_name = '" . $insert_csv ['student_last_name'] . "',
				//student_first_name = '" . $insert_csv ['student_first_name'] . "'
					//	where student_no = '" . $insert_csv ['student_no'] . "'");
		}
		else {
			//echo "insert";
			$query2 = "INSERT INTO course_section(section_no,course_no, level)
				VALUES('" . $insert_csv ['section_no'] . "','" . $insert_csv ['course_no'] . "',
				'" . $insert_csv ['level'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		}
		



		$i ++;
		
	}

	fclose ( $csvfile );

	echo "File data successfully imported to Course_Section table!!";

}*/

function insertStudentEnrollmentTable() {

	global $db;
	global $csv_file;
	$csvfile = fopen ( $csv_file, 'r' );

	$theData = fgets ( $csvfile );


	$i = 0;

	while ( ! feof ( $csvfile ) ) {

		$csv_data [] = fgets ( $csvfile, 1024 );

		$csv_array = explode ( ",", $csv_data [$i] );

		$insert_csv = array ();

		//$insert_csv ['section_no'] = isset ( $csv_array [14] ) ? $csv_array [14] : null;

		$insert_csv ['course_no'] = isset ( $csv_array [12] ) ? $csv_array [12] : null;
		
		$insert_csv ['student_no'] = isset ( $csv_array [5] ) ? $csv_array [5] : null;
		
		$insert_csv ['grade'] = isset ( $csv_array [16] ) ? $csv_array [16] : null;
		
		$insert_csv ['grade'] = str_replace("\r\n",'', $insert_csv ['grade']);
		
		$insert_csv ['status'] = isset ( $csv_array [15] ) ? $csv_array [15] : null;
		
		$insert_csv ['term'] = isset ( $csv_array [0] ) ? $csv_array [0] : null;
		
		$insert_csv ['a_level'] = isset ( $csv_array [11] ) ? $csv_array [11] : null;
		
		$insert_csv ['program_no'] = isset ( $csv_array [2] ) ? $csv_array [2] : null;
		
		//need to change the array number - just for testing purpose
		$insert_csv ['program_version'] = isset ( $csv_array [4] ) ? $csv_array [4] : null;
		
		//$insert_csv ['department_no'] = isset ( $csv_array [1] ) ? $csv_array [1] : null;

		$query1 = "select * from student_enrollment where
				course_no = '" . $insert_csv ['course_no'] . "'
				and student_no = '" . $insert_csv ['student_no'] . "'
				and term = '" . $insert_csv ['term'] . "'
				and a_level = '" . $insert_csv ['a_level'] . "' 
				and program_no = '" . $insert_csv ['program_no'] . "'
				and program_version = '" . $insert_csv ['program_version'] . "'";

		$result = mysqli_query ( $db, $query1 );

		if (mysqli_fetch_array($result) == true) {
			//echo "update";
				mysqli_query($db,"UPDATE student_enrollment SET
				grade = '" . $insert_csv ['grade'] . "',
				status = '" . $insert_csv ['status'] . "',
				a_level = '" . $insert_csv ['status'] . "',
				where student_no = '" . $insert_csv ['student_no'] . "'
				and course_no = '" . $insert_csv ['course_no'] . " '
				and term = '" . $insert_csv ['term'] . "'
				and program_no = '" . $insert_csv ['program_no'] . "'
				and program_version = '" . $insert_csv ['program_version'] . "'");
						
		}
		else {
			//echo "insert";
			$query2 = "INSERT INTO student_enrollment(term,student_no, program_no,program_version,course_no,grade,status,a_level)
				VALUES('" . $insert_csv ['term'] . "', '" . $insert_csv ['student_no'] . "','" . $insert_csv ['program_no'] . "',
				'" . $insert_csv ['program_version'] . "',
				'" . $insert_csv ['course_no'] . "',
				'" . $insert_csv ['grade'] . "',
				 '" . $insert_csv ['status'] . "', '" . $insert_csv ['a_level'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		}
		



		$i ++;

	}

	fclose ( $csvfile );

	echo "File data successfully imported to Student_Enrollment table!!";

}

function insertDeptTable() {

	global $db;
	global $csv_file;
	$csvfile = fopen ( $csv_file, 'r' );


	$theData = fgets ( $csvfile );


	$i = 0;

	while ( ! feof ( $csvfile ) ) {

		$csv_data [] = fgets ( $csvfile, 1024 );

		$csv_array = explode ( ",", $csv_data [$i] );

		$insert_csv = array ();


		$insert_csv ['dept_no'] = isset ( $csv_array [1] ) ? $csv_array [1] : null;

		//$query1 = "select * from course where course_no = '" . $insert_csv ['course_no'] . "'";
		//$result = mysqli_query ( $db, $query1 );

		//if (mysqli_fetch_array($result) == true) {
			//echo "update";
			//mysqli_query($db,"UPDATE course SET
				//course_name = '" . $insert_csv ['course_name'] . "'
					//	where course_no = '" . $insert_csv ['course_no'] . "'");
//		}
	//	else {
		//	echo "insert";
			$query2 = "INSERT INTO department(department_no)
				VALUES('" . $insert_csv ['dept_no'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		//}

		$i ++;

	}

	fclose ( $csvfile );

	echo "File data successfully imported to Department table!!";

}

function insertProgramTable() {

	global $db;
	global $csv_file;
	$csvfile = fopen ( $csv_file, 'r' );

	$theData = fgets ( $csvfile );


	$i = 0;

	while ( ! feof ( $csvfile ) ) {

		$csv_data [] = fgets ( $csvfile, 1024 );

		$csv_array = explode ( ",", $csv_data [$i] );

		$insert_csv = array ();

		$insert_csv ['program_no'] = isset ( $csv_array [2] ) ? $csv_array [2] : null;

		//need to change the array number - just for testing purpose
		$insert_csv ['program_version'] = isset ( $csv_array [4] ) ? $csv_array [4] : null;

		$insert_csv ['department_no'] = isset ( $csv_array [1] ) ? $csv_array [1] : null;

		$insert_csv ['program_name'] = isset ( $csv_array [3] ) ? $csv_array [3] : null;
		
		//$insert_csv ['a_level'] = isset ( $csv_array [11] ) ? $csv_array [11] : null;



		$query1 = "select * from program where
				program_no = '" . $insert_csv ['program_no'] . "'
				and program_version = '" . $insert_csv ['program_version'] . "'
				and department_no = '" . $insert_csv ['department_no'] . "'";

		$result = mysqli_query ( $db, $query1 );

		if (mysqli_fetch_array($result) == true) {
			//echo "update";
			mysqli_query($db,"UPDATE program SET
				program_name = '" . $insert_csv ['program_name'] . "'
				where program_no = '" . $insert_csv ['program_no'] . "'
				and department_no = '" . $insert_csv ['department_no'] . " '
				and program_version = '" . $insert_csv ['program_version'] . "'");
		}
		else {
		//	echo "insert";
			$query2 = "INSERT INTO program(program_no,program_version,department_no,program_name)
				VALUES('" . $insert_csv ['program_no'] . "','" . $insert_csv ['program_version'] . "',
				'" . $insert_csv ['department_no'] . "', '" . $insert_csv ['program_name'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		}




		$i ++;

	}

	fclose ( $csvfile );

	echo "File data successfully imported to Program table!!";

}

function insertProgramCourseTable() {

	global $db;
	global $csv_file;
	$csvfile = fopen ( $csv_file, 'r' );

	$theData = fgets ( $csvfile );


	$i = 0;

	while ( ! feof ( $csvfile ) ) {

		$csv_data [] = fgets ( $csvfile, 1024 );

		$csv_array = explode ( ",", $csv_data [$i] );

		$insert_csv = array ();

		$insert_csv ['program_no'] = isset ( $csv_array [2] ) ? $csv_array [2] : null;
		
		$insert_csv ['program_version'] = isset ( $csv_array [4] ) ? $csv_array [4] : null;

	//	$insert_csv ['department_no'] = isset ( $csv_array [1] ) ? $csv_array [1] : null;

		$insert_csv ['course_no'] = isset ( $csv_array [12] ) ? $csv_array [12] : null;



		$query1 = "select * from program_course where
				program_no = '" . $insert_csv ['program_no'] . "'
				and program_version = '" . $insert_csv ['program_version'] . "'
				and course_no = '" .$insert_csv['course_no'] . "'";
				

		$result = mysqli_query ( $db, $query1 );

		if (mysqli_fetch_array($result) == true) {
			//echo "update";
			//mysqli_query($db,"UPDATE program SET
				//program_name = '" . $insert_csv ['program_name'] . "'
				//where program_no = '" . $insert_csv ['program_no'] . "'
				//and department_no = '" . $insert_csv ['department_no'] . " '
				//and program_version = '" . $insert_csv ['program_version'] . "'");
		}
		else {
			//echo "insert";
			$query2 = "INSERT INTO program_course(program_no,program_version,course_no)
				VALUES('" . $insert_csv ['program_no'] . "','" . $insert_csv ['program_version'] . "',
				'" . $insert_csv ['course_no'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		}




		$i ++;

	}

	fclose ( $csvfile );

	echo "File data successfully imported to Program_Course table!!";

}



mysqli_close ( $db );

?>
</div>
</div>

</body>
</html>













