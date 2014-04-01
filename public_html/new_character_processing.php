<?php require_once ('../includes/initialize.php'); ?>

<?php


//Detect form submission
if(isset($_POST["submit"])){

	
	//perform validations
	$required_fields = array("first_name");
	validate_presences($required_fields);
	
	//validation passed
	if(empty($errors)){
			//set variables
			$user_id = (int)$_POST["userid"];
			$firstname=mysql_prep(trim($_POST["first_name"]));
			$lastname=mysql_prep(trim($_POST["last_name"]));
			$class = $_POST["class"];
			$race = $_POST["race"];
			$gender = mysql_prep($_POST["gender"]);
			$alignment = $_POST["alignment"];
			$notes = mysql_prep($_POST["notes"]);
			$visible = mysql_prep((int)($_POST["visible"]));
			//construct query
			$query = "INSERT INTO characters ";
			$query .= "(user_id, visible, firstname, lastname, class, race, alignment, gender, notes, portrait, portrait_path) ";
			$query .= "VALUES ({$user_id}, {$visible}, '{$firstname}', '{$lastname}', '{$class}', '{$race}', '{$alignment}', '{$gender}', '{$notes}', 0, '')";
			
			$result = mysqli_query($connection, $query);
			$last_id = mysqli_insert_id($connection);
			if ($result) {
				// Success!
				$char_id = $last_id;
				mkdir("images/{$user_id}");
				mkdir("images/{$user_id}/{$char_id}");
				
				$_SESSION["message"] = "Character created.";
				
				$query = "INSERT INTO stats (char_id, str, dex, con, intl, wis, cha) VALUES ({$last_id}, 10, 10, 10, 10, 10, 10)";
				mysqli_query($connection, $query);
				
				mysqli_close($connection);
				redirect_to("character.php?character=$last_id");
				
				echo $result;
			} else {
				// Display error message.
				$_SESSION["message"] = "Character creation failed." . mysqli_error($connection);
				redirect_to("new_character.php");
			}
			
		}

	
	else{
			//Validation failed
			
			$_SESSION["errors"]= $errors;
			mysqli_close($connection);
			redirect_to("new_character.php");
			
		}


}

else {
echo "No data";
}

?>