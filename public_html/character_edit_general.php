<?php require_once ('../includes/initialize.php'); ?>
<?php 
	// Set any page-specific variables before the header

	
	
?>
<?php include_once ('../includes/header.php'); ?>

<?php 

	if (!is_loggedin()){
		$_SESSION["message"] = "You must be logged in to edit a character.";
		redirect_to("index.php");
	}
	
	if (!isset($_GET["id"])){
		$_SESSION["message"] = "No character selected.";
		redirect_to("index.php");
	}
	
	
	$id = (int)$_GET["id"];
	$character_array = find_character($id);
	//start form processing
	
		
		//Detect form submission
	if(isset($_POST["submit"])){

		
		//perform validations
		$required_fields = array("first_name");
		validate_presences($required_fields);
		
		//validation passed
		if(empty($errors)){
				//set variables
				$user_id = (int)$character_array["user_id"];
				$firstname=mysql_prep(trim($_POST["first_name"]));
				$lastname=mysql_prep(trim($_POST["last_name"]));
				$class = $_POST["class"];
				$race = $_POST["race"];
				$gender = mysql_prep($_POST["gender"]);
				$alignment = $_POST["alignment"];
				$notes = mysql_prep($_POST["notes"]);
				$visible = mysql_prep((int)($_POST["visible"]));
				//construct query
				$query = "UPDATE characters SET ";
				$query .="firstname = '{$firstname}', ";
				$query .="lastname = '{$lastname}', ";
				$query .="class = '{$class}', ";
				$query .="race = '{$race}', ";
				$query .="gender = '{$gender}', ";
				$query .="alignment = '{$alignment}', ";
				$query .="notes = '{$notes}', ";
				$query .="visible = {$visible} ";
				$query .= "WHERE id={$id} ";
				$query .="LIMIT 1";
				$result = mysqli_query($connection, $query);
				if ($result) {
					// Success!
					$_SESSION["message"] = "Character Updated.";
					redirect_to("character.php?character=$id");
					
					echo $result;
				} else {
					// Display error message.
					$_SESSION["message"] = "Character update failed. " . mysqli_error();
					
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
		
			<h1>Edit General Info: <a href="character.php?character=<?php echo urlencode($id) ; ?>"><?php echo htmlentities($character_array["firstname"]) . " " . htmlentities($character_array["lastname"]) ?></a></h1>
			
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
			<form role="form" action="character_edit_general.php?id=<?php echo $id; ?>" method="post">
				<input type="hidden" name="userid" value="<?php echo htmlentities($character_array["user_id"]); ?>">

				<div class="row">
			  <div class="form-group col-md-3">
				<label for="first_name">First Name</label>
				<input type="text" class="form-control required" name="first_name" id="first_name" value="<?php echo htmlentities($character_array["firstname"]); ?>">
			  </div>
			  <div class="form-group col-md-3">
				<label for="last_name">Last Name</label>
				<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo htmlentities($character_array["lastname"]); ?>">
			  </div>
			  <div class="form-group col-md-3">
			  <label for="class">Class</label>
				  <select class="form-control" id="class" name="class">
				  <option <?if ($character_array["class"] === "Barbarian"){echo " selected";} ?> value="Barbarian">Barbarian</option>
				  <option <?if ($character_array["class"] === "Bard"){echo " selected";} ?> value="Bard">Bard</option>
				  <option <?if ($character_array["class"] === "Cleric"){echo " selected";} ?> value="Cleric">Cleric</option>
				  <option <?if ($character_array["class"] === "Druid"){echo " selected";} ?> value="Druid">Druid</option>
				  <option <?if ($character_array["class"] === "Fighter"){echo " selected";} ?> value="Fighter">Fighter</option>
				  <option <?if ($character_array["class"] === "Monk"){echo " selected";} ?> value="Monk">Monk</option>
				  <option <?if ($character_array["class"] === "Paladin"){echo " selected";} ?> value="Paladin">Paladin</option>
				  <option <?if ($character_array["class"] === "Ranger"){echo " selected";} ?> value="Ranger">Ranger</option>
				  <option <?if ($character_array["class"] === "Rogue"){echo " selected";} ?> value="Rogue">Rogue</option>
				  <option <?if ($character_array["class"] === "Sorcerer"){echo " selected";} ?> value="Sorcerer">Sorcerer</option>
				  <option <?if ($character_array["class"] === "Wizard"){echo " selected";} ?> value="Wizard">Wizard</option>
				 </select>
			  </div>
			  
			  <div class="form-group col-md-3">
			  <label for="race">Race</label>
				  <select class="form-control" id="race" name="race">
				  <option <?if ($character_array["race"] === "Human"){echo " selected";} ?> value="Human">Human</option>
				  <option <?if ($character_array["race"] === "Dwarf"){echo " selected";} ?> value="Dwarf">Dwarf</option>
				  <option <?if ($character_array["race"] === "Elf"){echo " selected";} ?> value="Elf">Elf</option>
				  <option <?if ($character_array["race"] === "Gnome"){echo " selected";} ?> value="Gnome">Gnome</option>
				  <option <?if ($character_array["race"] === "Half-elf"){echo " selected";} ?> value="Half-elf">Half-elf</option>
				  <option <?if ($character_array["race"] === "Half-orc"){echo " selected";} ?> value="Half-orc">Half-orc</option>
				  <option <?if ($character_array["race"] === "Halfling"){echo " selected";} ?> value="Halfling">Halfling</option>
				  
				 </select>
			  </div>
			  </div>
			  <div class="row">
			  <div class="form-group col-md-3">
				<label for="gender">Gender</label>
				<input type="text" class="form-control" name="gender" id="gender" value="<?php echo htmlentities($character_array["gender"]); ?>">
			  </div>
			  
			  <div class="form-group col-md-3">
			  <label for="alignment">Alignment</label>
				  <select class="form-control" id="alignment" name="alignment">
				  <option <?if ($character_array["alignment"] === "True Neutral"){echo " selected";} ?> value="True Neutral">True Neutral</option>
				  <option <?if ($character_array["alignment"] === "Neutral Good"){echo " selected";} ?> value="Neutral Good">Neutral Good</option>
				  <option <?if ($character_array["alignment"] === "Neutral Evil"){echo " selected";} ?> value="Neutral Evil">Neutral Evil</option>
				  <option <?if ($character_array["alignment"] === "Lawful Neutral"){echo " selected";} ?> value="Lawful Neutral">Lawful Neutral</option>
				  <option <?if ($character_array["alignment"] === "Lawful Good"){echo " selected";} ?> value="Lawful Good">Lawful Good</option>
				  <option <?if ($character_array["alignment"] === "Lawful Evil"){echo " selected";} ?> value="Lawful Evil">Lawful Evil</option>
				  <option <?if ($character_array["alignment"] === "Chaotic Neutral"){echo " selected";} ?> value="Chaotic Neutral">Chaotic Neutral</option>
				  <option <?if ($character_array["alignment"] === "Chaotic Good"){echo " selected";} ?> value="Chaotic Good">Chaotic Good</option>
				  <option <?if ($character_array["alignment"] === "Chaotic Evil"){echo " selected";} ?> value="Chaotic Evil">Chaotic Evil</option>
				  
				 </select>
			  </div>
			  </div>
			   <div class="form-group">
				<label for="notes">General Notes</label>
				<textarea class="form-control" id="notes" name="notes" rows="5"><?php echo htmlentities($character_array["notes"]); ?></textarea>
			  </div>
			  <div class="form-group">
				<label for="public">Would you like this character to be visible to the public?<br />
				<input type="radio" name="visible" value="1" <?php if ($character_array["visible"]==1){echo "checked";} ?> > Yes <br />
				<input type="radio" name="visible" value="0" <?php if ($character_array["visible"]==0){echo "checked";} ?>> No</label>
			  </div>
			  
			  
			  
			  <button type="submit" name="submit" class="btn btn-default btn-lg">Save</button>
			</form>

			
			
			
		</div>
	</div>
	

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>