<?PHP
	
	echo '<footer id = "footer">';
	//echo '<footer id = "footer" class = "snapPoint" style = "scroll-snap-align: end none;">';
	
	/*require "Prefabs/prefab_headerContent.php";*/
	
	echo
		'<div class = "footer">
			
			<script>
				function ScrollToTop()
				{
					document.getElementById("contentWrap").querySelectorAll("H1, H2")[0].scrollIntoView({behavior: "smooth", block: "center"});
				}
			</script>
			
			<button class = "linkButton" style = "width: 100vw; margin-bottom: -5vh; font-size: 1vw; font-family: verdana; font-weight: bold;" onmousedown = "ScrollToTop();">RETURN TO TOP</button>
			
			<br/>
			
			<div style = "display: inline-block; width: 40vw;">
				<h2 style = "font-size: 1vw; margin-bottom: -1vh;">Disclaimer:</h2><br/>
				<p>• This website is currently only optimized for PCs •</p>
				<p>• What you are seeing is a prototypical version of the website and may change •</p>
				<p>• We have not yet administered surveys, so our predictions are arbitrary •</p><br/>
			</div>
			
			<div style = "display: inline-block; width: 10vw;">
				<img src = "Images/WhiteLogo.png" onDragStart = "return false;" class = "logo" name = "logo623" onClick = "RotateLogo(623)" />
			</div>
			
			<div style = "display: inline-block; width: 40vw;">
				<h2 style = "font-size: 1vw; margin-bottom: 0vh;">Additional:</h2><br/>
				<p style = "line-height: 1.75vh;">All property of Ocean Personalities™, including the name, logo, artwork, source code, theme, and intellectual property, is trademark protected</p><br/>
				<p style = "line-height: 1.75vh; padding-top: 1vh;">Join our <a href = "https://discord.gg/gxWfHqHQsn" class = "footerLink" style = "margin-top: -1vh;">DISCORD SERVER</a> to support us, get in the loop, and talk to the team!</p><br/>
			</div>
		</div>';
		
	echo '</footer>';
	
?>
