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

					////////////////SETUP

					/*
					* "NAME OF OPTION HERE" => "TYPE OF OPTION HERE"
					* 
					* option types:
					* 
					* special: will look at the key and call a function given its value
					* nominal: individual options, like race, gender, sex, country, etc
					* date: will split the set of dates into 6 subsections, linear difference
					* scalar: will split the likert scale into x / 3 subsections
					* 
					*/

					$optionsX = array(
						//"openness" => "nominal"
						//"race_self" => "nominal"
						//"gender_self" => "nominal"
					);
					$optionsY = array(
						//"FREQUENCY" => "special"
						//"extraversion" => "nominal"
						//"birthday_self" => "date"
						//"test_accuracy_self" => "scalar"
					);

					////////////////FILL OPTIONS

					

				?>
				
				<br/></br><br/></br><br/></br>
			
				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
