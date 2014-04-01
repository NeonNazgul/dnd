<?php require_once ('../includes/initialize.php'); ?>
<?php if (!is_admin()){	redirect_to("index.php");}?>

<?php require_once ('../includes/header.php'); ?>

<div class="row marginbottom10">
	<div class="col-md-12">
		<h1>Admin</h1>
		<?php include_once('../includes/admin_toolbar.php'); ?>
		

		
	</div>
</div>









	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>