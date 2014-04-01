<?php require_once ('../includes/initialize.php'); ?>

<?	if (!is_loggedin()){
		$_SESSION["message"] = "Please log in.";
		redirect_to("index.php");
	} ?>

<?php require_once ('../includes/header.php'); ?>
<?php $id = $_SESSION["user_id"];?>
	<div class="row">
		<div class="col-md-12">
			<h1>My Characters</h1>
			
			<?php include('../includes/errors.php'); ?>
		<?php include('../includes/messages.php'); ?>
		
			</div>
	</div>

		

	<br />
		
			<?php 
				//Find characters query
				$character_set = find_characters_for_user($id);
				if (mysqli_num_rows($character_set) === 0) {echo "<center><h3>You have no characters.  Add some now</h3></center>";	}
				//Display $character_set
				while ($character = mysqli_fetch_assoc($character_set)){
					$player = find_user_by_id($character["user_id"]);
					
				?>
				<div class="col-md-3"><div class="well characters">
				<h3> <a href="character.php?character=<?php echo urlencode($character["id"]); ?>"><?php echo htmlentities($character["firstname"]) . " " . htmlentities($character["lastname"]); ?></a></h3>
				
				<h4><?php echo htmlentities($character["alignment"]) . " " . htmlentities($character["race"]) . " " . htmlentities($character["class"]); ?></h4>
				
				</div>
				</div>		
				<?php
				} //End while $character loop
				//Release $result
				
				mysqli_free_result($character_set);

			?>
			<div class="row">
				<div class="col-md-12">
				<?php if (is_loggedin()){ ?>
				<a class="btn btn-primary btn-large" href="new_character.php">Add New Character</a>
				<?php } ?>
					
				</div>
			</div>			
		
	
	

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>