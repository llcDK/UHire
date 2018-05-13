<!DOCTYPE html>
<html lang='eng'>
<head>
<title>LOGIN</title>
<link href="css/login/myStyle.css" rel="stylesheet" type="text/css"/ >
<link href="css/login/button.css" rel="stylesheet" type="text/css"/ >


</head>
<body>
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
	include 'backend.php';
	//tell if the user typed content .empty? or value.
	if(isset($_GET["action"]) && $_GET["action"] == "login")
	{
		$inputName = empty($_POST["username"]) ? "" : htmlspecialchars($_POST["username"]) ;
		$inputPassword  = empty($_POST["password"] ) ? "" : htmlspecialchars($_POST["password"]);
		
		// Creat a DBConnection object
		
		//echo "<script>alert('Log in processing ... ');</script>" ;
		
		// Request User information
		$dbqueryFindAccount = "select * from Account where accNo = '$inputName' and password = '$inputPassword';";
		$dbqueryResult = $dbconnect->executeCommand($dbqueryFindAccount);
		
		
		if(mysqli_num_rows($dbqueryResult) > 0)
		{
			// Log in Successfully
			echo "<script>alert('Log in successful !');</script>";
			// Process the account into a object
			$accRow = mysqli_fetch_row($dbqueryResult);
			$accObj = new Account($accRow[0], $accRow[1], $accRow[2], $accRow[3], $accRow[4], $accRow[5], $accRow[6]);
			session_start();
			
			$_SESSION['account'] = serialize($accObj);
			
			// Open main.php
			echo "<script>loadMainPage()</script>";
		}
		else
		{
			echo "<script>loginFailed()</script>";
		}
	}
	
?>
 
	<div id ="background" style="opacity:0.8";>
		<img src="images/login/car1.jpg"/ >;
	</div>


<div id = "login_frame" >
	
	<div id="image_logo"><img style="width:100px;hight:100px" src="images/login/rent.png"/></div>
	
	<div class="line">
			<span class='left'></span>
			<span class = 'title'>Change Your Life Style</span>
			<span class = 'right'></span>
	</div>
	
    
	<div id="loginuser">
		
		<form method="post" action="carlogin.php?action=login">  
		<input type="text" id="name" name="username" placeholder = "User" /> </br>
        <input type="password" id="password" name="password"  placeholder = "Password" /> 
	</div>
  
			<div id="login_control">  
				<button type ="submit"class="button">Log In </button>
			</div>
	 </form>
		<div id="si" >
			<a id="fsub"href="register.php">Sign up</a>
			<a id="rsub"href="forget_pwd.php">Forgot password</a>
		</div>
     
	<div id="or_line">
			<span class='left1'></span>
			<span class = "orr">OR</span>
			<span class = 'right1'></span>
	</div>
	
	<div id= main>
	
		<div id="icon">
			<a href = "signUpviaFacebook.php"><img style="width:35px;hight:35px" src = "images/login/face.png"/></a>
		</div>
	
		<div  id="icon2">
			<img style="width:35px;hight:35px" src = "images/login/gog.png"/>
		</div>
	
	</div>
</div>  




</body>