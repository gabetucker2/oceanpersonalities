<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Sign Up</title>
		<meta name = "description" content = "Create an account."/>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php";?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>

				<?PHP $displayLoggingInText = false; ?>
					
					<?PHP
							
						$returnMessage = "";
						
						if(isset($_POST["signUpSubmit"]))
						{
							$localUsername = $_POST["localUsername"];
							$localFirstName = $_POST["localFirstName"];
							$localEmail = $_POST["localEmail"];
							$localPasswordInit = $_POST["localPasswordInit"];
							$localPasswordConf = $_POST["localPasswordConf"];
							
							$mainVars = array($localFirstName, $localUsername, $localEmail, $localPasswordInit, $localPasswordConf);
							$varStrings = array("first name", "username", "email", "initial password", "confirm password");
							
							for($i = 0; $i < count($mainVars); $i++)
							{
								if(empty($mainVars[$i]))
								{
									$returnMessage .= "Missing a valid " . $varStrings[$i] . " AND ";
								}
							}
							
							if(preg_match("/^[0-9]*$/", $localFirstName))
							{
								$returnMessage .= "Your first name may not have numbers AND ";
							}
							
							if(strlen($localUsername) < 2 && !empty($localFirstName))
							{
								$returnMessage .= "Your first name must have at least one character AND ";
							}
							
							if(!preg_match("/^[a-zA-Z0-9]*$/", $localUsername))//valid character check
							{
								$returnMessage .= "Invalid username character(s) AND ";
							}
							
							if(strlen($localUsername) < 3 && !empty($localUsername))
							{
								$returnMessage .= "Username is under 3 characters AND ";
							}
							
							if(!filter_var($localEmail, FILTER_VALIDATE_EMAIL) && !empty($localEmail))
							{
								$returnMessage .= "Email is invalid AND ";
							}
							
							if($localPasswordInit != $localPasswordConf)
							{
								$returnMessage .= "Passwords do not match AND ";
							}
							
							if($returnMessage == "")//if no error, proceed to considering the database
							{
								$SQL =
									"SELECT userUsername
									FROM users_general
									WHERE userUsername = '{$localUsername}';";
								
								if(!empty(mysqli_query($connection, $SQL)))//if would make a connection with database and userUsernames is not taken
								{
									$SQL =
										"SELECT userEmail
										FROM users_general
										WHERE userEmail = '{$localEmail}';";
									
									if(mysqli_num_rows(mysqli_query($connection, $SQL)) == 0)//if would make a connection with database and userEmail is not taken
									{
										$encryptedPassword = password_hash($localPasswordInit, PASSWORD_DEFAULT);
										
										$thisDateTime = 
										
										$SQL =
											"INSERT INTO users_general (userUsername, userFirstName, userEmail, userPassword, userAccountTime, OTI, userAdmin)
											VALUES ('{$localUsername}', '{$localFirstName}', '{$localEmail}', '{$encryptedPassword}', '" . date("Y-m-d H:i:s") . "', '{$zeros}', 0);";
										
										mysqli_query($connection, $SQL);
										
										$SQL =
											'SELECT *
											FROM users_general
											WHERE userID = ' . mysqli_insert_id($connection) . ';';
										
										$row = mysqli_fetch_assoc(mysqli_query($connection, $SQL));
										
										require "Handlers/handler_logIn.php";
										
										$returnMessage = "SUCCESS";
									}
									else
									{
										$returnMessage .= "Email already exists AND ";
									}
								}
								else
								{
									$returnMessage .= "Username already exists AND ";
								}
							}
							
							if($returnMessage == "SUCCESS")
							{
								echo '<script>window.location.href = "test.php";</script>';
								$displayLoggingInText = true;
							}
						}

						if ($displayLoggingInText) {
							echo '<h1>Signing you in...</h1>';
						} else {
							echo '
							<h1 style = "margin: -4vh 0vw 2vh; padding: 2vh 0vw; font-size: 2vw;">SIGN UP TO TAKE OUR TEST</h1>
							
							<div class = "formDiv" style = "margin-top: -1vh;">
							';

							if ($returnMessage != "") {
								echo '<p class = "emphasize warning" style = "padding: 0vh 2vw;">' . $returnMessage . ' just try again and you\'ll be all set!</p>';//error message
							}

							echo '
								<form method = "POST" style = "padding-bottom: 2vh;">
									
									<div class = "formMain">
										
										first name<br/><input type = "text" name = "localFirstName" placeholder = "..."/>
										<br/>
										username<br/><input type = "text" name = "localUsername" placeholder = "..."/>
										<br/>
										email<br/><input type = "text" name = "localEmail" placeholder = "..."/>
										<br/>
										type password twice<br/><input type = "password" name = "localPasswordInit" placeholder = "..."/>
										<br/>
										<input type = "password" name = "localPasswordConf" placeholder = "..."/>
										
									</div>
									
									<button type = "submit" name = "signUpSubmit" class = "button large">sign up</button>
									
								</form>
								
								<p style = "margin: -3vh 0vw -1vh;"><a href = "logIn.php" class = "linkButton subEmphasize">already have an account?</a></p>
								
							</div>
							';
						}
						
					?>
					
					<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
