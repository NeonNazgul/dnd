<?php require_once ('../includes/initialize.php'); ?>

<?php 
	// Set any page-specific variables before the header
		$upload_errors = array(
				// http://www.php.net/manual/en/features.file-upload.errors.php
				UPLOAD_ERR_OK 			=> "No errors.",
				UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
			  	UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
			  	UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
			  	UPLOAD_ERR_NO_FILE 		=> "No file.",
			  	UPLOAD_ERR_NO_TMP_DIR	=> "No temporary directory.",
			  	UPLOAD_ERR_CANT_WRITE 	=> "Can't write to disk.",
			  	UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
			);
	
	
?>
<?php include_once ('../includes/header.php'); ?>

<?php 

	if (!is_loggedin()){
		$_SESSION["message"] = "You must be logged in to edit a character.";
		redirect_to("index.php");
	}
	
	
	$id = (int)$_GET["id"];
	$character_array = find_character($id);
	
	
		
		//Detect form submission
	if(isset($_POST["submit"])){

		
		//perform validations
		$required_fields = array();
		validate_presences($required_fields);
		

		if(!getimagesize($_FILES['file_upload']['tmp_name'])){
		   $errors["image"] = "Not an image.";
		}
		
		//validation passed
		if(empty($errors)){

				//set variables
				$char_id = (int)$character_array["id"];
				$user_id = (int)$character_array["user_id"];

				//process file upload
				$tmp_file = $_FILES['file_upload']['tmp_name'];
				$original = basename($_FILES['file_upload']['name']);
				$ext = end(explode(".", $original));
				$target_file = "portrait.{$ext}";

				if (!is_dir("images/{$user_id}/{$char_id}")) {
 				   		mkdir("images/{$user_id}");
						mkdir("images/{$user_id}/{$char_id}");
					}

				
				$upload_dir = "images/{$user_id}/{$char_id}";
				if(move_uploaded_file($tmp_file, $upload_dir."/".$target_file)){
					$message = "File uploaded successfully";
					$portrait_path = $upload_dir . "/". $target_file;
					//construct query
					$query = "UPDATE characters SET ";
					$query .= "portrait_path = '{$portrait_path}', ";
					$query .= "portrait = 1 ";
					$query .= "WHERE id={$char_id} ";
					
					$result = mysqli_query($connection, $query);
					if ($result) {
						// Success!
						$_SESSION["message"] = "Portrait Added.";
						redirect_to("character.php?character=$id");
						
						echo $result;
					} else {
						// Display error message.
						$_SESSION["message"] = "Portrait not added. " . mysqli_error($connection);
						
					}


				} else {
					$error = $_FILES['file_upload']['error'];
					$message = $upload_errors[$error];
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
		
			<h1>Add Portrait: <a href="character.php?character=<?php echo urlencode($id) ; ?>"><?php echo htmlentities($character_array["firstname"]) . " " . htmlentities($character_array["lastname"]) ?></a></h1>
			
			<?php include('../includes/errors.php'); ?>
			<?php include('../includes/messages.php'); ?>
			
			<?php 
				$player = find_user_by_id($character_array["user_id"]); 
				$user = $_SESSION["username"];
				//if user is not admin	
				if (!is_admin()){
					//check to see if this character is owned by user
					  if (!is_my_character($user, $player["username"])){
						// User does not own character, redirect  
						redirect_to("characters.php");
						}
					 }
				
				
				?>
				
					<form action="character_add_portrait.php?id=<?php echo $id; ?>" enctype="multipart/form-data" method="post" role="form">
						<div class="form-group">
							<label for="file_upload">Please select file (.jpg, .gif, .png or .bmp formats only)</label>
							<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
							<input type="file" name="file_upload" />
						</div>
						<input type="submit" class="btn btn-submit" name="submit" value="upload" />	
					</form>

			
			
			
		</div>
	</div>
	

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>