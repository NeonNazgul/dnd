<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>D&amp;D Character Record</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	
	<link href="css/custom.css" media="all" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
		<script type="text/javascript">
		<!--
		(function() {
			if ("-ms-user-select" in document.documentElement.style && navigator.userAgent.match(/IEMobile\/10\.0/)) {
				var msViewportStyle = document.createElement("style");
				msViewportStyle.appendChild(
					document.createTextNode("@-ms-viewport{width:auto!important}")
				);
				document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
			}
		})();
		//-->
		</script>
  </head>
  <body>
  
  <div class="container">
	<div class="row" id="header">
		<div class="col-md-9"><a href="index.php"><img src="images/header.jpg" class="img-responsive" /></a></div>
		<div class="col-md-3">
		<?php 
			if (is_loggedin()){ ?>
				
				<div class="well" id="userpanel">
				<h4>Logged in as: <?php echo htmlentities($_SESSION["username"]); ?></h4>
				<p><a href="my_characters.php">My Characters</a> <?php if (is_admin()){ ?>| <a href="admin.php">Admin</a><?php } ?> | <a href="user_change_password.php">Change Password</a></p>
				
				
				
				<a class="btn btn-sm btn-default pull-right" href="logout.php">Logout</a>
				<br clear="all" />
				</div>
			
			<?php }
			else {
		
		?>
			<?php if (!$page_register){ ?>
				<h3>Login <small><a href="register.php">or Register</a></small></h3>
					<form role="form" action="login.php" method="post">
					  <div class="form-group">
						
						<input type="text" class="form-control" id="username" name="username" placeholder="Username">
					  </div>
					  <div class="form-group">
					
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					  </div>
					 
					  <button type="submit"  name="submit" class="btn btn-default pull-right">Submit</button>
					</form>
					<?php } ?>
			
			<?php } ?>

		</div>
	</div>