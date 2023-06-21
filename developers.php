<!DOCTYPE HTML>
<html>
	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Developers</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_scrollLabel.php"; ?>
				
				<a href = "info.php" class = "button"><<</a>
				
				<h1>DEVELOPERS</h1>

				<p class = "leftParagraph">
					Hello!  My name is Gabe Tucker, and as of right now, I'm the sole developer of Ocean Personalities.  I have not yet written a bio for this page, so for now, below is a picture of me, and feel free to visit me at my <a class = "linkButton" href = "https://gabetucker.com/">portfolio</a> or my <a class = "linkButton" href = "https://www.linkedin.com/in/gabriel-tucker-9a57b6152/">LinkedIn profile</a>!
					<br/>
				</p>

				<image src = "Images/Gabe.jpg" style = "width: 20vw;"/>
				
				<a href = "info.php" class = "button return"><<</a>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
