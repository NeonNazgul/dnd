<?php require_once ('../includes/initialize.php'); ?>
<?php if (!is_admin()){	redirect_to("index.php");}?>
<?php 
	// Set any page-specific variables before the header

	$form = true; //marks this page as a form so the footer will load the validation javascript 

?>
<?php include_once ('../includes/header.php'); ?>

<?php

$id = (int)$_GET["user_id"];

$user_array = find_user_by_id($id);


//Detect form submission
if(isset($_POST["submit"])){

	
	//perform validations
	$required_fields = array("username", "password", "email");
	validate_presences($required_fields);
	
	//validation passed
	if(empty($errors)){
	
	
			//echo "Woo! No errors!";
			$id=$_POST["user_id"]; 
			$username=mysql_prep(trim($_POST["username"]));
			$hashed_password=password_encrypt($_POST["password"]);
			$email=mysql_prep(trim($_POST["email"]));
			$admin = mysql_prep((int)($_POST["admin"]));
			//construct query
			$query = "UPDATE users SET ";
			$query .= "username = '{$username}', hashed_password = '{$hashed_password}', email = '{$email}', admin = {$admin}  ";
			$query .= "WHERE id = {$id} ";
			$query .= "LIMIT 1";
			
			
			$result = mysqli_query($connection, $query);
			if ($result) {
				// Success!
				$_SESSION["message"] = "User updated.";
				redirect_to("admin_manage_users.php");
				
				echo $result;
			} else {
				// Display error message.
				$_SESSION["message"] = "User update failed.";
				redirect_to("admin_manage_users.php");
				
			}
			
		}

	
	else{
			//Validation failed
			
			$_SESSION["errors"]= $errors;
			
			
		}


}


//end form processing
?>


	<div class="row">
		
		<div class="col-md-12">
			<h1>Edit User</h1>
			<?php 
				if (isset($_SESSION["errors"])){
				?>
				
				<div class="bg-danger col-md-12">
				<?php $errors = errors();
				echo form_errors($errors); ?>
				
				</div>
				<?php
				} ?>
			<div class="col-md-6  col-md-offset-3">
			<form role="form" action="admin_edit_user.php?user_id=<?php echo $id; ?>" method="post">
				
			<input type="hidden" name = "user_id" value="<?php echo $user_array["id"]; ?>" >
			  <div class="form-group">
				<label for="first_name">Username</label>
				<input type="text" class="form-control required" name="username" id="username" value="<?php echo htmlentities($user_array["username"]); ?>">
			  </div>
			  <div class="form-group">
				<label for="last_name">Password</label>
				<input type="password" class="form-control" name="password" id="password">
			  </div>
			  
			  <div class="form-group">
				<label for="first_name">Email</label>
				<input type="text" class="form-control required" name="email" id="email" value="<?php echo htmlentities($user_array["email"]); ?>">
			  </div>
			  
			  
			  
			 
			  
			  <div class="form-group">
				<label for="public">Admin?<br />
				<input type="radio" name="admin" value="1" <?php if ($user_array["admin"]==1){echo "checked";} ?>> Yes <br />
				<input type="radio" name="admin" value="0" <?php if ($user_array["admin"]==0){echo "checked";} ?>> No</label>
			  </div>
			  
			  
			  
			  <div class="btn-group pull-right">
				<button type="submit" name="submit" class="btn btn-default btn-lg">Submit</button>
				<a href="admin_delete_user.php?user_id=<?php echo $id; ?>" class="btn btn-danger btn-lg deletebutton">Delete User</a>
			</div>
			</form>
			</div>

			
			</div>
			
			
			</div>			
		
	

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>