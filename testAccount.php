<!DOCTYPE HTML>
<html>
	<head>
		
		<?PHP require "Prefabs/prefab_core.php" ?>
		
		<title>Ocean - Consider This</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
			
				<h1 class = "warning" style = "margin-top: -2vh;">BEFORE YOU PROCEED</h1>
				
				<br/><br/>
				
				<p class = "centerParagraph subEmphasize">
					Please consider taking a moment to create an account if you would like to save your results.<br/><br/>To ensure our findings are valid and for the purpose of collecting data, we rely heavily on the data our users provide to learn more about our many personality types.<br/><br/>We would be grateful if you were to create an account before taking the test so that we can learn from your responses and show you your unique statistics on <span class = "emphasize warning">Ocean Personalities</span>, although we acknowledge that your time is important and that you should have the ability to decide whether to create an account before taking the test.
				</p>
				
				<p class = "centerParagraph"><a href = "test.php" class = "linkButton warning subEmphasize">Proceed to Test</a></p>

				<?PHP require "Prefabs/prefab_signUpLogIn.php"; ?>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
