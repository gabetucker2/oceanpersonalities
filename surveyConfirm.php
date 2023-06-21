<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Surveys</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php";?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
			
				<h1 style = "margin: -2vh 0 0vh; font-size: 2vw;">SURVEY CONFIRMATION</h1>
				
				<div class = "tinyLine"></div>
				
				<?PHP
					
					if($_SESSION["turnOver"] == true)
					{
						$_SESSION["turnOver"] = false;
						
						$thisSurveyID = $_GET["surveyID"];
						
						$SQL =
							"INSERT INTO surveys_taken (userID, surveyID, surveyTakenTime)
							VALUES ({$userID}, {$thisSurveyID}, \"" . date("Y-m-d H:i:s") . "\");";
						
						mysqli_query($connection, $SQL);
						$thisSurveyTakenID = mysqli_insert_id($connection);
						
						foreach($_POST as $key => $value)
						{
							$thisQuestionID = substr($key, 1);
							
							$SQL =
								"SELECT surveyAnswerID
								FROM surveys_questionanswers
								WHERE surveyQuestionID = {$thisQuestionID};";
							
							$thisAnswerID = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["surveyAnswerID"];
							
							$thisResponse = $value;
							
							$SQL =
								"INSERT INTO surveys_responses (surveyTakenID, surveyQuestionID, surveyAnswerID, surveyResponse)
								VALUES ({$thisSurveyTakenID}, {$thisQuestionID}, {$thisAnswerID}, \"{$thisResponse}\");";
							
							mysqli_query($connection, $SQL);
						}
						
						require "Handlers/handler_getSortedSurveyArrs.php";
						
						echo "<p class = 'leftParagraph'>Thank you for taking this survey.<br/><br/>We have recorded your responses, and our other surveys can be found at the <a href = 'surveyNavigator.php' class = 'linkButton'>navigation page</a>.";
						
						if($incompleteStrings && count($incompleteStrings) > 0)
						{
							$thisSurvey = $incompleteStrings[0];
							
							echo "<br/><br/>Alternatively, you can take the next available survey at {$thisSurvey}.";
						}
						
						echo "<br/><br/>The answers you provided will be scrutinized and significantly help us to shape the future of the OTI.</p>";
					}
					else
					{
						echo "<br/><br/><br/><p class = 'emphasize warning'>Not here from previous page</p><br/><br/><br/>";
					}
					
				?>
				
				<div class = "line"></div>
				
				<br/><a href = "profile.php" class = "linkButton">Return to Profile</a>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
