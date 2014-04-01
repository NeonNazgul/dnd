<?php require_once ('../includes/initialize.php'); ?>

<?php 
	// Set any page-specific variables before the header also test editor yep indeedyweedy

	$form = true; //marks this page as a form so the footer will load the validation javascript 
	$page_register = true; // Identifies this as the Registration page

?>
<?php include_once ('../includes/header.php'); ?>


<div class="overlay"><img src="images/loading.gif" class="loading" /></div>
	<div class="row">
		
		<div class="col-md-12">
			
			<h1>Register</h1>
			<?php include('../includes/errors.php'); ?>
			<?php include('../includes/messages.php'); ?>
			<div class="col-md-6  col-md-offset-3">
			<form role="form" action="register_processing.php" id="register" method="post">
				
				
			  <div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control required" name="username" id="username" placeholder="Username">
			  </div>
			  <div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" name="password" id="password">
			  </div>
			  
			  <div class="form-group">
				<label for="email">Email</label>
				<input type="text" class="form-control required" name="email" id="email" placeholder="user@email.com">
			  </div>
			  <div class="form-group">
				<label for="captcha_input">Enter Captcha</label><br />
				
				<img src="captcha_image.php" /></br >
				<input type="text" class="form-control required" name="captcha_input" id="captcha_input">
				
			  </div>
			  
			  
			  
			
			  
			 
			  
			  
			  <button type="submit" name="submit" id="registersubmit" class="btn btn-default btn-lg btn-primary">Submit</button>
			</form>
			</div>
			</div>
			
			
			</div>			
		


	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>