<?php

// Connect to the MySQL database
include("connect.php");

$limit = $_GET['limit'];


$result = mysql_query("SELECT DISTINCT studentName from studentStats LIMIT 200");
$rows = array();
while($r = mysql_fetch_array($result)) {
    array_push($rows, $r);
}

header('Content-type: application/json');
echo json_encode($rows); 

?>


