<html>
<head>
   <link href="css/myAccount/topStyle.css" rel="stylesheet" type="text/css"/ >
   <link href="css/myAccount/midStyle.css" rel="stylesheet" type="text/css"/ >
   <link href="css/myAccount/botStyle.css" rel="stylesheet" type="text/css"/ >
</head>

<body>
<script>
	function updateInfo()
	{
		var fname = document.getElementById('fnameInput').value;
		var lname = document.getElementById('lnameInput').value;
		var dob = document.getElementById('dobInput').value;
		var email = document.getElementById('emailInput').value;
		var gender = document.getElementById('genderInput').value;
		var address = document.getElementById('addInput').value;
		var bankAcc = document.getElementById('bankAccInput').value;
		var cardNo = document.getElementById('cardNoInput').value;
		var type = document.getElementById('typeInput').value;
		var expire = document.getElementById('expireInput').value;
		
		window.location = "myAccount.php?state=2&fn=" + fname + "&ln=" + lname + "&d=" + dob + "&e=" + email + "&g=" + gender + "&ad=" + address + "&b=" + bankAcc + "&c=" + cardNo + "&t=" + type + "&ex=" + expire;
		
	}
</script>
<?php
	include 'backend.php';
	session_start();
	
	$myAccount = unserialize($_SESSION['account']);
	$myAccount->initProfile($dbconnect);
	$userType = $myAccount->type();
	// If the userType is admin, redirect to admin page
	if($userType == "Admin")
	{
		// Re-direct to admin mode
	}
	else
	{
		
	}
	
	
	// Set the state variable
	/*
		$state records the state of the page
		0: Read-only mode
		1: Edit mode
		2: Intermediate mode, for updating database
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
	
	// For the intermediate updating page
	if($state == 2)
	{
		// Frist based on $_GET, create a new Account object
		$newAccObj = new Account($myAccount->getAccNo(), $myAccount->getPassword(), $myAccount->type(), $_GET['fn'], $_GET['ln'], $_GET['ad'], $myAccount->getRating());
		$newProfile = new Profile($_GET['d'], $_GET['e'], $_GET['g'], "");
		$newAccObj->setProfile($newProfile);
		$newAccObj->setBankAccount($_GET['b']);
		
		$newBankCardObj = new BankCard($_GET['c'], $_GET['t'], $myAccount->getBankCard()->getBalance(), $_GET['ex'], $myAccount->getAccNo());
		$newAccObj->setBankCard($newBankCardObj);
		
		$flag = $myAccount->setDetail($dbconnect, $newAccObj); // $flag is either true or false
		
		echo "<script>window.location = 'myAccount.php?state=0';</script>";
	}
	else if($state == 4)
	{
		// Get the file from the $_POST
		$uploadedPictureName = $_FILES['profilePic']['tmp_name'];
		$myAccount->getProfile()->setProfilePicture($dbconnect, $uploadedPictureName, $myAccount->getAccNo());
		
		// Reload the page
		echo "<script>window.location = 'myAccount.php?state=0';</script>";
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
			<div class="circleContainer"> 
				<?php 
					if($state == 0)
					{
						?>
						<div id="ownerImg" onClick = "window.location = 'myAccount.php?state=3'" style = "background-image: url(<?php echo $myAccount->getProfile()->getPictureURL(); ?>)"></div> 
				<?php
					}
					else if($state == 1)
					{
						?>
						<div id="ownerImg" style = "background-image: url(<?php echo $myAccount->getProfile()->getPictureURL(); ?>)"></div> 
				<?php
					}
					else
					{
						?>
						<div id="ownerImg" style = "background-image: url(<?php echo $myAccount->getProfile()->getPictureURL(); ?>)"></div>
						UPLOAD YOUR NEW PROFILE PICTURE: <br/>
						<form action = "myAccount.php?state=4" method = "POST" enctype = "multipart/form-data">
							<input type = "file" name = "profilePic" value = "<?php echo Profile::getImageDir() . "default.jpg";?>" />
							<button type = "submit">Submit</button>
						</form>
				<?php
					}
				?>
			</div>
			<div class="circleContainer"> <div id="weirdCircle"></div> </div>
		</div>

		<div id="userInfo">
			<div id="midInputsTop">
				<div id="midInputsLeft">
					<span><b>PERSONAL INFORMATION</b></span>
					<div>
						<?php 
						
							if($state == 1)
							{
							?>
								FIRST NAME: <input id = "fnameInput" type="text" value = "<?php echo $myAccount->getFirstName(); ?>" /><br/>
								LAST NAME: <input id = "lnameInput" type="text" value = "<?php echo $myAccount->getLastName(); ?>" /><br/>
						<?php
							}
							else
							{
								echo "<label>NAME: </label>";
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
								<input id = "dobInput" type="text" value = "<?php echo $myAccount->getProfile()->getDOB(); ?>" /><br/>
						
						<?php
							}
							else
							{
								echo $myAccount->getProfile()->getDOB();
							}
						?>
					</div>

					<div>
						<label>E-MAIL: </label>
						<?php
							if($state == 1)
							{
							?>
								<input id = "emailInput" type="text" value = "<?php echo $myAccount->getProfile()->getEmail(); ?>" /><br/>
						<?php
							}
							else
							{
								echo $myAccount->getProfile()->getEmail();
							}
						?>
					</div>

					<div>
						<label>GENDER: </label>
						<?php
							if($state == 1)
							{
							?>
								<input id = "genderInput" type="text" value = "<?php echo $myAccount->getProfile()->getGender(); ?>" /><br/>
						<?php
							}
							else
							{
								echo $myAccount->getProfile()->getGender();
							}
						?>
					</div>

					<div>
						<label>ADDRESS: </label>
						<?php
							if($state == 1)
							{
							?>
								<input id = "addInput" type="text" value = "<?php echo $myAccount->getAddress(); ?>" /><br/>
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
					<span><b>CREDIT CARD INFORMATION</b></span>
					<div>
						<?php
							if(!empty($myAccount->getBankAccount()))
							{
							?>
								<label>BANK ACCOUNT: </label>
						<?php
								if($state == 1)
								{
								?>
									<input id = "bankAccInput" type="text" value = "<?php echo $myAccount->getBankAccount(); ?>" /><br/>
							<?php		
								}
								else
								{
									echo $myAccount->getBankAccount();
								}
									
							}
							?>
							
							
					</div>
					<div>
						<label>BANK CARD: </label><br/>
						<label>CARD NO. :</label>
						<?php
							if($state == 1)
							{
							?>
								<input id = "cardNoInput" type="text" value = "<?php echo $myAccount->getBankCard()->getCardNo(); ?>" /><br/>
								(note that once this card is valid and used, it will be binded with the account)
						<?php
							}
							else
							{
								echo $myAccount->getBankCard()->getCardNo();
							}
						?>
					</div>
					<div>
						<label>TYPE :</label>
						<?php
							if($state == 1)
							{
							?>
								<input id = "typeInput" type="text" value = "<?php echo $myAccount->getBankCard()->type(); ?>" /><br/>
						<?php
							}
							else
							{
								echo $myAccount->getBankCard()->type();
							}
						?>
					</div>
					<div>
						<?php
							if($state != 1)
							{
								?>
								<label>BALANCE :</label>
								<?php echo "$" . $myAccount->getBankCard()->getBalance(); ?>
								
						<?php
							}
						?>
					</div>
					<div>
						<label>EXPIRE DATE :</label>
						<?php
							if($state == 1)
							{
							?>
								<input id = "expireInput" type="text" value = "<?php echo $myAccount->getBankCard()->getExpireDate(); ?>" /><br/>
						<?php
							}
							else
							{
								echo $myAccount->getBankCard()->getExpireDate();
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
						<!-- This will change the page to edit mode -->
						<button class="editButton" onClick = "window.location = 'myAccount.php?state=1'"></button>
				<?php
					}
					else
					{
					?>
						<!-- This will change the page to finish mode -->
						<button class="tickButton" onClick = "updateInfo()"></button>
						<!--<button class="tickButton" onClick = "window.location = 'myAccount.php?state=0'"></button>-->
				<?php
					}
				?>
				<!-- <button class="tickButton"></button> -->
			</div>
		</div>
	</div>
</div>


<div id="bot">
	<?php
		if($myAccount->type() == "Car owner")
		{
			?>
			<div id="botBanner"> UPLOAD CARS </div>
	<?php	
		}
		else
		{
			?>
			<div id="botBanner"> BECOME A CAR OWNER </div>
	<?php
		}
	?>

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