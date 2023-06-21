<!DOCTYPE HTML>
<html>
	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Methods</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_scrollLabel.php"; ?>
				
				<a href = "info.php" class = "button"><<</a>
				
				<h1>METHODOLOGY</h1>
				
				<p class = "leftParagraph">
					The OTI consists of <span class = "emphasize">243 personality types</span> derived from the three possible valencies- low, medium, or high trait expression- for each of the Big Five personality traits.  We're leaving nothing to chance.
				</p><p class = "leftParagraph">
					We measure this many types by using <span class = "emphasize">algorithms</span>. These algorithms look through a library of information and select information to show the user based on what is relevant to his or her type. For instance, if we found a correlation between high openness and low neuroticism, then we would add an explanation of our finding to every single type with high openness and low neuroticism (30001) (e.g., types 32221 and 31331 would both be shown this paragraph); this will be how the traits pertaining to our personality types are communicated to test-takers. We will conduct mass surveys among different OTI types to identify trends, and over time, further nuance our assertions.    
				</p><p class = "leftParagraph">
					How does our test work?  In our test, we employ the <span class = "emphasize">Likert Scale</span>- where you respond to a prompt based off how strongly you agree or disagree- but without a neutral option.  This allows you to nuance your answers and offers a greater scope of depth to each of your responses.  We omit the neutral option in hopes that if a person is forced to make a close decision, that the person will answer based on his or her subconscious attitude towards how strongly they exhibit that trait.
				</p><p class = "leftParagraph">
					In addition, for the purposes of collecting data, we only allow <span class = "subEmphasize">users with an account</span> to have their results recorded as not to skew our results.  If we didn't do this, we would have no way to determine whether a person has already taken the test, and we would be forced to record each test as being taken by a different user, which would be inaccurate.  To ensure that we don't include the results of a person answering dishonestly in our data, we have created <span class = "emphasize">control questions</span> that ask the same question in different ways, and if a user has results inconsistent between a third or more of our controls, we will know to exclude their results and give the user an error page. Further, we measure the average response strength of each question to watch for whether a question provokes a disproportionate response in the affirmative or the negative; if one does, we replace it with a newer test version and watch for whether this fixes the issue.  If there are any close cases between two traits, the person is prompted with a tie page, where they are asked which description of each trait better coincides with their sense of self; the selected paragraph will determine the selected trait in this tie.
				</p>

				<h1>TECHNICAL ILLUSTATIONS</h1>

				<br/>

				<h2>Test handling:</h2>
				<image style = "width: 60vw;" src = "Images/LogicSlidePictures/Slide1.png"/>

				<h2>Control question handling:</h2>
				<image style = "width: 60vw;" src = "Images/LogicSlidePictures/Slide2.png"/>
				
				<h2>Tie handling:</h2>
				<image style = "width: 60vw;" src = "Images/LogicSlidePictures/Slide3.png"/>

				<h2>Trait-sort handling:</h2>
				<image style = "width: 60vw;" src = "Images/LogicSlidePictures/Slide4.png"/>

				<h2>Data structure:</h2>
				<image style = "width: 60vw;" src = "Images/LogicSlidePictures/Slide5.png"/>

				<br/><br/><br/><br/><br/>
				
				<a href = "info.php" class = "button return"><<</a>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
