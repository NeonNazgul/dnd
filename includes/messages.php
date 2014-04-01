<?php 
if (isset($_SESSION["message"])){
?>

<div class="alert alert-success alert-dismissable">
<button type="button" class="close js" data-dismiss="alert" aria-hidden="true">&times;</button>

<p class="text-info"><?php echo htmlentities(message()); ?></p>
</div>
<?php
} ?>