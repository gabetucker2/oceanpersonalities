<!DOCTYPE HTML>
<html>
	<head>
		
		<?PHP require "Prefabs/prefab_core.php" ?>
		
		<title>Ocean - Erroneous Answer</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
			
				<h1 class = "warning" style = "margin-top: -2vh;">ERRONEOUS ANSWERS DETECTED</h1>
				
				<p class = "centerParagraph subEmphasize">
					Unfortunately, we have determined the results you provided to be rushed or misleading.<br/><br/>We would permit this, but you were logged in while you provided these answers which means that we would have been recording erroneous information, in turn skewing the validity of our data.<br/><br/>Some things you could do if you retake the test are <span class = "emphasize warning">reading the questions closely</span>, <span class = "emphasize warning">carefully considering</span> how strongly you agree or disagree with the questions, <span class = "emphasize warning">answering consistently</span>, and <span class = "emphasize warning">not fence-sitting</span> (i.e., not having mostly weak answers).<br/><br/>If this was an honest misunderstanding, we thank you for your patience.
				</p>
				
				<br/>
				<br/>
				
				<p class = "centerParagraph"><a href = "test.php" class = "linkButton warning subEmphasize">Retake Test Carefully</a></p>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
