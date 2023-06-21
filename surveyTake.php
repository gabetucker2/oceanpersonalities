<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Survey</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_scrollLabel.php"; ?>
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
				
				<?PHP
					
					$maxLikertAnswer = 18;
					
					$thisSurveyID;
					$thisSurveyName;
					$thisWarningHTML;
					
					if(isset($_GET["surveyID"]))
					{
						$thisSurveyID = $_GET["surveyID"];
						
						$SQL =
							"SELECT surveyName
							FROM surveys_general
							WHERE surveyID = {$thisSurveyID};";
						
						$result = mysqli_query($connection, $SQL);
						
						if(mysqli_num_rows($result) == 1)
						{
							$thisSurveyName = strtoupper(str_replace("_", " ", mysqli_fetch_assoc($result)["surveyName"]));
							
							$thisWarningHTML = "";
						}
						else
						{
							$thisSurveyID = -1;
							$thisSurveyName = "No Valid URL";
							$thisWarningHTML = " class = 'warning'";
						}
					}
					else
					{
						$thisSurveyID = -1;
						$thisSurveyName = "No Valid URL";
						$thisWarningHTML = " class = 'warning'";
					}
					
					
					$allAnswerIDs = array();
					$allAnswerQIDs = array();
					$allAnswerData = array();
					$allAnswerTypes = array();
					$allAnswerQuantities = array();//multiple questions may use the same answer; as a result, this allows us to grab document.getElementsByName[X] where X is the amount of previous answers of this type as to distunguish how there can be multiple
					
					$SQL =
						"SELECT *
						FROM surveys_questionanswers
						INNER JOIN surveys_questions ON surveys_questionanswers.surveyQuestionID = surveys_questions.surveyQuestionID
						INNER JOIN surveys_answers ON surveys_questionanswers.surveyAnswerID = surveys_answers.surveyAnswerID
						WHERE surveys_questions.surveyID = {$thisSurveyID};";
					
					if($result = mysqli_query($connection, $SQL))
					{
						while($row = mysqli_fetch_assoc($result))
						{
							$thisAnswerID = $row["surveyAnswerID"];
							$thisAnswerQID = $row["surveyQuestionID"];
							$thisAnswerData = $row["surveyAnswerData"];
							$thisAnswerType = $row["surveyAnswerType"];
							
							$thisIteration = array_count_values($allAnswerIDs)[$thisAnswerID] ?? 0;//if first of this answer type, it will say 0; if second, 1; etc so you can document.getElementsByName[thisIteration]
							
							array_push($allAnswerIDs, $thisAnswerID);
							array_push($allAnswerQIDs, $thisAnswerQID);
							array_push($allAnswerData, $thisAnswerData);
							array_push($allAnswerTypes, $thisAnswerType);
							
							array_push($allAnswerQuantities, $thisIteration);//add count of however many thisAnswer's already exist
						}
					}
					
					
					$allAnswerIDsString = "[";
					$allAnswerQIDsString = "[";
					$allAnswerDataString = "[";
					$allAnswerQuantitiesString = "[";
					
					for($i = 0; $i < count($allAnswerIDs); $i++)
					{
						$allAnswerIDsString .= $allAnswerIDs[$i] . ", ";
						$allAnswerQIDsString .= $allAnswerQIDs[$i] . ", ";
						$allAnswerDataString .= "'" . $allAnswerData[$i] . "'" . ", ";
						$allAnswerQuantitiesString .= $allAnswerQuantities[$i] . ", ";
					}
					
					$allAnswerIDsString .= "]";
					$allAnswerQIDsString .= "]";
					$allAnswerDataString .= "]";
					$allAnswerQuantitiesString .= "]";
					
				?>
				
				<a href = "surveyNavigator.php" class = "button" style = "display: inline-block; margin-top: -5vh;"><<</a>
				<h2 style = "margin: -2.5vh 2.5vh 2.5vh; display: inline-block;">Survey:</h2><br/>
				<h1 style = "margin: -3vh 0vw 0vh; font-size: 2vw;" class = "subEmphasize"<?PHP echo $thisWarningHTML; ?>>-<?PHP echo $thisSurveyName; ?>-</h1>
				
				<div class = "tinyLine"></div>
				
				<p class = "subEmphasize">• Please respond to all of the fields below to submit your survey •</p>
				
				<script>
					
					let maxLikertAnswer = <?PHP echo $maxLikertAnswer; ?>;
					let neutralVal = maxLikertAnswer / 2;
					
					let maxWidth = 2;
					let dilutionValue = 10;//to expunge the possibility of dividing by 0; raises the min value
					let heightToWidthRatio = 5;
					
					let neutralColorRange = "#083651";
					let neutralColorThumb = "#F4F4F4";
					let agreeColor = "#03FC56";
					let disagreeColor = "#FC0349";
					
					let allAnswerIDs = <?PHP echo $allAnswerIDsString; ?>;
					let allAnswerQIDs = <?PHP echo $allAnswerQIDsString; ?>;
					let allAnswerData = <?PHP echo $allAnswerDataString; ?>;
					let allAnswerQuantities = <?PHP echo $allAnswerQuantitiesString; ?>;
					
					function SubmitSurvey()
					{
						let submit = true;
						
						let responses = [];
						
						for(i = 0; i < allAnswerIDs.length; i++)
						{
							let answerInput = document.getElementsByName("answerID" + allAnswerIDs[i])[allAnswerQuantities[i]];//for non-multiple_choice
							let answerValue;
							if (typeof answerInput != 'undefined'){ answerValue = answerInput.value; }
							let oneChecked;
							
							switch(allAnswerData[i])
							{
								case "multiple_choice":
									let theseUnderscores = "";
									
									for(a = 0; a < allAnswerQuantities[i]; a++)
									{
										theseUnderscores += "_";
									}
									
									let answerChoiceInputs = document.getElementsByName("multiple_choice" + theseUnderscores + "answerID" + allAnswerIDs[i]);//update into array for all choices
									
									let oneChecked = false;

									for(let thisChoiceInput of answerChoiceInputs)//iterate through choices and mark proceed as true if at least one is selected
									{
										let thisChoiceID = parseInt(thisChoiceInput.id.split("-")[1]);
										
										if(thisChoiceInput.checked)
										{
											oneChecked = true;
											
											responses["r" + allAnswerQIDs[i]] = thisChoiceID;//id is choiceID
											
											break;
										}
									}

									if(oneChecked == false) {
										submit = false;
									}

									break;
								case "date":
									if(!answerValue.match(/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/))
									{
										submit = false;
									}
									else
									{
										responses["r" + allAnswerQIDs[i]] = answerValue;
									}
									
									break;
								case "written":
									if(answerValue == "")
									{
										submit = false;
									}
									else
									{
										responses["r" + allAnswerQIDs[i]] = answerValue;
									}
									
									break;
								case "likert":
									if(answerValue == neutralVal)
									{
										submit = false;
									}
									else
									{
										responses["r" + allAnswerQIDs[i]] = answerValue;
									}
									
									break;
								case "dropbox":
									let thisDropbox = document.getElementsByName("dropbox_answerID" + allAnswerIDs[i])[0];//update into array for all choices
									let selectedElement = thisDropbox.options[thisDropbox.selectedIndex];
									
									//is default selection
									if (selectedElement.value == "N") {
										submit = false;
									} else {
										responses["r" + allAnswerQIDs[i]] = selectedElement.value;
									}

									break;
								case "N":
									submit = false;
									
									break;
							}
						}
						
						if(submit)
						{
							<?PHP $_SESSION["turnOver"] = true; ?>
							
							PostFromJS("./surveyConfirm.php?surveyID=" + <?PHP echo $thisSurveyID; ?>, responses);
						}
					}
					
					function DateFormatCheck(thisAnswerID, thisAnswerIteration)
					{
						let localInputElement = document.getElementsByName("answerID" + thisAnswerID)[thisAnswerIteration];
						let localInputText = localInputElement.value;
						
						if(!localInputText.match(/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/))
						{
							localInputElement.value = "YYYY-MM-DD";
						}
					}
					
					function UpdateRange(thisAnswerID, thisAnswerIteration)
					{
						function ConductFunction(thisAnswerID, thisAnswerIteration)
						{
							let answerRange = document.getElementsByName("answerID" + thisAnswerID)[thisAnswerIteration];
							let answerStyle = document.querySelector('[data = "likertSlider' + thisAnswerID + '-' + thisAnswerIteration + '"]');
							
							answerRange.max = maxLikertAnswer;
							answerRange.min = 0;
							
							if(answerRange.value < neutralVal)
							{
								answerRange.style.backgroundColor = disagreeColor;
							}
							else if(answerRange.value > neutralVal)
							{
								answerRange.style.backgroundColor = agreeColor;
							}
							else
							{
								answerRange.style.backgroundColor = neutralColorRange;
							}
							
							let newVal = ((Math.abs(neutralVal - answerRange.value) + dilutionValue) / (neutralVal + dilutionValue)) * maxWidth;
							let directoryStart = '.number' + thisAnswerID + '-' + thisAnswerIteration + '.slider';//just to save space with or statement for different ::slider-thumbs
							let firefoxWidth = 0.725;//if Chrome's width is 1, Firefox's is...
							let firefoxHeight = 0.875;//if Chrome's height is 1, Firefox's is...
							
							answerStyle.innerHTML = directoryStart + '::-webkit-slider-thumb, ' + directoryStart + '::-moz-range-thumb { border-color: ' + neutralColorThumb + '; }' + directoryStart + '::-webkit-slider-thumb { width: ' + newVal + 'vw; height: ' + (newVal * heightToWidthRatio) + 'vh; }' + directoryStart + '::-moz-range-thumb { width: ' + (newVal * firefoxWidth) + 'vw; height: ' + (newVal * firefoxHeight * heightToWidthRatio) + 'vh; }';
						}
						
						ConductFunction(thisAnswerID, thisAnswerIteration);
					}
					
				</script>
				
				<?PHP
					
					$first = true;
					
					if($thisSurveyID != -1)//if survey is valid
					{
						echo "<form method = 'POST'>";
						
						$SQL =
							"SELECT *
							FROM surveys_questions
							WHERE surveyID = {$thisSurveyID}
							ORDER BY surveyQuestionOrder ASC;";
						
						if($result = mysqli_query($connection, $SQL))
						{
							if(mysqli_num_rows($result) > 0)
							{
								while($row = mysqli_fetch_assoc($result))
								{
									$thisQuestionID = $row["surveyQuestionID"];
									$thisQuestionPrompt = $row["surveyQuestionPrompt"];
									$thisQuestionTarget = $row["surveyQuestionTarget"];
									
									if($first == false)
									{
										echo '<div class = "tinyLine" style = "margin-top: 2vh; margin-bottom: 7vh;"></div>';
									}
									else
									{
										$first = false;
									}
									
									echo "<h2>{$thisQuestionPrompt}</h2>";
									
									for($i = 0; $i < count($allAnswerIDs); $i++)
									{
										$thisAnswerID = $allAnswerIDs[$i];
										$thisAnswerQID = $allAnswerQIDs[$i];
										$thisAnswerData = $allAnswerData[$i];
										$thisAnswerType = $allAnswerTypes[$i];
										$thisIteration = $allAnswerQuantities[$i];//if first of this answer type, it will say 0; if second, 1; etc so you can document.getElementsByName[thisIteration]
										
										$theseUnderscores = "";
										
										for($a = 0; $a < $thisIteration; $a++)
										{
											$theseUnderscores .= "_";
										}
										
										if($thisAnswerQID == $thisQuestionID)
										{
											switch($thisAnswerData)
											{
												case "multiple_choice":
													$SQL =
														"SELECT *
														FROM surveys_choices
														WHERE surveyAnswerID = {$thisAnswerID}
														ORDER BY surveyChoiceOrder ASC;";
													
													if($result3 = mysqli_query($connection, $SQL))
													{
														echo "<ul>";
														
														while($row3 = mysqli_fetch_assoc($result3))
														{
															$thisChoiceID = $row3["surveyChoiceID"];
															$thisChoiceText = $row3["surveyChoiceText"];
															
															echo "<li class = 'clickable multiple_choice'><input class = 'multiple_choice_input' type = 'radio' name = 'multiple_choice{$theseUnderscores}answerID{$thisAnswerID}' id = 'choiceID{$thisAnswerQID}-{$thisChoiceID}'/><label for = 'choiceID{$thisAnswerQID}-{$thisChoiceID}'>{$thisChoiceText}</label></li>";
														}
														
														echo "</ul>";
													}
													else
													{
														echo "<p class = 'emphasize warning'>No multiple choices identified</p>";
													}
													
													break;
												case "date":
													echo
														'<div class = "formMain">
															Date of Birth<br/><input type = "text" name = "answerID' . $thisAnswerID . '" value = "YYYY-MM-DD" placeholder = "YYYY-MM-DD" onFocusOut = "DateFormatCheck(' . $thisAnswerID . ', ' . $thisIteration . ')"/>
														</div>
														
														<p class = "subEmphasize" style = "margin-top: 0;">It is important that you enter the date in the provided format</p>';
													
													break;
												case "written":
													echo '<textarea name = "answerID' . $thisAnswerID . '" placeholder = "ENTER YOUR RESPONSE HERE.  IF YOU HAVE NO OPINION, PLEASE ENTER \'N/A\'." style = "font-size: 1.5vw; padding: 5vw; height: 30vh; width: 60vw; border: 1vw solid #083651; background-color: #000020; color: #F4F4F4;"></textarea>';
													
													break;
												case "likert":
													$valencies = array("", "least", "", "", "most", "");
													
													for($v = 0; $v < count($valencies); $v++)
													{
														echo '<h2 class = "subEmphasize" style = "font-size: 1.5vw; display: inline-block; width: ' . (100 / (count($valencies) + 1)) . 'vw; margin-bottom: -8.5vh;">' . $valencies[$v] . '</h2>';
													}
													
													echo
														'<div class = "sliderContainer">
															
															<style data = "likertSlider' . $thisAnswerID . '-' . $thisIteration . '" type = "text/css"></style>
															
															<input type = "range" class = "number' . $thisAnswerID . '-' . $thisIteration . ' slider" name = "answerID' . $thisAnswerID . '" value = "' . ($maxLikertAnswer / 2) . '" onInput = "UpdateRange(' . $thisAnswerID . ', ' . $thisIteration . ')"/>
															
														</div>
														
														<script>UpdateRange(' . $thisAnswerID . ', ' . $thisIteration . ');</script>';
													
													break;
												case "dropbox":
													echo "<select name = 'dropbox_answerID{$thisAnswerID}' style = 'width: 20vw; background-color: #000020; color: #F4F4F4; border-radius: 3vw;'>";

													echo '<option value = "N">[No Selection]</option>';

													$SQL =
														"SELECT *
														FROM surveys_choices
														WHERE surveyAnswerID = {$thisAnswerID}
														ORDER BY surveyChoiceOrder ASC;";
													if ($result3 = mysqli_query($connection, $SQL)) {
														while ($row = mysqli_fetch_assoc($result3)) {
															echo "<option value = '".$row["surveyChoiceID"]."'>".$row["surveyChoiceText"]."</option>";
														}
													}
													
													echo '</select>';
													
													break;
												default:
													echo "<p class = 'emphasize warning'>Data type not identified</p>";
													
													$thisAnswerData = "N";
													
													break;
											}
										}
									}
								}
							}
							else
							{
								echo "<p><span class = 'emphasize warning'>Survey exists but currently contains no questions; please try retuning to the </span> <a href = 'surveyNavigator.php' class = 'linkButton warning'>survey navigator</a></p>";
							}
						}
						else
						{
							echo "<p><span class = 'emphasize warning'>Survey exists but currently contains no questions; please try retuning to the </span> <a href = 'surveyNavigator.php' class = 'linkButton warning'>survey navigator</a></p>";
						}
						
						echo
							'<br/><br/><br/><br/><input type = "button" class = "button" value = "SUBMIT" onClick = "SubmitSurvey()"/>';
						
						echo "</form>";
					}
					else
					{
						echo "<p><span class = 'emphasize warning'>Cannot find survey; please try returning to the</span> <a href = 'surveyNavigator.php' class = 'linkButton warning'>survey navigator</a></p>";
					}
					
				?>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
