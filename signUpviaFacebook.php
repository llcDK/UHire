<script>
	function loginFailed()
	{
		alert("User name or password incorrect!");
	}
	function loadMainPage()
	{
		window.location = "main.php";
	}
</script>
<?php
	include '/vendor/autoload.php';
	require __DIR__ . '/vendor/autoload.php';
	
	session_start();
	
	//Import Hybridauth's namespace
	use Hybridauth\Hybridauth; 

    $config = array(
      "base_url" => "http://localhost:806/Projects/UHire(git)/google.php",
      "providers" => array (
        "Google" => array (
          "enabled" => true,
          "keys"    => array ( "id" => "47786754348-i456hpaebt3f2u4mb6pina1t7l547938.apps.googleusercontent.com", "secret" => "GskkFoKCYbqG4iiBCfPYPIwM" ),
    )));
 
    //require_once( "vendor/hybridauth/hybridauth/hybridauth/Hybrid/Auth.php" );
 
    $hybridauth = new Hybrid_Auth( $config );
    echo "test";
 
    $adapter = $hybridauth->authenticate("Google");
    //echo "fb fired";
 
    $user_profile = $adapter->getUserProfile();
    echo "ID: " . $user_profile->identifier . "<br>";
    echo "Hi there! " . $user_profile->displayName . "<br>";
    echo "First Name: " . $user_profile->firstName . "<br>";
    echo "Last Name: " . $user_profile->lastName . "<br>";
    echo "Account Type: " . "Car renter" . "<br>";
    echo "Email: " . $user_profile->emailVerified;
    
    echo "db";
    include 'backend.php';
	
	$accNo = "";	// Same as Facebook account
	
	$checkExist = "select * from Account where fname = '$user_profile->firstName' and lname = '$user_profile->lastName' and password = 'SocialLogin';";
	$existsResult = $dbconnect->executeCommand($checkExist);
	
	echo $checkExist;
	
	if(mysqli_num_rows($existsResult) > 0)
	{
		// The account is already exists
		$accObj = Account::getAccount($dbconnect, $checkExist);
		echo "OLD THINGS";
	}
	else
	{
		$insertQueryToAccount = "insert into Account values('$user_profile->identifier', 'SocialLogin', 'Car renter', '$user_profile->firstName',  '$user_profile->lastName', NULL, NULL);";
		$insertQueryTosocialMedia = "insert into SocialMedia values('$user_profile->identifier', 'Google', '$user_profile->identifier');";
		$insertQueryToProfile = "insert into Profile values('$user_profile->identifier', NULL, NULL, NULL, NULL, NULL);";
		
		
		$dbconnect->executeCommand($insertQueryToAccount);
		$dbconnect->executeCommand($insertQueryTosocialMedia);
		$dbconnect->executeCommand($insertQueryToProfile);
		
		// After inserting, serialise and store account variable
		$accObj = new Account($user_profile->identifier, 'SocialLogin', 'Car renter', $user_profile->firstName,  $user_profile->lastName);
		
		echo "NEW THINGS";
	}
	
	print_r($accObj);
	
	$_SESSION['account'] = serialize($accObj);
	echo "<script>loadMainPage()</script>";
?>
