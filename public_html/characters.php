<?php require_once ('../includes/initialize.php'); ?>
<?php require_once ('../includes/header.php'); ?>

	<div class="row">
		<div class="col-md-12">
			<h1>Characters</h1>
			
			<?php include('../includes/errors.php'); ?>
		<?php include('../includes/messages.php'); ?>
		
			</div>
	</div>

		

	<br />
		
			<?php 
				//Find characters query
				$character_set = find_all_public_characters();
				//Display $character_set
				while ($character = mysqli_fetch_assoc($character_set)){
					$player = find_user_by_id($character["user_id"]);
				?>
				<div class="col-md-3"><div class="well characters">
				<h3> <a href="character.php?character=<?php echo urlencode($character["id"]); ?>"><?php echo htmlentities($character["firstname"]. " " . $character["lastname"]); ?></a></h3>
				 <p>Played by: <?php echo htmlentities($player["username"]); ?></p>
				<h4><?php echo htmlentities($character["race"]  . " " . $character["class"]); ?></h4>
				
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