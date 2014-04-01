<?php require_once ('../includes/initialize.php'); ?>


<?php

$username = "";
//Detect form submission
if(isset($_POST["submit"])){

	
	//perform validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);
	
	//validation passed
	if(empty($errors)){
		//no errors, attempt login
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$found_user = attempt_login($username, $password);
		if ($found_user){
			//success.  Mark user as logged in 
			$_SESSION["user_id"] = $found_user["id"];
			$_SESSION["username"] = $found_user["username"];
			$_SESSION["admin"] = (int)$found_user["admin"];
			//Check for cookie
			if (isset($_COOKIE["token"])){redirect_to("index.php");} 
			else {
					
					$token = password_encrypt($username);
					setcookie("token", $token, time()+(60*60*24*7));
					
					$query = "UPDATE users SET ";
					$query .= "token = '{$token}' ";
					$query .= "WHERE id={$found_user["id"]} ";
					$query .="LIMIT 1";
					$result = mysqli_query($connection, $query);
						if ($result) {
							// token set
							//$_SESSION["message"] = "token set";
							
							echo $result;
						} else {
							// Display error message.
							//$_SESSION["message"] = "token not set" . mysql_error();
							
							}
						}
			
			mysqli_close($connection);
			redirect_to("index.php");
		} else {
			//Login failed 
			$_SESSION["message"] = "Username/password not found";
			mysqli_close($connection);
			redirect_to("index.php");
		}
		
	
			
		}

	
	else{
			//Validation failed
			
			$_SESSION["errors"]= $errors;
			mysqli_close($connection);
			redirect_to("index.php");
			
		}


}

else {
mysqli_close($connection);
redirect_to("index.php");
}

?>