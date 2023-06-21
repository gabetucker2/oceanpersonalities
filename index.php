<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php" ?>
		
		<title>Ocean Personalities</title>
		<meta name = "description" content = "With 243 personality types, <b>Ocean Personalities</b> aims to be the most valid, reliable, and detailed type-based personality test."/>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
				
				<h2 style = "margin-bottom: -2vh; color: #083651;">Welcome to</h2>
				<img src = "Images/BlackLogo.png" style = "height: 25vh; margin: -18vh -2vw;" onDragStart = "return false;" class = "logo" name = "logo689" onClick = "RotateLogo(689)" />
				<h1 style = "text-shadow: none; margin: 0vh -2.75vw -10vh 0vw; color: #083651;">cean Personalities</h1>
				<h2 style = "color: #083651; margin: <?PHP if($userID == -1) { echo "10vh"; } else { echo "8vh"; } ?> 0vw -3.5vh; font-size: <?PHP if ($userID == -1) { echo "2.25"; } else { echo "3.5"; } ?>vw;"><?PHP if($userID == -1) { echo "Log in below!"; } else { echo $userFirstName; } ?></h2>
				
				<br/>
				<br/>
				
				<div class = "tinyLine"></div>
				
				<a href = "info.php" class = "linkButton centerParagraph">learn about the OTI</a><br/>
				
				<a href = "stats.php" class = "linkButton centerParagraph">view our public statistics</a><br/>
				
				<a href = "types.php" class = "linkButton centerParagraph">search for an OTI type</a><br/>
				
				<?PHP require "Prefabs/prefab_relevantOption.php"; ?>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
