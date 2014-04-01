<?php require_once ('../includes/initialize.php'); ?>

<?php 
	// Set any page-specific variables before the header

	//$form = true; //marks this page as a form so the footer will load the validation javascript 

?>

<?php include_once ('../includes/header.php'); ?>
<?php 
	if (!is_loggedin()){
		$_SESSION["message"] = "You must be logged in to add a character.";
		redirect_to("index.php");
	}
?>
	<div class="row">
		
		<div class="col-md-12">
			<h1>New Character</h1>
			<?php include('../includes/errors.php'); ?>
			<?php include('../includes/messages.php'); ?>
			<?php $user_id = (int)$_SESSION["user_id"];?>
			<form role="form" action="new_character_processing.php" method="post">
				<input type="hidden" name="userid" value="<?php echo $user_id; ?>" >
				<div class="row">
			  <div class="form-group col-md-3">
				<label for="first_name">First Name</label>
				<input type="text" class="form-control required" name="first_name" id="first_name" placeholder="First Name">
			  </div>
			  <div class="form-group col-md-3">
				<label for="last_name">Last Name</label>
				<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
			  </div>
			  <div class="form-group col-md-3">
			  <label for="class">Class</label>
				  <select class="form-control" id="class" name="class">
				  <option value="Barbarian">Barbarian</option>
				  <option value="Bard">Bard</option>
				  <option value="Cleric">Cleric</option>
				  <option value="Druid">Druid</option>
				  <option value="Fighter">Fighter</option>
				  <option value="Monk">Monk</option>
				  <option value="Paladin">Paladin</option>
				  <option value="Ranger">Ranger</option>
				  <option value="Rogue">Rogue</option>
				  <option value="Sorcerer">Sorcerer</option>
				  <option value="Wizard">Wizard</option>
				 </select>
			  </div>
			  
			  <div class="form-group col-md-3">
			  <label for="race">Race</label>
				  <select class="form-control" id="race" name="race">
				  <option value="Human">Human</option>
				  <option value="Dwarf">Dwarf</option>
				  <option value="Elf">Elf</option>
				  <option value="Gnome">Gnome</option>
				  <option value="Half-elf">Half-elf</option>
				  <option value="Half-orc">Half-orc</option>
				  <option value="Halfling">Halfling</option>
				  
				 </select>
			  </div>
			  </div>
			  <div class="row">
			  <div class="form-group col-md-3">
				<label for="gender">Gender</label>
				<input type="text" class="form-control" name="gender" id="gender" placeholder="Gender">
			  </div>
			  
			  <div class="form-group col-md-3">
			  <label for="alignment">Alignment</label>
				  <select class="form-control" id="alignment" name="alignment">
				  <option value="True Neutral">True Neutral</option>
				  <option value="Neutral Good">Neutral Good</option>
				  <option value="Neutral Evil">Neutral Evil</option>
				  <option value="Lawful Neutral">Lawful Neutral</option>
				  <option value="Lawful Good">Lawful Good</option>
				  <option value="Lawful Evil">Lawful Evil</option>
				  <option value="Chaotic Neutral">Chaotic Neutral</option>
				  <option value="Chaotic Good">Chaotic Good</option>
				  <option value="Chaotic Evil">Chaotic Evil</option>
				  
				 </select>
			  </div>
			  </div>
			   <div class="form-group">
				<label for="notes">General Notes</label>
				<textarea class="form-control" id="notes" name="notes" "placeholder="Notes" rows="5"></textarea>
			  </div>
			  <div class="form-group">
				<label for="public">Would you like this character to be visible to the public?<br />
				<input type="radio" name="visible" value="1" checked> Yes <br />
				<input type="radio" name="visible" value="0"> No</label>
			  </div>
			  
			  
			  
			  <button type="submit" name="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
			</form>

			
			
			</div>			
		</div>

	

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>