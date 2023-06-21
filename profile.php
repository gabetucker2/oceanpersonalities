<!--Requires max_input_vars in php.ini (.user.ini in GoDaddy) to be higher than 1000 - namely, 9999-->
<!DOCTYPE HTML>
<html>

	<head>

		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Profile</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_scrollLabel.php"; ?>
				
				<script>
				
					function UpdateElementColor(i, elementName)
					{
						let localElement = document.getElementsByName(elementName + i)[0];
						
						localElement.style.color = "#" + localElement.value;
					}
					
				</script>
				
				<?PHP
					
					ob_start();
					
					function RefreshPage()
					{
						while(ob_get_status())
						{
							ob_end_clean();
						}
						
						echo '<script>window.location.href = "profile.php";</script>';
					}
					
					$SQL =
						'SELECT versionID
						FROM versions_general;';
					
					$versionIDList = array();
					
					if($result = mysqli_query($connection, $SQL))
					{
						for($i = 0; $i < mysqli_num_rows($result); $i++)
						{
							array_push($versionIDList, mysqli_fetch_assoc($result)["versionID"]);
						}
					}
					
					require "Prefabs/prefab_projectTitle.php";
					
					echo '<h1 style = "margin: -3vh 0 0vh; font-size: 2vw;">PROFILE</h1>';
					
					if($userID != -1)
					{
						echo '<p class = "subtext">- ' . $userUsername . ' -</p>';
					}
					
					echo '<div class = "tinyLine"></div>';
					
					$nameString;
					
					if($userID != -1)
					{
						$nameString = ", {$userFirstName}";
					}
					else
					{
						$nameString = "!  Please log in below";
					}
					
					echo
						"<h2 style = 'margin: 6vh 0 6vh;'>
							Welcome to your profile page{$nameString}!
						</h2>";
					
					$mayViewStats = false;
					
					$SQL =
						"SELECT *
						FROM tests_taken
						WHERE userID = {$userID}
						ORDER BY testTakenID DESC
						LIMIT 1;";
					
					if(mysqli_num_rows(mysqli_query($connection, $SQL)) == 1)
					{
						$mayViewStats = true;
					}
					
					if($userID != -1 && $userOTI != $zeros)
					{
						$uniqueText = "";
						
						if($mayViewStats)
						{
							$uniqueText = "• Scroll down to view your unique statistics and to take our surveys •";
						}
						else
						{
							$uniqueText = "• Test version has been updated • To view your statistics, you must retake the test •";
						}
						
						echo "<p class = 'subEmphasize' style = 'margin-top: -5vh;'>{$uniqueText}</p>";
					}
					
					require "Prefabs/prefab_relevantOption.php";
					
					if($userID != -1 && $userOTI != $zeros && $mayViewStats)//stats section
					{
						//set respective HTML
						echo
							'<div class = "tinyLine"></div>
							<h2 style = "margin-bottom: -3vh;">your statistics</h2>';
						
						if($otherUsersCount > 0)
						{
							echo "<p class = 'subEmphasize'>{$otherUsersCount} other tests have been compared against yours</p>";
							echo "<p class = 'subEmphasize' style = 'margin-top: -4vh;'>The thick black line between the colors is the average score for other people</p>";
							echo "<p class = 'subEmphasize' style = 'margin-top: -4vh;'>See your personality type for general information</p>";

							echo '<div style = "width: 60vw; height: 63vh; margin: 0 0 0 20vw;">';

							echo "<div style = 'margin: 0 0 -1.4vh; width: 100%; height: 1vh; background-color: #000020;'></div>";
							
							for($t = 0; $t < 5; $t++)//add each paragraph
							{
								$percentUser = number_format($thisUserTraits[$t], 0, '.', '');
								$percentileUser = number_format($thisUserTraitsPercentiles[$t], 0, '.', '');
								$percentOther = $otherUserTraits[$t];

								$percentileUserString = "";
								switch (substr($percentileUser, -1)){
									case 1:
										$percentileUserString = $percentileUser . "st";
										break;
									case 2:
										$percentileUserString = $percentileUser . "nd";
										break;
									case 3:
										$percentileUserString = $percentileUser . "rd";
										break;
									default:
										$percentileUserString = $percentileUser . "th";
										break;
								}
								
								$traitName = $traitWords[$t];
								
								echo
									"<br/><a href = 'traitDefine.php?{$traitName}&previousPage=profile.php'>

										<p style = 'user-select: none; pointer-events: none; margin: -0.05vh 0 0; font-size: 1.2vw; color: #000020;' class = 'subtext subEmphasize'>{$percentUser}% " . ucfirst($traitWords[$t]) . "</p>

										<div style = 'margin: -4vh 0 1.1vh; width: 100%; height: 4vh; background: linear-gradient(to right, #00002050 0%, transparent {$percentUser}%), linear-gradient(to right, #{$oceanColors[$t]} {$percentUser}%, transparent {$percentUser}%);'></div>

									</a>";
								
								echo
									"<br/><a href = 'traitDefine.php?{$traitName}&previousPage=profile.php'>

										<div style = 'margin: -3.1vh 0 0.2vh; width: 100%; height: 2vh; background: linear-gradient(to right, #083651 {$percentOther}%, transparent {$percentOther}%);'></div>

									</a>";
								
								echo
									"<a href = 'traitDefine.php?{$traitName}&previousPage=profile.php''>

										<p style = 'user-select: none; pointer-events: none; color: #000020; font-size: 1.2vw;' class = 'subtext subEmphasize'>{$percentileUserString} Percentile</p>

										<div style = 'margin: -6.5vh 0 -1.4vh; width: 100%; height: 4vh; background: linear-gradient(to right, #00002050 0%, transparent {$percentileUser}%), linear-gradient(to right, #{$oceanColors[$t]} 0%, #{$oceanColors[$t]} {$percentileUser}%, transparent {$percentileUser}%);'></div>

									</a>";
								
								echo "<div style = 'margin: 1.4vh 0 -1.4vh; width: 100%; height: 1vh; background-color: #000020;'></div>";
							}

							echo '</div>';

						}
						else
						{
							echo "<p class = 'emphasize warning'>no other users have yet taken a test against which to compare yours</p>";
						}
					}
					
				?>

				<div class = "line"></div>
				
				<h2>Surveys</h2>
				
				<p class = "subEmphasize">In order to refine our test results and findings, we rely on users like you who take our surveys.</p>
				
				<?PHP
					
					if($userID != -1)
					{
						if($userOTI != "" && $userOTI != $zeros)//if type assigned and logged in
						{
							echo '<p class = "subEmphasize">Our records indicate that you have taken the test and have been assigned a type!<br/>This means you may click on the link below to navigate our surveys.</p>';
							
							echo '<a class = "linkButton" href = "surveyNavigator.php">View Surveys</a>';
						}
						else
						{
							echo '<p class = "subEmphasize">Please take our test in order to access our surveys!</p>';
						}
					}
					else
					{
						echo '<p class = "subEmphasize">Please log in then take the test in order to access our surveys!</p>';
					}
					
				?>

				<br/><br/><br/><br/>

				<div class = "line" style = "margin-top: 0vh;"></div>
				
				<h2>Discord</h2>

				<p class = "centerParagraph subEmphasize">We have an active Discord server in which we talk with supporters, post updates, bug test, recruit developers, have casual discussions, and learn about all you have to say regarding our test!  Please feel free to join using the link below; we'd love to have you, and there's zero strings attached.</p><br/>

				<a href = "https://discord.gg/gxWfHqHQsn" class = "linkButton" style = "margin-top: -1vh;">Join our Official Discord Server</a><br/>
				
				<div class = "line"></div>
					
				<?PHP
					
					if($userAdmin)
					{
						//create admin account display
						echo
							'<p class = "subEmphasize" style = "margin: 0 0 -3vh;">• This is an administrator account •</p>
							
							<h1 style = "margin-top: 2vh;" class = "warning">ADMIN PANEL</h1>
							
							<div>
								<a href = "profile.php" class = "linkButton">safely refresh page</a>
							</div>
							
							<p style = "margin-top: 0;">[ Current Version No. ' . $currentVersionNumber . ' ]</p>
							
							<div class = "line"></div>';
						
						require "Handlers/handler_oneTimeInject.php";
						
						echo '<p class = "subEmphasize" style = "margin: 0 0 -3vh;">• When creating new rows, make sure you do so in direct subsequent order • Otherwise, the primary key will be inconsistent •</p><br/>';
						
						echo '<div class = "line"></div>';
						
						////
						////MAKE TABLE FOR OCEAN MANAGER//////////////////////////////////////////////////////////////////////////////////
						$totalRows = count($traitWords);
						
						//make main HTML
						echo 
							'<div>
								<h2 style = "margin-bottom: 0;">Ocean Manager</h2>
								
								<br/>
								
								<form method = "POST" class = "formAdminPrimary" style = "width: 30vw; height: 30vh; margin-left: 35vw; overflow: hidden;">
									<button type = "submit" name = "newOceansSubmit" class = "button">execute</button>
									
									<br/><br/>
									
									<table class = "formAdminSecondary">
										<tr>
											<th style = "width: 20%;">trait</th>
											<th style = "width: 15%;">color</th>
											<th style = "width: auto;">paragraph</th>
										</tr>';
						
						for($i = 0; $i < 5; $i++)
						{
							$SQL =
								"SELECT *
								FROM traits_ocean
								WHERE localID = " . ($i + 1) . ";";
							
							$row = mysqli_fetch_assoc(mysqli_query($connection, $SQL));
							
							$localOceanColor = $row["oceanColor"] ?? "1590A3";
							$localOceanParagraph = $row["oceanParagraph"] ?? "";
							
							echo
								'<tr>
									<td name = "managerOceanName" style = "text-align: right;">' . $traitWords[$i] . '</td>
									<td><input type = "text" name = "managerOceanColor' . $i . '" value = "' . $localOceanColor . '" onFocusOut = "UpdateElementColor(' . $i . ', \'managerOceanColor\')"/></td>
									<td><input type = "text" name = "managerOceanParagraph' . $i . '" value = "' . $localOceanParagraph . '"/></td>
								</tr>';
						}
						
						//conclude main HTML
						echo '</table></form></div>';
						
						//insert new questions then refresh if execute was clicked
						if(isset($_POST["newOceansSubmit"]))
						{
							for($i = 0; $i < 5; $i++)
							{
								$localOceanColor = $_POST["managerOceanColor{$i}"] ?? "1590A3";
								$localOceanParagraph = $_POST["managerOceanParagraph{$i}"] ?? "";
								
								if(isset($_POST["managerOceanColor{$i}"]) && isset($_POST["managerOceanParagraph{$i}"]))
								{
									$SQL =
										"UPDATE traits_ocean
										SET oceanColor = '{$localOceanColor}', oceanParagraph = '{$localOceanParagraph}'
										WHERE localID = " . ($i + 1) . ";";
									
									mysqli_query($connection, $SQL);
								}
							}
							
							RefreshPage();
						}
						
					?>
						
						<script>
							
							for(i = 0; i < 5; i++)
							{
								UpdateElementColor(i, "managerOceanColor");
							}
							
						</script>
						
					<?PHP
						
						////POPULATE OCEAN//////////////////////////////////////////////////////////////////////////////////
						//if button clicked, truncate then insert default rows
						if(isset($_POST["populateOceansSubmit"]))
						{
							$SQL = "TRUNCATE TABLE traits_ocean;";
							
							mysqli_query($connection, $SQL);
							
							//iterate through all of the domains and add them in
							for($i = 0; $i < 5; $i++)
							{					
								$SQL =
									"INSERT INTO traits_ocean (oceanColor, oceanParagraph)
									VALUES ('1590A3', '');";
								
								mysqli_query($connection, $SQL);
							}
							
							RefreshPage();
						}
						
						//create button
						echo
							'<br/><div>
								<form method = "POST">
									<button type = "submit" name = "populateOceansSubmit" class = "linkButton warning">populate ocean database with default rows</button>
								</form>
							</div>
							
							<div class = "line"></div>';
						
						////
						////MAKE TABLE FOR DOMAIN MANAGER//////////////////////////////////////////////////////////////////////////////////
						//add values to table that will be referenced in <table> to show pre-existing questions
						$totalRows = 10;
						
						$existingQuestions =
							array(
								array(),
								array(),
								array(),
								array()
							);
						
						$SQL =
							'SELECT *
							FROM traits_domains
							ORDER BY domainOrder = -1 ASC, domainOrder ASC;';
						
						if($result = mysqli_query($connection, $SQL))
						{
							while($questionRow = mysqli_fetch_assoc($result))
							{
								array_push($existingQuestions[0], $questionRow["domainID"]);
								array_push($existingQuestions[1], $questionRow["domainName"]);
								array_push($existingQuestions[2], $questionRow["domainOrder"]);
								array_push($existingQuestions[3], $questionRow["domainColor"]);
							}
						}
						
						//make main HTML
						echo 
							'<div>
								<h2 style = "margin-bottom: 0;">Domain Manager</h2>
								
								<br/>
								
								<form method = "POST" class = "formAdminPrimary" style = "width: 30vw; height: 60vh; margin-left: 35vw; overflow: hidden;">
									<button type = "submit" name = "newDomainsSubmit" class = "button">execute</button>
									
									<p style = "color: #F4F4F4;">Set order to -1 to negate a value<br/>Start at 0 for ordering<br/>To increase max amount, change in script</p>
									
									<br/><br/>
									
									<table class = "formAdminSecondary">
										<tr>
											<th style = "width: 5%;">DID</th>
											<th style = "width: auto;">name</th>
											<th style = "width: 5%;">order</th>
											<th style = "width: auto;">color</th>
										</tr>';
						
						//make each domain row
						for($i = 0; $i < $totalRows; $i++)
						{
							$localDomainID = $existingQuestions[0][$i];
							$localDomainName = $existingQuestions[1][$i];
							$localDomainOrder = $existingQuestions[2][$i];
							$localDomainColor = $existingQuestions[3][$i];
							
							echo
								'<tr>
									<td>' . $localDomainID . '</td><input type = "hidden" name = "managerDomainID' . $i . '" value = "' . $localDomainID . '"/>
									<td><input type = "text" name = "managerDomainName' . $i . '" value = "' . $localDomainName . '"/></td>
									<td><input type = "text" name = "managerDomainOrder' . $i . '" value = "' . $localDomainOrder . '"/></td>
									<td><input type = "text" name = "managerDomainColor' . $i . '" value = "' . $localDomainColor . '" onFocusOut = "UpdateElementColor(' . $i . ', \'managerDomainColor\')"/></td>
								</tr>';
						}
						
						//conclude main HTML
						echo '</table></form></div>';
						
						//insert new questions then refresh if execute was clicked
						if(isset($_POST["newDomainsSubmit"]))
						{
							for($i = 0; $i < $totalRows; $i++)
							{
								$localDomainName = "";
								$localDomainOrder = -1;
								$localDomainColor = "1590A3";
								
								if(isset($_POST["managerDomainOrder{$i}"]) && $_POST["managerDomainOrder{$i}"] != -1)
								{
									$localDomainOrder = $_POST["managerDomainOrder{$i}"];
									$localDomainName = $_POST["managerDomainName{$i}"];
									$localDomainColor = $_POST["managerDomainColor{$i}"];
								}
								
								$SQL =
									"UPDATE traits_domains
									SET domainName = '" . $localDomainName . "', domainOrder = " . $localDomainOrder . ", domainColor = '" . $localDomainColor . "'
									WHERE domainID = " . $_POST["managerDomainID{$i}"] . ";";//assumes ID's are 1-max
								
								mysqli_query($connection, $SQL);
							}
							
							RefreshPage();
						}
						
					?>
						
						<script>
							
							for(let i = 0; i < <?PHP echo $totalRows; ?>; i++)
							{
								UpdateElementColor(i, "managerDomainColor");
							}
							
						</script>
						
					<?PHP
						
						////POPULATE DOMAINS//////////////////////////////////////////////////////////////////////////////////
						//if button clicked, truncate then insert default rows
						if(isset($_POST["populateDomainsSubmit"]))
						{
							$SQL = "TRUNCATE TABLE traits_domains;";
							
							mysqli_query($connection, $SQL);
							
							//iterate through all of the domains and add them in
							for($i = 1; $i <= $totalRows; $i++)
							{					
								$SQL =
									"INSERT INTO traits_domains (domainName, domainOrder, domainColor)
									VALUES ('', -1, '1590A3');";
								
								mysqli_query($connection, $SQL);
							}
							
							RefreshPage();
						}
						
						//create button
						echo
							'<br/><div>
								<form method = "POST">
									<button type = "submit" name = "populateDomainsSubmit" class = "linkButton warning">populate domains database with default rows</button>
								</form>
							</div>
							
							<div class = "line"></div>';
						
						////MAKE TABLE FOR TYPES/TRAITS MANAGER//////////////////////////////////////////////////////////////////////////////////
						//update inherit values
						$typeTraitSelectedVal;
						$filterTypeTraitsVal;
						
						if(isset($_POST["switchTypeTraits"]) && $_POST["switchTypeTraits"] == "traitSelected")
						{
							$typeTraitSelectedVal = "traitSelected";
						}
						else//for default if it's not set OR for if it is set to typeSelected
						{
							$typeTraitSelectedVal = "typeSelected";
						}
						
						if(isset($_POST["filterTypeTraits"]))
						{
							$filterTypeTraitsVal = $_POST["filterTypeTraits"];
						}
						else
						{
							$filterTypeTraitsVal = $zeros;
						}
						
						//create main HTML
						echo
						'<div>
							<h2 style = "margin-bottom: 0;">Type / Trait Manager</h2>
							
							<br/>
							
							<form method = "POST" class = "formAdminPrimary">
								<p style = "text-align: center; color: #F4F4F4; margin: 0 5% 5vh;">
									OTI is XXXXX where 0 is void, 1-3 is include trait
									<br/>Execute in scope you\'d like to update
									<br/>If you would like to delete a trait, uncheck inc
									<br/>If you would like to update a trait paragraph, just change the paragraph
									<br/>If you would like to update a trait OTI or DID, make a new row and uncheck the old row
								</p>
								
								<h2 name = "switchTypeTraitsButton" class = "linkButton" style = "margin-top: -2vh; margin-bottom: 0; color: #F4F4F4;" onClick = "SwitchTypeTraits()">N/A</h2>
								<input type = "hidden" name = "switchTypeTraits" value = "' . $typeTraitSelectedVal . '"/>
								
								<span class = "formMain" style = "color: #F4F4F4;"><br/>
									filter OTI<br/><input type = "text" name = "filterTypeTraits" placeholder = "' . $zeros . '" value = "' . $filterTypeTraitsVal . '" onFocusOut = "UpdateTypeTraits()"/><br/>
								</span><br/>
								
								<p name = "globalPrevalence" style = "text-align: center; color: #F4F4F4; margin: 0 5% 5vh;">
									N/A
								</p>
								
								<button type = "submit" name = "typeTraitsSubmit" class = "button">execute</button>
								
								<br/><br/>
								
								<table class = "formAdminSecondary">
									<tr>
										<th style = "width: 5%;">inc</th>
										<th style = "width: 7%;">OTI</th>
										<th name = "nameOrDID" style = "width: 15%;">N</th>
										<th name = "averageOrParagraph" style = "width: auto;">N</th>
										<th name = "nullOrVoteRatio" style = "width: 25%;">N</th>
									</tr>';
						
						$SQL =
							"SELECT *
							FROM traits_general
							ORDER BY SUBSTRING(OTI, 5, 1) = '0' DESC, SUBSTRING(OTI, 4, 1) = '0' DESC, SUBSTRING(OTI, 3, 1) = '0' DESC, SUBSTRING(OTI, 2, 1) = '0' DESC, SUBSTRING(OTI, 1, 1) = '0' DESC, SUBSTRING(OTI, 1, 1) ASC, SUBSTRING(OTI, 2, 1) ASC, SUBSTRING(OTI, 3, 1) ASC, SUBSTRING(OTI, 4, 1) ASC, SUBSTRING(OTI, 5, 1) ASC, domainID ASC;";//order by ascending order in first 1-3 to last 1-3 (putting 0's last) (remember SQL starts at 1 in index)
						$result = mysqli_query($connection, $SQL);
						$numTraitRows = mysqli_num_rows($result);
						$totalRows = 243 + $numTraitRows;
						$iInit = 0;
						$i = 0;

						//for traits (initialize traitcount ($iInit))
						while ($row = mysqli_fetch_assoc($result)) {
							echo
								'<tr>
									<td><input type = "checkbox" id = "notAvoid" name = "typeTraitInclude' . $i . '"/></td>
									<td style = "padding: 0 1vw;"><input type = "text" name = "typeTraitOTI' . $i . '"/></td>
									<td style = "padding: 0 1vw;"><input type = "text" name = "typeTraitNameOrDID' . $i . '"/></td>
									<td><input type = "text" name = "typeTraitParagraph' . $i . '"/></td>
									<td name = "typeTraitNullOrVoteRatio' . $i . '" style = "text-align: left; padding: 0 1vw;">N</td>
								</tr>';
							//just so JS can reference the traitID
							echo '<input type = "hidden" name = "typeTraitID' . $i . '" value = "'.$row["traitID"].'"/>';
							$i++;
						}
						$iInit = $i;
						
						//for types
						for($i = $iInit; $i < 243 + $iInit; $i++)
						{
							echo
								'<tr>
									<td><input type = "checkbox" id = "notAvoid" name = "typeTraitInclude' . $i . '"/></td>
									<td style = "padding: 0 1vw;"><input type = "text" name = "typeTraitOTI' . $i . '"/></td>
									<td style = "padding: 0 1vw;"><input type = "text" name = "typeTraitNameOrDID' . $i . '"/></td>
									<td><input type = "text" name = "typeTraitParagraph' . $i . '"/></td>
									<td name = "typeTraitNullOrVoteRatio' . $i . '" style = "text-align: left; padding: 0 1vw;">N</td>
								</tr>';
							//just so JS can reference the traitID
							echo '<input type = "hidden" name = "typeTraitID' . $i . '" value = "N"/>';
						}
						
						//just so JS can reference typeTraitInclude since it's disabled in this case
						//notAvoid means that script will only update physical properties of others
						for ($i = 0; $i < 243 + $iInit; $i++) {
							echo '<input type = "hidden" name = "typeTraitInclude' . $i . '" checked/>';
						}
						
						//set arrays
						$typesArray = array
						(
							array(),
							array(),
							array(),
							array()
						);
						
						$traitsArray = array
						(
							array(),
							array(),
							array(),
							array()
						);
						
						$currentFilter;
						
						if(isset($_POST["filterTypeTraits"]))
						{
							$currentFilter = $_POST["filterTypeTraits"];
						}
						else
						{
							$currentFilter = false;
						}
						
						function NullPush($thisArray)
						{
							array_push($thisArray[0], "00000");
							array_push($thisArray[1], "N");
							array_push($thisArray[2], "");
							array_push($thisArray[3], "N");
							
							return $thisArray;
						}
						
						function CheckOTIMatch($thisOTI, $funcCurrentFilter)
						{
							$proceed = true;
							
							if($funcCurrentFilter != false)
							{
								for($s = 0; $s < 5; $s++)
								{
									if($funcCurrentFilter[$s] != "0" && $funcCurrentFilter[$s] != $thisOTI[$s])
									{
										$proceed = false;
									}
								}
							}
							
							return $proceed;
						}
						
						
						$SQL =
							'SELECT OTI
							FROM users_general
							WHERE OTI <> "' . $zeros . '";';
						
						$result = mysqli_query($connection, $SQL);
						
						$numAllSetUsers = mysqli_num_rows($result);
						
						$numAverageUsersPerOTI = number_format(($numAllSetUsers / 243), $decimalLimit, '.', '');
						$percentAverageUsersPerOTI = number_format((100 / 243), $decimalLimit, '.', '');//always the same
						
						
						$SQL =
							'SELECT *
							FROM types_general';
						
						if($resultType = mysqli_query($connection, $SQL))
						{
							while($row = mysqli_fetch_assoc($resultType))
							{
								if($currentFilter == false || preg_match('/^[0-3]{5}$/', $currentFilter))
								{
									$thisOTI = $row["OTI"];
									
									if(CheckOTIMatch($thisOTI, $currentFilter))
									{
										array_push($typesArray[0], $thisOTI);
										array_push($typesArray[1], $row["typeName"]);
										
										$SQL =
											'SELECT OTI
											FROM users_general
											WHERE OTI = "' . $thisOTI . '";';
										
										$numThisOTI = mysqli_num_rows(mysqli_query($connection, $SQL));
										
										$percentThisOTI = "N";
										if($numAllSetUsers > 0)
										{
											$percentThisOTI = number_format((($numThisOTI / $numAllSetUsers) * 100), $decimalLimit, '.', '');
										}
										
										$meanAbsoluteDeviation = number_format((abs($percentThisOTI - $percentAverageUsersPerOTI)), $decimalLimit, '.', '');
										
										$prevalenceString = "{$meanAbsoluteDeviation}% mean absolute deviation ----- {$percentThisOTI}% ({$numThisOTI} / {$numAllSetUsers} users)";
										
										array_push($typesArray[2], $prevalenceString);
										array_push($typesArray[3], "N");
									}
									else
									{
										$typesArray = NullPush($typesArray);
									}
								}
							}
							
							for($i = 0; $i < $numTraitRows; $i++)//compensate for the traitsRows not included in while
							{
								$typesArray = NullPush($typesArray);
							}
						}
						
						$SQL =
							"SELECT *
							FROM traits_general
							ORDER BY SUBSTRING(OTI, 5, 1) = '0' DESC, SUBSTRING(OTI, 4, 1) = '0' DESC, SUBSTRING(OTI, 3, 1) = '0' DESC, SUBSTRING(OTI, 2, 1) = '0' DESC, SUBSTRING(OTI, 1, 1) = '0' DESC, SUBSTRING(OTI, 1, 1) ASC, SUBSTRING(OTI, 2, 1) ASC, SUBSTRING(OTI, 3, 1) ASC, SUBSTRING(OTI, 4, 1) ASC, SUBSTRING(OTI, 5, 1) ASC, domainID ASC;";//order by ascending order in first 1-3 to last 1-3 (putting 0's last) (remember SQL starts at 1 in index)
						
						if($resultTrait = mysqli_query($connection, $SQL))
						{
							while($row = mysqli_fetch_assoc($resultTrait))
							{
								if($currentFilter == false || preg_match('/^[0-3]{5}+$/', $currentFilter))
								{
									if(CheckOTIMatch($row["OTI"], $currentFilter))
									{
										array_push($traitsArray[0], $row["OTI"]);
										array_push($traitsArray[1], $row["domainID"]);
										array_push($traitsArray[2], str_replace("<br/><br/>", "!BREAK", $row["traitParagraph"]));//decode for view
										array_push($traitsArray[3], $row["traitID"]);
									}
									else
									{
										$traitsArray = NullPush($traitsArray);
									}
								}
							}
						}
						
						for($i = 0; $i < 243; $i++)//compensate for the 243 not included rows in while
						{
							$traitsArray = NullPush($traitsArray);
						}

						$jsKeyVotes = "[";
						$jsValVotes = "[";
						$phpKeyVotes = array();//trait ids
						$phpValVotes = array();//vals corresponding thereto

						$SQL = "
							SELECT *
							FROM traits_general
							INNER JOIN votes_traits ON traits_general.traitID = votes_traits.traitID
							WHERE votes_traits.voteIsCurrent = 1
							ORDER BY votes_traits.traitID ASC;
						";
						//set php arrays
						if ($result = mysqli_query($connection, $SQL)) {
							while($row = mysqli_fetch_assoc($result)) {
								$vote = $row["voteIsUpvote"];
								$traitID = $row["traitID"];

								if (in_array($traitID, $phpKeyVotes)) {
									//update existing array entry
									$index = array_search($traitID, $phpKeyVotes);
									array_push($phpValVotes[$index], $vote);
								} else {
									//create new array entry
									array_push($phpKeyVotes, $traitID);
									$newVoteArray = array($vote);
									array_push($phpValVotes, $newVoteArray);
								}
							}
						}
						//set js array
						for ($i = 0; $i < count($phpKeyVotes); $i++) {
							$jsKeyVotes .= $phpKeyVotes[$i] . ",";
							$jsValVotes .= "[";
							for ($j = 0; $j < count($phpValVotes[$i]); $j++) {
								$jsValVotes .= $phpValVotes[$i][$j] . ",";
							}
							$jsValVotes .= "],";
						}

						$jsValVotes .= "]";
						$jsKeyVotes .= "]";
						echo "<script>let votesValues = {$jsValVotes}, votesKeys = ${jsKeyVotes};</script>";
						//votesValues = [[1,0,1,1,0],[0,1,1,1],[0]]
						//votesKeys = [312, 52, 299]
					?>
					
					<script>
						
						let filterTypeTraits = document.getElementsByName("filterTypeTraits")[0];
						let switchTypeTraitsButton = document.getElementsByName("switchTypeTraitsButton")[0];
						let globalPrevalence = document.getElementsByName("globalPrevalence")[0];
						
						let typeSelected = <?PHP echo ($typeTraitSelectedVal == "typeSelected" ? "true" : "false") ?>;
						
						let totalRows = <?PHP echo $totalRows; ?>;
						
						let typeSelectedText = "> Displaying Types <";
						let traitSelectedText = "> Displaying Traits <";
						
						//perform update from type to traits or vice-versa
						function UpdateTypeTraits()
						{
							let currentFilter = filterTypeTraits.value;
							
							if(!currentFilter.match(/^[0-3]{5}$/))//if it's not XXXXX where X = 0-3 and it's 5 chars, set it to default 00000
							{
								filterTypeTraits.value = zeros;
								currentFilter = filterTypeTraits.value;
							}
							
							let nameOrDIDTH = document.getElementsByName("nameOrDID")[0];
							let averageOrParagraph = document.getElementsByName("averageOrParagraph")[0];
							let nullOrVoteRatio = document.getElementsByName("nullOrVoteRatio")[0];
							
							let displayTypes;
							
							let thisArray = [[], [], [], []];
							
							<?PHP
								
								function UpdateThisArray($thisArray, $funcTotalRows)
								{
									echo 'let proceed;';
									for($i = 0; $i < $funcTotalRows; $i++)
									{
										echo
											'proceed = true;
											
											for(s = 0; s < 5; s++)
											{
												if(currentFilter.charAt(s) != "0" && currentFilter.charAt(s) != "' . $thisArray[0][$i] . '".charAt(s))
												{
													proceed = false;
													
													break;
												}
											}
											
											if(proceed == true)
											{
												thisArray[0].push("' . $thisArray[0][$i] . '");
												thisArray[1].push("' . $thisArray[1][$i] . '");
												thisArray[2].push("' . $thisArray[2][$i] . '");

												//handle vote ratios
												let upvotes = 0, downvotes = 0;
												let traitID = "' . $thisArray[3][$i] . '";
												let out = "";
												if (traitID != "N") {
													let thisIndex = votesKeys.indexOf(parseInt(traitID));
													
													if (thisIndex != -1) {
														for (let i = 0; i < votesValues[thisIndex].length; i++) {
															if (votesValues[thisIndex][i] == 1) {
																upvotes += 1;
															} else {
																downvotes += 1;
															}
														}
														out = upvotes + " upvts : " + downvotes + " dnvts => " + Math.round((upvotes / (upvotes + downvotes)) * 100) + "%";
													} else {
														out = "no entries";
													}
												} else {
													out = "no entries";
												}
												thisArray[3].push(out);
											}';
									}
								}
								
							?>
							
							if(typeSelected == true)
							{
								switchTypeTraitsButton.innerHTML = typeSelectedText;
								nameOrDIDTH.innerHTML = "name";
								averageOrParagraph.innerHTML = "prevalence";
								globalPrevalence.innerHTML = "average " + <?PHP echo '"' . $numAverageUsersPerOTI . '"'; ?> + " AND " + <?PHP echo '"' . $percentAverageUsersPerOTI . '"'; ?> + "% users per OTI";
								nullOrVoteRatio.innerHTML = "N";
								
								<?PHP UpdateThisArray($typesArray, $totalRows); ?>
							}
							else
							{
								switchTypeTraitsButton.innerHTML = traitSelectedText;
								nameOrDIDTH.innerHTML = "DID";
								averageOrParagraph.innerHTML = "paragraph";
								globalPrevalence.innerHTML = "no stats for traits";
								nullOrVoteRatio.innerHTML = "vote ratio";
								
								<?PHP UpdateThisArray($traitsArray, $totalRows); ?>
							}
							
							for(i = 0; i < totalRows; i++)
							{
								let localTTI = document.getElementsByName("typeTraitInclude" + i);
								/*
								 * I LOVE PHP!!!!
								 * So you cannot set a checkbox to readOnly.  So we set it as disabled, but this makes it such that the POST value is not sent.
								 * As a result, we have to make a whole separate element of the same name,
								 * only change the physical value of the original element ("notAvoid" id),
								 * and pass through the POST value only of the new element (hidden with value) to
								 * preserve the disabled look plus it actually passing through the desired forced value.  Yay 
								*/
								for (let j = 0; j < localTTI.length; j++) {
									const item = localTTI.item(j);
									if (item.id == "notAvoid") {
										localTTI = item;
										break;
									}
								}
								let localTTO = document.getElementsByName("typeTraitOTI" + i)[0];
								let localTTNOD = document.getElementsByName("typeTraitNameOrDID" + i)[0];
								let localTTP = document.getElementsByName("typeTraitParagraph" + i)[0];
								let localTTNOVR = document.getElementsByName("typeTraitNullOrVoteRatio" + i)[0];
								let localTTID = document.getElementsByName("typeTraitID" + i)[0];
								
								if(typeSelected == true)//disable OTI change for type view
								{
									localTTNOVR.innerHTML = "N";
									localTTI.disabled = true;

									if(thisArray[0][i] == zeros || !thisArray[0][i])
									{
										localTTI.checked = false;
										localTTO.readOnly = true;
										localTTNOD.readOnly = true;
										localTTP.readOnly = true;
									}
									else
									{
										localTTI.checked = true;
										localTTO.readOnly = true;
										localTTNOD.readOnly = false;
										localTTP.readOnly = true;
									}
								}
								else
								{
									localTTNOVR.innerHTML = thisArray[3][i];
									
									//other stuff
									localTTI.disabled = false;
									localTTO.readOnly = false;
									localTTNOD.readOnly = false;
									localTTP.readOnly = false;
									
									if(thisArray[1][i] == "N" || !thisArray[0][i])
									{
										localTTI.checked = false;
									}
									else
									{
										localTTI.checked = true;
									}
								}
								
								if(thisArray[0][i])
								{
									localTTO.value = thisArray[0][i];
									localTTNOD.value = thisArray[1][i];
									localTTP.value = thisArray[2][i];
								}
								else
								{
									localTTO.value = zeros;
									localTTNOD.value = "N";
									localTTP.value = "";
								}
							}
						}
						
						UpdateTypeTraits();//activate on start
						
						//switch between type display and trait display with jQuery by updating PHP variable and local variable
						function SwitchTypeTraits()
						{
							typeSelected = !typeSelected;
							
							let localSTT = document.getElementsByName("switchTypeTraits")[0];
							
							if(localSTT.value == "typeSelected")//update PHP recipient value for POST
							{
								localSTT.value = "traitSelected";
							}
							else
							{
								localSTT.value = "typeSelected";
							}
							
							UpdateTypeTraits();
						}
						
					</script>
					
					<?PHP
						
						echo '</table></form></div>';

						//update type/trait table
						if(isset($_POST["typeTraitsSubmit"]))
						{
							echo '<script>console.log("EXECUTE");</script>';
							for($i = 0; $i < $totalRows; $i++)
							{
								if(isset($_POST["typeTraitInclude{$i}"]))
								{
									echo '<script>console.log("----ROW '.$i.':");</script>';
									$newOTI = $_POST["typeTraitOTI{$i}"] ?? "NO OTI FOUND";
									$newParagraph = str_replace("!BREAK", "<br/><br/>", addslashes($_POST["typeTraitParagraph{$i}"] ?? "NO PARAGRAPH FOUND"));
									
									echo '<script>console.log("$_POST[\"typeTraitNameOrDID{$i}\"]: '.$_POST["typeTraitNameOrDID{$i}"].'");</script>';
									
									if($_POST["switchTypeTraits"] == "typeSelected")//type execute
									{
										$newName = $_POST["typeTraitNameOrDID{$i}"];
										
										$SQL =
											"UPDATE types_general
											SET typeName = '{$newName}'
											WHERE OTI = '{$newOTI}';";
										
										mysqli_query($connection, $SQL);
									}
									else//trait execute
									{
										$newDID = $_POST["typeTraitNameOrDID{$i}"];

										$traitID = "";
										$SQL = "
											SELECT *
											FROM traits_general
											WHERE OTI = '{$newOTI}' AND domainID = {$newDID};
										";
										if ($result = mysqli_query($connection, $SQL)) {
											if (mysqli_num_rows($result) == 1) {
												$traitID = mysqli_fetch_assoc($result)["traitID"];
											}
										}
										
										$SQL =
											"SELECT *
											FROM traits_general
											WHERE OTI = '{$newOTI}' AND domainID = {$newDID};";
										
										if(mysqli_num_rows(mysqli_query($connection, $SQL)) == 1)//if already exists, update
										{
											$initParagraph = "";
											$SQL = "
												SELECT *
												FROM traits_general
												WHERE traitID = {$traitID};
											";
											if ($r = mysqli_query($connection, $SQL)) {
												if (mysqli_num_rows($r) == 1) {
													$initParagraph = str_replace("!BREAK", "<br/><br/>", addslashes(mysqli_fetch_assoc($r)["traitParagraph"] ?? "NO PARAGRAPH FOUND"));
												}
											}

											if ($newParagraph != $initParagraph) {
												$SQL = "
													UPDATE votes_traits
													SET voteIsCurrent = 0
													WHERE voteIsCurrent = 1 AND traitID = {$traitID};
												";
												mysqli_query($connection, $SQL);
											}

											$SQL =
												"UPDATE traits_general
												SET traitParagraph = '{$newParagraph}'
												WHERE OTI = '{$newOTI}' AND domainID = {$newDID};";
											mysqli_query($connection, $SQL);
										}
										else if(mysqli_num_rows(mysqli_query($connection, $SQL)) == 0)//otherwise add
										{
											$SQL =
												"INSERT INTO traits_general (OTI, domainID, traitParagraph)
												VALUES ('{$newOTI}', {$newDID}, '{$newParagraph}');";
											mysqli_query($connection, $SQL);
										}
									}
								}
								else
								{
									if($_POST["switchTypeTraits"] == "traitSelected")//delete traits unchecked
									{
										$newOTI = $_POST["typeTraitOTI{$i}"] ?? "NO OTI FOUND";
										$newDID = $_POST["typeTraitNameOrDID{$i}"];
										
										$SQL =
											"DELETE FROM traits_general
											WHERE OTI = '{$newOTI}' AND domainID = {$newDID};";
										
										mysqli_query($connection, $SQL);
									}
								}
							}
							
							RefreshPage();
						}
						
						////POPULATE TYPES
						//if button clicked, truncate then insert default rows
						if(isset($_POST["populateTypesSubmit"]))
						{
							$SQL = "TRUNCATE TABLE types_general;";
							
							mysqli_query($connection, $SQL);
							
							//iterate through all of the 243 types and add them in
							for($o = 1; $o <= 3; $o++)
							{
								for($c = 1; $c <= 3; $c++)
								{
									for($e = 1; $e <= 3; $e++)
									{
										for($a = 1; $a <= 3; $a++)
										{
											for($n = 1; $n <= 3; $n++)
											{								
												$SQL =
													"INSERT INTO types_general (OTI, typeName)
													VALUES ('{$o}{$c}{$e}{$a}{$n}', 'Placeholder');";
												
												mysqli_query($connection, $SQL);
											}
										}
									}
								}
							}
							
							RefreshPage();
						}
						
						//create button
						echo
							'<br/><div>
								<form method = "POST">
									<button type = "submit" name = "populateTypesSubmit" class = "linkButton warning">populate types database with default rows</button>
								</form>
							</div>';
						
						////PURGE TRAITS
						//if button clicked, truncate
						if(isset($_POST["purgeTraitsSubmit"]))
						{
							$SQL = "TRUNCATE TABLE traits_general;";
							
							mysqli_query($connection, $SQL);
							
							RefreshPage();
						}
						
						//create button
						echo
							'<div>
								<form method = "POST">
									<button type = "submit" name = "purgeTraitsSubmit" class = "linkButton warning">purge all trait rows</button>
								</form>
							</div>
							
							<div class = "line"></div>';
						
						
						////
						//DISPLAY ALL VERSIONS/////////////////////////////////////////////////////////////////////////////////////////////
						//if version is dropped via button, execute version drop
						if(isset($_POST["dropVersionSubmit"]))
						{
							$dropNum = $_POST["dropVersion"];
							
							$SQL =
								"SELECT versionID
								FROM versions_general
								WHERE versionNumber = {$dropNum};";
							
							$dropID = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["versionID"];
							
							$SQL =
								"DELETE FROM versions_general
								WHERE versionID = {$dropID};";
							
							mysqli_query($connection, $SQL);
							
							$SQL =
								"DELETE FROM versions_questions
								WHERE versionID = {$dropID};";
							
							mysqli_query($connection, $SQL);
							
							$SQL =
								"DELETE FROM tests_taken
								WHERE versionID = {$dropID};";
							
							mysqli_query($connection, $SQL);
							
							RefreshPage();
						}
						
					?>
					
					<script>
						
						//version display function
						function DisplayVersionQuestions(thisVersion, QID, VNum, QC, QT, QPO, QPR, QA, maxDisplayQuestionRows)
						{
							let versionViewing = document.getElementsByName("versionViewing")[0];//update innerHTML accordingly
							versionViewing.innerHTML = '[ Version Viewing No. ' + thisVersion + ' ]';
							
							for(i = 0; i < maxDisplayQuestionRows; i++)
							{
								if(questionQID = document.getElementsByName("displayQuestionQID" + i)[0])
								{
									let questionVID = document.getElementsByName("displayQuestionVID" + i)[0];
									let questionCorrelate = document.getElementsByName("displayQuestionCorrelate" + i)[0];
									let questionTrait = document.getElementsByName("displayQuestionTrait" + i)[0];
									let questionPositive = document.getElementsByName("displayQuestionPositive" + i)[0];
									let questionPrompt = document.getElementsByName("displayQuestionPrompt" + i)[0];
									let questionAverage = document.getElementsByName("displayQuestionAverage" + i)[0];
									
									if(QID[i])
									{
										questionQID.innerHTML = QID[i];
										questionVID.innerHTML = VNum[i];
										questionCorrelate.innerHTML = QC[i];
										questionTrait.innerHTML = QT[i];
										questionPositive.innerHTML = QPO[i];
										questionPrompt.innerHTML = QPR[i];
										questionAverage.innerHTML = QA[i];
									}
									else
									{
										questionQID.innerHTML = "N";
										questionVID.innerHTML = "N";
										questionCorrelate.innerHTML = "N";
										questionTrait.innerHTML = "N";
										questionPositive.innerHTML = "N";
										questionPrompt.innerHTML = "N";
										questionAverage.innerHTML = "N";
									}
								}
							}
						}
						
					</script>
					
					<?PHP
						
						//set main HTML
						echo
							'<div>
								<h2 style = "margin-bottom: 0;">Versions Display</h2>
								<p style = "margin: 0;">[ Current Version No. ' . $currentVersionNumber . ' ]</p>
								
								<br/>
								
								<form method = "POST" class = "formAdminPrimary" style = "width: 90vw; margin-left: 5vw;">
									<p style = "color: #F4F4F4; margin-top: 0;">N = missing sufficient data<br/>M = sample mean<br/>IQR = (quasi-) interquartile range: ((average of positive) - (absolute value of average of negative values)) divided by two<br/>str = strikes: percent of users whose results are included yet who recieved a strike for missing this control question</p>
									
									<button type = "submit" name = "dropVersionSubmit" class = "button">execute</button>
									
									<br/>
									
									<span class = "formMain" style = "color: #F4F4F4;"><br/>
										drop version<br/><input type = "text" name = "dropVersion" placeholder = "V# (avoid since this omits data)"/><br/>
									</span><br/>
									
									<table class = "formAdminSecondary">
										<tr>
											<th style = "width: 5%;">V#</th>
											<th style = "width: 5%;">max value</th>
											<th style = "width: 5%;">question count</th>
											<th style = "width: 5%;">tests taken</th>
											<th style = "width: auto;">release time</th>
											<th style = "width: 5%;">(VID)</th>
										</tr>';
						
						//indiscriminately get max amount of rows for table wherein all versions selected would be fully accommodated
						$maxDisplayQuestionRows = 0;
						
						for($i = 0; $i < count($versionIDList); $i++)//foreach version $i by ID
						{
							$localRows = 0;
							
							$SQL =
								'SELECT *
								FROM versions_questions';
							
							if($result = mysqli_query($connection, $SQL))
							{
								while($versionRow = mysqli_fetch_assoc($result))//foreach question/version combo in versions_questions
								{
									if($versionRow["versionID"] == $versionIDList[$i])//while iterating through all rows, filter through only ones on this current ID's iteration
									{
										$localRows += 1;
									}
								}
							}
							
							if($maxDisplayQuestionRows < $localRows)
							{
								$maxDisplayQuestionRows = $localRows;
							}
						}
						
						
						//update version display via JavaScript function without refreshing page upon click
						$SQL =
							'SELECT *
							FROM versions_general;';
						
						$versionResult = mysqli_query($connection, $SQL);
						
						while($versionRow = mysqli_fetch_assoc($versionResult))//foreach version
						{
							$suffix = ", ";
							
							$SQL =
								'SELECT versionNumber
								FROM versions_general
								WHERE versionID = ' . $versionRow["versionID"] . ';';
							
							$thisVersionID = $versionRow["versionID"];
							$thisVersionMax = $versionRow["versionMaxValue"];
							$thisVersionMid = $thisVersionMax / 2;
							$thisVersionNum = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["versionNumber"];
							
							$SQL =
								"SELECT localID
								FROM versions_questions
								INNER JOIN questions_general ON questions_general.questionID = versions_questions.questionID
								WHERE versionID = {$thisVersionID};";
							
							$versionQuestionCount = mysqli_num_rows(mysqli_query($connection, $SQL));
							
							$QID = "[";
							$VNum = "[";
							$QC = "[";
							$QT = "[";
							$QPO = "[";
							$QPR = "[";
							$QA = "[";
							
							
							$SQL =
								"SELECT *
								FROM questions_general
								INNER JOIN versions_questions ON questions_general.questionID = versions_questions.questionID
								WHERE versionID = {$thisVersionID}
								ORDER BY questions_general.questionTrait ASC, questions_general.questionPositive DESC, questions_general.questionCorrelate ASC;";
							
							if($resultQG = mysqli_query($connection, $SQL))
							{
								while($questionRow = mysqli_fetch_assoc($resultQG))//foreach version-question assignment
								{
									$thisQID = $questionRow["questionID"];
									
									$SQL =
										"SELECT tests_responses.questionResponse, questions_general.questionCorrelate, mainTG.testTakenID
										FROM tests_taken mainTG
										INNER JOIN tests_responses ON tests_responses.testTakenID = mainTG.testTakenID
										INNER JOIN users_general ON users_general.userID = mainTG.userID
										INNER JOIN questions_general ON questions_general.questionID = tests_responses.questionID
										WHERE tests_responses.questionID = {$thisQID} AND mainTG.testTakenID =
										(
											SELECT MAX(subTG.testTakenID)
											FROM tests_taken subTG
											WHERE subTG.userID = mainTG.userID
										);";
									
									$thisSampleMean = "N";
									$thisIQR = "N";
									$thisStrike = "N";

									if($resultT = mysqli_query($connection, $SQL))//if questionResponses were found
									{
										$responsesArray = array();
										$strikesArray = array();
										$negArray = array();
										$posArray = array();
										
										while($testResponseRow = mysqli_fetch_assoc($resultT))//foreach questionResponse by questionID
										{
											$thisTID = $testResponseRow["testTakenID"];
											
											array_push($responsesArray, $testResponseRow["questionResponse"]);

											if($testResponseRow["questionCorrelate"] != -1)
											{
												$correlateID = $testResponseRow["questionCorrelate"];
												
												$SQL =
													"SELECT tests_responses.questionResponse
													FROM tests_taken mainTG
													INNER JOIN tests_responses ON tests_responses.testTakenID = mainTG.testTakenID
													INNER JOIN users_general ON users_general.userID = mainTG.userID
													INNER JOIN questions_general ON questions_general.questionID = tests_responses.questionID
													WHERE tests_responses.questionID = {$correlateID} AND mainTG.testTakenID = {$thisTID};";

												if($resultC = mysqli_query($connection, $SQL))//add correlate by this QID's correlate if it exists to add strikes
												{
													while($thisResponseRow = mysqli_fetch_assoc($resultC))//foreach questionResponse by this correlateID (which exists)
													{
														$thisResponse = $thisResponseRow["questionResponse"];
														$localResponse = $testResponseRow["questionResponse"];
														
														/*
														if(abs($thisResponse - $localResponse) > $currentVersionMaxValue / 3 || ($thisResponse > $thisVersionMid && $localResponse < $thisVersionMid) || ($localResponse > $thisVersionMid && $thisResponse < $thisVersionMid))//if qualifies for a strike
														*/
														if(abs($thisResponse - $localResponse) > $currentVersionMaxValue / 3)//if qualifies for a strike
														{
															array_push($strikesArray, 1);//STRIKE
															
															$thisStrike = number_format(((array_sum($strikesArray) / count($strikesArray)) * 100), $decimalLimit, '.', '');
														}
														else
														{
															array_push($strikesArray, 0);
														}
													}
												}
												else
												{
													array_push($strikesArray, 0);
												}
											}
											else
											{
												array_push($strikesArray, 0);
											}

											if($testResponseRow["questionResponse"] > $thisVersionMid)//over 1/2
											{
												array_push($posArray, $testResponseRow["questionResponse"]);
											}
											else if($testResponseRow["questionResponse"] < $thisVersionMid)//under 1/2
											{
												array_push($negArray, $testResponseRow["questionResponse"]);
											}
										}
										
										if(count($responsesArray) > 0)//just in case no records for QID don't break when it looks for null value
										{
											$thisSampleMean = number_format((((((array_sum($responsesArray) / count($responsesArray)) - $thisVersionMid)) / $thisVersionMax) * 100), $decimalLimit, '.', '');
											
											if($questionRow["questionPositive"] == 0)//if negative question, inverse the responses so it makes more sense to read
											{
												$thisSampleMean *= -1;
											}
										}
										
										$QANeg = "N";
										$QAPos = "N";
										
										if(count($negArray) > 0)
										{
											$QANeg = (((array_sum($negArray) / count($negArray)) - $thisVersionMid)) * (1 / $thisVersionMid) * 100;
										}
										
										if(count($posArray) > 0)
										{
											$QAPos = (((array_sum($posArray) / count($posArray)) - $thisVersionMid)) * (1 / $thisVersionMid) * 100;
										}
										
										if($QANeg != "N" && $QAPos != "N")
										{
											$thisIQR = number_format((($QAPos + abs($QANeg)) / 2), $decimalLimit, '.', '');
										}
									}

									$QID .= $thisQID . $suffix;
									$QC .= $questionRow["questionCorrelate"] . $suffix;
									$QT .= $questionRow["questionTrait"] . $suffix;
									$QPO .= $questionRow["questionPositive"] . $suffix;
									$QPR .= "'" . addslashes($questionRow["questionPrompt"]) . "'" . $suffix;//replace all apostrophes with \'
									$QA .= "'M: {$thisSampleMean}%; IQR: {$thisIQR}%; str: {$thisStrike}%'{$suffix}";//replace all apostrophes with \'
									
									$SQL1 =
										'SELECT versionID
										FROM versions_questions
										WHERE questionID = ' . $questionRow["questionID"] . '
										ORDER BY versions_questions.versionID ASC';
									
									$SQL2 =
										'SELECT versionNumber
										FROM versions_general
										WHERE versionID = ' . mysqli_fetch_assoc(mysqli_query($connection, $SQL1))["versionID"] . ';';
									
									$VNum .= mysqli_fetch_assoc(mysqli_query($connection, $SQL2))["versionNumber"] . $suffix;
								}
							}

							$QID .= "]";
							$VNum .= "]";
							$QC .= "]";
							$QT .= "]";
							$QPO .= "]";
							$QPR .= "]";
							$QA .= "]";
							
							$currentTestsOfVersion = 0;
							
							$SQL =
								"SELECT mainTG.testTakenID
								FROM tests_taken mainTG
								INNER JOIN users_general ON users_general.userID = mainTG.userID
								WHERE mainTG.versionID = {$thisVersionID} AND mainTG.testTakenID =
								(
									SELECT MAX(subTG.testTakenID)
									FROM tests_taken subTG
									WHERE subTG.userID = mainTG.userID
								);";
							
							if($result = mysqli_query($connection, $SQL))
							{
								$currentTestsOfVersion = mysqli_num_rows($result);
							}
							
							echo
								'<tr onClick = "DisplayVersionQuestions(' . $thisVersionNum . $suffix . $QID . $suffix . $VNum . $suffix . $QC . $suffix . $QT . $suffix . $QPO . $suffix . $QPR . $suffix . $QA . $suffix . $maxDisplayQuestionRows . ')" class = "rowHoverCursorPointer">
									<td style = "width: 5%; text-align: left;">' . $versionRow["versionNumber"] . '</td>
									<td style = "width: 5%;">' . $versionRow["versionMaxValue"] . '</td>
									<td style = "width: 5%;">' . $versionQuestionCount . '</td>
									<td style = "width: 5%;">' . $currentTestsOfVersion . '</td>
									<td style = "width: auto;">' . $versionRow["versionTime"] . '</td>
									<td style = "width: 5%; text-align: left;">' . $thisVersionID . '</td>
								</tr>';//can't translate well to HTML, use standard concat
						}
						
						echo '</table>';
						
						//makes subsequent table for question viewer
						echo
							'<p style = "margin-top: 0; color: #FFFFFF;" name = "versionViewing">[ Version Viewing No. N/A ]</p>
							
							<table class = "formAdminSecondary">
								<tr>
									<th style = "width: 5%;">QID</th>
									<th style = "width: 5%;">V#</th>
									<th style = "width: 5%;">crlt</th>
									<th style = "width: 5%;">trait</th>
									<th style = "width: 5%;">+</th>
									<th style = "width: auto;">prompt</th>
									<th style = "width: 28%;">stats</th>
								</tr>';
						
						$SQL =
							'SELECT *
							FROM versions_questions';
						
						//add rows for table
						if($result = mysqli_query($connection, $SQL))
						{
							for($i = 0; $i < $maxDisplayQuestionRows; $i++)
							{
								echo
									"<tr>
										<td style = 'text-align: left;' name = 'displayQuestionQID{$i}'>N</td>
										<td style = 'text-align: left;' name = 'displayQuestionVID{$i}'>N</td>
										<td name = 'displayQuestionCorrelate{$i}'>N</td>
										<td name = 'displayQuestionTrait{$i}'>N</td>
										<td name = 'displayQuestionPositive{$i}'>N</td>
										<td style = 'text-align: left;' name = 'displayQuestionPrompt{$i}'>N</td>
										<td style = 'text-align: left;' name = 'displayQuestionAverage{$i}'>N</td>
									</tr>";
							}
						}
						
						echo '</table></form></div>';
						
						////VERSION CREATOR//////////////////////////////////////////////////////////////////////////////////
						$openRows = 75;
						
						//add values to table that will be referenced in <table> to show pre-existing questions
						$existingQuestions =
							array(
								array(),
								array(),
								array(),
								array(),
								array()
							);
						
						$SQL =
							"SELECT *
							FROM questions_general
							INNER JOIN versions_questions ON questions_general.questionID = versions_questions.questionID
							WHERE versionID = {$currentVersionID}
							ORDER BY questions_general.questionTrait ASC, questions_general.questionPositive ASC, questions_general.questionCorrelate ASC;";
						
						if($result = mysqli_query($connection, $SQL))
						{
							while($questionRow = mysqli_fetch_assoc($result))
							{
								array_push($existingQuestions[0], strval($questionRow["questionID"]));
								array_push($existingQuestions[1], strval($questionRow["questionCorrelate"]));
								array_push($existingQuestions[2], strval($questionRow["questionTrait"]));
								array_push($existingQuestions[3], strval($questionRow["questionPositive"]));
								array_push($existingQuestions[4], $questionRow["questionPrompt"]);
							}
						}
						else
						{
							$existingQuestions = array(array());
						}
						
						$existingQuestionsCount = count($existingQuestions[0]);
						
						$totalRows = $openRows + $existingQuestionsCount;
						
						//create main HTML
						echo
						'<div>
							<h2 style = "margin-bottom: 0;">Version Creator</h2>
							<p style = "margin: 0;">[ Current Version No. ' . $currentVersionNumber . ' ]</p>
							
							<br/>
							
							<form method = "POST" class = "formAdminPrimary">
								<p style = "color: #F4F4F4; text-align: left; margin-left: 5%;">
									questionID (QID) is question ID if it already exists
									<br/>versionNumber(V#) is the earliest version number of question if it already exists so you know when its max value started
									<br/>INCLUDE (Inc) is whether to ignore the row
									<br/>PRESERVE (Pres) is if the question already exists and you would like to keep it identical for the next version; only set to true if version maxVal is the same of old question version and new version and all attributes are the same; if you would like to update the question attributes, uncheck Inc and place the new wording into another box you will include so it knows to create a new data representation thereof
									<br/>CORRELATE (crlt) is -1 if the question is not a control; if it is, it\'s the questionID of its corresponding control
									<br/>TRAIT is 1-5 for the OCEAN trait being measured
									<br/>POSITIVE (+) is whether answering the question in the affirmative will augment or decriment the trait\'s valency
									<br/>PROMPT is the question being asked
								</p>
								
								<button type = "submit" name = "newVersionSubmit" class = "button">execute</button>
								
								<br/>
								
								<span class = "formMain" style = "color: #F4F4F4;"><br/>
									new version<br/><input type = "text" name = "newVersion" placeholder = "version no."/><br/>
									max value<br/><input type = "text" name = "newMaxValue" placeholder = "slider max int"/><br/>
								</span>
								
								<br/>
								
								<table class = "formAdminSecondary">
									<tr>
										<th style = "width: 5%;">QID</th>
										<th style = "width: 5%;">V#</th>
										<th style = "width: 5%;">inc</th>
										<th style = "width: 5%;">pres</th>
										<th style = "width: 5%;">crlt</th>
										<th style = "width: 5%;">trait</th>
										<th style = "width: 5%;">+</th>
										<th style = "width: auto;">prompt</th>
									</tr>';
						
						//store values in POSTed tables if execute clicked
						if(isset($_POST["newVersionSubmit"]))
						{
							$SQL =
								'INSERT INTO versions_general (versionNumber, versionMaxValue, versionTime)
								VALUES (' . floatval($_POST["newVersion"]) . ', ' . intval($_POST["newMaxValue"]) . ', "' . date("Y-m-d H:i:s") . '");';
							
							mysqli_query($connection, $SQL);//insert new version
							
							$localVersionID = mysqli_insert_id($connection);
							
							//foreach row, store in questions_general and versions_questions tables
							for($i = 0; $i < $totalRows; $i++)
							{
								if(isset($_POST["creatorQuestionInclude{$i}"]) && $_POST["creatorQuestionInclude{$i}"])//if this question is being added to the new version
								{
									$localQuestionID;
									
									//match or add question to its questions_general correlate
									if(isset($_POST["creatorQuestionPreserve{$i}"]) && $_POST["creatorQuestionPreserve{$i}"])//if this is a question that existed in a previous version and is being preserved as it was, match
									{
										$localQuestionID = $_POST["creatorQuestionQID{$i}"];//set $localQuestionID to the existing QID so it's matched to new version
									}
									else//if it didn't exist in a previous version, create a new representation in questions_general
									{
										$localCorrelate = -1;
										$localTrait = -1;
										$localPositive = -1;
										$localPrompt = "N";
										
										//check $questionCorrelate for existence
										if(isset($_POST["creatorQuestionCorrelate{$i}"]))
										{
											$localCorrelate = $_POST["creatorQuestionCorrelate{$i}"];
										}
										
										//check $localTrait for existence
										if(isset($_POST["creatorQuestionTrait{$i}"]))
										{
											$localTrait = $_POST["creatorQuestionTrait{$i}"];
										}
										
										//convert $localPositive to 0 or 1 (isset only if checked)
										if(isset($_POST["creatorQuestionPositive{$i}"]))
										{
											$localPositive = 1;
										}
										else
										{
											$localPositive = 0;
										}
										
										//check $localPrompt for existence
										if(isset($_POST["creatorQuestionPrompt{$i}"]))
										{
											$localPrompt = $_POST["creatorQuestionPrompt{$i}"];
										}
										
										$SQL =
											"INSERT INTO questions_general (questionCorrelate, questionTrait, questionPositive, questionPrompt)
											VALUES ({$localCorrelate}, {$localTrait}, {$localPositive}, '{$localPrompt}');";
										
										mysqli_query($connection, $SQL);
										
										$localQuestionID = mysqli_insert_id($connection);
									}
									
									//add version-question pairs to versions_questions to make local question present in new version
									$SQL =
										"INSERT INTO versions_questions (versionID, questionID)
										VALUES ({$localVersionID}, {$localQuestionID});";
									
									mysqli_query($connection, $SQL);
								}
							}
							
							RefreshPage();
						}
						
						//create rows
						$SQL = "SHOW TABLE STATUS LIKE 'questions_general';";
						
						$nextIncrement = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["Auto_increment"];
						
						for($i = 0; $i < $totalRows; $i++)//openRows + existingQuestions so there will always be openRows more open spaces than there are existing questions
						{
							$localQuestionID = "N";
							$localVersionNumber = "N";
							$localExists = "";
							$localCorrelate = -1;
							$localTrait = "";
							$localPositive = "";
							$localPrompt = "";
							
							//if currentRow is less than amount of pre-existing questions being added, checks default values for pre-existing question
							if($i < $existingQuestionsCount)
							{
								$localExists = " checked";
								$localQuestionID = $existingQuestions[0][$i];
								$localCorrelate = $existingQuestions[1][$i];
								$localTrait = $existingQuestions[2][$i];
								$localPrompt = $existingQuestions[4][$i];
								
								$SQL =
									"SELECT versionID
									FROM versions_questions
									WHERE questionID = {$localQuestionID};";
								
								$localVersionID = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["versionID"];//set versionID to associated question's ID; should get first by default
								
								$SQL =
									"SELECT versionNumber
									FROM versions_general
									WHERE versionID = {$localVersionID};";
								
								$localVersionNumber = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["versionNumber"];//set versionNumber thereto based on ID just gotten
								
								//converts localPositive to "checked" or "" for pre-existing answer
								if($existingQuestions[3][$i] == "1")
								{
									$localPositive = " checked";
								}
							}
							else
							{
								$localQuestionID = $nextIncrement;//set $localQuestionID to what it will be if it's made for sake of corresponding referencing
								
								$nextIncrement += 1;
							}
							
							echo
								"<tr>
									<td>{$localQuestionID}</td><input type = 'hidden' name = 'creatorQuestionQID{$i}' value = '{$localQuestionID}'/>
									<td>{$localVersionNumber}</td>
									<td><input type = 'checkbox' name = 'creatorQuestionInclude{$i}'{$localExists}/></td>
									<td><input type = 'checkbox' name = 'creatorQuestionPreserve{$i}'{$localExists}/></td>
									<td><input type = 'text' name = 'creatorQuestionCorrelate{$i}' value = '{$localCorrelate}'/></td>
									<td><input type = 'text' name = 'creatorQuestionTrait{$i}' value = '{$localTrait}'/></td>
									<td><input type = 'checkbox' name = 'creatorQuestionPositive{$i}'{$localPositive}/></td>
									<td><input type = 'text' name = 'creatorQuestionPrompt{$i}' value = \"{$localPrompt}\"/></td>
								</tr>";
						}
						
						echo
								'</table>
							</form></div>
							
							<div class = "line"></div>';
						
						///////////////////////SURVEYS
						//////SURVEY SELECTOR
						
						echo '<form method = "POST">';
						
						echo
							'<h2>Surveys</h2>
							<button type = "submit" name = "updateSurveyHiddens" class = "button">execute</button>';
						
						if(isset($_POST["viewNewSurvey"]))
						{
							$_SESSION["currentViewingSurvey"] = $_POST["viewNewSurvey"];
							
							RefreshPage();
						}
						
						if(!isset($_SESSION["currentViewingSurvey"]))
						{
							$_SESSION["currentViewingSurvey"] = "N";
						}
						
						echo
							'<p style = "text-align: left; margin-left: 5%;">
								click "F" on the respective survey below to filter
							</p>
							
							<table class = "formAdminSecondary">
								<tr>
									<th style = "width: 5%;">view</th>
									<th style = "width: 5%;">SID</th>
									<th style = "width: auto;">name</th>
									<th style = "width: 5%;">order</th>
									<th style = "width: 5%;">hidden</th>
								</tr>';
						
						if($_SESSION["currentViewingSurvey"] == "N")
						{
							echo
								'<tr style = "background-color: #000020; color: #F4F4F4;">
								<td style = "background-color: #F4F4F4; color: #000020;">T</td>';
						}
						else
						{
							echo
								'<tr>
								<td><button type = "submit" style = "background-color: #000020; color: #F4F4F4;" name = "viewNewSurvey" value = "N">F</button></td>';
						}
						
						echo
									'<td>N</td>
									<td>_VIEW_ALL_SURVEYS</td>
									<td>/</td>
									<td>/</td>
								</tr>';
						
						$currentTotalQuestions = 0;
						
						$SQL =
							"SELECT *
							FROM surveys_general
							ORDER BY surveyOrder ASC;";
						
						$result = mysqli_query($connection, $SQL);
						
						while($row = mysqli_fetch_assoc($result))
						{
							$thisSID = $row["surveyID"];
							$thisName = $row["surveyName"];
							$thisOrder = $row["surveyOrder"];
							$thisHidden = $row["surveyHidden"];
							
							if($_SESSION["currentViewingSurvey"] == $thisSID)
							{
								echo
									'<tr style = "background-color: #000020; color: #F4F4F4;">
									<td style = "background-color: #F4F4F4; color: #000020;">T</td>';
							}
							else
							{
								echo
									'<tr>
									<td><button type = "submit" style = "background-color: #000020; color: #F4F4F4;" name = "viewNewSurvey" value = "' . $thisSID . '">F</button></td>';
							}
							
							echo '<td>' . $thisSID . '</td><input type = "hidden" name = "surveyName' . $currentTotalQuestions . '" value = "' . $thisSID . '"/>';
							echo "<td>{$thisName}</td>";
							echo '<td><input type = "text" name = "surveyOrder' . $currentTotalQuestions . '" value = "' . $thisOrder . '"/></td>';
							
							$checkedString = "";
							
							if($thisHidden == 1)
							{
								$checkedString = " checked";
							}
							
							echo '<td><input type = "checkbox" name = "surveyHidden' . $currentTotalQuestions . '"' . $checkedString . '/></td>';
							
							$currentTotalQuestions += 1;
							
							echo '</tr>';
						}
						
						if(isset($_POST["updateSurveyHiddens"]))
						{
							for($i = 0; $i < $currentTotalQuestions; $i++)
							{
								$thisSID = $_POST["surveyName{$i}"];
								$thisOrder = $_POST["surveyOrder{$i}"];
								
								//if checked hidden
								if(isset($_POST["surveyHidden{$i}"]))
								{
									$SQL =
										"UPDATE surveys_general
										SET surveyOrder = {$thisOrder}, surveyHidden = 1
										WHERE surveyID = {$thisSID};";
								}
								else
								{
									$SQL =
										"UPDATE surveys_general
										SET surveyOrder = {$thisOrder}, surveyHidden = 0
										WHERE surveyID = {$thisSID};";
								}
								
								mysqli_query($connection, $SQL);
							}
							
							RefreshPage();
						}
						
						echo '</table></form>';
						
						////SURVEY MANAGER//////////////////////////////////////////////////////////////////////////////////
						echo
						'<div>
							<h2 style = "margin-bottom: 0;">Survey Manager</h2>
							
							<br/>
							
							<form method = "POST" class = "formAdminPrimary" style = "height: 75vh;">
								<button type = "submit" name = "updateSurveys" class = "button">execute</button>';
							
							
							///////////////////////QUESTIONS
							
							echo
								'<h2 style = "color: #F4F4F4;">Questions</h2>
								
								<p style = "color: #F4F4F4; text-align: left; margin-left: 5%;">
									inc is whether to include; to delete, leave data and uncheck it<br/>
									prompt is the question asked<br/>
									target is the person being targeted; is either self, parent, or sibling<br/>
									identifier is N by default, but iff type and target are the same OR it\'s not multiple_choice, set it<br/>
									*MAKE SURE TO ADD IN ROWS CHRONOLOGICALLY WITHOUT SKIPPING
								</p>
								
								<table class = "formAdminSecondary">
									<tr>
										<th style = "width: 5%;">inc</th>
										<th style = "width: 5%;">SQID</th>
										<th style = "width: 5%;">SID</th>
										<th style = "width: 5%;">order</th>
										<th style = "width: auto;">prompt</th>
										<th style = "width: 20%;">target</th>
										<th style = "width: 20%;">identifier</th>
									</tr>';
							
							$extraQuestionSpaces = 15;
							$currentTotalQuestions = 0;
							
							$SQL =
								"SELECT *
								FROM surveys_questions
								ORDER BY surveyID ASC, surveyQuestionOrder ASC;";
							
							$result = mysqli_query($connection, $SQL);
							
							while($row = mysqli_fetch_assoc($result))
							{
								$thisSID = $row["surveyID"];
								
								if($_SESSION["currentViewingSurvey"] == "N" || $_SESSION["currentViewingSurvey"] == $thisSID)
								{
									$currentTotalQuestions += 1;
									
									$thisSQID = $row["surveyQuestionID"];
									$thisSO = $row["surveyQuestionOrder"];
									$thisSQP = $row["surveyQuestionPrompt"];
									$thisSQT = $row["surveyQuestionTarget"];
									$thisSQI = $row["surveyQuestionIdentifier"];
									
									echo '<tr>';
									
									echo '<td><input type = "checkbox" name = "surveyQuestionInclude' . $currentTotalQuestions . '" checked/></td>';
									echo '<td>' . $thisSQID . '</td><input type = "hidden" name = "surveyQuestionID' . $currentTotalQuestions . '" value = "' . $thisSQID . '"/>';
									echo '<td><input type = "text" name = "surveyQuestionSID' . $currentTotalQuestions . '" value = "' . $thisSID . '"/></td>';
									echo '<td><input type = "text" name = "surveyQuestionOrder' . $currentTotalQuestions . '" value = "' . $thisSO . '"/></td>';
									echo '<td><input type = "text" name = "surveyQuestionPrompt' . $currentTotalQuestions . '" value = "' . $thisSQP . '"/></td>';
									echo '<td><input type = "text" name = "surveyQuestionTarget' . $currentTotalQuestions . '" value = "' . $thisSQT . '"/></td>';
									echo '<td><input type = "text" name = "surveyQuestionIdentifier' . $currentTotalQuestions . '" value = "' . $thisSQI . '"/></td>';
									
									echo '</tr>';
								}
							}
							
							$SQL = "SHOW TABLE STATUS LIKE 'surveys_questions';";
							$nextIncrement = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["Auto_increment"] - 1;
							
							for($i = 0; $i < $extraQuestionSpaces; $i++)
							{
								$currentTotalQuestions += 1;
								
								$nextIncrement += 1;
								
								echo '<tr>';
								
								echo '<td><input type = "checkbox" name = "surveyQuestionInclude' . $currentTotalQuestions . '"/></td>';
								echo '<td>' . $nextIncrement . '</td><input type = "hidden" name = "surveyQuestionID' . $currentTotalQuestions . '" value = "' . $nextIncrement . '"/>';
								echo '<td><input type = "text" name = "surveyQuestionSID' . $currentTotalQuestions . '" value = "-1"/></td>';
								echo '<td><input type = "text" name = "surveyQuestionOrder' . $currentTotalQuestions . '" value = "-1"/></td>';
								echo '<td><input type = "text" name = "surveyQuestionPrompt' . $currentTotalQuestions . '" value = "N"/></td>';
								echo '<td><input type = "text" name = "surveyQuestionTarget' . $currentTotalQuestions . '" value = "self/parent/sibling"/></td>';
								echo '<td><input type = "text" name = "surveyQuestionIdentifier' . $currentTotalQuestions . '" value = "N"/></td>';
								
								echo '</tr>';
							}
							
							if(isset($_POST["updateSurveys"]))
							{
								for($i = 0; $i < $currentTotalQuestions; $i++)
								{
									$thisSQID = $_POST["surveyQuestionID{$i}"];
									
									//if checked include
									if(isset($_POST["surveyQuestionInclude{$i}"]))//add content of row
									{
										$thisSID = $_POST["surveyQuestionSID{$i}"];
										$thisSO = $_POST["surveyQuestionOrder{$i}"];
										$thisSQP = $_POST["surveyQuestionPrompt{$i}"];
										$thisSQT = $_POST["surveyQuestionTarget{$i}"];
										$thisSQI = $_POST["surveyQuestionIdentifier{$i}"];
										
										$SQL =
											"SELECT *
											FROM surveys_questions
											WHERE surveyQuestionID = {$thisSQID};";
										
										$numRows = mysqli_num_rows(mysqli_query($connection, $SQL));
										
										if($numRows == 0)//if isn't already existent in table, insert
										{
											$SQL =
												"INSERT INTO surveys_questions (surveyID, surveyQuestionOrder, surveyQuestionPrompt, surveyQuestionTarget, surveyQuestionIdentifier)
												VALUES ({$thisSID}, {$thisSO}, \"{$thisSQP}\", \"{$thisSQT}\", \"{$thisSQI}\");";
										}
										else//if already exists in table, update
										{
											$SQL =
												"UPDATE surveys_questions
												SET surveyID = {$thisSID}, surveyQuestionOrder = {$thisSO}, surveyQuestionPrompt = \"{$thisSQP}\", surveyQuestionTarget = \"{$thisSQT}\", surveyQuestionIdentifier = \"{$thisSQI}\"
												WHERE surveyQuestionID = {$thisSQID};";
										}
										
										mysqli_query($connection, $SQL);
									}
									elseif(isset($_POST["surveyQuestionID{$i}"]))//remove content of row if the row was pre-existing
									{
										$SQL = "DELETE FROM surveys_questions WHERE surveyQuestionID = {$thisSQID};";
										
										mysqli_query($connection, $SQL);
									}
								}
								
								RefreshPage();
							}
							
							echo '</table>';
							
							
							///////////////////////ANSWERS
							
							echo
								'<h2 style = "color: #F4F4F4;">Answers</h2>
								
								<p style = "color: #F4F4F4; text-align: left; margin-left: 5%;">
									data is either multiple_choice, date, written, likert, or dropbox<br/>
									type is the enumerator name; nationality, race, age, etc<br/>
									*MAKE SURE TO ADD IN ROWS CHRONOLOGICALLY WITHOUT SKIPPING
								</p>
								
								<table class = "formAdminSecondary">
									<tr>
										<th style = "width: 5%;">inc</th>
										<th style = "width: 5%;">SAID</th>
										<th style = "width: auto;">data</th>
										<th style = "width: auto;">(type)</th>
									</tr>';
							
							$extraQuestionSpaces = 10;
							$currentTotalQuestions = 0;
							
							$SQL =
								"SELECT *
								FROM surveys_answers
								WHERE surveyAnswerType = 'N';";
							
							$result = mysqli_query($connection, $SQL);
							
							while($row = mysqli_fetch_assoc($result))//add in N types first for all surveyIDs to access
							{
								$currentTotalQuestions += 1;
								
								$thisSAID = $row["surveyAnswerID"];
								$thisSAD = $row["surveyAnswerData"];
								$thisSAT = $row["surveyAnswerType"];
								
								echo '<tr>';
								
								echo '<td><input type = "checkbox" name = "surveyAnswerInclude' . $currentTotalQuestions . '" checked/></td>';
								echo '<td>' . $thisSAID . '</td><input type = "hidden" name = "surveyAnswerID' . $currentTotalQuestions . '" value = "' . $thisSAID . '"/>';
								echo '<td><input type = "text" name = "surveyAnswerData' . $currentTotalQuestions . '" value = "' . $thisSAD . '"/></td>';
								echo '<td><input type = "text" name = "surveyAnswerType' . $currentTotalQuestions . '" value = "' . $thisSAT . '"/></td>';
								
								echo '</tr>';
							}
							
							$SQL =
								"SELECT *
								FROM surveys_answers
								INNER JOIN surveys_questionanswers ON surveys_questionanswers.surveyAnswerID = surveys_answers.surveyAnswerID
								INNER JOIN surveys_questions ON surveys_questionanswers.surveyQuestionID = surveys_questions.surveyQuestionID
								WHERE surveyAnswerType <> 'N';";
							
							if($_SESSION["currentViewingSurvey"] == "N")//N is wildcard
							{
								$SQL =
									"SELECT *
									FROM surveys_answers
									WHERE surveyAnswerType <> 'N';";
							}
							
							$result = mysqli_query($connection, $SQL);
							
							$allSAIDsRows = array();
							
							while($row = mysqli_fetch_assoc($result))//add in rows of surveyID
							{
								if($_SESSION["currentViewingSurvey"] == "N" || $_SESSION["currentViewingSurvey"] == $row["surveyID"])//N allows all main answerTypes, like writing, to always display
								{
									$currentTotalQuestions += 1;
									
									if(!in_array($row["surveyAnswerID"], $allSAIDsRows))//exclude duplicate rows
									{
										$thisSAID = $row["surveyAnswerID"];
										array_push($allSAIDsRows, $thisSAID);
										$thisSAD = $row["surveyAnswerData"];
										$thisSAT = $row["surveyAnswerType"];
										
										echo '<tr>';
										
										echo '<td><input type = "checkbox" name = "surveyAnswerInclude' . $currentTotalQuestions . '" checked/></td>';
										echo '<td>' . $thisSAID . '</td><input type = "hidden" name = "surveyAnswerID' . $currentTotalQuestions . '" value = "' . $thisSAID . '"/>';
										echo '<td><input type = "text" name = "surveyAnswerData' . $currentTotalQuestions . '" value = "' . $thisSAD . '"/></td>';
										echo '<td><input type = "text" name = "surveyAnswerType' . $currentTotalQuestions . '" value = "' . $thisSAT . '"/></td>';
										
										echo '</tr>';
									}
								}
							}
							
							$SQL = "SHOW TABLE STATUS LIKE 'surveys_answers';";
							$nextIncrement = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["Auto_increment"] - 1;
							
							for($i = 0; $i < $extraQuestionSpaces; $i++)
							{
								$currentTotalQuestions += 1;
								
								$nextIncrement += 1;
								
								echo '<tr>';
								
								echo '<td><input type = "checkbox" name = "surveyAnswerInclude' . $currentTotalQuestions . '"/></td>';
								echo '<td>' . $nextIncrement . '</td><input type = "hidden" name = "surveyAnswerID' . $currentTotalQuestions . '" value = "' . $nextIncrement . '"/>';
								echo '<td><input type = "text" name = "surveyAnswerData' . $currentTotalQuestions . '" value = "multiple_choice/date/written/likert/dropbox"/></td>';
								echo '<td><input type = "text" name = "surveyAnswerType' . $currentTotalQuestions . '" value = "N"/></td>';
								
								echo '</tr>';
							}
							
							if(isset($_POST["updateSurveys"]))
							{
								for($i = 0; $i < $currentTotalQuestions; $i++)
								{
									$thisSAID = $_POST["surveyAnswerID{$i}"];
									
									//if checked include
									if(isset($_POST["surveyAnswerInclude{$i}"]))//add content of row
									{
										$thisSAD = $_POST["surveyAnswerData{$i}"];
										$thisSAT = $_POST["surveyAnswerType{$i}"];
										
										$SQL =
											"SELECT *
											FROM surveys_answers
											WHERE surveyAnswerID = {$thisSAID};";
										
										$numRows = mysqli_num_rows(mysqli_query($connection, $SQL));
										
										if($numRows == 0)//if isn't already existent in table, insert
										{
											$SQL =
												"INSERT INTO surveys_answers (surveyAnswerData, surveyAnswerType)
												VALUES (\"{$thisSAD}\", \"{$thisSAT}\");";
										}
										else//if already exists in table, update
										{
											$SQL =
												"UPDATE surveys_answers
												SET surveyAnswerData = \"{$thisSAD}\", surveyAnswerType = \"{$thisSAT}\"
												WHERE surveyAnswerID = {$thisSAID};";
										}
										
										mysqli_query($connection, $SQL);
									}
									elseif(isset($_POST["surveyAnswerID{$i}"]))//remove content of row if the row was pre-existing
									{
										$SQL = "DELETE FROM surveys_answers WHERE surveyAnswerID = {$thisSAID};";
										
										mysqli_query($connection, $SQL);
									}
								}
								
								RefreshPage();
							}
							
							echo '</table>';
							
							
							///////////////////////QUESTIONANSWERS
							
							echo
								'<h2 style = "color: #F4F4F4;">Question-Answers</h2>
								
								<p style = "color: #F4F4F4; text-align: left; margin-left: 5%;">
									to draw connections between same answer types and different questions (e.g. nationality of you vs parent vs sibling)
								</p>
								
								<table class = "formAdminSecondary">
									<tr>
										<th style = "width: 5%;">inc</th>
										<th style = "width: auto;">SQID</th>
										<th style = "width: auto;">SAID</th>
										<th style = "width: 5%;">(localID)</th>
									</tr>';
							
							$extraQuestionSpaces = 15;
							$currentTotalQuestions = 0;
							
							$SQL =
								"SELECT *
								FROM surveys_questionanswers
								INNER JOIN surveys_questions ON surveys_questionanswers.surveyQuestionID = surveys_questions.surveyQuestionID;";
							
							if($_SESSION["currentViewingSurvey"] == "N")//N is wildcard
							{
								$SQL = "SELECT * FROM surveys_questionanswers;";
							}
							
							$result = mysqli_query($connection, $SQL);
							
							while($row = mysqli_fetch_assoc($result))
							{
								if($_SESSION["currentViewingSurvey"] == "N" || $_SESSION["currentViewingSurvey"] == $row["surveyID"])
								{
									$currentTotalQuestions += 1;
									
									$thisSQID = $row["surveyQuestionID"];
									$thisSAID = $row["surveyAnswerID"];
									$thisLID = $row["localID"];
									
									echo '<tr>';
									
									echo '<td><input type = "checkbox" name = "surveyQuestionAnswerInclude' . $currentTotalQuestions . '" checked/></td>';
									echo '<td><input type = "text" name = "surveyQuestionAnswerSQID' . $currentTotalQuestions . '" value = "' . $thisSQID . '"/></td>';
									echo '<td><input type = "text" name = "surveyQuestionAnswerSAID' . $currentTotalQuestions . '" value = "' . $thisSAID . '"/></td>';
									echo '<td>' . $thisLID . '</td><input type = "hidden" name = "surveyQuestionAnswerLID' . $currentTotalQuestions . '" value = "' . $thisLID . '"/>';
									
									echo '</tr>';
								}
							}
							
							$SQL = "SHOW TABLE STATUS LIKE 'surveys_questionanswers';";
							$nextIncrement = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["Auto_increment"] - 1;
							
							for($i = 0; $i < $extraQuestionSpaces; $i++)
							{
								$currentTotalQuestions += 1;
								
								$nextIncrement += 1;
								
								echo '<tr>';
								
								echo '<td><input type = "checkbox" name = "surveyQuestionAnswerInclude' . $currentTotalQuestions . '"/></td>';
								echo '<td><input type = "text" name = "surveyQuestionAnswerSQID' . $currentTotalQuestions . '" value = "-1"/></td>';
								echo '<td><input type = "text" name = "surveyQuestionAnswerSAID' . $currentTotalQuestions . '" value = "-1"/></td>';
								echo '<td>' . $nextIncrement . '</td><input type = "hidden" name = "surveyQuestionAnswerLID' . $currentTotalQuestions . '" value = "' . $nextIncrement . '"/>';
								
								echo '</tr>';
							}
							
							if(isset($_POST["updateSurveys"]))
							{
								for($i = 0; $i < $currentTotalQuestions; $i++)
								{
									$thisLID = $_POST["surveyQuestionAnswerLID{$i}"];
									
									//if checked include
									if(isset($_POST["surveyQuestionAnswerInclude{$i}"]))//add content of row
									{
										$thisSQID = $_POST["surveyQuestionAnswerSQID{$i}"];
										$thisSAID = $_POST["surveyQuestionAnswerSAID{$i}"];
										
										$SQL =
											"SELECT *
											FROM surveys_questionanswers
											WHERE localID = {$thisLID};";
										
										$numRows = mysqli_num_rows(mysqli_query($connection, $SQL));
										
										if($numRows == 0)//if isn't already existent in table, insert
										{
											$SQL =
												"INSERT INTO surveys_questionanswers (surveyQuestionID, surveyAnswerID)
												VALUES ({$thisSQID}, {$thisSAID});";
										}
										else//if already exists in table, update
										{
											$SQL =
												"UPDATE surveys_questionanswers
												SET surveyQuestionID = {$thisSQID}, surveyAnswerID = {$thisSAID}
												WHERE localID = {$thisLID};";
										}
										
										mysqli_query($connection, $SQL);
									}
									elseif(isset($_POST["surveyQuestionAnswerLID{$i}"]))//remove content of row if the row was pre-existing
									{
										$SQL = "DELETE FROM surveys_questionanswers WHERE localID = {$thisLID};";
										
										mysqli_query($connection, $SQL);
									}
								}
								
								RefreshPage();
							}
							
							echo '</table>';
							
							
							///////////////////////CHOICES
							
							echo
								'</table>
								
								
								<h2 style = "color: #F4F4F4;">Choices</h2>
								
								<p style = "color: #F4F4F4; text-align: left; margin-left: 5%;">
									text is the text for each corresponding choice of a multi-choice answer; basically an enumerator value
								</p>
								
								<table class = "formAdminSecondary">
									<tr>
										<th style = "width: 5%;">inc</th>
										<th style = "width: 5%;">SCID</th>
										<th style = "width: 5%;">SAID</th>
										<th style = "width: 5%;">order</th>
										<th style = "width: auto;">text</th>
									</tr>';
							
							$extraQuestionSpaces = 20;
							$currentTotalQuestions = 0;
							
							$SQL =
								"SELECT *
								FROM surveys_choices
								INNER JOIN surveys_answers ON surveys_answers.surveyAnswerID = surveys_choices.surveyAnswerID
								INNER JOIN surveys_questionanswers ON surveys_questionanswers.surveyAnswerID = surveys_answers.surveyAnswerID
								INNER JOIN surveys_questions ON surveys_questionanswers.surveyQuestionID = surveys_questions.surveyQuestionID
								ORDER BY surveys_questions.surveyID ASC, surveys_choices.surveyAnswerID ASC, surveys_choices.surveyChoiceOrder ASC;";
							
							$result = mysqli_query($connection, $SQL);
							
							$allSCIDsRows = array();
							
							while($row = mysqli_fetch_assoc($result))
							{
								if($_SESSION["currentViewingSurvey"] == "N" || $_SESSION["currentViewingSurvey"] == $row["surveyID"])
								{
									$currentTotalQuestions += 1;
									
									if(!in_array($row["surveyChoiceID"], $allSCIDsRows))//exclude duplicate rows
									{
										$thisSCID = $row["surveyChoiceID"];
										array_push($allSCIDsRows, $thisSCID);
										$thisSAID = $row["surveyAnswerID"];
										$thisSCO = $row["surveyChoiceOrder"];
										$thisSCT = $row["surveyChoiceText"];
										
										echo '<tr>';
										
										echo '<td><input type = "checkbox" name = "surveyChoiceInclude' . $currentTotalQuestions . '" checked/></td>';
										echo '<td>' . $thisSCID . '</td><input type = "hidden" name = "surveyChoiceID' . $currentTotalQuestions . '" value = "' . $thisSCID . '"/>';
										echo '<td><input type = "text" name = "surveyChoiceSAID' . $currentTotalQuestions . '" value = "' . $thisSAID . '"/></td>';
										echo '<td><input type = "text" name = "surveyChoiceOrder' . $currentTotalQuestions . '" value = "' . $thisSCO . '"/></td>';
										echo '<td><input type = "text" name = "surveyChoiceText' . $currentTotalQuestions . '" value = "' . $thisSCT . '"/></td>';
										
										echo '</tr>';
									}
								}
							}
							
							$SQL = "SHOW TABLE STATUS LIKE 'surveys_choices';";
							$nextIncrement = mysqli_fetch_assoc(mysqli_query($connection, $SQL))["Auto_increment"] - 1;
							
							for($i = 0; $i < $extraQuestionSpaces; $i++)
							{
								$currentTotalQuestions += 1;
								
								$nextIncrement += 1;
								
								echo '<tr>';
								
								echo '<td><input type = "checkbox" name = "surveyChoiceInclude' . $currentTotalQuestions . '"/></td>';
								echo '<td>' . $nextIncrement . '</td><input type = "hidden" name = "surveyChoiceID' . $currentTotalQuestions . '" value = "' . $nextIncrement . '"/>';
								echo '<td><input type = "text" name = "surveyChoiceSAID' . $currentTotalQuestions . '" value = "-1"/></td>';
								echo '<td><input type = "text" name = "surveyChoiceOrder' . $currentTotalQuestions . '" value = "-1"/></td>';
								echo '<td><input type = "text" name = "surveyChoiceText' . $currentTotalQuestions . '" value = "N"/></td>';
								
								echo '</tr>';
							}
							
							if(isset($_POST["updateSurveys"]))
							{
								for($i = 0; $i < $currentTotalQuestions; $i++)
								{
									$thisSCID = $_POST["surveyChoiceID{$i}"];
									
									//if checked include
									if(isset($_POST["surveyChoiceInclude{$i}"]))//add content of row
									{
										$thisSAID = $_POST["surveyChoiceSAID{$i}"];
										$thisSCO = $_POST["surveyChoiceOrder{$i}"];
										$thisSCT = $_POST["surveyChoiceText{$i}"];
										
										$SQL =
											"SELECT *
											FROM surveys_choices
											WHERE surveyChoiceID = {$thisSCID};";
										
										$numRows = mysqli_num_rows(mysqli_query($connection, $SQL));
										
										if($numRows == 0)//if isn't already existent in table, insert
										{
											$SQL =
												"INSERT INTO surveys_choices (surveyAnswerID, surveyChoiceOrder, surveyChoiceText)
												VALUES ({$thisSAID}, {$thisSCO}, \"{$thisSCT}\");";
										}
										else//if already exists in table, update
										{
											$SQL =
												"UPDATE surveys_choices
												SET surveyAnswerID = {$thisSAID}, surveyChoiceOrder = {$thisSCO}, surveyChoiceText = \"{$thisSCT}\"
												WHERE surveyChoiceID = {$thisSCID};";
										}
										
										mysqli_query($connection, $SQL);
									}
									elseif(isset($_POST["surveyChoiceID{$i}"]))//remove content of row if the row was pre-existing
									{
										$SQL = "DELETE FROM surveys_choices WHERE surveyChoiceID = {$thisSCID};";
										
										mysqli_query($connection, $SQL);
									}
								}
								
								RefreshPage();
							}
							
							echo '</table>';
						
						echo
							'</div>';
						
						////
						
						if(isset($_POST["makeSurvey"]))
						{
							$newSurveyName = $_POST["makeSurveyName"];
							
							$SQL =
								"INSERT INTO surveys_general (surveyName, surveyOrder, surveyHidden)
								VALUES ('{$newSurveyName}', -1, 1);";
							
							mysqli_query($connection, $SQL);
							
							RefreshPage();
						}
						
						if(isset($_POST["eraseSurvey"]))
						{
							$newSurveyName = $_POST["eraseSurveyName"];
							
							$SQL = "DELETE FROM surveys_general WHERE surveyName = '{$newSurveyName}';";
							
							mysqli_query($connection, $SQL);
							
							RefreshPage();
						}
						
						//create button
						echo
							'<br/><div>
								<form method = "POST">
									<input type = "text" name = "makeSurveyName" value = "newSurvey" style = "background-color: #1590A3; border-radius: 1vh; color: #FFFFFF; padding: 0.3vw;"/>
									
									<button type = "submit" name = "makeSurvey" class = "linkButton"><< make new survey</button>
									
									
									<input type = "text" name = "eraseSurveyName" value = "newSurvey" style = "background-color: #FC0349; border-radius: 1vh; color: #FFFFFF; padding: 0.3vw;"/>
									
									<button type = "submit" name = "eraseSurvey" class = "linkButton warning"><< erase survey</button>
								</form>
							</div>';
						
						////SURVEY RESPONSE VIEWER//////////////////////////////////////////////////////////////////////////////////
						
						$theseSQIDs = array();
						
						echo
						'<div>
							<h2 style = "margin-bottom: 0;">Survey Viewer</h2>
							
							<br/>
							
							<form method = "POST" class = "formAdminPrimary" style = "height: 65vh;">';
						
						$thisSurvey = $_SESSION["currentViewingSurvey"];
						
						if($thisSurvey == "N")//look through all questions
						{
							$SQL =
								"SELECT *
								FROM surveys_questions
								INNER JOIN surveys_questionanswers ON surveys_questions.surveyQuestionID = surveys_questionanswers.surveyQuestionID
								INNER JOIN surveys_answers ON surveys_questionanswers.surveyAnswerID = surveys_answers.surveyAnswerID
								ORDER BY surveyQuestionOrder ASC;";
						}
						else//look through specific questions
						{
							$SQL =
								"SELECT *
								FROM surveys_questions
								INNER JOIN surveys_questionanswers ON surveys_questions.surveyQuestionID = surveys_questionanswers.surveyQuestionID
								INNER JOIN surveys_answers ON surveys_questionanswers.surveyAnswerID = surveys_answers.surveyAnswerID
								WHERE surveyID = {$thisSurvey}
								ORDER BY surveyQuestionOrder ASC;";
						}
						
						$result = mysqli_query($connection, $SQL);
						
						while($row = mysqli_fetch_assoc($result))
						{
							switch($row["surveyAnswerData"])
							{
								case "multiple_choice":
									//no need to do anything here; statistics page will show all that needs to be seen
									
									break;
								case "written"://have JS button to randomly pull 10 responses from pre-loaded full PHP array of responses
									echo '<h2 style = "color: #F4F4F4; font-size: 1vw; margin-bottom: -1vh;">' . $row["surveyQuestionPrompt"] . ' - <span class = "subEmphasize" style = "color: #F4F4F4;">' . $row["surveyQuestionTarget"] . '</span></h2>';
									
									$thisSQID = $row["surveyQuestionID"];
						
									echo
										'<span class = "formMain" style = "color: #F4F4F4;"><br/>
											filter OTI<br/><input type = "text" name = "filterSurveyWrittenTraits' . $thisSQID . '" placeholder = "' . $zeros . '" value = "' . $zeros . '" onFocusOut = "FetchResponses' . $thisSQID . '()"/><br/>
										</span><br/>';
									
									echo '<input type = "button" class = "linkButton" style = "font-family: titleFont; color: #1590A3; font-size: 0.75vw; margin-top: -3vh;" onClick = "FetchResponses' . $thisSQID . '()" value = "Retrieve New Responses">';
									
									$numResponses = 10;
									
									for($i = 0; $i < $numResponses; $i++)
									{
										echo '<p style = "color: #1590A3; font-size: 0.75vw; margin-bottom: -3vh;" name = "surveyUserID' . $row["surveyQuestionID"] . '">UID - UOTI</h2><br/>';
										echo '<p style = "text-align: left; padding: 0 25vw; color: #F4F4F4; font-size: 0.65vw; line-height: 2.5vh;" name = "surveyQuestionViewID' . $thisSQID . '">RESPONSE</p>';
									}
									
									echo '<br/><br/><br/>';
									
									
									$users = "[";
									$uOTIs = "[";
									$responses = "[";
									
									$SQL =
										"SELECT *
										FROM surveys_responses
										INNER JOIN surveys_taken mainST ON surveys_responses.surveyTakenID = mainST.surveyTakenID
										INNER JOIN users_general ON mainST.userID = users_general.userID
										WHERE surveyQuestionID = {$thisSQID} AND mainST.surveyTakenID =
										(
											SELECT MAX(subST.surveyTakenID)
											FROM surveys_taken subST
											WHERE subST.userID = mainST.userID AND subST.surveyID = mainST.surveyID
										);";
									
									if($result2 = mysqli_query($connection, $SQL))
									{
										while($row2 = mysqli_fetch_assoc($result2))
										{
											$users .= '"' . $row2["userID"] . "\", ";
											$uOTIs .= '"' . $row2["OTI"] . "\", ";
											$responses .= '"' . $row2["surveyResponse"] . "\", ";
										}
									}
									
									$users .= "]";
									$uOTIs .= "]";
									$responses .= "]";
									
									echo
									"<script>
										function FetchResponses{$thisSQID}()
										{
											let users = {$users};
											let uOTIs = {$uOTIs};
											let responses = {$responses};
											
											let thisFilter = document.getElementsByName('filterSurveyWrittenTraits{$thisSQID}')[0];
											let thisFilterVal = thisFilter.value;
											
											if(!thisFilterVal.match(/^[0-3]{5}$/))//if it's not XXXXX where X = 0-3 and it's 5 chars, set it to default 00000
											{
												thisFilter.value = zeros;
												thisFilterVal = thisFilter.value;
											}
											
											
											let proceed = false;
											
											for(o = 0; o < uOTIs.length; o++)//check to see if OTI of filter exists in array so it doesn't infinitely search for random values of its type in recursive function
											{
												let localProceed = true;
												
												for(s = 0; s < 5; s++)
												{
													if(thisFilterVal.charAt(s) != '0' && thisFilterVal.charAt(s) != uOTIs[o].charAt(s))
													{
														localProceed = false;
														
														break;
													}
												}
												
												if(localProceed == true)
												{
													proceed = true;
													
													break;
												}
											}
											
											for(i = 0; i < {$numResponses}; i++)
											{
												if(proceed == true)
												{
													let thisIndex;
													
													function RecursiveRefresh()//randomly search for SQID of thisIndex that matches the OTI filter
													{
														thisIndex = Math.floor(Math.random() * responses.length);
														
														for(s = 0; s < 5; s++)
														{
															if(thisFilterVal.charAt(s) != '0' && thisFilterVal.charAt(s) != uOTIs[thisIndex].charAt(s))
															{
																RecursiveRefresh();
																
																break;
															}
														}
													}
													
													RecursiveRefresh();
													
													let thisUserElement = document.getElementsByName('surveyUserID' + '{$thisSQID}')[i];
													let thisQuestionElement = document.getElementsByName('surveyQuestionViewID' + '{$thisSQID}')[i];
													
													thisUserElement.innerHTML = '<span style = \"color: #F4F4F4;\">' + users[thisIndex] + '</span>ID - <span style = \"color: #F4F4F4;\">' + uOTIs[thisIndex] + '</span>OTI';
													thisQuestionElement.innerHTML = responses[thisIndex];
												}
												else
												{
													let thisUserElement = document.getElementsByName('surveyUserID' + '{$thisSQID}')[i];
													let thisQuestionElement = document.getElementsByName('surveyQuestionViewID' + '{$thisSQID}')[i];
													
													thisUserElement.innerHTML = 'UID - UOTI';
													thisQuestionElement.innerHTML = 'RESPONSE';
												}
											}
										}
										
										FetchResponses{$thisSQID}();
									</script>";
									
									break;
								case "likert":
									//no need to do anything here; statistics page will show all that needs to be seen
									
									break;
								case "date":
									//no need to do anything here; statistics page will show all that needs to be seen
									
									break;
								case "dropbox":
									/////////////////////FIX LATER
									
									break;
							}
						}
						
						echo '</form></div>';
					}
					
					require "Prefabs/prefab_dotsDown.php";
					
				?>
				
				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
