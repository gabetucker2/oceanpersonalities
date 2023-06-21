<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Surveys</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_scrollLabel.php"; ?>
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
				
				<h1 style = "margin: -4vh 0vw -1vh; font-size: 2vw;">SURVEY NAVIGATOR</h1>
				
				<div class = "tinyLine"></div>
				
				<?PHP
					
					echo '<p class = "centerParagraph">Below is a list of available surveys for you to take.<br/><br/>Please start by taking <span class = "emphasize">DEMOGRAPHICS GENERAL</span>!  Then you may take the remaining surveys in any order you like.  The more surveys you take, the greater your contribution will be to our project.  Your responses will be kept anonymous.<br/><br/>We thank you for your assistance, and we will carefully consider all information you provide us for making improvements.  And as always, if you have any objections, you may reach out to us at the email provided in the footer.  Good luck!<p>';
					
					require "Handlers/handler_getSortedSurveyArrs.php";
					
					echo '<h2 style = "margin-bottom: 0;">Incomplete</h2>';
					
					$isCalled = false;
					
					for($i = 0; $i < count($incompleteStrings); $i++)
					{
						$isCalled = true;
						
						echo $incompleteStrings[$i] . '<br/>';
					}
					
					if($isCalled == false)
					{
						echo '<p class = "subEmphasize">NONE</p>';
					}
					
					echo '<h2 style = "margin-bottom: 0;">Complete</h2>';
					
					$isCalled = false;
					
					for($i = 0; $i < count($completeStrings); $i++)
					{
						$isCalled = true;
						
						echo $completeStrings[$i] . '<br/>';
					}
					
					if($isCalled == false)
					{
						echo '<p class = "subEmphasize">NONE</p>';
					}
					
				?>
				
				<div class = "line"></div>
				
				<a href = "profile.php" class = "linkButton">Return to profile</a>
				
				<br/><br/><br/><br/>

				<?PHP require "Prefabs/prefab_footer.php"; ?>

			</div>
			
		</div>
		
	</body>

</html>
