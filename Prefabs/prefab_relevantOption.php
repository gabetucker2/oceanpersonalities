<?PHP
	
	/*require "Prefabs/prefab_dotsDown.php";*/
	
	if($userID == -1)
	{
		require "prefab_signUpLogIn.php";
	}
	else
	{
		if($userOTI == $zeros)
		{
			require "prefab_takeTest.php";
		}
		else
		{
			require "prefab_yourType.php";
		}
	}
	
?>
