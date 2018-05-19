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
	$myAccount = Account::queryAccount($dbconnect, $myAccount->getAccNo());
	$_SESSION['account'] = serialize($myAccount);
	$userType = $myAccount->type();
	// If the userType is admin, redirect to admin page
	if($userType == "Admin")
	{
		// Re-direct to admin mode
	}
	else if($userType == "Car owner")
	{
		// Set global variable for the page of displaying car list
		if(!isset($_SESSION['carIndex']))
		{
			$_SESSION['carIndex'] = 0;
		}
		$carIndex = $_SESSION['carIndex'];
	}
	
	
	// Set the state variable
	/*
		$state records the state of the page
		0: Read-only mode
		1: Edit mode
		2: Intermediate mode, for editing and updating database
		3: Upload profile picture mode
		4: Intermediate mode, for storing profile picture and updating database for profile picture
		5: Verify account mode
		6: Intermediate mode, Previous/next page for car listing
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
		$newProfile = new Profile($_GET['d'], $_GET['e'], $_GET['g'], "", "NO");
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
	else if($state == 5)
	{
		// Verify the account
		$verifyResult = $myAccount->verify($dbconnect);
		if($verifyResult)
		{
			echo "<script>alert('Verify the account successfully');</script>";
		}
		else
		{
			echo "<script>alert('Fail to verify the account');</script>";
		}
		echo "<script>window.location = 'myAccount.php?state=0';</script>";
	}
	else if($state == 6)
	{
		if($_GET['action'] == 'prev')
		{
			$_SESSION['carIndex'] -= 3;
		}
		else if($_GET['action'] == 'next')
		{
			$_SESSION['carIndex'] += 3;
		}
		echo "<script>window.location = 'myAccount.php?state=0'; </script>";
	}

	
?>

<?php
	// All PHP functions
	function verifyAccount()
	{
		return "To verifiy";
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
            <a href="myReceipt.php"> Receipt </a>
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
					else if($state == 3)
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
					else
					{
						?>
						<div id="ownerImg" style = "background-image: url(<?php echo $myAccount->getProfile()->getPictureURL(); ?>)"></div>
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
								(HAS TO BE IN FORM YYYY-MM-DD) <br/>
						
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
					
					<div>
						<?php 
						if($state == 0)
						{
							if(!$myAccount->getProfile()->verified())
							{
								// NOT VERIFIED 
							?>
								You haven't verified your account. To verifiy: <br />
								<button id = "verifyButton" onClick = "window.location = 'myAccount.php?state=5'" >VERIFY</button><br/>	
						<?php
							}
							else
							{
								echo " VERIFIED: TRUE";
							}
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
					else if($state == 1)
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
			
			if($carIndex > 0)
			{
			?>
				<div id="left"><a href="myAccount.php?state=6&action=prev" class="previous round leftRight">&#8249;</a></div>			
		<?php
			}
	
			$cars = $myAccount->getCars($dbconnect);
			
			for($i = $carIndex; $i < min(sizeof($cars), $carIndex+3); $i++)
			{
				?>
				
				<div class="tileContainer">
					<div> <img class="carTile" src="<?php echo $cars[$i]->getImageURL(); ?>" /> </div>
					<div class="buttonGroup">
					<form action = "upload.php?state=0" method = "POST">
						<input type = "hidden" name = "action" value = "update" />
						
						<input type = "hidden" name = "pn" value = "<?php echo empty($cars[$i]->getPlateNum())? "" : $cars[$i]->getPlateNum() ; ?>" />
						<input type = "hidden" name = "pd" value = "<?php echo empty($cars[$i]->getPrice())? "" : $cars[$i]->getPrice() ; ?>" />
						<input type = "hidden" name = "loc" value = "<?php echo empty($cars[$i]->getLocation())? "" : $cars[$i]->getLocation() ; ?>" />
						<input type = "hidden" name = "at" value = "<?php echo empty($cars[$i]->getAvaiableTo())? "" : $cars[$i]->getAvaiableTo() ; ?>" />
						<input type = "hidden" name = "yb" value = "<?php echo empty($cars[$i]->getYearBought())? "" : $cars[$i]->getYearBought(); ?>" />
						<input type = "hidden" name = "m" value = "<?php echo empty($cars[$i]->getModel())? "" : $cars[$i]->getModel(); ?>" />
						<input type = "hidden" name = "desc" value = "<?php echo empty($cars[$i]->getFullDescription())? "" : $cars[$i]->getFullDescription(); ?>" />
						<input type = "hidden" name = "b" value = "<?php echo empty($cars[$i]->getBrand())? "" : $cars[$i]->getBrand() ; ?>" />
						<input type = "hidden" name = "t" value = "<?php echo empty($cars[$i]->getTransmission())? "" : $cars[$i]->getTransmission(); ?>" />
						<input type = "hidden" name = "ns" value = "<?php echo empty($cars[$i]->getNumberSeats())? "" : $cars[$i]->getNumberSeats() ; ?>" />
						<input type = "hidden" name = "odo" value = "<?php echo empty($cars[$i]->getOdometer())? "" : $cars[$i]->getOdometer() ; ?>" />
						<input type = "hidden" name = "ft" value = "<?php echo empty($cars[$i]->getFuelType())? "" : $cars[$i]->getFuelType(); ?>" />
						<input type = "hidden" name = "bt" value = "<?php echo empty($cars[$i]->getBobyType())? "" : $cars[$i]->getBobyType(); ?>" />
						<button type = "submit" class="editCar"></button>
					</form>
						<button class="deleteCar"></button>
					</div>
				</div>
	
		<?php	
			}
			
			if($carIndex + 3 < sizeof($cars))
			{
			?>
			
				<div id="right"><a href="myAccount.php?state=6&action=next" class="next round leftRight">&#8250;</a></div>
		<?php
			}
			?>
			
		<?php	
			
		}
		else if($myAccount->type() == "Car renter")
		{
			// Display a button that can let the renter upload a car and becomes a car owner
			?>
				<button type = "submit" onClick = "window.location = 'upload.php?state=0&action=insert';">Become a car owner</button>
	<?php
		}
		
	?>
	
   </div>
   <div id = "reviewBox">
	<?php
		$reviews = $myAccount->getReviews();
		if(sizeof($reviews) > 0)
		{
			if($myAccount->getRating() == 0)
			{
			?>
				<div>Total Ratings: Not enough ratings</div>
		<?php
				
			}
			else
			{
		?>	
				<div>Total Rating: <?php echo $myAccount->getRating(); ?></div>
		<?php
			}
		?>
			
			<table style = "border: 3px solid red" >
				<tr>
					<th>renterID</th>
					<th>Time of the review<th>
					<th>Plate Number</th>
					<th>Review</th>
					<th>Rating</th>
				</tr>
		<?php	
			foreach($reviews as $rev)
			{
			?>
				<tr>
				<?php
				if($rev->anon())
				{
					?>
					<td>Anonymous</td>
				<?php	
				}
				else
				{
					?>
					<td><?php echo $rev->getRenter(); ?></td>
				<?php
				}
				?>
					<td><?php echo $rev->getTime(); ?></td>
					<td><?php echo $rev->getPlateNum(); ?></td>
					<td><?php echo $rev->getContent(); ?></td>
					<td><?php echo $rev->getRating(); ?></td>
				</tr>
			<?php
			}
			
			?>
			</table>
		<?php
		}
		else
		{
			?>
			<div> Currently no ratings </div>
			<div> Currently no reviews </div>
		<?php
		}
	?>
   </div>

</div>

<!--
<div id="footer">

   <div id="footerData"> <span id="footerText">COPYRIGHT © 2018 Design By Wenjuan Sun </span></div>
   <div id="footerImage"> <img src="images/myAccount/socialIcons.png" id="socialMedia"/> </div>
</div>
-->

</body>


</html>