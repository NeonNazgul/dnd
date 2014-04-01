<?php require_once ('../includes/initialize.php'); ?>

<?php if (!is_admin()){	redirect_to("index.php");}?>

<?php 
	// Set any page-specific variables before the header

	$form = true; //marks this page as a form so the footer will load the validation javascript 

?>
<?php include_once ('../includes/header.php'); ?>




<?php


//Detect form submission
if(isset($_POST["submit"])){

	
	//perform validations
	$required_fields = array("username", "password", "email");
	validate_presences($required_fields);
	
	//validation passed
	if(empty($errors)){
	
	
			
			$username=mysql_prep(trim($_POST["username"]));
			$hashed_password = password_encrypt($_POST["password"]);
			$email=mysql_prep(trim($_POST["email"]));
			$admin = mysql_prep((int)($_POST["admin"]));
			//Check is username is unquie
			
			$query_uniqe = "SELECT * FROM users WHERE username = '{$username}'";
			$unique_result = mysqli_query ($connection, $query_uniqe);
			if (mysqli_num_rows($unique_result) != 0) {
				$_SESSION["message"] = "Username taken. Please enter a new username.";
				redirect_to("admin_add_user.php");
			}
			
			
			
			//construct query
			$query = "INSERT INTO users ";
			$query .= "(username, hashed_password, email, admin) ";
			$query .= "VALUES ('{$username}', '{$hashed_password}', '{$email}', {$admin})";
			$result = mysqli_query($connection, $query);
			
			
			
			if ($result) {
				// Success!
				$_SESSION["message"] = "User created.";
				redirect_to("admin_manage_users.php");
				
				echo $result;
			} else {
				// Display error message.
				$_SESSION["message"] = "User creation failed.";
				redirect_to("admin_manage_users.php");
				
			}
			
		}

	
	else{
			//Validation failed
			
			$_SESSION["errors"]= $errors;
			redirect_to("admin_add_user.php");
			
		}


}

else {

?>


	<div class="row">
		
		<div class="col-md-12">
			<h1>New User</h1>
			<?php include('../includes/errors.php'); ?>
			<?php include('../includes/messages.php'); ?>
			<div class="col-md-6  col-md-offset-3">
			<form role="form" action="admin_add_user.php" method="post">
				
				
			  <div class="form-group">
				<label for="first_name">Username</label>
				<input type="text" class="form-control required" name="username" id="username" placeholder="Username">
			  </div>
			  <div class="form-group">
				<label for="last_name">Password</label>
				<input type="password" class="form-control" name="password" id="password">
			  </div>
			  
			  <div class="form-group">
				<label for="first_name">Email</label>
				<input type="text" class="form-control required" name="email" id="email" placeholder="user@email.com">
			  </div>
			  
			  
			  
			 
			  
			  <div class="form-group">
				<label for="public">Admin?<br />
				<input type="radio" name="admin" value="1" checked> Yes <br />
				<input type="radio" name="admin" value="0"> No</label>
			  </div>
			  
			  
			  
			  <button type="submit" name="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
			</form>
			</div>
			</div>
			
			
			</div>			
		
	<?php } ?>

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>