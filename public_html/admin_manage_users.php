<?php require_once ('../includes/initialize.php'); ?>
<?php if (!is_admin()){	redirect_to("index.php");}?>

<?php require_once ('../includes/header.php'); ?>

<div class="row marginbottom10">
	<div class="col-md-12">
		<h1>Admin - Manage Users</h1>
		<?php include_once('../includes/admin_toolbar.php'); ?>
		</div>
	</div>
		
			<?php include('../includes/errors.php'); ?>
			<?php include('../includes/messages.php'); ?>
			<div class="row">
				<div class="col-md-12">
			<ul class="list-group">
				<?php
					$user_set = find_all_users();
					while($user = mysqli_fetch_assoc($user_set)){
						?>
							
								<li class="list-group-item">User: <?php echo htmlentities($user["username"]); ?> | Email: <?php echo htmlentities($user["email"]);?> | Admin: <?php if ((int)$user["admin"]===1){echo "Yes";} else {echo "No";}  ?> | <a href="admin_edit_user.php?user_id=<?php echo urlencode($user['id']);?>"> Edit User</a></li>
						
					<? } //End while loop
						?>
			</ul>
			<a href="admin_add_user.php">Add User</a>
		</div>
	</div>
			
			
		
	










	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>