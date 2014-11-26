<?php
$dbhost = 'localhost';
$dbname = 'softwareproject';
$username = 'root';
$pass = '';

$db = mysqli_connect($dbhost,$username,$pass)
or die('<div align="center">Warning: Could not connect to the database</div>');
if (!$db) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}
mysqli_select_db($db, $dbname);
?>
