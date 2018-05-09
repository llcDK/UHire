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
	
	$userType = $myAccount->type();
	// If the userType is admin, redirect to admin page
	if($userType == "Admin")
	{
		// Re-direct to admin mode
	}
	else
	{
		
	}
	
	// Create DB connection
	$dbconnect = new DBConnection();
	
	// Set the state variable
	/*
		$state records the state of the page
		0: Read-only mode
		1: Edit mode
		default: 0
	*/
	if(isset($_GET['state']) && !empty($_GET['state']))
	{
		$state = $_GET['state'];
	}
	else
	{
		$state = 0;
	}
	
	
?>
<div id="top">
      <div class="darken">

         <div id="Banner">
            <div id="topText"> UDRIVE </div>
         </div>

         <div class="topnav">
            <a href="main.php">Home</a>
            <a href="myAccount.php" class="active"> My Account</a>
            <a href="messages.html">Messages</a>
            <a href="#help"> Help </a>
            <a href="#contact">Contact</a>
         </div>
      </div>
</div>

<div id="mid">
	<div id="midBanner"> MY ACCOUNT : <?php echo strtoupper($userType); ?> </div>

	<div id="midMain">
		<div id="midLeft">
			<div class="circleContainer"> <div id="ownerImg"></div> </div>
			<div class="circleContainer"> <div id="weirdCircle"></div> </div>
		</div>

		<div id="userInfo">
			<div id="midInputsTop">
				<div id="midInputsLeft">
					<span>PERSONAL INFORMATION</span>
					<div>
						<label>NAME: </label>
						<?php 
						
							if($state == 1)
							{
							?>
								<input type="text" value = "<?php echo $myAccount->getFirstName() . ' ' . $myAccount->getLastName(); ?>" /><br/>
					  
						<?php
							}
							else
							{
								echo $myAccount->getFirstName() . ' ' . $myAccount->getLastName(); 
							}
						?>
					</div>

					<div>
						<label>D.O.B: </label>
						<?php
							if($state == 1)
							{
							?>
								<input type="text" value = "<?php echo "" ?>" /><br/>
						
						<?php
							}
							else
							{
								
							}
						?>
					</div>

					<div>
						<label>E-MAIL: </label>
						<?php
							if($state == 1)
							{
							?>
								<input type="text" value = "" /><br/>
						<?php
							}
							else
							{
								
							}
						?>
					</div>

					<div>
						<label>GENDER: </label>
						<?php
							if($state == 1)
							{
							?>
								<input type="text"/><br/>
						<?php
							}
							else
							{
								
							}
						?>
					</div>

					<div>
						<label>ADDRESS: </label>
						<?php
							if($state == 1)
							{
							?>
								<input type="text" value = "<?php echo $myAccount->getAddress(); ?>" /><br/>
						<?php
							}
							else
							{
								echo $myAccount->getAddress();
							}
						?>
					</div>
				</div>
				<div id="midInputsRight">
					<span>CREDIT CARD INFORMATION</span>
					<div>
						<label>VISA </label>
						<?php
							if($state == 1)
							{	
							?>
								<input type="text"/><br/>
						<?php
							}
							else
							{
								
							}
						?>
							
							
					</div>
					<div>
						<label>MASTER </label>
						<?php
							if($state == 1)
							{
							?>
								<input type="text"/><br/>
						<?php
							}
							else
							{
								
							}
						?>
					</div>
				</div>
			</div>
			<div id="midInputsBot">
				<?php
					if($state == 0)
					{
					?>
						<button class="editButton"></button>
				<?php
					}
					else
					{
					?>
						<button class="tickButton"></button>
				<?php
					}
				?>
				<!-- <button class="tickButton"></button> -->
			</div>
		</div>
	</div>
</div>


<div id="bot">
   <div id="botBanner"> UPLOAD CARS </div>

   <div id="carScroll">

	<?php
		if($myAccount->type() == "Car owner")
		{
			// If the account belongs to a car owner
			$cars = $myAccount->getCars($dbconnect);
			foreach($cars as $car)
			{
				?>
				<div id="left"><a href="#" class="previous round leftRight">&#8249;</a></div>
				
				<div class="tileContainer">
					<div> <img class="carTile" src="<?php echo $car->getImageURL(); ?>" /> </div>
					<div class="buttonGroup">
						<button class="editCar"></button>
						<button class="deleteCar"></button>
					</div>
				</div>
	
				<div id="right"><a href="#" class="next round leftRight">&#8250;</a></div>
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
	
   </div>

</div>

<div id="footer">
   <div id="footerData"> <span id="footerText">COPYRIGHT © 2018 Design By Wenjuan Sun </span></div>
   <div id="footerImage"> <img src="images/myAccount/socialIcons.png" id="socialMedia"/> </div>
</div>


</body>


</html>