<html>
<head>
	<title>My Account</title>
  
   
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/MyAccount.css" rel="stylesheet" type="text/css">
		 <!-- font -->
		<link href="http://fonts.googleapis.com/css?family=Kaushan+Script&amp;subset=latin-ext" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
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
	
	function deleteCar(plateNum)
	{
		
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
	<div class="bigtop">
			<!--class="darken"-->
		  <div class="darken">

			 <div id="banner">
				<div id="topText"> UDRIVE </div>
			 </div>
				<div class="topnav">
					<a href="main.php">Home</a>
					<a href="myAccount.php" class="active"> My Account</a>
					<a href="messages.php" >Messages</a>
					<a href="receipt.php"> My Receipt </a>
					<a href="#contact">Contact</a>
				</div>
			</div>
	</div>
		
		<div class="padding-100"></div>
		<div class="tittle"> <h2>.MY ACCOUNT.</h2><div>
		<div class="padding-100"></div>

<div id="container-fluid">
	<div class="container"><h3>"<?php echo strtoupper($userType); ?>"<h3></div>
	
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
			<div class="weirdCircle"></div>
		</div>

		
		<div id="userInfo">
			<div id="midInputsTop">
				<div id="midInputsLeft">
					<p>PERSONAL INFORMATION</p>
					<div>
						<?php 
						
							if($state == 1)
							{
							?>
								<b>First Name:</b> <input id = "fnameInput" type="text" value = "<?php echo $myAccount->getFirstName(); ?>" /><br/>
								<br/>
								<b>Last  Name:</b> <input id = "lnameInput" type="text" value = "<?php echo $myAccount->getLastName(); ?>" /><br/>
						<?php
							}
							else
							{
								echo "<i class='fa fa-user' style='font-size:24px'></i> <label>Full Name: </label>";
								echo $myAccount->getFirstName() . ' ' . $myAccount->getLastName(); 
							}
						?>
					</div>

					<div>
						<i class="fa fa-calendar" style='font-size:24px'></i><label>D.O.B: </label>
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
						<i class="fa fa-envelope" style='font-size:24px'></i> <label>E-Mail: </label>
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
						<i class="fa fa-female" style='font-size:24px'></i>/<i class="fa fa-male" style='font-size:24px'></i><label>Gender: </label>
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
						<i class="fa fa-institution" style='font-size:24px'></i><label>Address: </label>
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
								<i class="fa fa-angellist" style="font-size:24px"></i><button id = "verifyButton" onClick = "window.location = 'myAccount.php?state=5'" >VERIFY</button><br/>	
						<?php
							}
							else
							{
								echo "<label><i class='fa fa-angellist' style='font-size:24px'></i> Verified:</labe>" .'True';
							}
						}
						?>
					</div>
					
				</div>
				<div id="midInputsRight">
					<p>CREDIT CARD INFORMATION<p>
					<div>
						<?php
							if(!empty($myAccount->getBankAccount()))
							{
							?>
								<i class="fa fa-credit-card" style='font-size:24px'></i> <label>BANK ACCOUNT: </label>
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
						 <label>BANK CARD:<i class="fa fa-cc-visa" style="color:navy font-size:24px"></i>
										  <i class="fa fa-cc-amex" style="color:blue;"></i>
										  <i class="fa fa-cc-mastercard" style="color:red;"></i>
										  <i class="fa fa-cc-discover" style="color:orange;"></i> </label><br/>
						<i class="fa fa-sort-numeric-asc" style='font-size:24px'></i> 
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
						<i class="fa fa-cc-mastercard" style='font-size:24px'></i> <label>TYPE :</label>
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
								<i class="fa fa fa-money" style='font-size:24px'></i> <label>BALANCE :</label>
								<?php echo "$" . $myAccount->getBankCard()->getBalance(); ?>
								
						<?php
							}
						?>
					</div>
					<div>
						<i class="fa fa-calendar" style='font-size:24px'></i> <label>EXPIRE DATE :</label>
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
						<div id="midInputsBot">
							<?php
								if($state == 0)
								{
								?>
									<!-- This will change the page to edit mode -->
									<button style="font-size:15px" onClick = "window.location = 'myAccount.php?state=1'">Edit<i class="fa fa-pencil"></i></button>
							<?php
								}
								else if($state == 1)
								{
								?>
									<!-- This will change the page to finish mode -->
									<button style="font-size:15px" onClick = "updateInfo()">Done<i class="fa fa-heart"></i></button>
									<!--<button class="tickButton" onClick = "window.location = 'myAccount.php?state=0'"></button>-->
							<?php
								}
							?>
						<!-- <button class="tickButton"></button> -->
						</div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<div class="padding-100"></div>

<div class="carBox">

