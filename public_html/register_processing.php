<?php require_once ('../includes/initialize.php'); ?>

<?php 
	// Set any page-specific variables before the header

	//$form = true; //marks this page as a form so the footer will load the validation javascript 
	$page_register = true; // Identifies this as the Registration page
?>
<?php include_once ('../includes/header.php'); ?>




<?php


//Detect form submission
if(isset($_POST["submit"])){

	
	//perform validations
	$required_fields = array("username", "password", "email");
	validate_presences($required_fields);

	//echo "Session code: " . $_SESSION["pass"] . " <br />Posted code: " . $_POST["captcha_input"] . "<br />";

 if ($_POST["captcha_input"] != $_SESSION["pass"])
{
	
	$errors["captcha"] = "Captcha wrong";
}

	
	//validation passed
	if(empty($errors)){
	
			unset($_SESSION["pass"]);
			$username=mysql_prep(trim($_POST["username"]));
			$hashed_password = password_encrypt($_POST["password"]);
			$email=mysql_prep(trim($_POST["email"]));
			
			//Check is username is unquie
			
			$query_uniqe = "SELECT * FROM users WHERE username = '{$username}'";
			$unique_result = mysqli_query ($connection, $query_uniqe);
			if (mysqli_num_rows($unique_result) != 0) {
				$_SESSION["message"] = "Username taken. Please enter a new username.";
				redirect_to("register.php");
			}
			
			
			
			//construct query
			$query = "INSERT INTO users ";
			$query .= "(username, hashed_password, email, admin) ";
			$query .= "VALUES ('{$username}', '{$hashed_password}', '{$email}', 0)";
			$result = mysqli_query($connection, $query);
			$last_id = mysqli_insert_id($connection);
			
			
			if ($result) {
				// Success!
				$_SESSION["message"] = "Registration successful. Welcome to the site.";
				$user = find_user_by_id($last_id);				
				$_SESSION["user_id"] = $user["id"];
				$_SESSION["username"] = $user["username"];
				$_SESSION["admin"] = (int)$user["admin"];
				$token = password_encrypt($username);
				setcookie("token", $token, time()+(60*60*24*7));
				$query = "UPDATE users SET ";
				$query .= "token = '{$token}' ";
				$query .= "WHERE id={$user["id"]} ";
				$query .="LIMIT 1";
				$result = mysqli_query($connection, $query);
					if ($result) {
						// token set
						//$_SESSION["message"] = "token set";
						
						//echo $result;
					} else {
						// Display error message.
						//$_SESSION["message"] = "token not set" . mysql_error();
						
						}
				//Send email
				
		
				// PHPMailer's Object-oriented approach
				$mail = new PHPMailer();
				
				// Can use SMTP
				// comment out this section and it will use PHP mail() instead
				$mail->IsSMTP();
				$mail->Host     = SMTP_HOST;
				$mail->Port     = SMTP_PORT;
				$mail->SMTPAuth = SMTP_AUTH;
				$mail->SMTPSecure = SMTP_SMTPSECURE;
				// end SMTP define
				$mail->Username = SMTP_USERNAME;
				$mail->Password = SMTP_PASSWORD;
				$mail->FromName = SMTP_FROMNAME;
				$mail->From     = SMTP_FROM;
				$mail->AddAddress($email, $username);
				$mail->Subject  = "New User Registration";
				$mail->Body     = "Welcome to DnD Character Record.  This confirms your account has been registered successfully. Your username is {$username}.";
				
				$emailresult = $mail->Send();
				$emailresult ? redirect_to("index.php") : die("email not sent. address: {$email}");
				//Everything is good, redirect to index
				
				
				//echo $result;
			} else {
				// Display error message.
				$_SESSION["message"] = "User creation failed.";
				redirect_to("register.php");
				
			}
			
		}

	
	else{

			//Validation failed
			
			$_SESSION["errors"]= $errors;
			redirect_to("register.php");
			
			
		}


}

else {
	die ("no data");
}