<?php
//Functions Include
ob_start();
//Calculate the stat modifier
function stat_modifier($base_stat){
				$modifier=-5;
				for ($i=1; $i<$base_stat; $i++){
						if ($i % 2 == 0) {
							// Number is even, go back to loop;
							} else{
							//Add 1 to $modifier
							$modifier = ($modifier+1);						
							}
					}
				return $modifier;
	
			}

// Calculate level by XP
function getLevel($xp){
			if ($xp >= 190000){
				return 20;
			}
			else if ($xp >= 171000){
				return 19;
			} 
			else if ($xp >= 153000){
				return 18;
			} 
			else if ($xp >= 136000){
				return 17;
			} 
			else if ($xp >= 120000){
				return 16;
			} 
			else if ($xp >= 105000){
				return 15;
			} 
			else if ($xp >= 91000){
				return 14;
			}
			else if ($xp >= 78000){
				return 13;
			}  
			else if ($xp >= 66000){
				return 12;
			} 
			else if ($xp >= 55000){
				return 11;
			} 
			else if ($xp >= 45000){
				return 10;
			} 
			else if ($xp >= 36000){
				return 9;
			} 
			else if ($xp >= 28000){
				return 8;
			} 
			else if ($xp >= 21000){
				return 7;
			} 
			else if ($xp >= 15000){
				return 6;
			} 
			else if ($xp >= 10000){
				return 5;
			} 
			else if ($xp >= 6000){
				return 4;
			} 
			else if ($xp >= 3000){
				return 3;
			} 
			else if ($xp >= 1000){
				return 2;
			} 
			else if ($xp < 1000){
				return 1;
			}			
		}


# recursively remove a directory
function rrmdir($dir) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
    rmdir($dir);
}
			
function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
	
function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}			
			
function confirm_query($result_set){
	if (!$result_set) {
		//die("Query failed.");
		return false;
	}
}

function find_all_characters(){
	global $connection;
	$query = "SELECT * FROM characters ORDER BY user_id ASC ";
	$character_set = mysqli_query($connection, $query);
	confirm_query($character_set);
	return $character_set;
}

function find_all_public_characters(){
	global $connection;
	$query = "SELECT * FROM characters ";
	$query .= "WHERE visible = 1 ORDER BY firstname ASC ";
	$character_set = mysqli_query($connection, $query);
	confirm_query($character_set);
	return $character_set;
}

function find_characters_for_user($id){
global $connection;

$safe_user_id = mysqli_real_escape_string($connection, $id);
$query = "SELECT * FROM characters ";
$query .= "WHERE user_id= {$safe_user_id} ORDER BY firstname ASC ";
$character_set = mysqli_query($connection, $query);
confirm_query($character_set);
return $character_set;

	}

function find_character($id){
global $connection;

$safe_character_id = mysqli_real_escape_string($connection, $id);
$query = "SELECT * FROM characters ";
$query .= "WHERE id= {$safe_character_id}";
$character_set = mysqli_query($connection, $query);
confirm_query($character_set);
if ($character_array = mysqli_fetch_assoc($character_set)){
		return $character_array;
	}
	else {return null;}

	}

function find_stats_for_character($char_id){
	global $connection;
	$safe_char_id = mysqli_real_escape_string($connection, $char_id);
	$query = "SELECT * FROM stats ";
	$query .= "WHERE char_id = {$safe_char_id} ";
	$stat_set = mysqli_query($connection, $query);
	confirm_query($stat_set);
	return $stat_set;
}

function find_all_users(){
	global $connection;
	$query = "SELECT * FROM users ";
	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);
	return $user_set;
}

function find_user_by_id($userid){
	global $connection;
	$safe_userid = mysqli_real_escape_string($connection, $userid);
	$query = "SELECT * FROM users WHERE id = {$safe_userid} LIMIT 1";
	$userset = mysqli_query($connection, $query);
	confirm_query($userset);
	if ($user_array = mysqli_fetch_assoc($userset)){
		return $user_array;
	}
	else {return null;}

	}

function find_user_by_username($username){
	global $connection;
	$safe_username = mysqli_real_escape_string($connection, $username);
	$query = "SELECT * FROM users WHERE username = '{$safe_username}' LIMIT 1";
	$userset = mysqli_query($connection, $query);
	confirm_query($userset);
	if ($user_array = mysqli_fetch_assoc($userset)){
		return $user_array;
	}
	else {return null;}

	}
	
function form_errors($errors=array()){
	$output="";
	if(!empty($errors)){

	$output .="<p class=\"text-danger\">Please fix the following errors:</p>";
	$output .="<ul class=\"text-danger\">";
	foreach ($errors as $key => $error){
			$output.="<li>{$error}</li>";
		}
	$output.="</li>";
	}
	return $output;
}

function password_encrypt($password){
	$hash_format = "$2y$10$"; //Use Blowfish with a cost of 10
	$salt_length = 22; //Blowfish salts should be 22 chars or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

function generate_salt($length){
	$unique_random_string = md5(uniqid(mt_rand(), true));
	$base64_string = base64_encode($unique_random_string);
	$modified_base64_string = str_replace('+', '.', $base64_string);
	$salt = substr($modified_base64_string, 0, $length);
	return $salt;
}

function password_check($password, $existing_hash){
	$hash = crypt($password, $existing_hash);
	if($hash===$existing_hash){
		return true;
	} else {
		return false;
	}
}

function attempt_login($username, $password){
	$user = find_user_by_username($username);
	if ($user){
		//Found user, check password
		if (password_check($password, $user["hashed_password"])){
			//password matches
			return $user;
		} else {
			//password does not match
			return false; 
		}
	} else {
		//User not found
		return false;
	}
}

function is_loggedin(){
	//Check for active user_id in session
	if (isset($_SESSION["user_id"])){
		return true;
	}

//No session, check for "remember me" cookie token 
	else if (isset($_COOKIE["token"])){
			global $connection;
			$cookie_token = $_COOKIE["token"];
			$query = "SELECT * FROM users WHERE token = '{$cookie_token}' LIMIT 1";
			$user_set = mysqli_query($connection, $query);
			confirm_query($user_set);
			
			if (!$user_set){return false;} else {
				//Try to assign user to session
				$user_array = mysqli_fetch_assoc($user_set);

				//Fix cookie sync bug where query can return valid but not find a user
				//If username is blank string, delete cookie, destroy session and refresh login
				if ($user_array["username"] == ""){
						setcookie("token", "", time()-42000);
						session_destroy();
						mysqli_close($connection);
						redirect_to("index.php");
					}

				$_SESSION["user_id"] = $user_array["id"];
				$_SESSION["username"] = $user_array["username"];
				$_SESSION["admin"] = (int)$user_array["admin"];

				
				//Generate a new token and store it in the database as well as cookie
				//This add security by making cookies stored on other browsers invalid
						$username=$user_array["username"];
						$user_id = (int)$user_array["id"];
						$token = password_encrypt($username);
						setcookie("token", $token, time()+(60*60*24*7));
						$query = "UPDATE users SET ";
						$query .= "token = '{$token}' ";
						$query .= "WHERE id={$user_id} ";
						$query .="LIMIT 1";
						$result = mysqli_query($connection, $query);
							if ($result) {
								// token set
								
							} else {
								// token not set
								
								}
							}

				return true;
			}
		
	else {
	 	return false;
	 }
}

function is_admin(){
	return $_SESSION["admin"];
	}

function is_my_character($user_id, $character_id){
	if ($user_id == $character_id){
		return true;
	} else {
		return false;
	}
}	
?>