<?php
		if($myAccount->type() == "Car owner")
		{
			?>

			<div id="botBanner"><h1> UPLOADED CARS</h1> </div>
			<div class="padding-100"></div>
			<form method = "POST" action = "upload.php?">
				<input type = "hidden" name = "action" value = "insert" />
				<button class="btn btn-success" onClick = "window.location = 'upload.php?state=0&action=insert';"> UPLOAD A NEW CAR </button>
			</form>
			<div class="padding-100"></div>

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
				<div id="left"><a href="myAccount.php?state=6&action=prev" class="previous round leftRight"><i class="fa fa-angle-double-left" style="font-size:36px"></i></a></div>			

		<?php
			}
	
			$cars = $myAccount->getCars($dbconnect);
			
			for($i = $carIndex; $i < min(sizeof($cars), $carIndex+3); $i++)
			{
				?>
				
				<div class="tileContainer">
					<div> <img class="carTile" src="<?php echo $cars[$i]->getImageURL(); ?>" onClick = "window.location='cardetail.php?carPlateNum=<?php echo $cars[$i]->getPlateNum(); ?>';" /> </div>
				
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
						<div id="lb"><button type = "submit" class="editCar"><i class="fa fa-pencil" style='font-size:24px'></i></button></div>
					</form>
						<div id="rb"><button class="deleteCar" onClick = "deleteCar('<?php echo $cars[$i]->getPlateNum(); ?>')" ><i class="fa fa-times" style='font-size:24px'></i></button></div>
					</div>
				</div>
	
		<?php	
			}
			
			if($carIndex + 3 < sizeof($cars))
			{
			?>
			
				<div id="right"><a href="myAccount.php?state=6&action=next" class="next round leftRight"><i class="fa fa-angle-double-right" style="font-size:36px"></i></a></div>
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

</div>
   
   
   
   
   <div id = "reviewBox">
   <div class="cantainer-fluid">
   <h3 class="to">REVIEW</h3>
   </div>	
	<?php
		$reviews = $myAccount->getReviews();
		if(sizeof($reviews) > 0)
		{
			if($myAccount->getRating() == 0)
			{
			?>
				<div><h2 class="to">Total Ratings: Not enough ratings</h2></div>
		<?php
				
			}
			else
			{
		?>	
				<div><h3 class="to">Total Rating: <?php echo $myAccount->getRating(); ?></h3></div>
		<?php
			}
		?>
		
		<div class="container">
		<div class="media-left">
			<img src="images/detailImage/person3.png" class="media-object" style="width:60px">
		</div>
					
		<div class="media-body">
						<div>
						<h4 class="media-heading"><span>ID.User:</h4>
						<h4 class="media-heading">Plate No. 43543</h4>
						</div>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star nochecked"></span>
						<span class="fa fa-star nochecked"></span>
						<p>The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						The car is really nice,Thanks Crusie!!!
						</p>
						<p class="text-right">2018-05-22 08:54:48</p>
					</div>
				 <hr>
	  	 </div>
			<!--	 
			<table style = "border: 3px solid red" >
				<tr>
					<th>renterID</th>
					<th>Time of the review<th>
					<th>Plate Number</th>
					<th>Review</th>
					<th>Rating</th>
				</tr>-->
		<?php	
			foreach($reviews as $rev)
			{
				$plateNum = $rev->getPlateNum();
			?>
				
				<div class="container">
				<div class="media-left">
					<img src="images/detailImage/person3.png" class="media-object" style="width:60px">
				</div>
							
				<div class="media-body">
					<div>
					<h4 class="media-heading">ID: <?php echo $rev->getRenter(); ?> User:</h4>
					<h4 class="media-heading">Plate No. <?php echo (empty($plateNum) && !isset($plateNum)) ? "":$plateNum ; ?></h4>
					</div>
					
					<?php
						$rt = (int) $rev->getRating(); 
						for($i = 0; $i < $rt; $i++)
						{
							?>
							<span class="fa fa-star checked"></span>
					<?php
						}
						
						for($i = 0; $i < 5 - $rt; $i++)
						{
							?>
							<span class="fa fa-star nochecked"></span>
					<?php
						}
					?>
					
					<p><?php echo $rev->getContent(); ?></p>
					<p class="text-right"><?php echo $rev->getTime(); ?></p>
				</div>
				<hr>
				</div>
				
			<?php
			}
			
			?>
			</table>
		<?php
		}
		else
		{
			?>
			<div><h4> Currently no ratings<h4> </div>
			<div><h4>Currently no reviews <h4></div>
			
		<?php
		}
	?>
	
	
	
	
	
	</div>
   </div>



<footer>
		<div class="copyright">
	    <div class="line">
			<div class="margin">
				<!-- left -->
				<div class="s-12 m-12 l-8 footer-links">
					<p>Copyright &copy; 2018.Designed By WENJUANSUN .</p>
				</div>
				<!-- right -->
				<div class="s-12 m-12 l-4 payment-methods">
					<i class="fa fa-cc-visa fa-2x"></i>
					<i class="fa fa-cc-mastercard fa-2x"></i> 
					<i class="fa fa-cc-paypal fa-2x"></i>
					<i class="fa fa-credit-card fa-2x"></i>
				</div>
			</div>
		</div>
	</div>
</footer>



</body>


</html>