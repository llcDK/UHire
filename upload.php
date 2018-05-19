<html>

<head>
	<title>Upload Vehicle</title>
	<link href="css/upload.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	/*
		$state records the state of the page
		0: Normal edit mode, not allowing upload image
		1: Intermediate mode, updating database
		2: Edit profile picture mode
		default: 0
	*/
	include 'backend.php';
	session_start();
	$myAccount = unserialize($_SESSION['account']);
	
	if(isset($_GET['state']) && !empty($_GET['state']))
	{
		$state = $_GET['state'];
	}
	else
	{
		$state = 0;
	}
	
	if($state == 1)
	{
		// Depend on the operations: Insert a new car or edit an existing car
		if($_POST['action'] == "insert")
		{
			// Get all variables from $_POST
			$plateNum = $_POST['pn'];
			$price = $_POST['pd'];
			$location = $_POST['loc'];
			$avaiableTo = $_POST['at'];
			$year = $_POST['yb'];
			$model = $_POST['m'];
			$description = $_POST['desc'];
			$brand = $_POST['b'];
			$transmission = $_POST['t'];
			$numberOfSeats = $_POST['ns'];
			$odometer = $_POST['odo'];
			$fuelType = $_POST['ft'];
			$bodyType = $_POST['bt'];
			
			// Create a new car and return true / false: depending on if it is valid
			$newCar = Car::createCar($dbconnect, $plateNum, $price, $location, $myAccount->getAccNo(), $avaiableTo, $year, $model, $description, $brand, $transmission, $numberOfSeats, $odometer, $fuelType, $bodyType);
			
			if($newCar == false)
			{
				echo "<script>alert('Failed to upload a new car, something is wrong!');</script>";
				// Return to the same page
				echo "<script>window.location = 'upload.php?state=0';</script>";
			}
			else
			{
				echo "<script>alert('Upload a car successfully!');</script>";
				echo "<script>alert('Congratulations! You are a car owner now!');</script>";
				// Account type became 'car owner' and return to the previous page.
				$myAccount->setUserType($dbconnect, 'Car owner');
				// Change the account session variable
				$_SESSION['account'] = serialize($myAccount);
				echo "<script>window.location = 'myAccount.php?state=0';</script>";
			}
			
		}
		else if($_POST['action'] == "update")
		{
			
			// Get the existing car
			// Get all variables from $_POST
			$plateNum = $_POST['pn'];
			$price = $_POST['pd'];
			$location = $_POST['loc'];
			$avaiableTo = $_POST['at'];
			$year = $_POST['yb'];
			$model = $_POST['m'];
			$description = $_POST['desc'];
			$brand = $_POST['b'];
			$transmission = $_POST['t'];
			$numberOfSeats = $_POST['ns'];
			$odometer = $_POST['odo'];
			$fuelType = $_POST['ft'];
			$bodyType = $_POST['bt'];
			
			
			// Update a existing car
			$flag = Car::modifyCar($dbconnect, $plateNum, $price, $location, $myAccount->getAccNo(), $avaiableTo, $year, $model, $description, $brand, $transmission, $numberOfSeats, $odometer, $fuelType, $bodyType, "");
			
			if($flag)
			{
				echo "<script>alert('Update Car successfully!');</script>";
				echo "<script>window.location = 'myAccount.php?state=0';</script>";
			}
		}
	}
?>

<div id="top">
	<div class="darken">

		<div id="Banner">
			<div id="topText"> UDRIVE </div>
		</div>

		<div class="topnav">
			<a href="main.php">Home</a>
			<a href="myAccount.php"> My Account</a>
			<a href="messages.html">Messages</a>
			<a href="myReceipt.php"> Receipt </a>
			<a href="#contact">Contact</a>
		</div>
	</div>
</div>


<div id="pageHeading">
	<h2>UPLOAD</h2>
</div>
<div id="yellowLine">
	<hr>
</div>


<div id="image">
	<div id="imgFrame">
		<img src="images/upload/vehiclePlaceholder.jpg" alt="Upload Image">
	</div>
	
	<div id="uploadDiv">
		<button id="imgSelect"> Upload Image </button>
	</div>
