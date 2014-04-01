<?php require_once ('../includes/initialize.php'); ?>

<?php 

//user not logged in, redirect 
if (!is_loggedin()){
		$_SESSION["message"] = "You must be logged in to edit a character.";
		redirect_to("index.php");
	}


$character = find_character($_GET["id"]);
if (!$character){
	//No valid character
	redirect_to("characters.php");
}

$player = find_user_by_id($character["user_id"]); 
$user = $_SESSION["username"];
//if user is not admin	
if (!is_admin()){
	//check to see if this character is owned by user
	  if (!is_my_character($user, $player["username"])){
		// User does not own character, redirect 
		$_SESSION["message"] = "You do not have permission to delete this character";
		redirect_to("characters.php");
		}
	 }	 

//user is either admin or owns the character, attempt delete
$id = $character["id"];
$query = "DELETE FROM characters WHERE id = {$id} LIMIT 1";
$result = mysqli_query($connection, $query);

if ($result && mysqli_affected_rows($connection) == 1){
	//Success
	$_SESSION["message"] = "Character Deleted";
	redirect_to("characters.php");
}
else {
	//Failure
	$_SESSION["message"] = "Deletion Failed";
	redirect_to("character.php?id={$id}");
}




?>