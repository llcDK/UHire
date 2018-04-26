<!DOCTYPE html>
<html lang='eng'>
<head>
<title>LOGIN</title>
<link href="css/login/myStyle.css" rel="stylesheet" type="text/css"/ >
<link href="css/login/button.css" rel="stylesheet" type="text/css"/ >


</head>
<body>
<?php
//tell if the user typed content .empty? or value.
  $getname = empty($_GET["username"]) ? "" : htmlspecialchars($_GET["username"]) ;
  $getpassword  = empty($_GET["password"] ) ? "" : htmlspecialchars($_GET["password"]);
  
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
		
		<form method="post" action="student_db.php">  
		<input type="text" id="name" name="username" placeholder = "User" /> </br>
        <input type="text" id="password" name="password"  placeholder = "Password" /> 
	</div>
  
			<div id="login_control">  
				<button type ="submit"class="button">Log In </button>
			</div>
	 </form>
		<div id="si" >
			<a id="fsub"href="register.php">Sign up</a>
			<a id="rsub"href="forget_pwd.php">Forgot password</a>
		</div>
     
	<div  id="or_line">
			<span class='left1'></span>
			<span class = "orr">OR</span>
			<span class = 'right1'></span>
	</div>
	
	<div id= main>
	
		<div  id="icon">
			<img style="width:35px;hight:35px" src = "images/login/face.png"/>
		</div>
	
		<div  id="icon2">
			<img style="width:35px;hight:35px" src = "images/login/gog.png"/>
		</div>
	
	</div>
</div>  




</body>