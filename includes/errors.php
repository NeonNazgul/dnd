<?php 
if (isset($_SESSION["errors"])){
?>

<div class="alert alert-danger alert-dismissable">
<button type="button" class="close js" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php $errors = errors();
	echo form_errors($errors); ?>

</div>
<?php
} ?>