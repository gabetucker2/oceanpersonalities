<!DOCTYPE HTML>
<html>
	<head>
		
		<?PHP require "Prefabs/prefab_core.php" ?>
		
		<title>Ocean - Information</title>
		<meta name = "description" content = "Learn about how the <b>Ocean Type Indicator</b> collects data, ensures validity, and furthers personality research."/>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_scrollLabel.php"; ?>
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
			
				<h1 style = "margin: -4vh 0vw -1vh; font-size: 2vw;">INFORMATION & MATERIALS</h1>
				
				<div class = "tinyLine"></div>
				
				<p class = "centerParagraph">
					The <span class = "emphasize">Ocean Type Indicator</span> is our measure for personality which aims to be the most valid, reliable, and specific type-based personality test.  The OTI is based off the Big Five Model–the most reputable and sound model among psychologists for measuring general personality.  There are five traits measured in this model:
				</p>
				
				<div class = "line"></div>
				
				<ul>
					<?PHP
						for($t = 0; $t < 5; $t++)
						{
							$traitName = $traitWords[$t];
							
							echo '<li class = "clickable" onMouseOver = "' . $oceanStyles[3][$t] . '" onMouseOut = "' . $noTextShadow . '" onMouseDown = "' . $clickTextShadow . '"><a href = "traitDefine.php?' . $traitName . '&previousPage=info.php">' . $traitName . '</a></li>';
						}
					?>
				</ul>
				
				<div class = "line"></div>
				
				<h2>Abstract</h2>
				
				<p class = "leftParagraph">
					
					There are already many tests that measure the Big Five traits, but what this test does differently is categorize them into different personality types so that it is possible to make complex inferences based on interactions between these traits.
					</br></br>The OTI consists of 243 personality types.  If we simplify each of the Big Five personality traits into 3 possible levels (low, medium, and high) and combine these 5 traits into every possible unique combination, there are 243 (3 to the 5th power) types.
					</br></br>But how could we display information for so many personality types?  The answer is simple: by using algorithms.  These algorithms search through a library of information to show the user based on what information is relevant to his or her type.  This information is manually written in by the developers of the OTI, and–as soon as surveys are administered–will be compared with user surveys to ensure validity.
					</br></br>For instance, a person who is both low in neuroticism and high in conscientiousness is especially likely to be financially successful, so beyond telling these people the surface-level facts about what it means to have low neuroticism and high conscientiousness, we tell them that they have a unique combination of traits which allows us to make this inference of financial success.
					</br></br>We have already developed the bedrock for the personality test.  Our next steps are to administer surveys and to make statistics publicly available so that they are free, easy to understand, and accessible for anyone.  This will make it significantly easier for people to identify and understand both how personality correlates with sociobiological predispositions and how it directly affects a person’s life outcome.
					
				</p>
				
				<div class = "line"></div>
				
				<ul>
					<li class = "clickable"><a href = "terminology.php">Terminology</a></li>
					<li class = "clickable"><a href = "applications.php">Applications</a></li>
					<li class = "clickable"><a href = "methods.php">Methodology</a></li>
					<li class = "clickable"><a href = "OTIvsOthers.php">Why the OTI</a></li>
					<li class = "clickable"><a href = "https://gabetucker.com/">Developers</a></li>
					<li class = "clickable"><a href = "sources.php">Sources</a></li>
				</ul>
				
				<div class = "line"></div>
				
				<h2>closing remarks</h2>
				
				<p class = "centerParagraph">
					Our goal is that this project will enable accurate classification and analysis of personality traits to a degree that no personality test has yet been able to reach.  Although the release version is almost complete, our next steps will be to introduce nuance to each Big Five trait, breaking each trait into several subcategories to make way for even more specific descriptions for each type.  If you would like to get in touch with us, please don't hesitate to join our Discord community linked in the footer!
				</p>
				
				<div class = "line"></div>
				
				<?PHP require "Prefabs/prefab_relevantOption.php"; ?>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
