<?php
$dbhost = 'localhost';
$dbname = 'mydb';
$username = 'root';
$pass = '';

$db = mysqli_connect ( $dbhost, $username, $pass ) or die ( '<div align="center">Warning: Could not connect to the database</div>' );
if (! $db) {
	printf ( "Error: %s\n", mysqli_error ( $db ) );
	exit ();
}

$cid = mysqli_select_db ( $db, $dbname );
// supply your database name

define ( 'CSV_PATH', 'C:/wamp/www/SoftwareProjectV1/' );

// path where your CSV file is located

$csv_file = CSV_PATH . "clientdataComplete.csv"; // Name of your CSV file

insertStudentTable();
insertCourseTable();
insertCourseSectionTable();
insertStudentEnrollmentTable();
insertDeptTable(); 
insertProgramtable();
insertProgramCourseTable();

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
	
	$query1 = "select * from student where student_no = '" . $insert_csv ['student_no'] . "'";
	$result = mysqli_query ( $db, $query1 );
	
	if (mysqli_fetch_array($result) == true) {
		echo "update";
		//mysqli_query($db,"UPDATE student SET Age=36 WHERE FirstName='Peter' AND LastName='Griffin'");
		mysqli_query($db,"UPDATE student SET 
				student_last_name = '" . $insert_csv ['student_last_name'] . "',
				student_first_name = '" . $insert_csv ['student_first_name'] . "'
						where student_no = '" . $insert_csv ['student_no'] . "'");
	}
	else {
		echo "insert";
		$query2 = "INSERT INTO student(student_no,student_first_name,student_last_name) 
				VALUES('" . $insert_csv ['student_no'] . "','" . $insert_csv ['student_first_name'] . "','" . $insert_csv ['student_last_name'] . "')";	

	
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
		
		$insert_csv ['level'] = isset ( $csv_array [11] ) ? $csv_array [11] : null;

		$insert_csv ['course_name'] = isset ( $csv_array [13] ) ? $csv_array [13] : null;

		$query1 = "select * from course where course_no = '" . $insert_csv ['course_no'] . "'
		and level = '" . $insert_csv ['level'] . "'";
		$result = mysqli_query ( $db, $query1 );

		if (mysqli_fetch_array($result) == true) {
			echo "update";
			mysqli_query($db,"UPDATE course SET
				course_name = '" . $insert_csv ['course_name'] . "'
						where course_no = '" . $insert_csv ['course_no'] . "'
						and level = '" . $insert_csv ['level'] . "'");
		}
		else {
			echo "insert";
			$query2 = "INSERT INTO course(course_no,course_name,level)
				VALUES('" . $insert_csv ['course_no'] . "','" . $insert_csv ['course_name'] . "',
						'" . $insert_csv ['level'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		}
		
		$i ++;
		
	}

	fclose ( $csvfile );

	echo "File data successfully imported to Course table!!";

}


function insertCourseSectionTable() {

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
			echo "update";
			//mysqli_query($db,"UPDATE student SET Age=36 WHERE FirstName='Peter' AND LastName='Griffin'");
		//	mysqli_query($db,"UPDATE student SET
			//	student_last_name = '" . $insert_csv ['student_last_name'] . "',
				//student_first_name = '" . $insert_csv ['student_first_name'] . "'
					//	where student_no = '" . $insert_csv ['student_no'] . "'");
		}
		else {
			echo "insert";
			$query2 = "INSERT INTO course_section(section_no,course_no, level)
				VALUES('" . $insert_csv ['section_no'] . "','" . $insert_csv ['course_no'] . "',
				'" . $insert_csv ['level'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		}
		



		$i ++;
		
	}

	fclose ( $csvfile );

	echo "File data successfully imported to Course_Section table!!";

}

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

		$insert_csv ['section_no'] = isset ( $csv_array [14] ) ? $csv_array [14] : null;

		$insert_csv ['course_no'] = isset ( $csv_array [12] ) ? $csv_array [12] : null;
		
		$insert_csv ['student_no'] = isset ( $csv_array [5] ) ? $csv_array [5] : null;
		
		$insert_csv ['grade'] = isset ( $csv_array [16] ) ? $csv_array [16] : null;
		
		$insert_csv ['status'] = isset ( $csv_array [15] ) ? $csv_array [15] : null;
		
		$insert_csv ['term'] = isset ( $csv_array [0] ) ? $csv_array [0] : null;
		
		$insert_csv ['level'] = isset ( $csv_array [11] ) ? $csv_array [11] : null;

		$query1 = "select * from student_enrollment where
				section_no = '" . $insert_csv ['section_no'] . "'
				and course_no = '" . $insert_csv ['course_no'] . "'
				and student_no = '" . $insert_csv ['student_no'] . "'
				and term = '" . $insert_csv ['term'] . "'
				and level = '" . $insert_csv ['level'] . "'";

		$result = mysqli_query ( $db, $query1 );

		if (mysqli_fetch_array($result) == true) {
			echo "update";
				mysqli_query($db,"UPDATE student_enrollment SET
				grade = '" . $insert_csv ['grade'] . "',
				status = '" . $insert_csv ['status'] . "'
				where student_no = '" . $insert_csv ['student_no'] . "'
				and course_no = '" . $insert_csv ['course_no'] . " '
				and section_no = '" . $insert_csv ['section_no'] . "'
				and term = '" . $insert_csv ['term'] . "'
				and level = '" . $insert_csv ['level'] . "'");
		}
		else {
			echo "insert";
			$query2 = "INSERT INTO student_enrollment(level,section_no,course_no, student_no, grade, status,term)
				VALUES('" . $insert_csv ['level'] . "', '" . $insert_csv ['section_no'] . "','" . $insert_csv ['course_no'] . "',
				'" . $insert_csv ['student_no'] . "', '" . $insert_csv ['grade'] . "', 
				'" . $insert_csv ['status'] . "', '" . $insert_csv ['term'] . "')";
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



		$query1 = "select * from program where
				program_no = '" . $insert_csv ['program_no'] . "'
				and program_version = '" . $insert_csv ['program_version'] . "'
				and department_no = '" . $insert_csv ['department_no'] . "'";

		$result = mysqli_query ( $db, $query1 );

		if (mysqli_fetch_array($result) == true) {
			echo "update";
			mysqli_query($db,"UPDATE program SET
				program_name = '" . $insert_csv ['program_name'] . "'
				where program_no = '" . $insert_csv ['program_no'] . "'
				and department_no = '" . $insert_csv ['department_no'] . " '
				and program_version = '" . $insert_csv ['program_version'] . "'");
		}
		else {
			echo "insert";
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

		$insert_csv ['department_no'] = isset ( $csv_array [1] ) ? $csv_array [1] : null;

		$insert_csv ['course_no'] = isset ( $csv_array [12] ) ? $csv_array [12] : null;
		
		$insert_csv ['level'] = isset ( $csv_array [11] ) ? $csv_array [11] : null;



		$query1 = "select * from program_course where
				program_no = '" . $insert_csv ['program_no'] . "'
				and program_version = '" . $insert_csv ['program_version'] . "'
				and department_no = '" . $insert_csv ['department_no'] . "'
				and course_no = '" .$insert_csv['course_no'] . "'
				and level = '" .$insert_csv['level'] . "'";

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
			echo "insert";
			$query2 = "INSERT INTO program_course(program_no,program_version,department_no,course_no,level)
				VALUES('" . $insert_csv ['program_no'] . "','" . $insert_csv ['program_version'] . "',
				'" . $insert_csv ['department_no'] . "', '" . $insert_csv ['course_no'] . "',
				'" . $insert_csv ['level'] . "')";
			$insert = mysqli_query ( $db, $query2 );

		}




		$i ++;

	}

	fclose ( $csvfile );

	echo "File data successfully imported to Program_Course table!!";

}



mysqli_close ( $db );

?>
