<?php require_once ('../includes/initialize.php'); ?>
<?	if (!is_loggedin()){
		$_SESSION["message"] = "Please log in.";
		redirect_to("index.php");
	} ?>
<?php include_once ('../includes/header.php'); ?>

<?php 
	$id = $_SESSION["user_id"];
	$user = find_user_by_id($id);
	$saved_hashed_password = $user["hashed_password"];
?>


<?php


//Detect form submission
if(isset($_POST["submit"])){

	
	//perform validations
	$required_fields = array("current_password", "new_password");
	
	validate_presences($required_fields);
	// Check current password against existing
	$current_password = mysql_prep(trim($_POST["current_password"]));
	if (!password_check($current_password, $saved_hashed_password)){
		$errors["password"] = "Current password does not match";
	}
	//validation passed
	if(empty($errors)){
	
			
			$hashed_password=password_encrypt($_POST["new_password"]);
			$query = "UPDATE users SET ";
			$query .= "hashed_password = '{$hashed_password}' ";
			$query .= "WHERE id = {$id} ";
			$query .= "LIMIT 1";
			
			
			$result = mysqli_query($connection, $query);
					
			
			if ($result) {
				// Success!
				$_SESSION["message"] = "Password Changed.";
				redirect_to("index.php");
				
				echo $result;
			} else {
				// Display error message.
				$_SESSION["message"] = "Password change failed.";
				redirect_to("user_change_password.php");
				
			}
			
		}

	
	else{
			//Validation failed
			
			$_SESSION["errors"]= $errors;
			redirect_to("user_change_password.php");
			
			
		}


}

else //No $_POST request, display form
	{

?>


	<div class="row">
		
		<div class="col-md-12">
			<h1>Change Password</h1>
			<?php include('../includes/errors.php'); ?>
			<?php include('../includes/messages.php'); ?>
			<div class="col-md-6  col-md-offset-3">
			<form role="form" action="user_change_password.php" method="post">
				
				
			  <div class="form-group">
				<label for="current_password">Current Password</label>
				<input type="password" class="form-control" name="current_password" id="current_password">
			  </div>
			  <div class="form-group">
				<label for="new_password">New Password</label>
				<input type="password" class="form-control" name="new_password" id="new_password">
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