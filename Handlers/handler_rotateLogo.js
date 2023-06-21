let timesToSpin = 0;

let timesToRotate = 24;//must be increment of 360
let rotationTime = 0.5;
let rotateIncrement = 360 / timesToRotate;

let currentRotation = 360;
let intervalRot;

let isRotating = false;
let rotatingPos = -1;

function RotateLogo(logoPos)
{
	if(isRotating == false || (isRotating == true && logoPos == rotatingPos))
	{
		let logo = document.getElementsByName("logo" + logoPos)[0];
		
		rotatingPos = logoPos;
		
		timesToSpin++;
		
		SubFunction();
		
		function SubFunction()//call this from inside to avoid recursive function calling erroneously thinking that the user clicked another time
		{
			if(isRotating == false)
			{
				isRotating = true;
				
				intervalRot = setInterval(MakeRotation, (1000 * rotationTime / timesToRotate));
			}
			
			function MakeRotation()
			{
				currentRotation -= rotateIncrement;
				
				let hasIncremented = false;
				
				function RotateIncrement()
				{
					if(!hasIncremented)
					{
						hasIncremented = true;
						
						logo.style.transform = "rotate(" + currentRotation + "deg)";
					}
				}
				
				if(currentRotation <= 0)
				{
					currentRotation = 360;
					
					clearInterval(intervalRot);
					
					isRotating = false;
					
					timesToSpin--;
					
					if(timesToSpin > 0)
					{
						RotateIncrement();//just so that it will rotate it the final time to prepare for the next spin
						
						SubFunction();
					}
				}
				
				RotateIncrement();
				
				if(timesToSpin == 0)
				{
					logo.style.removeProperty("transform");
				}
			}
		}
	}
}
