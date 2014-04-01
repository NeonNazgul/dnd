<?
// *** The CAPTCHA comparison - http://frikk.tk ***
// *** further modifications - http://www.captcha.biz ***

session_start();

// *** We need to make sure theyre coming from a posted form -
//	If not, quit now ***
if ($_SERVER["REQUEST_METHOD"] <> "POST")
	die("You can only reach this page by posting from the html form");

// *** The text input will come in through the variable $_POST["captcha_input"],
//	while the correct answer is stored in the cookie $_COOKIE["pass"] ***
if ($_POST["captcha_input"] == $_SESSION["pass"])
{
	// *** They passed the test! ***
	// *** This is where you would post a comment to your database, etc ***
	

	?>
	
	
	
	
	
<?php include('header.inc.php'); ?>
        <div class="row"><!-- begin main row-->   


        <div class="span12">
          
          	
	
	
	
	
	
	
	
	
	
	
	<?php
	
	echo "<p>Thank you!</p>";
       echo "Your message has been sent. We will reply ASAP.";

//sends email via php to the following address
$mailuser = "kevin@thebestmedia.com";
$sentfrom="form@thebestmedia.com";
$headers .= "X-Priority: 3\n";
	$headers .= "X-MSMail-Priority: Normal\n";
$header = "Return-Path: ".$sentfrom."\r\n";
 $header .= "From: TheBestMedia.com Form <".$sentfrom.">\r\n";
  $header .= "Content-Type: text/html;";
  $mail_body = '	Name: '. $_POST[name] . '<br>	Email: '. $_POST[email] . '<br>Phone: '. $_POST[telephone] . '<br />Comments: '. $_POST[comments] . '<br>'	;
  mail ($mailuser, 'Form sent', $mail_body, $header);
  mail ("roberto@thebestmedia.com", 'Form sent', $mail_body, $header);
 mail ("david@thebestmedia.com", 'Form sent', $mail_body, $header);
     
  ?>
   </div>

       </div><!-- end main row -->
        
    <?php include('portfolio.inc.php'); ?>
    <?php include('menu.inc.php'); ?>

      
      
      
        </div><!--/menu div -->
       </div><!--/menu row -->
<?php include('footer.inc.php'); ?>
<?php

} else {
	// *** The input text did not match the stored text, so they failed ***
	// *** You would probably not want to include the correct answer, but
	//	unless someone is trying on purpose to circumvent you specifically,
	//	its not a big deal.  If someone is trying to circumvent you, then
	//	you should probably use a more secure way besides storing the
	//	info in a cookie that always has the same name! :) ***
	
?>


<?php include('header.inc.php'); ?>
        <div class="row"><!-- begin main row-->   


        <div class="span12">
          
          
          
          
       Captcha not correct, Please Try again.
          
          
          
          
          
          
          </div>

       </div><!-- end main row -->
        
    <?php include('portfolio.inc.php'); ?>
    <?php include('menu.inc.php'); ?>

      
      
      
        </div><!--/menu div -->
       </div><!--/menu row -->
<?php include('footer.inc.php'); ?>






<?php
}?>

