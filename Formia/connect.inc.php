<?php
// File for connecting to the MySQL database. 
//defining variables.
$serverName="localhost";
$serverUserName="hellouser";
$serverPassword="hellouser123";
$dbname="formiadatacenter";

//connecting..
if(@$conn = new mysqli($serverName, $serverUserName, $serverPassword, $dbname))
	{
		//echo "ok.";
	}
//else echo "err";


//checking connection..
if($conn->connect_error)
{
	die("Connection failed.".$conn->connect_error);
}
?>