<?php require_once ('../includes/initialize.php'); ?>

<?php if (!is_admin()){	redirect_to("index.php");}?>

<?php require_once ('../includes/header.php'); ?>

<div class="row marginbottom10">
	<div class="col-md-12">
		<h1>Admin - View All Characters</h1>
		<?php include_once('../includes/admin_toolbar.php'); ?>
		</div>
	</div>
		
			<?php include('../includes/errors.php'); ?>
			<?php include('../includes/messages.php'); ?>
			<div class="row">
				<div class="col-md-12">
			<ul class="list-group">
				<?php
					$character_set = find_all_characters();
					while($character = mysqli_fetch_assoc($character_set)){
						$player = find_user_by_id($character["user_id"]);
						?>
							
								<li class="list-group-item">
									<a href="character.php?character=<?php echo urlencode($character["id"]); ?>"><?php echo htmlentities($character["firstname"]. " " . $character["lastname"]); ?></a> | 
									User: <?php echo htmlentities($player["username"]);?>

								</li>
						
					<? } //End while loop
						?>
			</ul>
			
		</div>
	</div>
			
			
		
	










	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>