<?PHP
	
	$localServer = array("127.0.0.1", "::1");
	$publicServer = array("35.212.127.164");
	
	$serverName = "";
	$databaseUsername = "";
	$databasePassword = "";
	
	if(in_array($_SERVER["REMOTE_ADDR"], $localServer))//if is on localhost
	{
		$databaseName = "database_oceanpersonalities";
		$serverName = "127.0.0.1";
		$databaseUsername = "root";
	}
	else if(in_array($_SERVER["SERVER_ADDR"], $publicServer))//if is live on web
	{
		$databaseName = "dbugy7xvc3tb61";
		$serverName = "35.212.127.164";
		$databaseUsername = "ulmhnby3d5rcn";
		$databasePassword = "&&D6^5hG}D%6";
	}
	else
	{
		$serverName = "NO_SERVER_FOUND";
	}
	
	
	$connection = mysqli_connect($serverName, $databaseUsername, $databasePassword, $databaseName);
	
?>
