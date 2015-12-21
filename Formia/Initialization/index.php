<?php
//
// INITIATION FILE
// ^^^^^^^^^^^^^^^
// ****** IMPORTANT ******
// 
// RUN THIS FILE TO INITIATE THE PROJECT. IF YOU RECEIVE A SUCCESS MESSAGE, DELETE THIS FILE.
// DO NOT RUN THIS FILE MORE THAN ONCE.
//
//  Run the server and open phpMyAdmin -> create a new user to access the database with
//		username : hellouser
//		host 	 : SELECT local FROM THE DROPDOWN
//		password : hellouser123
//		permissions : select all
// -------------------------------------------------

$db_success = FALSE;
$table_success = FALSE;

echo "<br> INITIALIZING FORMIA";
echo "<br> Creating database and tables; please wait";


// create database
$servername = "localhost";
$username = "hellouser";
$password = "hellouser123";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("<br>Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE formiadatacenter";
if ($conn->query($sql) === TRUE) {
    echo "<br>Database created successfully";
    $db_success = TRUE;
} else {
    echo "<br>Error creating database: " . $conn->error;
    echo "<br>report your issue at here : ";
}
$conn->close();

// *************************************************************
// CREATE INITIALIZATION TABLE
//
// ---------------------------
//
$servername = "localhost";
$username = "hellouser";
$password = "hellouser123";
$dbname = "formiadatacenter";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("<br> Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE logindata (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) NOT NULL,
password VARCHAR(40) NOT NULL,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "<br>Table created successfully";
    $table_success = TRUE;
} else {
    echo "<br>Error creating table: " . $conn->error;
}

$conn->close();

if($db_success && $table_success){
	echo "<br> ********************************************";
	echo "<br> initialization completed successfully.";
	echo "<br> DELETE THIS(initialization.php) FILE.";
}else{
	echo "<br> ********************************************";
	echo "<br> initialization failed. Report the issue at :";

}
?>