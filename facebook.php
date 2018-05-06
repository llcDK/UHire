<?php
	include 'vendor/autoload.php';
	require __DIR__ . '/vendor/autoload.php';


	//Import Hybridauth's namespace
	use Hybridauth\Hybridauth; 

    $config = array(
      "base_url" => "https://127.0.0.1/Projects/UHire(git)/index.php",
      "providers" => array (
        "Facebook" => array (
          "enabled" => true,
          "keys"    => array ( "id" => "164171094252865", "secret" => "16ef9711b9471d45dcfe59f15da94411" ),
          "scope"   => ['email', 'user_about_me', 'user_birthday', 'user_hometown'], // optional
          "photo_size" => 200, // optional
    )));
 
    // require_once( "vendor/hybridauth/hybridauth/hybridauth/Hybrid/Auth.php" );
 
    $hybridauth = new Hybrid_Auth( $config );
 
    $adapter = $hybridauth->authenticate( "Facebook" );
 
    $user_profile = $adapter->getUserProfile();
    echo "Hi there! " . $user_profile->displayName;
    echo "First Name: " . $user_profile->firstName;
    echo "Last Name: " . $user_profile->lastName;
    echo "Account Type" . "Car renter";
    echo "Email: " . $user_profile->emailVerified;
?>