</div>

<form action = "upload.php?state=1" method = "POST">

	<div id="infoHeadings">

		<h2>

			<div>
				<div class="infoHeading">
					<span> Plate number </span>
				</div>
				<div class="infoInput">
					<input type="text" id="plateNum" name = "pn" value = "<?php echo $_POST['pn']; ?>" />
				</div>
			</div>
			
			<div>
				<div class="infoHeading">
					<span> Price / Day  </span>
				</div>
				<div class="infoInput">
					<input type="text" id="price" name = "pd" value = "<?php echo $_POST['pd']; ?>" />
				</div>
			</div>
			
			<!-- Below is a read-only filed -->
			<div>
				<div class="infoHeading">
					<span> Status : Avaiable </span>
				</div>
			</div>
			
			<div>
				<div class="infoHeading">
					<span> Location  </span>
				</div>
				<div class="infoInput">
					<input type="text" id="location" name = "loc" value = "<?php echo $_POST['loc']; ?>" />
				</div>

			</div>
			
			<div>
				<div class="infoHeading">
					<span> Avaiable To  </span>
				</div>
				<div class="infoInput">
					<input type="date" id="avaiableTo" name = "at" value = "<?php echo $_POST['at']; ?>" />
				</div>

			</div>
			
			<div>
				<div class="infoHeading">
					<span> Year bought  </span>
				</div>
				<div class="infoInput">
					<input type="date" id="year" name = "yb" value = "<?php echo $_POST['yb']; ?>" />
				</div>

			</div>
			
			<div>
				<div class="infoHeading">
					<span> Model  </span>
				</div>
				<div class="infoInput">
					<input type="text" id="model" name = "m" value = "<?php echo $_POST['m']; ?>" />
				</div>

			</div>
			
			<div>
				<div class="infoHeading">
					<span> Description  </span>
				</div>
				<div class="infoInput">
					<textarea type="text" id="desc" rows="10" cols="30" name = "desc" value = "<?php echo $_POST['desc']; ?>" > <?php echo $_POST['desc']; ?> </textarea>
				</div>
			</div>

			<div>
				<div class="infoHeading">
					<span> Brand </span>
				</div>
				<div class="infoInput">
					<input type="text" id="brand" name = "b" value = "<?php echo $_POST['b']; ?>" />
				</div>
			</div>

			<div>
				<div class="infoHeading">
					<span> Transmission  </span>
				</div>
				<div class="infoInput">
					<input type="text" id="trans" name = "t" value = "<?php echo $_POST['t']; ?>" />
				</div>
			</div>			
			
			<div>
				<div class="infoHeading">
					<span> Number of Seats  </span>
				</div>
				<div class="infoInput">
					<input type="text" id="numSeat" name = "ns" value = "<?php echo $_POST['ns']; ?>" />
				</div>
			</div>			

			<div>
				<div class="infoHeading">
					<span> Odometer  </span>
				</div>
				<div class="infoInput">
					<input type="text" id="odo" name = "odo" value = "<?php echo $_POST['odo']; ?>" />
				</div>
			</div>		
			
			<div>
				<div class="infoHeading">
					<span> Fuel Type </span>
				</div>
				<div class="infoInput">
					<input type="text" id="fuel" name = "ft" value = "<?php echo $_POST['ft']; ?>" />
				</div>
			</div>		

			<div>
				<div class="infoHeading">
					<span> Body Type  </span>
				</div>
				<div class="infoInput">
					<input type="text" id="body" name = "bt" value = "<?php echo $_POST['bt']; ?>" />
				</div>
			</div>
			
			<input type = "hidden" name = "action" value = "<?php echo empty($_GET['action'])? $_POST['action'] : $_GET['action'] ; ?>" />
			
			<div id="submitDiv">
				<button id="submit" type="submit" value="COMPLETE" >Submit</button>
			</div>
		</div>

	</h2>
	</div>
</form>

</body>

</html>