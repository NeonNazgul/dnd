<?php require_once ('../includes/initialize.php'); ?>
<?php include_once ('../includes/header.php'); ?>

<?php include('../includes/errors.php'); ?>
<?php include('../includes/messages.php'); ?>

	<div class="row">
		<div class="col-md-12">
			<h1>Welcome <?php if (is_loggedin()) {echo htmlentities($_SESSION["username"]);} ?></h1>

				
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tincidunt est at ligula sollicitudin, ac hendrerit nulla posuere.
                Maecenas eu risus tortor. Proin dictum imperdiet dolor, vel molestie felis varius vel. Cras mollis volutpat semper. Curabitur nisl diam,
                laoreet id adipiscing non, gravida non massa. </p>
				
				 <p>Cras auctor sed ipsum a consectetur. Donec condimentum mattis massa, ut molestie sapien hendrerit eget. Nam in dapibus augue.
                Maecenas vestibulum egestas fermentum. Vestibulum condimentum elit rhoncus arcu sollicitudin sollicitudin vel a nunc. Vestibulum ac
                iaculis nibh.</p>
		</div>
	</div>
	

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>