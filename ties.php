<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"; ?>
		
		<title>Ocean - Ties</title>
		<meta name = "description" content = "<b>Take the test</b> for deep self-insight."/>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
				
				<h1 style = "margin: -4vh 0vw -1vh; font-size: 2vw;">TIE BREAKER</h1>
				
				<p class = "subEmphasize">We have detected that you are close to a tie between different personality types.<br/><br/>We do not want to assume your type based on the difference of just a few points,<br/>so please select the paragraph that best describes your personality.<br/>Please do not refresh the page or we will lose your results.</p>
				
				<div class = "line" style = "margin-top: 0vh; margin-bottom: 3vh;"></div>
				
				<?PHP
					
					$currentType;
					
					if(isset($_SESSION["turnOver"]))//if it's okay to proceed with page
					{
						unset($_SESSION["turnOver"]);
						
						//set main HTML
						echo
							"<p name = 'paragraphOne' style = 'vertical-align: middle; text-align: right; display: inline-block; width: 40vw;'></p>
							
							<input onClick = 'UpdateIteration(0)' class = 'button' type = 'button' value = '<<' style = 'width: 5vw;'/>
							<input onClick = 'UpdateIteration(1)' class = 'button' type = 'button' value = '>>' style = 'width: 5vw;'/>
							
							<p name = 'paragraphTwo' style = 'vertical-align: middle; text-align: left; display: inline-block; width: 40vw;'></p>";
						
						//set up variables in JavaScript and PHP
						$currentType = $_GET["OTIType"];
						
						$suffix = ", ";
						
						$responsesStringList;
						$responsesArray = array();
						$responsesStringListCount = count($_POST);
						
						if($responsesStringListCount == 0)//if no posted responses bc user is logged in
						{
							$responsesStringList = "null";
						}
						else//if there are responses bc user is logged in
						{
							$responsesStringList = "{";
							
							for($i = 0; $i < $responsesStringListCount; $i++)
							{
								$thisResponse = $_POST["r{$i}"];
								
								$responsesStringList .= "r{$i}: " . $thisResponse . $suffix;
								array_push($responsesArray, $thisResponse);
							}
							
							$responsesStringList .= "}";
							
							$_SESSION["turnOver"] = true;//sets turnOver to true so that when it arrives at the next page, it knows to update the first and only the first time it does
						}
						
						echo "<script>let responses = {$responsesStringList};</script>";//echos null or an array
						
						//select paragraphs/values for JavaScript to later iterate through
						$conflictsArray = array(0, 0, 0, 0, 0);//where 0 is no conflict, 1 is conflict low, 2 is conflict high
						
						//ADD IN RESPONSES
						$finalValues = array(0, 0, 0, 0, 0);
						
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
							$thisResponse = $_POST["r{$iQuestion}"];
							
							if($questionRow["questionCorrelate"] != -1)//if is a correlate, half the value being considered for later calculation
							{
								$thisResponse /= 2;
							}
							
							$finalValues[($questionRow["questionTrait"] - 1)] += $thisResponse;
						}
						
						$thirdDeviation = 0.075;//percent difference +- from 0 to 1 to qualify as tie
						
						for($t = 1; $t <= 5; $t++)
						{
							$SQL =
								"SELECT *
								FROM questions_general mainQG
								INNER JOIN versions_questions ON mainQG.questionID = versions_questions.questionID
								WHERE versions_questions.versionID = {$currentVersionID} AND mainQG.questionTrait = {$t} AND (mainQG.questionCorrelate = -1 OR (mainQG.questionCorrelate > mainQG.questionID AND mainQG.questionCorrelate =
								(
									SELECT subQG.questionID
									FROM questions_general subQG
									WHERE subQG.questionID = mainQG.questionCorrelate
								)))
								ORDER BY questionTrait ASC, questionPositive ASC;";//only get first is questionCorrelate is not -1 to count two halfs as a whole
							
							if($result = mysqli_query($connection, $SQL))
							{
								$numTheseQuestsions = mysqli_num_rows($result);
								$thisAverageVal = $finalValues[$t - 1] / $numTheseQuestsions;
								
								$currentOneThirdVal = $currentVersionMaxValue * (1 / 3);
								$currentTwoThirdVal = $currentVersionMaxValue * (2 / 3);
								/////fix tie thing
								if($thisAverageVal <= $currentOneThirdVal + $thirdDeviation && $thisAverageVal >= $currentOneThirdVal - $thirdDeviation)//trait is within 1v2 range
								{
									$conflictsArray[$t - 1] = 1;
								}
								else if($thisAverageVal <= $currentTwoThirdVal + $thirdDeviation && $thisAverageVal >= $currentTwoThirdVal - $thirdDeviation)//trait is within 2v3 range
								{
									$conflictsArray[$t - 1] = 2;
								}
								else
								{
									$conflictsArray[$t - 1] = 0;
								}
							}
						}
						
						echo "<script>let currentType = '{$currentType}';</script>";
						
						$conflictsListString = "[";
						$paragraphsOneListString = "[";
						$paragraphsTwoListString = "[";
						
						$suffix = ", ";
						
						for($t = 0; $t < count($conflictsArray); $t++)
						{
							$thisConflict = $conflictsArray[$t];
							
							$conflictsListString .= $thisConflict . $suffix;
							
							if($thisConflict != 0)
							{
								$paragraphOne;
								$paragraphTwo;
								
								$thisParagraphOTIOne;
								$thisParagraphOTITwo;
								
								$replaceLength = 1;
								
								if($thisConflict == 1)//between 1 and 2
								{
									$thisParagraphOTIOne = substr_replace($zeros, '1', $t, $replaceLength);
									$thisParagraphOTITwo = substr_replace($zeros, '2', $t, $replaceLength);
								}
								else if($thisConflict == 2)//between 2 and 3
								{
									$thisParagraphOTIOne = substr_replace($zeros, '2', $t, $replaceLength);
									$thisParagraphOTITwo = substr_replace($zeros, '3', $t, $replaceLength);
								}
								
								$SQL =
									"SELECT traitParagraph
									FROM traits_general
									WHERE OTI = '{$thisParagraphOTIOne}' AND domainID = 1;";//assumes domainID 1 is General
								
								if($result = mysqli_query($connection, $SQL))
								{
									$paragraphOne = mysqli_fetch_assoc($result)["traitParagraph"] ?? "No paragraph yet in the database";
								}
								
								$SQL =
									"SELECT traitParagraph
									FROM traits_general
									WHERE OTI = '{$thisParagraphOTITwo}' AND domainID = 1;";
								
								if($result = mysqli_query($connection, $SQL))
								{
									$paragraphTwo = mysqli_fetch_assoc($result)["traitParagraph"] ?? "No paragraph yet in the database";
								}
								
								
								$unfilteredWords = array("!SINGULAR", "!PLURAL", "!POSSESSIVE");
								$filteredWords = array("Person of This Type", "Those of This Type", "Person of This Type's");
								
								for($i = 0; $i < count($filteredWords); $i++)//add span class to each name
								{
									$filteredWords[$i] = '<span class = \'emphasize\'>' . $filteredWords[$i] . '</span>';
								}
								
								$paragraphOne = str_replace($unfilteredWords, $filteredWords, $paragraphOne);
								$paragraphTwo = str_replace($unfilteredWords, $filteredWords, $paragraphTwo);
								
								$paragraphsOneListString .= '"' . $paragraphOne . '"' . $suffix;
								$paragraphsTwoListString .= '"' . $paragraphTwo . '"' . $suffix;
							}
							else
							{
								$paragraphsOneListString .= '""' . $suffix;
								$paragraphsTwoListString .= '""' . $suffix;
							}
						}
						
						$conflictsListString .= "]";
						$paragraphsOneListString .= "]";
						$paragraphsTwoListString .= "]";
						
						echo "<script>let allLists = [{$conflictsListString}, {$paragraphsOneListString}, {$paragraphsTwoListString}]</script>";
					}
					else
					{
						//set it so that nothing happens when JavaScript function is called to prevent errors
						echo '<script>let currentType = null;</script>';
						
						//set warning HTML
						echo "<p class = 'emphasize warning'>Not here from previous page<br/>Please only direct to this page after taking a test<br/>Otherwise, we cannot detect your results</p>";
					}
					
				?>
				
				<script>
					
					let paragraphOne = document.getElementsByName("paragraphOne")[0];
					let paragraphTwo = document.getElementsByName("paragraphTwo")[0];
					
					let thisOTI = "";
					
					let currentIteration = 0;
					
					let firstIteration = 0;
					
					
					function UpdateText(CI)//very finnicky and bad temporary solution for currentIteration system
					{
						if(currentType != null)
						{
							paragraphOne.innerHTML = allLists[1][CI];
							paragraphTwo.innerHTML = allLists[2][CI];
							
							currentIteration -= 1;
						}
					}
					
					function SkipEmptyRows()
					{
						if(currentType != null)
						{
							while(allLists[0][currentIteration] == 0)//skip next zeros
							{
								thisOTI += "0";//0, in this instance, equates to passing over this character
								currentIteration += 1;
							}
						}
					}
					
					function Finalize()
					{
						let localType = "";
						
						for(t = 0; t < 5; t++)
						{
							thisT = thisOTI[t];
							
							if(thisT != "0")
							{
								localType += thisT;
							}
							else
							{
								localType += currentType[t];
							}
						}
						
						SearchCurrentType(localType, responses);//inherit localType and responses, where localType is the old type with updates for ties
					}
					
					function UpdateIteration(thisSide)//-1 is no val update and text only update, 0 is left, 1 is right
					{
						if(currentType != null)
						{
							currentIteration += 1;
							
							if(currentIteration != 5)//if not final iteration, update page
							{
								//update OTI
								thisConflict = allLists[0][currentIteration];//0 for none, 1 for low, 2 for high
								
								if(thisSide != -1)//if button clicked to get here, update OTI
								{
									if(thisConflict != 0)//select if tie
									{
										if(thisConflict == 1)//LOW
										{
											if(thisSide == 0)//LEFT
											{
												thisOTI += "1";
											}
											else if(thisSide == 1)//RIGHT
											{
												thisOTI += "2";
											}
										}
										else if(thisConflict == 2)//HIGH
										{
											if(thisSide == 0)//LEFT
											{
												thisOTI += "2";
											}
											else if(thisSide == 1)//RIGHT
											{
												thisOTI += "3";
											}
										}
										
										currentIteration += 1;
									}
									
									SkipEmptyRows();
									
									if(currentIteration == 5)
									{
										Finalize();
									}
									
									UpdateText(currentIteration);
								}
							}
							else//finalize if just performed function on final iteration by forwarding to next page with new OTI
							{
								Finalize();
							}
						}
					}
					
					SkipEmptyRows();
					
					if(currentIteration != 5)
					{
						UpdateText(currentIteration);
					}
					else
					{
						Finalize();
					}
					
				</script>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
