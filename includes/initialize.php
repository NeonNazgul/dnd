<?php 


// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', DS.'Users'.DS.'kevinblades'.DS.'Sites'.DS.'dnd');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');


//Load site contstants
require_once('../../global/constants_dnd.php');

//load database connection
require_once (LIB_PATH.DS.'db_connect.php');

//load core functions
require_once (LIB_PATH.DS.'functions.php');

//load session 
require_once (LIB_PATH.DS.'session.php'); 

//load form validation functions
require_once (LIB_PATH.DS.'validation_functions.php'); 

//load PHPMailer Classes

require_once(LIB_PATH.DS."PHPMailer/class.phpmailer.php"); 
require_once(LIB_PATH.DS."PHPMailer/class.smtp.php"); 

?>