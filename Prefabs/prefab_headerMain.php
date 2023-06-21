<?PHP
	
	//PRELUDE
	echo
		'<div id = "prelude" class = "snapPoint">
			<script>
				let thisGlowLogo = null;
				let thisPageContainer = null;
				
				window.onload = function()
				{
					thisGlowLogo = document.getElementsByName("glowLogo")[0];
					thisPageContainer = document.getElementById("pageContainer");
				}
				
				//CALC MOUSE DISTANCE FROM ELEMENT SCRIPT
				let mouseX, mouseY;
				let distance;
				
				let thisMaxDistance1 = 400;
				let thisMaxDistance2 = 1000;
				
				document.onmousemove = function(e)
				{
					if(thisGlowLogo != null)
					{
						mouseX = e.clientX + thisPageContainer.scrollLeft;
						mouseY = e.clientY + thisPageContainer.scrollTop;
						
						distance = Math.floor(
						Math.sqrt(
							Math.pow(mouseX - thisGlowLogo.offsetLeft, 2) +
							Math.pow(mouseY - thisGlowLogo.offsetTop, 2)
						));
						
						let asOne = Math.floor((1 - (distance / thisMaxDistance1)) * 100);
						let asTwo = Math.floor((1 - (distance / thisMaxDistance2)) * 100);
						
						if(asTwo > 0){
							if(asOne < 0)
							{
								asOne = "00";
							}
							
							thisGlowLogo.style.boxShadow = "0 0 50vh 25vh #E6F2F0" + asOne + ", 0 0 100vh 50vh #67C1C7" + asTwo + ", inset 0 0 50vh 25vh #E6F2F0" + asOne + ", inset 0 0 100vh 50vh #67C1C7" + asTwo;
						} else {
							thisGlowLogo.style.boxShadow = "0 0 50vh 25vh #E6F2F000, 0 0 100vh 50vh #67C1C700, inset 0 0 50vh 25vh #E6F2F000, inset 0 0 100vh 50vh #67C1C700";
						}
					}
				};
				
				let returnDelayInMS = 1000;
				let currentTimeout;
				
				let currentScale = 100;
				let baseScale = 100;
				
				//GLOW SCRIPT
				function ClickGlowLogo(isReturning)
				{
					if(thisGlowLogo != null)
					{
						if(isReturning){
							thisGlowLogo.style.transform = "scale(1) translate(-50%, -50%)";
							thisGlowLogo.style.top = "50%";
							thisGlowLogo.style.left = "50%";
							
							currentScale = 100;
						} else {
							currentScale += 5;
							
							let thisScale = (((baseScale * currentScale) + (100 * currentScale) - 10000) / currentScale) * 0.01;
							
							thisGlowLogo.style.transform = "scale(" + thisScale + ") translate(-50%, -50%)";
							thisGlowLogo.style.top = (Math.floor(Math.random() * Math.floor(101))) + "%";
							thisGlowLogo.style.left = (Math.floor(Math.random() * Math.floor(101))) + "%";
							
							clearTimeout(currentTimeout);
							
							currentTimeout = setTimeout(function()
							{
								ClickGlowLogo(true);
							}, returnDelayInMS);
						}
					}
				}
				
			</script>
			
			<img src = "Images/WhiteLogo.png" onDragStart = "return false;" class = "glowLogo" name = "glowLogo" onClick = "ClickGlowLogo(false)" />
			<img src = "Images/ScrollArrowWhite.png" onDragStart = "return false;" class = "preludeScrollArrow" name = "preludeScrollArrow" style = "opacity: 0;" />
		</div>';
	
	//ACTUAL HEADER
	$buttonNames = array("Home", "Info", "Stats", "Types");
	$buttonLinks = array("index", "info", "stats", "types");
	
	$logInText;
	
	if($userUsername != "")
	{
		$logInText = $userUsername;
	}
	else
	{
		$logInText = "not logged in";
	}
	
	if(isset($_POST["logOutSubmit"]))
	{
		if(session_status() !== PHP_SESSION_ACTIVE)
		{
			session_start();
		}
		
		session_unset();
		session_destroy();
		
		echo '<script>window.location.href = "index.php";</script>';
	}
	
	$isHeader2 = false;
	
	require "Prefabs/prefab_headerContent.php";
	
	$isHeader2 = true;
	
	//GHOST LOGO
	//echo '<img src = "Images/BlackLogo.png" class = "ghostLogo" name = "ghostLogo">';
	
?>
