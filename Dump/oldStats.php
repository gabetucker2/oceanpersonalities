<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Statistics</title>
		<meta name = "description" content = "<b>View statistics</b> which cross-reference demographic data with the Big Five traits."/>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php";?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
				
				<h1 style = "margin: -4vh 0vw -1vh; font-size: 2vw;">STATISTICS & FINDINGS</h1>
				
				<div class = "tinyLine"></div>
				
				<?PHP
					
					$availableSurveys = array("_frequency", "oti_type");
					$surveyPrompts = array("_MEASURE_FREQUENCY_OF_OTHER_PROMPT", "_MEAN_OTI_TEST_STATS");
					$surveyVarTypes = array("special", "nominal");//nominal, scaled, or special (for _frequency)
					$responseOptions = "[[], ['openness', 'conscientiousness', 'extraversion', 'agreeableness', 'neuroticism'], ";/////////////ADD IN OTI SOON
					

					//$choiceOptions = array();
					$textOptions = array();
					$thisTextOption;

					//GET SURVEY DATA
					$SQL =
						"SELECT surveys_answers.surveyAnswerType qtype, surveys_questions.surveyQuestionIdentifier identifier, surveys_questions.surveyQuestionTarget qtarget, surveys_questions.surveyQuestionPrompt prompt
						FROM surveys_answers
						INNER JOIN surveys_questionanswers ON surveys_questionanswers.surveyAnswerID = surveys_answers.surveyAnswerID
						INNER JOIN surveys_questions ON surveys_questions.surveyQuestionID = surveys_questionanswers.surveyQuestionID
						INNER JOIN surveys_general ON surveys_general.surveyID = surveys_questions.surveyID
						WHERE surveys_general.surveyHidden = 0 AND (surveys_answers.surveyAnswerType <> 'N' OR surveys_questions.surveyQuestionIdentifier <> 'N')
						ORDER BY surveys_general.surveyOrder ASC, surveys_questions.surveyQuestionOrder ASC;";

					if($result = mysqli_query($connection, $SQL))
					{
						//get current x option (e.g., race_self) and fill x columns
						while($result && $row = mysqli_fetch_assoc($result))
						{
							array_push($textOptions, $row["qtype"]);
							if ($_GET["surveyTypeX"] == $row["qtype"] . "_" . $row["qtarget"]) {
								$thisTextOption = $row["qtype"];
							}
							
							$thisTypePure = "";
							$thisType = "";
							$thisIdentifier = "";
							if($row["qtype"] != "N") { $thisTypePure = $row["qtype"]; $thisType = $thisTypePure . "_"; }
							if($row["identifier"] != "N") { $thisIdentifier = $row["identifier"] . "_"; }
							
							if($row["qtype"] != "N") { array_push($surveyVarTypes, "nominal"); } else { array_push($surveyVarTypes, "scaled"); }
							
							array_push($availableSurveys, $thisType . $thisIdentifier . $row["qtarget"]);
							array_push($surveyPrompts, $row["prompt"]);
							
							//DEFINE THE NOMINAL X VARIABLES
							$thisNewTypesSet = "[";
							
							$SQL =
								"SELECT surveys_choices.surveyChoiceText choiceText
								FROM surveys_answers
								INNER JOIN surveys_choices ON surveys_choices.surveyAnswerID = surveys_answers.surveyAnswerID
								WHERE surveys_answers.surveyAnswerType = '{$thisTypePure}'
								ORDER BY surveys_choices.surveyChoiceOrder ASC
								LIMIT 10;";
							
							if($result2 = mysqli_query($connection, $SQL))
							{
								while($row = mysqli_fetch_assoc($result2))
								{
									$thisNewTypesSet .= '"' . $row["choiceText"] . '", ';
								}
							}
							
							$thisNewTypesSet .= "]";
							
							$responseOptions .= $thisNewTypesSet . ", ";
						}
					}
					
					$responseOptions .= "]";
					echo "<script>let responseOptions = {$responseOptions};</script>";
					
					//num responses per x column

					$choiceOptions = array();
					$surveyValuesRaw = array();

					// - preset all choice options in a table so that if there aren't responses for every choice, we'll still be able to match the responses accordingly
					$SQL =
						"SELECT SC.surveyChoiceID choiceID
						FROM surveys_answers SA
						INNER JOIN surveys_choices SC ON SC.surveyAnswerID = SA.surveyAnswerID
						WHERE SA.surveyAnswerData = 'multiple_choice' AND SA.surveyAnswerType = '" . $thisTextOption . "'
						ORDER BY SC.surveyChoiceID";
					
					if ($result = mysqli_query($connection, $SQL)) {
						while ($row = mysqli_fetch_assoc($result)) {
							array_push($choiceOptions, $row["choiceID"]);
							array_push($surveyValuesRaw, 0);
						}
					}

					// - get responses per option
					$SQL =
						"SELECT SR.surveyResponse response, SC.surveyChoiceText choice, mainST.surveyTakenID surveyID, SC.surveyChoiceID choiceID
						FROM surveys_taken mainST
						INNER JOIN surveys_responses SR ON SR.surveyTakenID = mainST.surveyTakenID
						INNER JOIN surveys_answers SA ON SA.surveyAnswerID = SR.surveyAnswerID
						INNER JOIN surveys_choices SC ON SC.surveyAnswerID = SA.surveyAnswerID AND SR.surveyResponse = SC.surveyChoiceID
						WHERE SA.surveyAnswerData = 'multiple_choice' AND SA.surveyAnswerType = '" . $thisTextOption . "' AND mainST.surveyTakenID =
						(
							SELECT MAX(subST.surveyTakenID)
							FROM surveys_taken subST
							WHERE subST.userID = mainST.userID
						)
						ORDER BY SC.surveyChoiceID;";
					
					//Raw numbers - sums
					if($result = mysqli_query($connection, $SQL)) {
						while ($row = mysqli_fetch_assoc($result)) {
							$surveyValuesRaw[array_search($row["choiceID"], $choiceOptions, true)]++;
						}
					}
					
					$surveyValuesRawJS = "[";
					foreach ($surveyValuesRaw as $val) {
						$surveyValuesRawJS .= $val . ", ";
					}
					$surveyValuesRawJS .= "]";

					echo "<script>let surveyValuesRaw = {$surveyValuesRawJS};</script>";
				?>
				
				<canvas name = "thisChart" width = "700" height = "495" style = "background: linear-gradient(110deg, #000020 0%, #083651 100%); border-radius: 1vw;"></canvas>
				
				<div style = "height: 50vh; width: 20vw; margin: 0 0 0 0; display: inline-block; border: solid 1vh #083651; border-radius: 1vw;">
					<h2>Controller</h2>
					
					<form method = "GET">
						<?PHP
							$surveyTypeXStartValue = "";
							$surveyTypeYStartValue = "";
							$surveyTypeXStartKey = 1;
							$surveyTypeYStartKey = 0;
							
							$refresh = false;
							
							if(isset($_GET["surveyTypeX"]))
							{
								$surveyTypeXStartValue = $_GET["surveyTypeX"];
							}
							else
							{
								$surveyTypeXStartValue = $availableSurveys[array_search("nominal", $surveyVarTypes)];
								
								$refresh = true;
							}
							
							if(isset($_GET["surveyTypeY"]))
							{
								$surveyTypeYStartValue = $_GET["surveyTypeY"];
							}
							else
							{
								$surveyTypeYStartValue = $availableSurveys[array_search("special", $surveyVarTypes)];
								
								$refresh = true;
							}
							
							if($refresh)
							{
								while(ob_get_status())
								{
									ob_end_clean();
								}
								
								echo '<script>window.location.href = "stats.php?surveyTypeX=' . $surveyTypeXStartValue . '&surveyTypeY=' . $surveyTypeYStartValue . '";</script>';
							}
						?>
						
						<label for = "surveyTypeX" style = "font-family: titleFont;">AXIS X</label>
						<select name = "surveyTypeX">
							<?PHP
								for($i = 0; $i < count($availableSurveys); $i++)
								{
									$thisName = $availableSurveys[$i];
									
									if($surveyVarTypes[$i] == "nominal")//later include scale variables
									{
										$selectedText = "";
										if($thisName == $surveyTypeXStartValue) { $selectedText = " selected"; $surveyTypeXStartKey = $i; }
										
										echo "<option value = '{$thisName}'{$selectedText}>{$thisName}</option>";
									}
								}
							?>
						</select><br/>
						
						<p style = "font-size: 0.75vw; line-height: normal; margin-top: 1vh;"><?PHP echo $surveyPrompts[$surveyTypeXStartKey]; ?></p><br/>
						
						<label for = "surveyTypeY" style = "font-family: titleFont;">AXIS Y</label>
						<select name = "surveyTypeY">
							<?PHP
								for($i = 0; $i < count($availableSurveys); $i++)
								{
									$thisName = $availableSurveys[$i];
									
									if($surveyVarTypes[$i] == "special")
									{
										$selectedText = "";
										if($thisName == $surveyTypeYStartValue) { $selectedText = " selected"; $surveyTypeYStartKey = $i; }
										
										echo "<option value = '{$thisName}'{$selectedText}>{$thisName}</option>";
									}
								}
							?>
						</select><br/>
						
						<p style = "font-size: 0.75vw; line-height: normal; margin-top: 1vh;"><?PHP echo $surveyPrompts[$surveyTypeYStartKey]; ?></p><br/>
					</form>
					
					<script>
						let surveyTypeX = document.getElementsByName("surveyTypeX")[0];
						let surveyTypeY = document.getElementsByName("surveyTypeY")[0];
						
						function SearchClick()
						{
							//if(!(surveyTypeX.value == "none" && surveyTypeY.value == "none"))
							//{
								PostFromJS("./stats.php?surveyTypeX=" + surveyTypeX.value + "&surveyTypeY=" + surveyTypeY.value, null);
							//}
						}
					</script>
					
					<button style = "margin-top: -5vh;" onClick = "SearchClick()" class = "button">SEARCH</button>
				</div>
				
				<script>
					let thisTypeXStartValue = <?PHP echo '"' . $surveyTypeXStartValue . '"'; ?>;
					let thisTypeYStartValue = <?PHP echo '"' . $surveyTypeYStartValue . '"'; ?>;
					let thisTypeXStartKey = <?PHP echo $surveyTypeXStartKey; ?>;
					let thisTypeYStartKey = <?PHP echo $surveyTypeYStartKey; ?>;
					
					//very patchy way to avoid having to deal with multiple window.onload events
					window.addEventListener('load', function()
					{
						let thisChart = document.getElementsByName("thisChart")[0];
						let thisCanvas = thisChart.getContext("2d");//700x 495y
						
						//0, 0, :
						let boundaryX = 700;
						let boundaryY = 495;
						
						let graphStartX = 150;
						let graphEndX = boundaryX;
						let graphStartY = 40;
						let graphEndY = 400;
						
						let lineStroke = 12;
						let typeTextOffset = 15;
						
						//BASE LINE X
						thisCanvas.fillStyle = "#F4F4F480";
						thisCanvas.fillRect(0, graphEndY, boundaryX, lineStroke);
						thisCanvas.setTransform();
						
						//X TEXT
						thisCanvas.font = "0.75vw titleFont";
						thisCanvas.fillStyle = "#F4F4F4";
						thisCanvas.textAlign = "center";
						thisCanvas.fillText(thisTypeXStartValue, (graphStartX + graphEndX) / 2, 480); 
						thisCanvas.setTransform();
						
						//BASE LINE Y
						thisCanvas.fillStyle = "#F4F4F480";
						thisCanvas.fillRect(graphStartX - lineStroke, 0, lineStroke, boundaryY);
						thisCanvas.setTransform();
						
						//Y TEXT
						thisCanvas.font = "0.75vw titleFont";
						thisCanvas.fillStyle = "#F4F4F4";
						thisCanvas.textAlign = "center";
						thisCanvas.fillText(thisTypeYStartValue, (graphStartX - lineStroke) / 2, graphStartY); 
						thisCanvas.setTransform();
						
						//BOTTOM LEFT FILL
						thisCanvas.fillStyle = "#00002050";
						thisCanvas.fillRect(0, graphEndY + lineStroke, graphStartX - lineStroke, boundaryY - (graphEndY + lineStroke));
						thisCanvas.setTransform();

						let surveyValuesTotal = 0;
						surveyValuesRaw.forEach(function(val) {
							surveyValuesTotal += val;
						});
						
						//LINES
						if(surveyTypeY.value == "_frequency" && surveyTypeX.value != "_none" && surveyTypeX.value != "_frequency")
						{
							let thisOff = 2;
							let offMult = 12;
							let thisResponseLen = responseOptions[thisTypeXStartKey].length;
							
							//range: 215x - 700x; 400y - 0y
							for(let i = 0; i < thisResponseLen; i++)
							{
								thisOff++;
								let textYOffset = offMult * 0;
								if(thisResponseLen > 3)
								{
									if(thisOff % 3 == 1) { textYOffset = offMult * 1; }
									else if(thisOff % 3 == 2) { textYOffset = offMult * 2; }
								}
								
								let thisWidth = 250 * (1 / thisResponseLen);
								let thisSpace = ((graphEndX - graphStartX) - (thisWidth * thisResponseLen)) / (thisResponseLen + 1);
								let thisXOff =
									graphStartX//init offset
									+ (thisWidth * i)
									+ (thisSpace * (i + 1));
								
								let thisFreqPerc = surveyValuesRaw[i] / surveyValuesTotal;//1 = 100%, 0 = 0%

								let thisYBarHeight = graphStartY + ((graphEndY - graphStartY) * (1 - thisFreqPerc));
								
								//LINE
								thisCanvas.fillStyle = "#1DB3CA";
								thisCanvas.fillRect(thisXOff, thisYBarHeight, thisWidth, graphEndY - thisYBarHeight);
								thisCanvas.setTransform();
								
								//TEXT
								thisCanvas.font = "0.5vw verdana";
								thisCanvas.fillStyle = "#F4F4F4";
								thisCanvas.textAlign = "center";
								thisCanvas.fillText(responseOptions[thisTypeXStartKey][i] + " (" + Math.round(thisFreqPerc * 100) + "%)", thisXOff + (thisWidth / 2), graphEndY + lineStroke + textYOffset + typeTextOffset); 
								thisCanvas.setTransform();
							}
						}

						//DATA TEXT BOTTOM LEFT
						thisCanvas.font = "0.75vw verdana";
						thisCanvas.fillStyle = "#F4F4F4";
						thisCanvas.textAlign = "center";
						thisCanvas.fillText("n = " + surveyValuesTotal, (graphStartX - lineStroke) / 2, (graphEndY + lineStroke) + (boundaryY - graphEndY) / 2); 
						thisCanvas.setTransform();
					});
					
				</script>
				
				<br/></br><br/></br><br/></br>
			
				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
