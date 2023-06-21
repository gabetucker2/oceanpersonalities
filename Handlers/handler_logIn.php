<?PHP
	
	//update main data
	$_SESSION["userID"] = $row["userID"];
	$_SESSION["userUsername"] = $row["userUsername"];
	$_SESSION["userFirstName"] = $row["userFirstName"];
	$_SESSION["userEmail"] = $row["userEmail"];
	$_SESSION["userAccountTime"] = $row["userAccountTime"];
	$_SESSION["userOTI"] = $row["OTI"];
	$_SESSION["userAdmin"] = $row["userAdmin"];
	
?>
