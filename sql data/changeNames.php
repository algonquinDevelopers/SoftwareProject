<?php

include("connect.php");
require_once __DIR__.'/Faker/src/autoload.php';

// use to get real random name to make sample data look better
// theres an error when updating many rows

$faker = Faker\Factory::create();
//return a number of all the unique names in the table

//SELECT DISTINCT studentNumber from studentStats LIMIT 715, 1000
$result = mysql_query("SELECT DISTINCT studentNumber from studentStats");

while ($row = mysql_fetch_array($result)) {
	$studentNum = $row['studentNumber'];

	$firstN = $faker->firstName;
	$lastN = $faker->lastName;
	$sql = "UPDATE studentStats
		SET studentName='$firstN $lastN', 
		firstName=' $firstN', 
		lastName='$lastN'
		WHERE studentNumber = $studentNum";

	$retval = mysql_query($sql);
	//echo $firstN ."</br>";
	if(! $retval )
	{
	  die('Could not update data: ' . mysql_error().' '. $studentNum);
	}

}

echo "done";

mysql_close($db);
?>