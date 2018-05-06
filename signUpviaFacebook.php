<?php
	$dbconnect = new DBConnection();
	$accNo = "";	// Same as Facebook account
	
	$checkExist = "select * from Account where accNo = '$accNo';";
	
	// Check if 
	$insertQueryToAccount = "insert into Account values('$accNo', 'SocailLogin', 'Car renter', NULL, NULL, NULL, NULL);";
	$insertQueryTosocialMedia = "insert into SocialMedia values(12345, 'Facebook', '$accNo');";

	$dbconnect->executeCommand($insertQueryTosocialMedia);
	$dbconnect->executeCommand($insertQueryToAccount);

?>