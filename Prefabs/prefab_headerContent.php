<?PHP
	
	$thisRandomNumber = rand(1000, 5000);
	
	echo '<div id = "header" class = "snapPoint">';
	
	echo
		'<script>
			function ScrollUp()
			{
				let element = document.getElementById("prelude");
				element.scrollIntoView({behavior: "smooth", block: "start"});
			}
		</script>';
	
	echo
			'<ul>
				<li><img src = "Images/WhiteLogo.png" onDragStart = "return false;" class = "logo" name = "logo614" onClick = "RotateLogo(614)" /></li>';
				
				for($i = 0; $i < count($buttonNames); $i++)
				{
					$styleToAdd = "";
					
					if(($i == 0 && in_array($_SERVER["REQUEST_URI"], $startURLS)) || strpos($_SERVER["REQUEST_URI"], $buttonLinks[$i] . ".php"))//if current page is this url
					{
						$styleToAdd = ' style = "font-weight: bold;"';
					}
					
					echo '<li class = "clickable"><a href = "' . $buttonLinks[$i] . '.php"' . $styleToAdd . '>' . $buttonNames[$i] . '</a></li>';
				}
				
				$testPath = "";
				
				if($userID == -1)//if not logged in
				{
					$testPath = "testAccount.php";
				}
				else
				{
					$testPath = "test.php";
				}
				
				echo
				'<li class = "clickable" style = "float: right;"><a href = "' . $testPath . '" style = "font-weight: bold;">Take the Test</a></li>
				
				<li style = "float: right;" class = "dropdown">
					<img src = "Images/AccountIcon.png" class = "accountIcon" />
					
					<div class = "dropdownContent">
						<a class = "miscellaneousText">' . $logInText . '</a>';
						
						if($userUsername != "")
						{
							echo
								'<a href = "profile.php" class = "clickableText">View Profile</a>
								
								<form action = "" style = "float: right;" method = "POST">
									<button type = "submit" name = "logOutSubmit" class = "clickableText">Log Out</a>
								</form>';
						}
						else
						{
							echo
								'<a href = "logIn.php" class = "clickableText">Log In</a>
								<a href = "signUp.php" class = "clickableText">Sign Up</a>';
						}
						
						echo '
					</div>
				</li>
			</ul>
		</div>';
?>
