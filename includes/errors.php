<?php 
if (isset($_SESSION["errors"])){
?>

<div class="alert alert-danger alert-dismissable col-md-6 col-md-offset-3">
<button type="button" class="close js" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php $errors = errors();
	echo form_errors($errors); ?>

</div>
<?php
} ?>