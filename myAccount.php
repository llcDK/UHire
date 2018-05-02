<html>
<head>
   <link href="css/myAccount/topStyle.css" rel="stylesheet" type="text/css"/ >
   <link href="css/myAccount/midStyle.css" rel="stylesheet" type="text/css"/ >
   <link href="css/myAccount/botStyle.css" rel="stylesheet" type="text/css"/ >
</head>



<body>
<?php
	include 'backend.php';
	session_start();
	$myAccount = unserialize($_SESSION['account']);
	
	// Create DB connection
	$dbconnect = new DBConnection();
	
?>
<div id="top">
   <div class="darken">

   <div id="Banner">
         <div id="topText"> UDRIVE </div>
   </div>
   
   <div class="topnav">
      <a class="active" href="#home">Home</a>
      <a href="#news">News</a>
      <a href="#contact">Contact</a>
      <a href="#about">About</a>
   </div>
   </div>
   </div>
</div>

<div id="mid">
   <div id="midBanner"> MY ACCOUNT </div>

   <div id="midMain">
      <div id="midLeft">
         <div id="ownerImg"></div>
         <div id="weirdCircle"></div>
      </div>

      <div id="userInfo">
         <div id="midInputsTop">
            <div id="midInputsLeft">
               <div>
                  <label>NAME: </label>
                  <input type="text" value = "<?php echo $myAccount->getFirstName() . ' ' . $myAccount->getLastName(); ?>" /><br/>
               </div>

               <div>
                  <label>D.O.B: </label>
                  <input type="text" value = "<?php echo "" ?>" /><br/>
               </div>

               <div>
                  <label>E-MAIL: </label>
                  <input type="text" value = "" /><br/>
               </div>

               <div>
                  <label>GENDER: </label>
                  <input type="text"/><br/>
               </div>

               <div>
                  <label>ADDRESS </label>
                  <input type="text" value = "<?php echo $myAccount->getAddress(); ?>" /><br/>
               </div>
            </div>
            <div id="midInputsRight">
               <div>
                  <label>VISA </label>
                  <input type="text"/><br/>
               </div>

               <div>
                  <label>MASTER </label>
                  <input type="text"/><br/>
               </div>
            </div>
         </div>
         <div id="midInputsBot">
            <button>EDIT</button>
            <button>TICK</button>

         </div>
      </div>
   </div>

</div>


<div id="bot">
   <div id="botBanner"> UPLOAD CARS </div>

   <div id="carScroll">
      <div id="left"><a href="#" class="previous round leftRight">&#8249;</a></div>

	<?php
		if($myAccount->type() == "Car owner")
		{
			// If the account belongs to a car owner
			$cars = $myAccount->getCars($dbconnect);
			foreach($cars as $car)
			{
				?>
				<div class="tileContainer">
					<div> <img class="carTile" src="<?php echo $car->getImageURL(); ?>" /> </div>
					<div class="buttonGroup">
						<button class="editCar"></button>
						<button class="deleteCar"></button>
					</div>
				</div>
	
	<?php	
			}
			
			
			
		}
		else if($myAccount->type() == "Car renter")
		{
			// Display a button that can let the renter upload a car and becomes a car owner
			?>
			<form action = "upload.php">
				<button type = "submit">Become a car owner</button>
			</form>
			
	<?php
		}
		
	?>
	
	<!--
      <div class="tileContainer">
         <div> <img class="carTile" src="images/myAccount/car3.png"/> </div>
         <div class="buttonGroup">
            <button class="editCar"></button>
            <button class="deleteCar"></button>
         </div>
      </div>

      <div class="tileContainer">
         <div> <img class="carTile" src="images/myAccount/car3.png"/> </div>
         <div class="buttonGroup">
            <button class="editCar"></button>
            <button class="deleteCar"></button>
         </div>
      </div>

      <div class="tileContainer">
         <div> <img class="carTile" src="images/myAccount/car3.png"/> </div>
         <div class="buttonGroup">
            <button class="editCar"></button>
            <button class="deleteCar"></button>
         </div>
      </div>
	-->
      
      <div id="right"><a href="#" class="next round leftRight">&#8250;</a></div>
   </div>

</div>

<div id="footer">
   <div id="footerData"> <span id="footerText">COPYRIGHT © 2018 Design By Wenjuan Sun </span></div>
   <div id="footerImage"> <img src="images/myAccount/socialIcons.png" id="socialMedia"/> </div>
</div>


</body>


</html>