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
$char_id = $character["id"];
$portrait_path = $character["portrait_path"];
$query = "UPDATE characters SET ";
$query .= "portrait_path = '', ";
$query .= "portrait = 0 ";
$query .= "WHERE id={$char_id} LIMIT 1";
$result = mysqli_query($connection, $query);

if ($result && mysqli_affected_rows($connection) == 1){
	//Success
	$_SESSION["message"] = "Portrait Deleted";
	unlink($portrait_path);
	redirect_to("character.php?character={$char_id}");
}
else {
	//Failure
	$_SESSION["message"] = "Deletion Failed";
	redirect_to("character.php?character={$char_id}");
}




?>