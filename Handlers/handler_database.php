<?PHP
	
	$localServer = array("127.0.0.1", "::1");
	$publicServer = array("107.180.51.87");
	
	$serverName = "";
	$databaseUsername = "";
	$databasePassword = "";
	
	if(in_array($_SERVER["REMOTE_ADDR"], $localServer))//if is on localhost
	{
		$serverName = "localhost";
		$databaseUsername = "root";
	}
	else if(in_array($_SERVER["SERVER_ADDR"], $publicServer))//if is live on web
	{
		$serverName = "a2plcpnl0482";
		$databaseUsername = "accessPortal";
		$databasePassword = "0p9o8i7u6y5t4r3e2w1q";
	}
	else
	{
		$serverName = "NO_SERVER_FOUND";
	}
	
	$databaseName = "database_oceanpersonalities";
	
	$connection = mysqli_connect($serverName, $databaseUsername, $databasePassword, $databaseName);
	
?>
