<!DOCTYPE HTML>
<html>

	<head>
		
		<?PHP require "Prefabs/prefab_core.php" ?>
		
		<title>Ocean - Define Trait</title>
		
	</head>
	
	<body>
		
		<div id = "pageContainer" onscroll = "ScrollCalled()">
			
			<?PHP require "Prefabs/prefab_headerMain.php"; ?>
			
			<div id = "contentWrap" onscroll = "ScrollCalled()">
				
				<?PHP
					
					$traitName = "N/A traitName";
					$paragraph = "N/A paragraph";
					$currentT = -1;
					
					for($t = 0; $t < 5; $t++)
					{
						if(isset($_GET[$traitWords[$t]]))
						{
							$traitName = $traitWords[$t];
							
							$SQL =
								"SELECT *
								FROM traits_ocean
								WHERE localID = " . ($t + 1) . ";";
							
							if($result = mysqli_query($connection, $SQL))
							{
								$paragraph = mysqli_fetch_assoc($result)["oceanParagraph"];
							}
							
							$currentT = $t;
							
							break;
						}
					}
					
					echo "<script>document.title = 'Ocean - " . ucwords($traitName) . "';</script>";
					
					if($currentT != -1)
					{
						$startPadding = "0.65vh 0.5vw";
						$newPadding = "0vh 0.33vw";
						
						$thisNewUrl;
						
						if(isset($_GET["previousPage"]))
						{
							$thisNewUrl = $_GET["previousPage"];
							
							if(isset($_GET["OTIType"]))
							{
								$thisNewUrl .= "?OTIType=" . $_GET["OTIType"];
							}
						}
						else
						{
							$thisNewUrl = "info.php";
						}
						
						echo
							'<br/><br/>
							
							<a href = "' . $thisNewUrl . '" style = "padding: ' . $startPadding . ';" class = "button" onMouseOver = "' . $oceanStyles[2][$currentT] . ' this.style.padding = \'' . $newPadding . '\';" onMouseOut = "' . $noTextShadow . ' this.style.padding = \'' . $startPadding . '\';" onMouseDown = "' . $clickButtonShadow . '"><<</a>
							
							<h1 class = "' . $traitName . '" style = "' . $oceanStyles[1][$currentT] . '">' . strtoupper($traitName) . '</h1>
							
							<p class = "centerParagraph" style = "padding-top: 16vh; padding-bottom: 10vh;">' .
								str_replace("!TRAIT", '<span class = "emphasize" style = "' . $oceanStyles[0][$currentT] . '">' . $traitName . '</span>', $paragraph) . '
							</p>';
					}
					else
					{
						echo '<p class = "warning">Make sure you arrived here from the previous page!  Unable to retrieve necessary data.</p>';
					}
				?>

				<br/><br/><br/><br/><br/><br/><br/>

				<?PHP require "Prefabs/prefab_footer.php"; ?>
				
			</div>
			
		</div>
		
	</body>

</html>
