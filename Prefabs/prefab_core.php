<?PHP

	session_start();
	
	require "Handlers/handler_database.php";
	
	
	//global variables
	
	$startURLS = array("/oceanpersonalities/", "/OceanPersonalities/", "/", "");
	
	if(in_array($_SERVER["REQUEST_URI"], $startURLS)){
		echo '<script>let isJustArriving = true;</script>';
	}else{
		echo '<script>let isJustArriving = false;</script>';
	}
	
	$zeros = "00000";
	
	$traitWords = array("openness", "conscientiousness", "extraversion", "agreeableness", "neuroticism");
	echo '<script>let traitWords = ["openness", "conscientiousness", "extraversion", "agreeableness", "neuroticism"];</script>';
	$traitLetters = array("O", "C", "E", "A", "N");
	$traitNumerals = array("I", "II", "III");
	
	$userID = -1;
	$userUsername = "";
	$userFirstName = "";
	$userEmail = "";
	$userOTI = "";
	$userAdmin = false;
	
	$decimalLimit = 3;
	
	$userOTINumerals = "";
	
	$userTypeName = "Placeholder";
	
	$currentVersionID = -1;
	$currentVersionNumber = -1;
	$currentVersionMaxValue = -1;
	
	
	$oceanColors = array();
	
	$oceanStyles = array
	(
		array(),//emphasize span (use PHP to set style)
		array(),//emphasize header (use PHP to set style)
		array(),//button hover (use onMouseOver and onMouseOut to set style)
		array()//textHighlight hover (use onMouseOver and onMouseOut to set style)
	);
	
	for($i = 0; $i < count($traitWords); $i++)
	{
		$SQL =
			"SELECT oceanColor
			FROM traits_ocean
			WHERE localID = " . ($i + 1) . ";";
		
		$result = mysqli_query($connection, $SQL);
		
		$color = mysqli_fetch_assoc($result)["oceanColor"] ?? "000020";
		
		array_push($oceanStyles[0], "text-shadow: 0 0.2vh #{$color};");
		array_push($oceanStyles[1], "text-shadow: 0 0.4vh #{$color};");
		array_push($oceanStyles[2], "this.style.textShadow = '0 0.4vh #{$color}';");
		array_push($oceanStyles[3], "this.style.textShadow = '0 0.2vh #{$color}';");
		array_push($oceanColors, $color);
	}
	
	$noTextShadow = "this.style.textShadow = '';";
	$clickTextShadow = "this.style.textShadow = '0 0.2vh #67C1C7';";
	$clickButtonShadow = "this.style.textShadow = '0 0.4vh #67C1C7';";
	
	$domainNames = array();
	$domainStyles = array();//emphasize (ues PHP to set style)
	
	$clickStyle = "";
	
	$SQL =
		"SELECT *
		FROM traits_domains;";
	
	$result = mysqli_query($connection, $SQL);
	
	while($row = mysqli_fetch_assoc($result))
	{
		array_push($domainNames, $row["domainName"]);
		array_push($domainStyles, "text-shadow: 0 0.2vh #" . $row["domainColor"] . ";");
	}
	
	//
	
	
	if(isset($_SESSION["userID"]))
	{
		$userID = $_SESSION["userID"];
		$userUsername = $_SESSION["userUsername"];
		$userFirstName = $_SESSION["userFirstName"];
		$userEmail = $_SESSION["userEmail"];
		$userOTI = $_SESSION["userOTI"];
		
		if($_SESSION["userAdmin"] == 1)
		{
			$userAdmin = true;
		}
		
		if($userOTI != $zeros && intval($userOTI) != 0)
		{
			for($t = 0; $t < 5; $t++)
			{
				$userOTINumerals .= $traitLetters[$t] . $traitNumerals[intval($userOTI[$t]) - 1];
			}
			
			$SQL =
				'SELECT typeName
				FROM types_general
				WHERE OTI = ' . $userOTI . ';';
			
			if($result = mysqli_query($connection, $SQL))
			{
				$userTypeName = mysqli_fetch_assoc($result)["typeName"];
			}
		}
	}
	
	$SQL =
		'SELECT *
		FROM versions_general
		ORDER BY versionID DESC;';
	
	if($result = mysqli_query($connection, $SQL))
	{
		$row = mysqli_fetch_assoc($result);
		
		$currentVersionID = $row["versionID"];
		$currentVersionNumber = $row["versionNumber"];
		$currentVersionMaxValue = $row["versionMaxValue"];
	}
	
	date_default_timezone_set("America/New_York");
	
	echo
		'<meta name = "author" content = "Gabe Tucker"/>
		<meta name = "keywords" content = "Big Five, Personality, Test, Ocean, Psychology, Personality Test, Ocean Personalities"/>
		<meta name = "viewport" content = "width = device-width, initial-scale = 1.0"/>
		
		<link rel = "shortcut icon" href = "Images/favicon.ico" type = "image/x-icon"/><!--Favicon-->
		<link rel = "icon" href = "Images/favicon.ico" type = "image/x-icon"/><!--Favicon-->
		
		<link rel = "stylesheet" href = "mainStyle.css"/><!--CSS-->
		
		<meta property = "og:image" content = "https://www.oceanpersonalities.com/Images/LogoPadded.png?latest3254"/><!--must change latest number if image of same name is updated-->
		
		<script src = "Handlers/handler_rotateLogo.js"></script>
		<script src = "Handlers/handler_postFromJS.js"></script>
		<script src = "Handlers/handler_searchCurrentType.js"></script>';
	
	$thisStyle = array("", "", "");
	
	if(isset($_SERVER["HTTP_USER_AGENT"]) && strstr($_SERVER["HTTP_USER_AGENT"], "Firefox"))
	{
		echo '<script>let delayInMS = 200;</script>';
	}
	else
	{
		echo '<script>let delayInMS = 400;</script>';
	}
	
	echo
		'<script>

			let zeros = "00000";
			
			let intervalScroll;
			
			let timesToFade = 20;
			let fadeTime = 0.35;
			let fadeIncrement = 1 / timesToFade;
			let currentFade;
			let remainingFades;
			
			let hasScrolled = false;
			let isScrollPage = false;
			
			function SubExecute(thisScroll, fadeOut)//not primed to have both a preludeScroll and scrollLabel on the same page
			{
				intervalScroll = setInterval(MakeFade, (500 * fadeTime / timesToFade));
				
				function MakeFade()
				{
					if(((currentFade > 0 && fadeOut) || (currentFade < 1 && !fadeOut)) && remainingFades > 0)
					{
						if(fadeOut){
							currentFade -= fadeIncrement;
						}else{
							currentFade += fadeIncrement;
						}
						
						if(currentFade < 0){
							currentFade = 0;
						}else if(currentFade > 1){
							currentFade = 1;
						}
						
						remainingFades--;
						
						let hasIncremented = false;
						
						function FadeIncrement()
						{
							if(!hasIncremented)
							{
								hasIncremented = true;
								
								thisScroll.style.opacity = currentFade;
							}
						}
						
						clearInterval(intervalScroll);
						
						SubExecute(thisScroll, fadeOut);
						
						FadeIncrement();
					}
					else{
						clearInterval(intervalScroll);
					}
				}
			}
			
			function ExecuteFade(thisScroll, fadeOut)
			{
				remainingFades = 20;
				
				SubExecute(thisScroll, fadeOut);
			}
			
			let isFullyLoaded = false;
			
			let isJustArrivingScrollPromptDelay = 1500;
			
			document.addEventListener("DOMContentLoaded", (event) => setTimeout(function()
			{
				if(!isJustArriving)
				{
					document.getElementById("header").scrollIntoView({behavior: "smooth", block: "start"});
				}
				
				document.body.className += " loaded";
			}, delayInMS));
			
			function OscillateScroll()
			{
				if(isJustArriving && !hasScrolled)
				{
					setTimeout(function()
					{
						let thisScroll = document.getElementsByName("preludeScrollArrow")[0];
						
						currentFade = 0;
						ExecuteFade(thisScroll, false);
						
						setTimeout(function()
						{
							ExecuteFade(thisScroll, true);
							
							OscillateScroll();
						}, 1000);
					}, 500);
				}
			}
			
			document.addEventListener("DOMContentLoaded", (e) => setTimeout(function()
			{
				OscillateScroll();
			}, isJustArrivingScrollPromptDelay));
			
			/*document.addEventListener("DOMContentLoaded", (e) => setTimeout(function()
			{
				//document.getElementsByName("ghostLogo")[0].style.opacity = 0;
			}, (delayInMS * 1)));*/
			
			document.addEventListener("DOMContentLoaded", (e) => setTimeout(function()
			{
				isFullyLoaded = true;
			}, (delayInMS * 5)));
			
			
			function ScrollCalled()
			{
				if(hasScrolled == false && isFullyLoaded == true)
				{
					hasScrolled = true;
					
					if(isScrollPage == true){
						let thisScroll = document.getElementsByName("scrollIndicator")[0];
						
						currentFade = 1;
						ExecuteFade(thisScroll, true);
					}
				}
			}
			
		</script>';
	
	//get stats
	$thisUserTraits = array(0, 0, 0, 0, 0);
	$thisUserTotalResponses = array(0, 0, 0, 0, 0);
	$thisUserVersionMaxValue = 0;
	$thisUserTraits;
	$thisUserTraitsPercentiles = array(0, 0, 0, 0, 0);

	$otherUsersWithHigherTraits = array(0, 0, 0, 0, 0);//for percentile finding
	$otherUserTraits = array(0, 0, 0, 0, 0);
	$otherUserTotalResponses = array(0, 0, 0, 0, 0);
	$otherUserDivisionFactorsLocal = array(0, 0, 0, 0, 0);
	$otherUserVersionMaxValues = array();
	
	$otherUsersCount = 0;

	//set percentiles
	$SQL =
		"SELECT mainTT.testTakenID testID, questions_general.questionTrait trait, questions_general.questionCorrelate correlate, tests_responses.questionResponse response, versions_general.versionMaxValue maxVal, mainTT.userID userID
		FROM tests_taken mainTT
		INNER JOIN tests_responses ON tests_responses.testTakenID = mainTT.testTakenID
		INNER JOIN questions_general ON questions_general.questionID = tests_responses.questionID
		INNER JOIN versions_general ON versions_general.versionID = mainTT.versionID
		WHERE mainTT.testTakenID = (
			SELECT MAX(subTT.testTakenID)
			FROM tests_taken subTT
			WHERE mainTT.userID = subTT.userID
		)
		ORDER BY mainTT.testTakenID ASC;";

	if ($result = mysqli_query($connection, $SQL)) {
		if ($userID != -1 && $userOTI != '' && $userOTI != $zeros) {//need separate line or else it'll screw up $result
			$prevTestID = "";
			$prevMaxVal = 0;

			$firstRun = true;
			$localTraitValues;
			$localTraitQuantities;
			
			$allLocalTraitValues = array();//array of arrays of trait responses
			$allLocalTraitMaxValues = array();//array of max values
			$allLocalTraitQuantities = array();//array of arrays of how many responses per summed value

			function PushUsers() {
				global $allLocalTraitValues; global $localTraitValues; global $allLocalTraitMaxValues; global $prevMaxVal; global $allLocalTraitQuantities; global $prevTraitQuantity; global $otherUsersCount;
				$otherUsersCount ++;
				array_push($allLocalTraitValues, $localTraitValues);
				array_push($allLocalTraitMaxValues, $prevMaxVal);
				array_push($allLocalTraitQuantities, $prevTraitQuantity);
			}

			while ($row = mysqli_fetch_assoc($result)) {
				$thisTestID = $row["testID"];
				$t = $row["trait"] - 1;

				if ($userID == $row["userID"]) {//thisUser

					$thisUserVersionMaxValue = $row["maxVal"];

					if ($row["correlate"] == -1) {
						$thisUserTraits[$t] += $row["response"];
						$thisUserTotalResponses[$t] ++;
					} else {
						$thisUserTraits[$t] += $row["response"] / 2;
						$thisUserTotalResponses[$t] += 0.5;
					}

				} else {//other user
					
					if ($prevTestID != $thisTestID) {//update each trait array for each new row
						if (!$firstRun) {
							PushUsers();
						} else {
							$firstRun = false;
						}
		
						$localTraitValues = array(0, 0, 0, 0, 0);
						$localTraitQuantities = array(0, 0, 0, 0, 0);
					}
		
					if ($row["correlate"] == -1) {
						$localTraitValues[$t] += $row["response"];
						$localTraitQuantities[$t] ++;
					} else {
						$localTraitValues[$t] += $row["response"] / 2;
						$localTraitQuantities[$t] += 0.5;
					}
		
					$prevTestID = $thisTestID;
					$prevMaxVal = $row["maxVal"];
					$prevTraitQuantity = $localTraitQuantities;
				
				}
			}

			PushUsers();//do it after since it doesn't detect after last iteration within loop

			//update thisUser values
			for ($t = 0; $t < 5; $t++) {

				//currently unaveraged raw number

				$thisUserTraits[$t] /= $thisUserTotalResponses[$t];
				//currently averaged raw number

				$thisUserTraits[$t] /= $thisUserVersionMaxValue;
				//currently percentage

			}

			//update other values
			for ($u = 0; $u < $otherUsersCount; $u++) {
				for ($t = 0; $t < 5; $t++) {
					
					//SET OTHER ARRAY VALS
					//currently unaveraged raw number

					$allLocalTraitValues[$u][$t] /= $allLocalTraitQuantities[$u][$t];//////////////////////////////////////////DIVISION BY 0 ERROR!!!!!!!!!!!!!!!
					//currently averaged raw number
					
					$allLocalTraitValues[$u][$t] /= $allLocalTraitMaxValues[$u];//////////////////////////////////////////DIVISION BY 0 ERROR!!!!!!!!!!!!!!!
					//currently percentage

					//SET OTHER AVERAGE PERCENT
					$otherUserTraits[$t] += $allLocalTraitValues[$u][$t] / $otherUsersCount;

				}
			}

			//set numeric amount higher than this user for each trait
			for ($u = 0; $u < $otherUsersCount; $u++) {
				for ($t = 0; $t < 5; $t++) {

					if ($thisUserTraits[$t] > $allLocalTraitValues[$u][$t]) {
						$otherUsersWithHigherTraits[$t] ++;
					} elseif ($thisUserTraits[$t] == $allLocalTraitValues[$u][$t]) {
						$otherUsersWithHigherTraits[$t] += 0.5;
					}
					
				}
			}

			//set percentile, and set others/user traits to out of 100 
			for ($t = 0; $t < 5; $t++) {
				$thisUserTraitsPercentiles[$t] = $otherUsersWithHigherTraits[$t] * 100 / $otherUsersCount;
				$otherUserTraits[$t] *= 100;
				$thisUserTraits[$t] *= 100;
			}
		}
	}
	
?>
