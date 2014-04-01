<?php require_once ('../includes/initialize.php'); ?>

<?php

$id = $_SESSION["user_id"];
$query = "UPDATE users SET token = '' WHERE id = '{$id}' LIMIT 1";
mysqli_query($connection, $query);

$_SESSION = array();
if (isset($_COOKIE[session_name()])){
	setcookie(session_name(), '', time()-42000, '/');
	
}
setcookie("token", "", time()-42000);
session_destroy();
mysqli_close($connection);
redirect_to("index.php");


?>