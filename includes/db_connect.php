<?php


require_once('../../global/constants_dnd.php');
	//Create a database connection

	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	//Test database connection and display error if any
	if(mysqli_connect_errno()){
		die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")" );
		}
?>