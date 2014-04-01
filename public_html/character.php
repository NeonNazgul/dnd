<?php require_once ('../includes/initialize.php'); ?>

<?php include_once ('../includes/header.php'); ?>

<?if (isset($_GET["character"])){
	$id = $_GET["character"];

	}
	else{?>
	<div class="row">
		<div class="col-md-12">
			<h1 class="center">No Character Selected</h1>
			<p class="center"><a class="btn btn-warning" href="characters.php">Back to Character List</a></p>
		</div>
	</div>
	
	<?php
	include_once ('../includes/footer.php');
	exit;
	}
?>

	
		<div class="col-md-12">
			
			<?php include('../includes/errors.php'); ?>
			<?php include('../includes/messages.php'); ?>
				
			
			<?php 
				//Find characters query

				$character_array = find_character($id);
				if (!$character_array){?>
				<div class="row">
					<div class="col-md-12">
						<h1 class="center">Character Not Found</h1>
						<p class="center"><a class="btn btn-warning" href="characters.php">Back to Character List</a></p>
					</div>
				</div>
				
				<?php
				include_once ('../includes/footer.php');
				exit;
				}
			?>
			<div class="overlay"></div>
			<?php

				$visible = (int)$character_array["visible"];
				$player = find_user_by_id($character_array["user_id"]);
				$user = $_SESSION["username"];
				
				if (!$visible){
					if (!is_my_character($user, $player["username"])){
						if(!is_admin($user))
							{$_SESSION["message"] = "Character not public";
								redirect_to("characters.php");}
				}
				}
				
				if (is_my_character($user, $player["username"])){
					//echo "This is your character";
				}
				
				
				$stat_set = find_stats_for_character($character_array["id"]);
				$stat_array = mysqli_fetch_assoc($stat_set);
				
				//Set variables
							
				$str = (int)$stat_array["str"];
				$dex = (int)$stat_array["dex"];
				$con = (int)$stat_array["con"];
				$intl = (int)$stat_array["intl"];
				$wis = (int)$stat_array["wis"];
				$cha = (int)$stat_array["cha"];
				
				?><div class="page-header">
				
				
					

					<h5 class="sectionhead">General Info</h5>
					<div class="panel col-md-12" id="char_general_info">
						<div class="col-md-4 center-block text-center">
							<?php 
								if (!$character_array["portrait"]){

							?>

							<img class="img-responsive char_portrait" src="images/placeholder.jpg" />
							
									
								<?php 

							} 
								else {
								//echo "Has portrait: " . $character_array["portrait_path"];
								echo "<img class=\"img-responsive char_portrait\" src=\"{$character_array["portrait_path"]}\" />";
								}
							?>

						</div>
						<div class="col-md-8">
							<h1><?php echo htmlentities($character_array["firstname"]) . " " . htmlentities($character_array["lastname"]) 
				. "<span class=\"small\"> played by: " . htmlentities($player["username"]) . "</small>";?></h1>
							<h3>Race: <?php echo htmlentities($character_array["race"]); ?> <br /> 
								Class: <?php echo htmlentities($character_array["class"]) ?> <br />
								 Alignment: <?php echo htmlentities($character_array["alignment"]) ; ?>  <br />
								  Gender: <?php echo htmlentities($character_array["gender"]); ?></h3>
						</div>
					</div>
				
				
				</div>
				
				<div class="row" id="stats">
				<div class="stat col-md-5">
					<h5 class="sectionhead">Stats</h5>
					<table class="stat-table table table-striped table-bordered table-condensed table-responsive">
						<tbody>
							<tr>
								<td>Strength: <?php echo $str; ?></td><td>Modifier: <?php $modifier=stat_modifier($str);  if($modifier > 0){echo "+";}?><span class="modifier"><?php echo $modifier;  ?></span></td><td class="js center"><button name="<?php echo $modifier; ?>" class="statcheck btn btn-default btn-sm">Roll check</button></td>
							</tr>
							<tr>
								<td>Dexterity: <?php echo $dex; ?></td><td>Modifier: <?php $modifier=stat_modifier($dex);  if($modifier > 0){echo "+";}?><span class="modifier"><?php echo $modifier;  ?></span></td><td class="js center"><button name="<?php echo $modifier; ?>" class="statcheck btn btn-default btn-sm">Roll check</button></td>
							</tr>
							<tr>
								<td>Constitution: <?php echo $con; ?></td><td>Modifier: <?php $modifier=stat_modifier($con);  if($modifier > 0){echo "+";}?><span class="modifier"><?php echo $modifier;  ?></span></td><td class="js center"><button name="<?php echo $modifier; ?>" class="statcheck btn btn-default btn-sm">Roll check</button>
							</tr>
							<tr>
								<td>Intelligence: <?php echo $intl; ?></td><td>Modifier: <?php $modifier=stat_modifier($intl);  if($modifier > 0){echo "+";}?><span class="modifier"><?php echo $modifier;  ?></span></td><td class="js center"><button name="<?php echo $modifier; ?>" class="statcheck btn btn-default btn-sm">Roll check</button>
							</tr>
							<tr>
								<td>Wisdom: <?php echo $wis; ?></td><td>Modifier: <?php $modifier=stat_modifier($wis);  if($modifier > 0){echo "+";}?><span class="modifier"><?php echo $modifier;  ?></span></td><td class="js center"><button name="<?php echo $modifier; ?>" class="statcheck btn btn-default btn-sm">Roll check</button>
							</tr>
							<tr>
								<td>Charisma: <?php echo $cha; ?></td><td>Modifier: <?php $modifier=stat_modifier($cha);  if($modifier > 0){echo "+";}?><span class="modifier"><?php echo $modifier;  ?></span></td><td class="js center"><button name="<?php echo $modifier; ?>" class="statcheck btn btn-default btn-sm">Roll check</button>
							</tr>
							</tbody>
					</table>
					</div>
							<div class="modal">
								<button type="button" class="close" id="remove" aria-hidden="true">&times;</button>

								<div id="roll_result"> </div>
							</div>
						</div>
					<div id="notes" class="row">
						<div class="col-md-12">
							<h5 class="sectionhead">Notes</h5>
							<div class="well panel"><?php 
							$notes = nl2br(htmlentities($character_array["notes"]));
							echo ($notes); ?></div>
						</div>
					</div>
					<?php if (is_admin() || is_my_character($user, $player["username"])){ ?> 
					<h5 class="sectionhead">Toolbar</h5>
					<div class="btn-toolbar" role="toolbar" id="admin_toolbar">
						<div class="col-md-12">
							<div class="btn-group">
								<a class="btn btn-default" href="character_edit_general.php?id=<?php echo urlencode($character_array["id"]); ?>">Edit General Info &amp; Notes</a> 
								<?php if (!$character_array["portrait"]){?>
								<a class="btn btn-default" href="character_add_portrait.php?id=<?php echo urlencode($character_array["id"]); ?>">Add Portrait</a> 
								<?php } else { ?>
								<a class="btn btn-default deletebutton" href="character_delete_portrait.php?id=<?php echo urlencode($character_array["id"]); ?>">Delete Portrait</a> 
								<?php } ?>
								<a class="btn btn-default" href="character_edit_stats.php?id=<?php echo urlencode($character_array["id"]); ?>">Edit Stats</a> 
								<a class="btn btn-danger deletebutton"  href="character_delete.php?id=<?php echo urlencode($character_array["id"]); ?>">Delete Character</a>
							</div>
						</div>
					</div>
					<?php } ?>
				
				<?php

				
				//Release $results
				
				
				mysqli_free_result($stat_set);
				
				
			?>
						
		
	
	

	<?php include_once ('../includes/footer.php'); ?>
<?php 
	//Close database connection
	mysqli_close($connection);
?>