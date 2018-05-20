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

    echo "import";
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
    echo "fb fired";
 
    $user_profile = $adapter->getUserProfile();
    echo "ID: " . $user_profile->identifier . "<br>";
    echo "Hi there! " . $user_profile->displayName . "<br>";
    echo "First Name: " . $user_profile->firstName . "<br>";
    echo "Last Name: " . $user_profile->lastName . "<br>";
    echo "Account Type: " . "Car renter" . "<br>";
    echo "Email: " . $user_profile->emailVerified;
    
    echo "db";
    include 'backend.php';
    $dbconnect = new DBConnection();
	$accNo = "";	// Same as Facebook account
	
	$checkExist = "select * from Account where accNo = $user_profile->identifier";
	

	$insertQueryToAccount = "insert into Account values($user_profile->identifier, 'SocialLogin', 'Car renter', $user_profile->firstName,  $user_profile->lastName, NULL, NULL);";
	$insertQueryTosocialMedia = "insert into SocialMedia values($user_profile->identifier, 'Facebook', $user_profile->identifier);";

	$dbconnect->executeCommand($insertQueryTosocialMedia);
	$dbconnect->executeCommand($insertQueryToAccount);
	
	// After inserting, serialise and store account variable
	$accObj = new Account($user_profile->identifier, 'SocialLogin', 'Car renter', $user_profile->firstName,  $user_profile->lastName);
	
	$_SESSION['account'] = serialize($accObj);
	# echo "<script>loadMainPage()</script>";
?>
