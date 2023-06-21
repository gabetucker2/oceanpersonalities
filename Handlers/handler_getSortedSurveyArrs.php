<?PHP
	
	$incompleteStrings = array();
	$completeStrings = array();
	
	$SQL =
		"SELECT *
		FROM surveys_general
		WHERE surveys_general.surveyHidden = 0
		ORDER BY surveys_general.surveyOrder ASC;";
	
	if($result = mysqli_query($connection, $SQL))
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$surveyHidden = $row["surveyHidden"];
			$surveyID = $row["surveyID"];
			
			$surveyName = strtoupper(str_replace("_", " ", $row["surveyName"]));
			
			$SQL =
				"SELECT *
				FROM surveys_taken
				WHERE userID = {$userID} AND surveyID = {$surveyID};";
			
			if(empty(@mysqli_num_rows(mysqli_query($connection, $SQL))))
			{
				array_push($incompleteStrings, "<a href = 'surveyTake.php?surveyID={$surveyID}' class = 'linkButton warning'>{$surveyName}</a>");
			}
			else
			{
				array_push($completeStrings, "<a href = 'surveyTake.php?surveyID={$surveyID}' class = 'linkButton'>{$surveyName}</a>");
			}
		}
	}
	
?>
