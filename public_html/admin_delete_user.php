<?php require_once ('../includes/initialize.php'); ?>

<?php 

if (!is_admin()){	redirect_to("index.php");}
$user = find_user_by_id($_GET["user_id"]);
if (!$user){
	//No valid user
	redirect_to("admin_manage_users.php");
}

$id = $user["id"];
$dir = "images/" . $id;
$query = "DELETE FROM users WHERE id = {$id} LIMIT 1";
$result = mysqli_query($connection, $query);

$query2 = "DELETE FROM characters WHERE user_id = {$id}";
$result2 = mysqli_query($connection, $query2);


if ($result && $result2){
	//Success
	$_SESSION["message"] = "User Deleted";
	mysqli_close($connection);
	rrmdir($dir);
	redirect_to("admin_manage_users.php");
}
else {
	//Failure
	$_SESSION["message"] = "Deletion Failed";
	mysqli_close($connection);
	redirect_to("admin_edit_user.php?id={$id}");
}




?>