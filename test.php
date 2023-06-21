<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"; ?>
		
		<title>Ocean - Test</title>
		<meta name = "description" content = "<b>Take the test</b> for self-insight."/>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" style = "scroll-snap-type: y mandatory;">
					
				<img src = "Images/SideArrow.png" style = "position: fixed; margin: 46vh 19.5vw; left: 0; width: 3vw; top: 0;" onDragStart = "return false;" />
				<img src = "Images/SideArrow.png" style = "position: fixed; margin: 46vh 77.5vw; left: 0; transform: rotate(180deg); width: 3vw; top: 0;" onDragStart = "return false;" />
				
				<div style = "scroll-snap-align: start none; margin-top: -5vh; padding-bottom: 5vh;"></div>
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
				
				<div style = "overflow: hidden; margin-top: -5vh;">
					
					<h2></h2>
					<img src = "Images/BlackLogo.png" style = "height: 15vh; margin: -11vh 0;" onDragStart = "return false;" class = "logo" name = "logo123" onClick = "RotateLogo(123)" />
					<h1 style = "margin: -4vh 0">OCEAN TYPE</h1>
					<img src = "Images/BlackLogo.png" style = "height: 15vh; margin: -11vh 0;" onDragStart = "return false;" class = "logo" name = "logo342" onClick = "RotateLogo(342)" />
					<h2>indicator</h2>
					
					<!--<img src = "Images/OTINodesLettersBorderedUnder.png" style = "margin: -3vh 0vw -3vh; height: 50vh; display: inline-block;" onDragStart = "return false;">-->
					
				</div>
				
				<div class = "tinyLine" style = "margin-top: 0vh;"></div>
				
				<p class = "subEmphasize" style = "margin: -3vh 0;">Indicate how strongly you</p>
				
				<h2 style = "color: #F4F4F4; border: 0.35vw solid #083651; background-color: #083651; border-radius: 1vw; width: 20vw; margin: 3vh auto 5vh; font-size: 1.25vw;">
					
					<span style = "color: #FC0349;">disagree&nbsp;&nbsp;</span>
					or
					<span style = "color: #03FC56;">&nbsp;&nbsp;&nbsp;agree&nbsp;&nbsp;</span>
					
				</h2>
				
				<p class = "subEmphasize" style = "margin-top: -3vh;">• Please leave no neutral responses • Answer carefully, honestly, and consistently •</p>
				<p class = "subEmphasize" style = "margin-top: -3vh;">• Respond based on your recent past behaviors, not based on how you wish you had acted •</p>
				
				<img src = "Images/ScrollArrowBlack.png" style = "width: 25vh; margin: -5vh 0; padding-bottom: 30vh;" onDragStart = "return false;" />
				
				<div name = "scrollOnTransition"></div>
				
				<p style = "margin-bottom: 0vh; font-size: 2vw; overflow: hidden;">
					<span class = "subEmphasize">TEST ADMINISTERED:</span>
					<?PHP
						$SQL =
							"SELECT testTakenID
							FROM tests_taken;";
						
						echo mysqli_num_rows(mysqli_query($connection, $SQL)) + 1;
					?>
				</p>
				
				<h2 style = "margin: 0 0 1vh;">slide to indicate the strength of your reaction:</h2>
				
				<?PHP
					
					$totalAnswerRanges = 0;
					
					echo
						'<script>
							function ScrollToNext(thisId)
							{
								setTimeout(function()
								{
									if(document.getElementById("answerRange" + (thisId + 1))){
										document.getElementById("answerRange" + (thisId + 1)).scrollIntoView({behavior: "smooth", block: "center"});
									}else{
										document.getElementById("answerRangeWildcard").scrollIntoView({behavior: "smooth", block: "center"});
									}
								}, 220);
							}
						</script>';
					
					if($currentVersionID != -1)
					{
						$questionsPerPage = 6;
						
						//populate page with questions
						for($i = 0; $i < $questionsPerPage; $i++)
						{
							$totalAnswerRanges++;
							
							echo '<div name = "answer" style = "scroll-snap-align: center none; margin-bottom: -8vh; padding-bottom: 4vh;">';
							
							//if($i != 0)
							//{
								echo '<div class = "tinyLine" style = "margin: 2vh auto 7vh;"></div>';
							//}
							
							echo '<p name = "answerText" class = "answerText" style = "font-family: verdana;"></p>';
							
							$valencies = array("", "disagree", "", "", "agree", "");
							
							for($v = 0; $v < count($valencies); $v++)
							{
								echo '<h2 class = "subEmphasize" style = "left: 0; font-size: 1.5vw; display: inline-block; width: ' . (100 / (count($valencies) + 1)) . 'vw; margin-bottom: -8.5vh;">' . $valencies[$v] . '</h2>';
							}
							
							echo
								'<div class = "sliderContainer">
									
									<style data = "sliderThumb' . $i . '" type = "text/css"></style>
									
									<input type = "range" class = "number' . $i . ' slider" name = "answerRange" id = "answerRange' . $i . '" onInput = "UpdateRange(' . $i . ')" onmouseup = "ScrollToNext(' . $i .');" />
									
								</div>';
							
							echo '</div>';
						}
					}
					else
					{
						echo '<p class = "emphasize warning">Unfortunately, no questions are currently in the system.  This means that the test\'s database is under maintainance and will be fixed very soon.</p>';
					}
					
				?>
				
				<br/>
				
				<div id = "dotContainer"></div>
				
				<script src = "Handlers/handler_searchCurrentType.js"></script>
					
				<script>//master script to update questions and manage sliders
					
					<?PHP
						
						if($currentVersionID != -1)
						{
							$suffix = ", ";

							//get database questions from php for JavaScript access
							$finalStringIDs = "";
							$finalStringCorrelates = "";
							$finalStringTraits = "";
							$finalStringPositives = "";
							$finalStringPrompts = "";
							$finalStringQuestionsPerTrait = array(0, 0, 0, 0, 0);
							
							$totalQuestions = 0;
							
							$SQL =
								"SELECT *
								FROM questions_general
								INNER JOIN versions_questions
								ON questions_general.questionID = versions_questions.questionID
								WHERE versions_questions.versionID = {$currentVersionID}
								ORDER BY questionTrait ASC, questionPositive ASC;";
							
							$result = mysqli_query($connection, $SQL);//result questions_general
							
							while($row = mysqli_fetch_assoc($result))//for all questions that are of trait and positive
							{
								$finalStringIDs .= $row["questionID"] . $suffix;//adds question correlate QID, or if nil, -1
								$finalStringCorrelates .= $row["questionCorrelate"] . $suffix;//adds question correlate QID, or if nil, -1
								$finalStringTraits .= $row["questionTrait"] . $suffix;//adds each question type 1-5
								$finalStringPositives .= $row["questionPositive"] . $suffix;//adds each question positive 0-1
								$finalStringPrompts .= '"' . $row["questionPrompt"] . '"' . $suffix;//adds each question text string
								
								if($row["questionCorrelate"] == -1)
								{
									$finalStringQuestionsPerTrait[($row["questionTrait"] - 1)] += 1;//add a whole for a non-correlate
								}
								else
								{
									$finalStringQuestionsPerTrait[($row["questionTrait"] - 1)] += 0.5;//add a half for a correlate
								}
								
								$totalQuestions++;
							}
							
							$numPages = round(($totalQuestions / $questionsPerPage) + 0.499);
							
							$questionsOnFinalPage = $questionsPerPage - (($questionsPerPage * $numPages) - $totalQuestions);
							
							echo
								"let currentVersionID = {$currentVersionID};
								let currentVersionNumber = {$currentVersionNumber};
								let currentVersionMaxValue = {$currentVersionMaxValue};
								
								let questionLists = [[{$finalStringIDs}], [{$finalStringCorrelates}], [{$finalStringTraits}], [{$finalStringPositives}], [{$finalStringPrompts}]];
								
								let questionsPerTrait = [{$finalStringQuestionsPerTrait[0]}, {$finalStringQuestionsPerTrait[1]}, {$finalStringQuestionsPerTrait[2]}, {$finalStringQuestionsPerTrait[3]}, {$finalStringQuestionsPerTrait[4]}];
								
								let questionsPerPage = {$questionsPerPage};
								let totalQuestions = {$totalQuestions};
								let numPages = {$numPages};
								let questionsOnFinalPage = {$questionsOnFinalPage};";
						}
					
					?>
					
					if(currentVersionID != -1)
					{
						let scrollOnTransition = document.getElementsByName("scrollOnTransition")[0];
						
						let neutralVal = currentVersionMaxValue / 2;
						
						let answerTexts = document.getElementsByName("answerText");
						let answerRanges = document.getElementsByName("answerRange");
						
						let currentPage = -1;//ranges from 0 to finalPage
						let finalPage = numPages - 1;
						
						let typeValues = [0, 0, 0, 0, 0, 0];//stores values for finalization; ctrl, o, c, e, a, n
						let userResponses = [];//stores individual question responses
						let scatterOrder = [];
						
						//fill arrays based on amount of totalQuestions
						for(let i = 0; i < totalQuestions; i++)
						{
							scatterOrder.push(i);
						}
						
						//scatter scatterOrder
						for (let i = scatterOrder.length - 1; i > 0; i--)
						{
							let j = Math.floor(Math.random() * (i + 1));
							
							[scatterOrder[i], scatterOrder[j]] = [scatterOrder[j], scatterOrder[i]];
						}
						
						
						function ReturnRandomPos(i)//where i is serial index in 0-inf
						{
							return scatterOrder[i];//ReturnRandomPos(0) -> 5; ReturnRandomPos(9) -> 8;
						}
						
						function ReturnOrderedPos(i)//where i is scattered location and needs converted back to serial index
						{
							return scatterOrder.indexOf(i);//ReturnOrderedPos(5) -> 0; ReturnOrderedPos(8) -> 9;
						}
						
						
						let dotContainer = document.getElementById("dotContainer");
						let answerArray = document.getElementsByName("answer");
						
						
						let correlatesIDs = [];
						let correlatesValues = [];
						
						
						let currentPageQuestions;
						let newPageQuestions;
						
						
						let maxWidth = 2;
						let dilutionValue = 10;//to expunge the possibility of dividing by 0; raises the min value
						let heightToWidthRatio = 5;
						
						let neutralColorRange = "#083651";
						let neutralColorThumb = "#F4F4F4";
						let agreeColor = "#03FC56";
						let disagreeColor = "#FC0349";

						let varianceNumerator = 0;
						
						
						function UpdateRange(rangeToUpdate)
						{
							function ConductFunction(i)
							{
								let answerRange = answerRanges[i];
								let answerStyle = document.querySelector('[data = "sliderThumb' + i + '"]');
								
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
								let directoryStart = '.number' + i + '.slider';//just to save space with or statement for different ::slider-thumbs
								let firefoxWidth = 0.725;//if Chrome's width is 1, Firefox's is...
								let firefoxHeight = 0.875;//if Chrome's height is 1, Firefox's is...
								
								answerStyle.innerHTML = directoryStart + '::-webkit-slider-thumb, ' + directoryStart + '::-moz-range-thumb { border-color: ' + neutralColorThumb + '; }' + directoryStart + '::-webkit-slider-thumb { width: ' + newVal + 'vw; height: ' + (newVal * heightToWidthRatio) + 'vh; }' + directoryStart + '::-moz-range-thumb { width: ' + (newVal * firefoxWidth) + 'vw; height: ' + (newVal * firefoxHeight * heightToWidthRatio) + 'vh; }';
							}
							
							if(rangeToUpdate == -1)//update all
							{
								for(i = 0; i < newPageQuestions; i++)
								{
									ConductFunction(i);
								}
							}
							else//update individual
							{
								ConductFunction(rangeToUpdate);
							}
						}
						
						
						function NextPage()
						{
							let newPage = currentPage + 1;
							
							if(currentPage == finalPage)//if is final page
							{
								currentPageQuestions = questionsOnFinalPage;
							}
							else
							{
								currentPageQuestions = questionsPerPage;
							}
							
							if(newPage == finalPage)//if is final page
							{
								newPageQuestions = questionsOnFinalPage;
							}
							else
							{
								newPageQuestions = questionsPerPage;
							}
							
							
							//checks whether currentPage has neutral values to keep next from working
							let noNeutrals = true;
							
							for(let i = 0; i < currentPageQuestions; i++)
							{
								if(answerRanges[i].value == neutralVal)
								{
									noNeutrals = false;
									
									break;
								}
							}
							
							if(noNeutrals || newPage == 0)//if there's no neutral values or it's the initial start, then run
							{
								
								function TransitionPage(updatePhysicalValues, updateStoredValues)
								{
									for(let iLocal = 0; iLocal < questionsPerPage; iLocal++)//iterate through each answer on page where iLocal is current answer on page targeted starting at 0
									{
										let iCurrentGlobal = iLocal + (currentPage * questionsPerPage);//get position in currentPage for retrospective updates
										let iNewGlobal = iLocal + (newPage * questionsPerPage);//get position in nextPage for proactive updates
										
										let answerText = answerTexts[iLocal];
										let answerRange = answerRanges[iLocal];
										
										
										if(updateStoredValues)//RETROACTIVE updates the stored values of the page it's moving off from
										{
											if(totalQuestions > iCurrentGlobal)//ensures current page does not look for nonexistent questions to retrieve values from
											{
												let meanRangeVal = 0;//I hate myself for this.  I am well aware of how disgusting this section is.
												for (let iLocal2 = 0; iLocal2 < questionsPerPage; iLocal2++) {
													//set value to add
													let newVal2 = -1;
													let iCurrentGlobal2 = iLocal2 + (currentPage * questionsPerPage);//get position in currentPage for retrospective updates
													let answerRange2 = answerRanges[iLocal2];
													if (answerRange2 == undefined) { break; }
													let iCurrentRandomGlobal2 = ReturnRandomPos(iCurrentGlobal2);//i position relative to page question order; iCurrentGlobal is i position relative to where stored in database
													
													if(questionLists[3][iCurrentRandomGlobal2] == 1)//question is positive
													{
														newVal2 = answerRange2.value;
													}
													else//question is negative
													{
														newVal2 = currentVersionMaxValue - answerRange2.value;//inverse
													}
													
													meanRangeVal += parseInt(newVal2);
												}
												meanRangeVal /= answerRanges.length;

												//set value to add
												let newVal = -1;
												let iCurrentRandomGlobal = ReturnRandomPos(iCurrentGlobal);//i position relative to page question order; iCurrentGlobal is i position relative to where stored in database
												
												if(questionLists[3][iCurrentRandomGlobal] == 1)//question is positive
												{
													newVal = answerRange.value;
												}
												else//question is negative
												{
													newVal = currentVersionMaxValue - answerRange.value;//inverse
												}

												varianceNumerator += Math.pow(newVal - meanRangeVal, 2);
												
												userResponses[iCurrentRandomGlobal] = newVal;//adds individual user response
												
												let questionCorrelate = questionLists[1][iCurrentRandomGlobal];
												
												//manage controls
												if(questionCorrelate != -1)
												{
													let orderedIndex = correlatesIDs.indexOf(questionLists[0][iCurrentRandomGlobal]);//finds number index in correlateIDs to see whether it is undefined (not added) or defined (is added)
													
													if(correlatesIDs[orderedIndex])//if correlate has already been added and it's not within one valency of newVal OR they're not on the same side of pro/con trait
													{
														//if difference > 6
														if((Math.abs(correlatesValues[orderedIndex] - newVal) > currentVersionMaxValue / 3)/* ||
															(correlatesValues[orderedIndex] > neutralVal && neutralVal > newVal) ||
															(newVal > neutralVal && neutralVal > correlatesValues[orderedIndex])*/)
														{
															typeValues[0] += 1;//typeValues adds one for each missed correlate, STRIKE
														}
													}
													else//if this is the first correlate of ID
													{
														correlatesValues.push(newVal);
														correlatesIDs.push(questionCorrelate);
													}
													
													newVal /= 2;//split its weight between this and its correlate for one response
												}
												
												//adds new value to ctrl, o, c, e, a, n; grabs current questionTraitList int, sums it with newVal, then reverts to int for saved value
												typeValues[questionLists[2][iCurrentRandomGlobal]] += parseInt(newVal);
											}
										}
										
										if(updatePhysicalValues)//PROACTIVE update text values to that of next page and sets values to neutral
										{
											if(totalQuestions > iNewGlobal)//ensures final page does not look for nonexistent questions to set the text of
											{
												answerText.innerHTML = questionLists[4][ReturnRandomPos(iNewGlobal)];//update to newPage's text
												
												answerRange.value = neutralVal;
												
												if(answerRange.max != currentVersionMaxValue || answerRange.min != 0)//sets default values of answerRanges if it's the first page and not already set
												{
													answerRange.max = currentVersionMaxValue;
													answerRange.min = 0;
												}
											}
										}
									}
								}
								
								function UpdateProgressDots()
								{
									while(dotContainer.firstChild)//remove any existing dots for future replacement
									{
										dotContainer.removeChild(dotContainer.firstChild);
									}
									
									//add updated dots
									for(let i = 0; i < numPages; i++)
									{
										let dotType = "";
										
										if(i <= newPage)//if creating dot of or before current page
										{
											dotType = "fullDot";
										}
										else//if creating dot of page not discovered yet
										{
											dotType = "emptyDot";
										}
										
										//append new divs
										let newDiv = document.createElement("div");
										newDiv.className = "progressDots " + dotType;
										
										dotContainer.appendChild(newDiv);//create each new dot
									}
								}
								
								if(newPage < numPages)//if final page or before
								{
									if(newPage == 0)//if updating first time
									{
										TransitionPage(true, false);//update physical values to newPage; don't store values of currentPage since it doesn't yet exist//FIRST
									}
									else//if updating after first time
									{
										TransitionPage(true, true);//update physical values to newPage; store new values selected on currentPage//BETWEEN
										
										setTimeout(function()
										{
											scrollOnTransition.scrollIntoView({behavior: "smooth", block: "start"});
										}, 1);
									}
									
									if(newPage == finalPage)//if updating to final page, destroy extra answer spaces (but so it can store currentPage's values first, only do this after transitioning)
									{
										let questionsToDestroy = answerArray.length - questionsOnFinalPage;
										
										while(questionsToDestroy > 0)
										{
											answerArray[answerArray.length - 1].remove();
											answerArray = document.getElementsByName("answer");
											
											questionsToDestroy = answerArray.length - questionsOnFinalPage;
										}
										
										//redefine answerTexts and answerRanges after deleting redundant ones
										answerTexts = document.getElementsByName("answerText");
										answerRanges = document.getElementsByName("answerRange");
									}
									
									UpdateRange(-1);//update all ranges
									UpdateProgressDots();
								}
								else if(newPage == numPages)//if finished final page, finalize quiz
								{
									TransitionPage(false, true);//don't physical values to newPage since there is no next page; store new values selected on currentPage//LAST
									
									//if three correlate pairs and one strike, say controls don't align; if four correlate pairs and one strike, they do
									//(> 1/3 questions must be inconsistent)
									//50% or less variance leads to it being nullified
									let controlsAlign;
									
									if((typeValues[0] != 0 && typeValues[0] > Math.round((correlatesIDs.length / 3) + 0.499))
									|| Math.abs(varianceNumerator / totalQuestions) / currentVersionMaxValue < 0.5)
									{
										controlsAlign = false;
									}
									else//controls do align
									{
										controlsAlign = true;
									}
									
									//compile OTI list
									let currentType = "";
									
									for(let t = 1; t <= 5; t++)
									{
										let typeNumber;
										
										if(typeValues[t] < (questionsPerTrait[(t - 1)] * currentVersionMaxValue * (1 / 3)))//1 threshold
										{
											typeNumber = "1";
										}
										else if(typeValues[t] > (questionsPerTrait[(t - 1)] * currentVersionMaxValue * (2 / 3)))//3 threshold
										{
											typeNumber = "3";
										}
										else//2 threshold
										{
											typeNumber = "2";
										}
										
										currentType += typeNumber;
									}
									
									let userID = <?PHP echo $userID; ?>;
									
									//if(controlsAlign == false && userID != -1)//redirect to the you-were-cheating page if they're logged in and would have had their data recorded
									//{
									//	location.replace("invalidAnswers.php");
									//}
									//else//update location with complex data to record if logged in, with surface data to discard if not
									//{
										let responses = [];
										
										for(i = 0; i < totalQuestions; i++)
										{
											responses["r" + i] = userResponses[i];
										}
										
										<?PHP $_SESSION["turnOver"] = true; ?>
										
										PostFromJS("./ties.php?OTIType=" + currentType, responses);
									//}
								}
								
								currentPage = newPage;//if next page runs, update currentPage to newPage
								
							}
						}
						
						NextPage();//set first page values
					}
					
				</script>
				
				<br/>
				
				<input type = "button" class = "button" value = "NEXT" onClick = "NextPage()" style = "padding-bottom: 20vh;"/>
				
				<div style = "scroll-snap-align: end none; padding-bottom: 16vh;" id = "answerRangeWildcard">
				
			</div>
			
		</div>
		
	</body>

</html>
