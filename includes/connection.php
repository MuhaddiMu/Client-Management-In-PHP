<?php
error_reporting(0);
$Server = "localhost";
$Username = "root";
$Password = "root";
$DB = "MyClients";
$Connection = mysqli_connect($Server, $Username, $Password, $DB);

if (!$Connection)
	{
	die("Connection Failed: " . mysqli_connect_error());
	}

?>
