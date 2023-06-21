<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php"?>
		
		<title>Ocean - Types</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php";?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP require "Prefabs/prefab_projectTitle.php"; ?>
			
				<h1 style = "margin: -4vh 0vw -1vh; font-size: 2vw;">TYPE INDEX NAVIGATOR</h1>
				
				<div class = "tinyLine"></div>


				<script>

					let typeOTIs = [], typeNames = [];

					function UpdateTypeTraits() {
						let table = document.getElementsByName("table")[0];
						while (table.childNodes.length > 2) {
							table.removeChild(table.lastChild);
						}

						let filterTypeTraits = document.getElementsByName("filterTypeTraits")[0];
						let currentFilter = filterTypeTraits.value;
						
						if(!currentFilter.match(/^[0-3]{5}$/))//if it's not XXXXX where X = 0-3 and it's 5 chars, set it to default 00000
						{
							filterTypeTraits.value = zeros;
							currentFilter = filterTypeTraits.value;
						}
						console.log(currentFilter);
						for (let i = 0; i < typeOTIs.length; i++) {
							let add = true;
							for (let t = 0; t < 5 && add; t++) {
								if (!(currentFilter[t] == "0" || typeOTIs[i][t] == currentFilter[t])) {
									add = false;
								}
							}
							
							if (add) {
								let tr = table.appendChild(document.createElement("tr"));
								let tdOTI = tr.appendChild(document.createElement("td"));
								let tdName = tr.appendChild(document.createElement("td"));
								let a1 = tdOTI.appendChild(document.createElement("a"));
								let a2 = tdName.appendChild(document.createElement("a"));

								let link = "typeDefine.php?OTIType=" + typeOTIs[i];
								a1.setAttribute("href", link);
								a2.setAttribute("href", link);
								a1.innerHTML = typeOTIs[i];
								a2.innerHTML = typeNames[i];
								let style1 = "padding: 3%; font-family: verdana; color: #000020;";
								let style2 = "padding: 3%; font-family: titleFont; color: #1590A3; ";
								a1.setAttribute("style", style1);
								a2.setAttribute("style", style2);
							}
						}
					}

				</script>
				
				<h2>Filter Types</h2>
				<p class = "subEmphasize" style = "margin-top: -2vh; line-height: 2.25vh;">0 means the trait is ambiguous<br/>1, 2, or 3 refers to a specific trait<br/>format: { abcde | 0 <= var <= 3 }<br/>e.g., typing 10002 would show you all types<br/>with low opennness and medium neuroticism</p>
				<span class = "formMain" style = "color: #000;">
					<input type = "text" name = "filterTypeTraits" placeholder = "00000" value = "00000" onFocusOut = "UpdateTypeTraits()"/>
				</span>

				<br/><br/><br/><br/>

				<table style = "margin: 0 40vw; width: 20vw; font-size: 2vh; text-align: left;">
					<tbody name = "table">
						<tr style = "text-align: center; font-family: subtitleFont;">
							<th>Type Name</td>
							<th>OTI</td>
						</tr>
					</tbody>
				</table>
				
				<?PHP
					
					$SQL = "
						SELECT *
						FROM types_general;
					";
					$result = mysqli_query($connection, $SQL);

					while ($row = mysqli_fetch_assoc($result)) {
						echo '<script>typeOTIs.push("'.$row["OTI"].'");</script>';
						echo '<script>typeNames.push("'.$row["typeName"].'");</script>';
					}

				?>

				<script> UpdateTypeTraits(); </script>

				<br/><br/><br/>

				<?PHP require "Prefabs/prefab_dotsDown.php"; ?>

				<?PHP require "Prefabs/prefab_relevantOption.php"; ?>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
