<?php

//
// some of the core functions.
// setting sessions and initializing the address bases.
//


ob_start();
//start session
session_start();

$current_file = $_SERVER['SCRIPT_NAME'];

// end address.
$addressBase = "http://".$_SERVER['SERVER_ADDR']."/Formia/";
$http_referer = $addressBase."index.php";

//varables from console1.php
$userData;
$tableData;
$tableName;

function loggedin()
{
	if(isset($_SESSION['userid']) && !empty($_SESSION['userid']))
		return TRUE;
	else
		return FALSE;
}

function getfield($field, $table, $conn)
{
	if(loggedin())
	{
		$userid = $_SESSION['userid'];
		$query = "SELECT $field FROM $table WHERE id='$userid'";
		if($result = $conn->query($query))
		{
			if ($result->num_rows > 0)
			{
				if($result= $result->fetch_row())
				{
					return $result;
				}
				else echo "fetch row fault";
			}
			elseif($result->num_rows < 0) echo "num_rows < 0";
			else echo "cant detect";							
		}
		else echo "failed - in getfield";
	}
}

function getanyfield($field, $table, $this1, $this2, $connect) //($field, $table, $WHERE_what ,$EQUALS_what, $connection)
{
	$query = "SELECT $field FROM $table WHERE $this1='$this2'";
	if($result = $connect->query($query))
	{
		if ($result->num_rows > 0)
		{
			return $result;			
		}
		else ;//echo "num_rows < 0";							
	}
	else 
	{
		
		return 0;
	}
}

?>