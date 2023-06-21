<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php" ?>
		
		<title>Ocean - Define Type</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_scrollLabel.php"; ?>
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
				
				<!--<a href = "types.php" class = "button" style = "margin-top: -7vh;"><<</a>-->
				
				<?PHP
					
					$currentOTI = $_GET["OTIType"];
					
					ob_start();
					
					function RefreshPage($newOTI)
					{
						while(ob_get_status())
						{
							ob_end_clean();
						}
						
						echo '<script>window.location.href = "typeDefine.php?OTIType='.$newOTI.'";</script>';
					}
					
					$hasPersonalStats = ($currentOTI == $userOTI);

					$voteExists = false;
					//clear old votes
					foreach ($_POST as $key => $val) {
						if (substr($key, 0, 4) == "vote") {
							$voteExists = true;
							$SQL = "
								UPDATE votes_traits
								SET voteIsCurrent = 0
								WHERE userID = {$userID};
							";
							mysqli_query($connection, $SQL);
							break;
						}
					}
					if ($voteExists) {
						//add new votes
						foreach ($_POST as $key => $val) {
							if (substr($key, 0, 4) == "vote") {
								$isUpvote = ($val == "upvote") ? 1 : 0;
								$traitID = substr($key, 4);
								
								$SQL = "
									INSERT INTO votes_traits (userID, traitID, voteIsUpvote, voteIsCurrent)
									VALUES ({$userID}, {$traitID}, {$isUpvote}, 1);
								";
								mysqli_query($connection, $SQL);
							}
						}

						//just to make sure that you don't resubmit same vote POST requests with each refresh
						RefreshPage($currentOTI);
					}

					//UPDATE DATABASES
					if(count($_POST) > 1 && isset($_SESSION["turnOver"]) && isset($_SESSION["userID"]) && $userID != -1)//if turnOver isset, know it's intending to update user value and make new test results; so long as turnOver is handled correctly, there should be no errors
					{
						unset($_SESSION["turnOver"]);//unset it so it knows, on refresh, not to execute this "if" statement's constituents
						
						//UPDATE USERTYPE SECTION
						$SQL =
							"UPDATE users_general
							SET OTI = '{$currentOTI}'
							WHERE userID = {$userID};";
						
						mysqli_query($connection, $SQL);
						
						$_SESSION["userOTI"] = $currentOTI;
						
						$SQL =
							"SELECT typeName
							FROM types_general
							WHERE OTI = '{$currentOTI}';";
						
						$_SESSION["userTypeName"] = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["typeName"];
						
						
						//CREATE TEST GENERAL
						$SQL =
							'INSERT INTO tests_taken (userID, versionID, OTI, testTime)
							VALUES (' . $userID . ', ' . $currentVersionID . ', \'' . $currentOTI . '\', \'' . date("Y-m-d H:i:s") . '\');';
						
						mysqli_query($connection, $SQL);
						
						$testTakenID = mysqli_insert_id($connection);
						
						//ADD IN RESPONSES
						$SQL =
							"SELECT *
							FROM questions_general
							INNER JOIN versions_questions ON questions_general.questionID = versions_questions.questionID
							WHERE versions_questions.versionID = {$currentVersionID}
							ORDER BY questionTrait ASC, questionPositive ASC;";
						
						$result = mysqli_query($connection, $SQL);
						
						$iQuestion = -1;
						
						while($questionRow = mysqli_fetch_assoc($result))//foreach question of current version
						{
							$iQuestion += 1;
							
							$SQL =
								'INSERT INTO tests_responses (testTakenID, questionID, questionResponse)
								VALUES (' . $testTakenID . ', ' . $questionRow["questionID"] . ', ' . ($_POST["r{$iQuestion}"] ?? -1) . ');';
							
							mysqli_query($connection, $SQL);
						}
						
						while(ob_get_status())
						{
							ob_end_clean();
						}
						
						echo '<script>window.location.href = "typeDefine.php?OTIType=' . $currentOTI . '";</script>';
					}
					
					//MAKE PAGE DISPLAY
					$typeName = "Placeholder";
					$typeDescription = [];
					$typeDescriptionTraitIDs = [];
					
					$SQL =
						"SELECT *
						FROM types_general
						WHERE OTI = '{$currentOTI}';";
					
					if($result = mysqli_query($connection, $SQL))
					{
						$typeName = mysqli_fetch_assoc($result)["typeName"];
					}

					$SQL =
						"SELECT *
						FROM traits_general
						WHERE OTI = '{$currentOTI}';";

					if ($result = mysqli_query($connection, $SQL)) {
						while ($traitRow = mysqli_fetch_assoc($result)) {
							$firstChar = substr($typeName, 0, 1);
							
							$questionText = $traitRow["traitParagraph"];
							if($firstChar == "A" || $firstChar == "E" || $firstChar == "I" || $firstChar == "O" || $firstChar == "U")
							{
								$questionText = str_replace(array("A !SINGULAR", " a !SINGULAR", "A !PLURAL", " a !PLURAL", "A !POSSESSIVE", " a !POSSESSIVE"), array("An !SINGULAR", " an !SINGULAR", "An !PLURAL", " an !PLURAL", "An !POSSESSIVE", " an !POSSESSIVE"), $questionText);
							}
							
							$unfilteredWords = array("!SINGULAR", "!PLURAL", "!POSSESSIVE");
							
							$plural;
							
							if(strtolower(substr($typeName, -1)) != "y")//if doesn't end in a y
							{
								$plural = $typeName . "s";//just add an s
							}
							else
							{
								$plural = substr($typeName, 0, strlen($typeName) - 1) . "ies";//drop the y and add ies
							}
							
							$filteredWords;
							
							if($typeName == "Placeholder")//hackey work-around
							{
								$filteredWords = array("Person of This Type", "Those of This Type", "Person of This Type's");
							}
							else
							{
								$filteredWords = array($typeName, $plural, $typeName . "'s");
							}
							
							for($i = 0; $i < count($filteredWords); $i++)//add span class to each name
							{
								$filteredWords[$i] = '<span class = "emphasize">' . $filteredWords[$i] . '</span>';
							}
							
							array_push($typeDescription, str_replace($unfilteredWords, $filteredWords, $questionText));
							array_push($typeDescriptionTraitIDs, $traitRow["traitID"]);
						}
					}
					
					echo "<script>document.title = 'Ocean - {$typeName}';</script>";
					
					$currentOTIPure = "";
					$currentOTINumbers = "";
					$currentOTINumerals = "";
					$currentOTINumeralArray = array();
					
					for($t = 0; $t < 5; $t++)
					{
						$currentOTIPure .= $currentOTI[$t];
						$currentOTINumbers .= $traitLetters[$t] . $currentOTI[$t];
						
						$currentNumeral = $traitNumerals[intval($currentOTI[$t]) - 1];
						$currentOTINumerals .= $traitLetters[$t] . $currentNumeral;
						array_push($currentOTINumeralArray, $currentNumeral);
					}
					
					$paragraph = ", is an OTI personality type.  Although we have not yet confirmed our predictions regarding this type, you may scroll down to see what we have inferred based on its traits.<br/><br/>";

					if ($typeName == "Placeholder") {
						$paragraph .= "<span class = 'subEmphasize'>(This type has not yet been named, so it is tentatively entitled <span class = 'emphasize'>Placeholder</span>)</span>";
					}
					
					echo
						'<h1 style = "margin-top: -3vh; color: #083651;">' . strtoupper($typeName) . '</h1>
						<p class = "subtext" style = "margin-bottom: -3vh;">' . "- " . $currentOTINumerals . " -" . '</p>';
					
					$valencies = array("low", "", "", "high");
					
					for($v = 0; $v < count($valencies); $v++)
					{
						echo '<h2 style = "display: inline-block; width: 22vw; margin: -100vh 0vw 3vh;">' . $valencies[$v] . '</h2>';
					}
					
					echo '<br/><br/><ul>';
					
					function ReturnAsPercent($number)
					{
						$currentAmount = -1;
						
						switch($number)
						{
							case "1":
								$currentAmount = 16.5;
								
								break;
							case "2":
								$currentAmount = 50;
								
								break;
							case "3":
								$currentAmount = 83.5;
								
								break;
						}
						
						return $currentAmount;
					}
					
					for($t = 0; $t < 5; $t++)
					{
						$currentAmount = ReturnAsPercent($currentOTI[$t]);
						
						$traitName = $traitWords[$t];
						
						echo '<li class = "clickable noClickColor noHoverColor hoverSpecialBorder" style = "background: linear-gradient(to right, #00002050 0%, transparent ' . ($currentAmount * 0.8) . '%), linear-gradient(to right, #' . $oceanColors[$t] . ' ' . $currentAmount . '%, transparent ' . $currentAmount . '%, transparent 100%);"><a href = "traitDefine.php?' . $traitName . '&previousPage=typeDefine.php&OTIType=' . $currentOTI . '" style = "color: #000020;">' . $traitName . '</a></li>';//add header for trait
						
						if($hasPersonalStats){
							$percentActual = $thisUserTraits[$t];
							
							echo "<div style = 'pointer-events: none; margin: -5.3vh 0 1.4vh; width: 100vw; height: 4vh; background: linear-gradient(to right, #00002050 0%, #00002050 {$percentActual}%, transparent {$percentActual}%), linear-gradient(to right, #{$oceanColors[$t]} 0%, transparent {$percentActual}%, transparent {$percentActual}%);'></div>";
						}
					}
					
					echo '</ul>';
					
					echo
						'<p class = "centerParagraph" style = "margin-top: 5vh; margin-bottom: 0vh;">
							The <span class = "emphasize">' . $typeName . '</span>' . ', of the acronym <span class = "subEmphasize">' . $currentOTIPure . '</span>, or <span class = "subEmphasize">' . $currentOTINumbers . '</span>' . $paragraph . '
						</p>';
					
					
					//for loop through arrays
					for ($i = 0; $i < count($typeDescription); $i++) {
						$thisTD = $typeDescription[$i];
						$thisTDTID = $typeDescriptionTraitIDs[$i];
						
						if ($hasPersonalStats) {
							$firstSelected = "";
							$secondSelected = "";
							$SQL = "
								SELECT *
								FROM votes_traits
								WHERE userID = {$userID} AND traitID = {$thisTDTID} AND voteIsCurrent = 1;
							";

							if ($result = mysqli_query($connection, $SQL)) {
								if (mysqli_num_rows($result) == 1) {
									if (mysqli_fetch_assoc($result)["voteIsUpvote"] == 1) {
										$firstSelected = " selected";
									} else {
										$secondSelected = " selected";
									}
								}
							}

							echo
								'
									<div class = "thumbs up'.$firstSelected.'" name = "upvote" id = "upvote'.$thisTDTID.'" onClick = "UpdateVoteButtons(true, '.$thisTDTID.')"></div>
									<div class = "thumbs down'.$secondSelected.'" name = "downvote" id = "downvote'.$thisTDTID.'" onClick = "UpdateVoteButtons(false, '.$thisTDTID.')"></div>
								';
						}

						echo
							'<p class = "leftParagraph" style = "margin-top: 5vh; margin-bottom: 0vh;">
								' . $thisTD . '
							</p>';
					}
					
					//iterate through each value in traits_general
					$prevDomainID = -1;
					
					$SQL =
						"SELECT *
						FROM traits_general
						INNER JOIN traits_domains
						ON traits_general.domainID = traits_domains.domainID
						ORDER BY traits_domains.domainOrder ASC, SUBSTRING(traits_general.OTI, 5, 1) = '0' DESC, SUBSTRING(traits_general.OTI, 4, 1) = '0' DESC, SUBSTRING(traits_general.OTI, 3, 1) = '0' DESC, SUBSTRING(traits_general.OTI, 2, 1) = '0' DESC, SUBSTRING(traits_general.OTI, 1, 1) = '0' DESC, SUBSTRING(traits_general.OTI, 1, 1) ASC, SUBSTRING(traits_general.OTI, 2, 1) ASC, SUBSTRING(traits_general.OTI, 3, 1) ASC, SUBSTRING(traits_general.OTI, 4, 1) ASC, SUBSTRING(traits_general.OTI, 5, 1) ASC;";
					
					$result = mysqli_query($connection, $SQL);
					
					$domainCount = -1;
					
					while($traitRow = mysqli_fetch_assoc($result))
					{
						$rowOTI = $traitRow["OTI"];
						$rowDomainID = $traitRow["domainID"];
						$traitID = $traitRow["traitID"];
						
						$addTrait = true;
						
						$numZeros = 0;
						for($t = 0; $t < 5; $t++)//foreach trait
						{
							if($rowOTI[$t] == '0') {
								$numZeros++;
							}
							else if($rowOTI[$t] != '0' && $rowOTI[$t] != $currentOTI[$t])//if this trait doesn't match because the single traits don't align (i.e. 2 compared against a 1 in 00301) or because it as XXXXX where !EX = 0; this is shown at the top
							{
								$addTrait = false;
								
								break;
							}
						}
						if ($numZeros == 0) { $addTrait = false; }
						
						if($addTrait)
						{
							$SQL =
								'SELECT *
								FROM traits_domains
								WHERE domainID = ' . $rowDomainID . ';';
							
							$domainRow = mysqli_fetch_assoc(mysqli_query($connection, $SQL));
							$domainName = $domainRow["domainName"];
							
							if($rowDomainID != $prevDomainID)//if we're entering a new domain of responses, entitle it
							{
								$prevDomainID = $rowDomainID;
								$domainCount += 1;
								
								echo '<h2 style = "font-size: 5vw; margin-bottom: 3vh; ' . $domainStyles[$domainCount] . '">' . $domainName . '</h2>';
							}
							
							echo '<br/><ul>';
							
							for($t = 0; $t < 5; $t++)//foreach trait
							{
								if($currentOTI[$t] == $rowOTI[$t])//if trait matches
								{
									$currentAmount = ReturnAsPercent($currentOTI[$t]);
									
									$traitName = $traitWords[$t];
									
									echo '<li class = "clickable noClickColor noHoverColor hoverSpecialBorder" style = "background: linear-gradient(to right, #00002050 0%, transparent ' . ($currentAmount * 0.8) . '%), linear-gradient(to right, #' . $oceanColors[$t] . ' ' . $currentAmount . '%, transparent ' . $currentAmount . '%, transparent 100%);"><a href = "traitDefine.php?' . $traitName . '&previousPage=typeDefine.php&OTIType=' . $currentOTI . '" style = "color: #000020;">' . $traitName . '</a></li>';
									
									if($hasPersonalStats == true){
										$percentActual = $thisUserTraits[$t];
										
										echo "<div style = 'pointer-events: none; margin: -5.3vh 0 1.4vh; width: 100vw; height: 4vh; background: linear-gradient(to right, #00002050 0%, #00002050 {$percentActual}%, transparent {$percentActual}%), linear-gradient(to right, #{$oceanColors[$t]} 0%, transparent {$percentActual}%, transparent {$percentActual}%);'></div>";
									}
								}
							}
							
							echo '</ul>';
							
							//later condense into one function
							$firstChar = substr($typeName, 0, 1);
							$questionText = $traitRow["traitParagraph"];

							if($firstChar == "A" || $firstChar == "E" || $firstChar == "I" || $firstChar == "O" || $firstChar == "U")
							{
								$questionText = str_replace(array("A !SINGULAR", " a !SINGULAR", "A !PLURAL", " a !PLURAL", "A !POSSESSIVE", " a !POSSESSIVE"), array("An !SINGULAR", " an !SINGULAR", "An !PLURAL", " an !PLURAL", "An !POSSESSIVE", " an !POSSESSIVE"), $questionText);
							}
							
							$unfilteredWords = array("!SINGULAR", "!PLURAL", "!POSSESSIVE");
							
							$plural;
							
							if(strtolower(substr($typeName, -1)) != "y")//if doesn't end in a y
							{
								$plural = $typeName . "s";//just add an s
							}
							else
							{
								$plural = substr($typeName, 0, strlen($typeName) - 1) . "ies";//drop the y and add ies
							}
							
							$filteredWords;
							
							if($typeName == "Placeholder")//hackey work-around
							{
								$filteredWords = array("Person of This Type", "Those of This Type", "Person of This Type's");
							}
							else
							{
								$filteredWords = array($typeName, $plural, $typeName . "'s");
							}
							
							for($i = 0; $i < count($filteredWords); $i++)//add span class to each name
							{
								$filteredWords[$i] = '<span class = "emphasize" style = "' . $domainStyles[$domainCount] . '">' . $filteredWords[$i] . '</span>';
							}
							
							$questionText = str_replace($unfilteredWords, $filteredWords, $questionText);
							
							if ($hasPersonalStats) {
								$firstSelected = "";
								$secondSelected = "";
								$SQL = "
									SELECT *
									FROM votes_traits
									WHERE userID = {$userID} AND traitID = {$traitID} AND voteIsCurrent = 1;
								";
								
								if ($result2 = mysqli_query($connection, $SQL)) {
									if (mysqli_num_rows($result2) == 1) {
										if (mysqli_fetch_assoc($result2)["voteIsUpvote"] == 1) {
											$firstSelected = " selected";
										} else {
											$secondSelected = " selected";
										}
									}
								}

								echo
									'
										<div class = "thumbs up'.$firstSelected.'" name = "upvote" id = "upvote'.$traitID.'" onClick = "UpdateVoteButtons(true, '.$traitID.')"></div>
										<div class = "thumbs down'.$secondSelected.'" name = "downvote" id = "downvote'.$traitID.'" onClick = "UpdateVoteButtons(false, '.$traitID.')"></div>
									';
							}
							
							echo '<p class = "leftParagraph">' . $questionText . '</p>';
						}
					}
					
					if($hasPersonalStats) {

						echo '<div class = "line"></div><br/>';
					
						$startPadding = "0.9vh 0.5vw";
						$newPadding = "0vh 0.33vw";

						echo '<input type = "button" class = "button" style = "margin: -5vh 0vw; padding: ' . $startPadding . ';" onMouseOver = "this.style.padding = \'' . $newPadding . '\';" onMouseOut = "this.style.padding = \'' . $startPadding . '\';" value = "SUBMIT YOUR VOTES" onClick = "SubmitVotes()"/>';

						echo '<br/><p class = "centerParagraph subEmphasize">If you clicked on the upvote/downvote buttons to tell us whether you thought a paragraph accurately describes you, please click the above button to submit your feedback into our system!<br/><br/>(If you already have submitted your most recent votes, there is no need to hit this button.)</p>';

					}
					
				?>

				<div class = "line"></div>
				
				<a href = "profile.php" class = "linkButton">see your stats</a><br/>
				
				<a href = "surveyNavigator.php" class = "linkButton">answer our questions</a><br/>

				<a href = "https://discord.gg/gxWfHqHQsn" class = "linkButton" style = "margin-top: -1vh;">Join the Discord Server</a><br/>
				
				<!--<a href = "methods.php" class = "linkButton">learn how we made the test</a><br/>-->
				
				<!--<a href = "terminology.php" class = "linkButton">learn about terminology for different types</a>-->
				
				<!--<a href = "types.php" class = "button return"><<</a>-->
				
				<br/>
				<br/>
			
				<?PHP require "Prefabs/prefab_footer.php"; ?>

				<script>

					function UpdateVoteButtons(upvoteClicked, thisID) {

						let upvoteButton = document.getElementById("upvote" + thisID);
						let downvoteButton = document.getElementById("downvote" + thisID);

						if (upvoteClicked) {
							if (upvoteButton.classList.contains("selected")) {
								upvoteButton.classList.remove("selected");
							} else {
								upvoteButton.classList.add("selected");
								downvoteButton.classList.remove("selected");
							}
						} else {
							if (downvoteButton.classList.contains("selected")) {
								downvoteButton.classList.remove("selected");
							} else {
								downvoteButton.classList.add("selected");
								upvoteButton.classList.remove("selected");
							}
						}

					}

					function SubmitVotes() {
						let OTIType = "<?PHP echo $currentOTI; ?>";
						
						let votes = [];

						let voteElements = [];
						voteElements = voteElements.concat(Array.from(document.getElementsByName("upvote")));
						voteElements = voteElements.concat(Array.from(document.getElementsByName("downvote")));
						
						let voteExists = false;
						voteElements.forEach(element =>
						{
							if (element.classList.contains("selected")) {
								voteExists = true;
								let thisID = element.id.match(/[0-9]*$/)[0];
								if (element.getAttribute("name") == "upvote") {
									//upvote
									votes["vote" + thisID] = "upvote";
								} else {
									//downvote
									votes["vote" + thisID] = "downvote";
								}
							}
						})
						
						if(OTIType.length == 5 && voteExists) {
							PostFromJS("./typeDefine.php?OTIType=" + OTIType, votes);
						}
					}

				</script>

			</div>
			
		</div>
		
	</body>

</html>
