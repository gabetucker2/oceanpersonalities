<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Log In</title>
		<meta name = "description" content = "Log into your account."/>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php";?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>

				<?PHP $displayLoggingInText = false; ?>
					
					<?PHP
							
						$returnMessage = "";
						
						if(isset($_POST["logInSubmit"]))
						{
							$localUsernameOrEmail = $_POST["usernameOrEmail"];
							$localPassword = $_POST["password"];
							
							$mainVars = array($localUsernameOrEmail, $localPassword);
							$varStrings = array("username or email", "password");
							
							for($i = 0; $i < count($mainVars); $i++)
							{
								if(empty($mainVars[$i]))
								{
									$returnMessage .= "Missing a valid " . $varStrings[$i] . " AND ";
								}
							}
							
							if($returnMessage == "")//if no error, proceed to considering the database
							{
								$SQL =
									"SELECT *
									FROM users_general
									WHERE userUsername = '{$localUsernameOrEmail}' OR userEmail = '{$localUsernameOrEmail}';";
								
								if($result = mysqli_query($connection, $SQL))
								{
									$row = mysqli_fetch_assoc($result) ?? null;
									if ($row != null) {
										$passwordCheck = password_verify($localPassword, $row["userPassword"]);//check password match

										if($row == null)
										{
											$returnMessage .= "Username or email not found AND ";
										}
										else if($passwordCheck == true)//if password match
										{
											$returnMessage = "SUCCESS";
											
											require "Handlers/handler_logIn.php";
										}
										else if($passwordCheck == false)
										{
											$returnMessage .= "We found your username or email but your password didn't match AND ";
										}
										else
										{
											$returnMessage .= "There was an error verifying your password AND ";
										}
									} else {
										$returnMessage .= "Error searching for your username or email AND ";
									}
								}
								else//never goes here for some reason
								{
									$returnMessage .= "Error searching for your username or email AND ";
								}
							}
							
							if($returnMessage == "SUCCESS")
							{
								echo '<script>window.location.href = "profile.php";</script>';
								$displayLoggingInText = true;
							}
						}

						if ($displayLoggingInText) {
							echo '<h1>Logging you in...</h1>';
						} else {
							
							echo '
								<h1 style = "margin: 2vh 0vw 2vh; padding: 2vh 0vw; font-size: 2vw;">LOG INTO YOUR ACCOUNT</h1>
								
								<div class = "formDiv" style = "margin-top: -1vh;">';

							if ($returnMessage != "") {
									echo '<p class = "emphasize warning" style = "padding: 0vh 2vw;">' . $returnMessage . ' if you keep having trouble, send an email to our support email in the footer!</p>';//error message
							}

							echo '
									<form method = "POST" style = "padding-bottom: 2vh; margin-top: 1vh;">
										
										<div class = "formMain">
											
											username/email<br/><input type = "text" name = "usernameOrEmail" placeholder = "..."/>
											<br/>
											password<br/><input type = "password" name = "password" placeholder = "..."/>
											
										</div>
										
										<button type = "submit" name = "logInSubmit" class = "button large">LOGIN</button>
									
									</form>
									
									<p style = "margin: -3vh 0vw -1vh;"><a href = "signUp.php" class = "linkButton subEmphasize">don\'t have an account?</a></p>
						
								</div>';
						}
						
					?>

				<br/><br/><br/><br/>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
