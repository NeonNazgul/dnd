<?php require_once ('../includes/initialize.php'); ?>
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
	$referrer = $_SERVER['HTTP_REFERER'];
	$character_array = find_character($id);
	
	//start form processing
	
		
		//Detect form submission
	if(isset($_POST["submit"])){

		
		//perform validations
		//none required
		
		//validation passed
		if(empty($errors)){
				//set variables
				$char_id = (int)$_POST["char_id"];
				$strength = (int)$_POST["strength"];
				$dexterity = (int)$_POST["dexterity"];
				$constitution = (int)$_POST["constitution"];
				$intelligence = (int)$_POST["intelligence"];
				$wisdom = (int)$_POST["wisdom"];
				$charisma = (int)$_POST["charisma"];
				
				
				
				//construct query
				$query = "UPDATE stats SET ";
				$query .="str = {$strength}, ";
				$query .="dex = {$dexterity}, ";
				$query .="con = {$constitution}, ";
				$query .="intl = {$intelligence}, ";
				$query .="wis = {$wisdom}, ";
				$query .="cha = {$charisma} ";
				$query .= "WHERE char_id={$char_id} ";
				$query .="LIMIT 1";
				$result = mysqli_query($connection, $query);
				if ($result) {
					// Success!
					$_SESSION["message"] = "Character Updated.";
					redirect_to("character.php?character=$id");
										
				} else {
					// Display error message.
					$_SESSION["message"] = "Character update failed. " . mysqli_error($connection);
					
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
		
			<h1>Edit Character Stats: <a href="character.php?character=<?php echo urlencode($id) ; ?>"><?php echo htmlentities($character_array["firstname"]) . " " . htmlentities($character_array["lastname"]) ?></a></h1>
			
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
				
				$stat_set = find_stats_for_character($character_array["id"]);
				$stat_array = mysqli_fetch_assoc($stat_set);
			
				
				?>
			<form role="form" class="form-horizontal" action="character_edit_stats.php?id=<?php echo $id; ?>" method="post">
				<input type="hidden" name="char_id" value="<?php echo htmlentities($id); ?>">
				
				<div class="form-group">
					<label for="strength" class="col-sm-2 control-label">Strength:</label>
					<div class="col-sm-2">
						<div class="input-group">	
					  		<input type="text" class="form-control" id="strength" placeholder="STR" name="strength" value="<?php echo (int)$stat_array["str"]; ?>"> 
					  			<span class="input-group-addon">
					  				<span class="math add"><span class="glyphicon glyphicon-plus"></span></span> 
					  				<span class="math subtract"><span class="glyphicon glyphicon-minus"></span></span>
					  			</span>
						</div>
					</div>
				  </div>

				  <div class="form-group">
					<label for="dexterity" class="col-sm-2 control-label">Dexterity:</label>
					<div class="col-sm-2">
						<div class="input-group">
					  <input type="text" class="form-control" id="dexterity" placeholder="DEX" name="dexterity" value="<?php echo (int)$stat_array["dex"]; ?>">
					  	<span class="input-group-addon">
					  				<span class="math add"><span class="glyphicon glyphicon-plus"></span></span> 
					  				<span class="math subtract"><span class="glyphicon glyphicon-minus"></span></span>
					  			</span>
					  		</div>
					</div>
				  </div>

				  <div class="form-group">
					<label for="constitution" class="col-sm-2 control-label">Constitution:</label>
					<div class="col-sm-2">
					<div class="input-group">
					  <input type="text" class="form-control" id="constitution" placeholder="CON" name="constitution" value="<?php echo (int)$stat_array["con"]; ?>">
					  <span class="input-group-addon">
					  				<span class="math add"><span class="glyphicon glyphicon-plus"></span></span> 
					  				<span class="math subtract"><span class="glyphicon glyphicon-minus"></span></span>
					  			</span>
					</div>
					</div>
				  </div>
				   <div class="form-group">
					<label for="intelligence" class="col-sm-2 control-label">Intelligence:</label>
					<div class="col-sm-2">
						<div class="input-group">
					  	<input type="text" class="form-control" id="intelligence" placeholder="INT" name="intelligence" value="<?php echo (int)$stat_array["intl"]; ?>">
					  	<span class="input-group-addon">
					  				<span class="math add"><span class="glyphicon glyphicon-plus"></span></span> 
					  				<span class="math subtract"><span class="glyphicon glyphicon-minus"></span></span>
					  			</span>
						</div>
					</div>
				  </div>
				   <div class="form-group">
					<label for="wisdom" class="col-sm-2 control-label">Wisdom:</label>
					<div class="col-sm-2">
						<div class="input-group">
					  	<input type="text" class="form-control" id="wisdom" placeholder="WIS" name="wisdom" value="<?php echo (int)$stat_array["wis"]; ?>">
					  	<span class="input-group-addon">
					  				<span class="math add"><span class="glyphicon glyphicon-plus"></span></span> 
					  				<span class="math subtract"><span class="glyphicon glyphicon-minus"></span></span>
					  			</span>
						</div>
					</div>
				  </div>
				  <div class="form-group">
					<label for="charisma" class="col-sm-2 control-label">Charisma:</label>
					<div class="col-sm-2">
						<div class="input-group">
					  <input type="text" class="form-control" id="charisma" placeholder="CHA" name="charisma" value="<?php echo (int)$stat_array["cha"]; ?>">
					  <span class="input-group-addon">
					  				<span class="math add"><span class="glyphicon glyphicon-plus"></span></span> 
					  				<span class="math subtract"><span class="glyphicon glyphicon-minus"></span></span>
					  			</span>
					</div>
					</div>
				  </div>
				
			  
			  
			  <div class="form-group">
			  <button type="submit" name="submit" class="btn btn-default btn-lg">Save Stats</button>
			</div>
			</form>

			
			
			
		</div>
	</div>
	

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>