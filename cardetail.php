<html>
	<head>
		<title>Cartdetailed</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="css/carde.css" rel="stylesheet" type="text/css"/>
		<link href="css/carde-mod.css" rel="stylesheet" type="text/css"/>
		
		<!-- font -->
		<link href="http://fonts.googleapis.com/css?family=Kaushan+Script&amp;subset=latin-ext" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- //font -->
	</head>
	<body>
	<script>
	
		function bookCar()
		{
			// Use javaScript to capture the booking date
			var bookDay = prompt('How long do you want to book? (in days)');
			if(confirm('Confirm your action'))
			{
				// Comfirmed and keep going
				var plateNum = document.getElementById('plateNum').innerHTML;
				
				//alert(plateNum);
				window.location = "cardetail.php?state=1&carPlateNum=" + plateNum + "&days=" + bookDay;
			}
			else
			{
				// Booking cancelled
				alert('Booking process canceled');
			}
		}
		
		function addReview()
		{
			var reviewContent = prompt('Please enter a short review for the car owner');
			var stars = prompt('Please give rating: (0-5)');
			
			// Check if the user inputs are in correct format
			if(reviewContent.trim() != "")
			{
				// Test if the input is a number 
				if(/^-?[\d.]+(?:e-?\d+)?$/.test(stars) && Number(stars) >= 0 && Number(stars) <= 5)
				{
					// Send the content and rating to the cardetail.php file and insert a comment
					//alert('Good');
					var location = 'cardetail.php?rc=' + reviewContent + '&star=' + stars + '&carPlateNum=' + "<?php echo $_GET['carPlateNum'];?>" + '&action=review';
					//alert(location);
					window.location = location;
				}
				else
				{
					alert('Please provide a rating between 0 - 5.');
				}
			}
			else
			{
				alert('Please provide something useful!');
			}
		}


		/*
		(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip(); 
		
			
		});
		*/
	</script>
	
	<?php
		// Helper function to display the content of a car
		function display($content)
		{
			if(empty($content))
			{
				return "None";
			}
			else
			{
				return $content;
			}
		}
	?>
	<?php
		include 'backend.php';
		session_start();
		$myAccount = unserialize($_SESSION['account']);
		
		// Capture the carPlateNum to display from $_GET['carPlateNum']
		if(isset($_GET['carPlateNum']))
		{
			$plateNum = $_GET['carPlateNum'];
			// Query the instance from the database
			//Write the query
			$getSingleCarQuery = "select * from Car where plateNum = '$plateNum';";
			
			$carList = Car::getCars($dbconnect, $getSingleCarQuery);
			$car = $carList[0];
		}
		else
		{
			// Nothing to capture
		}
		
		// Set the state variable
		/*
			$state records the state of the page
			0: Read mode
			1: Intermediate mode: Book a car
			
		*/
		if(empty($_GET['state']) || !isset($_GET['state']))
		{
			// No state, default sate 0
			$state = 0;
		}
		else
		{
			// Intermediate mode
			$state = $_GET['state'];
		}
		
		//If state = 1 Book car
		if($state == 1)
		{
			$bookingDays = empty($_GET['days'])? 0:$_GET['days'] ;
			if($bookingDays <= 0)
			{
				echo "<script>alert('Not a valid booking duration!');</script>";
				// Back to the page
				echo "<script>window.location = 'cardetail.php';</script>";
			}
			else
			{
				$receipt = $car->book($dbconnect, $myAccount, $bookingDays);
				if($receipt != false)
				{
					// Print the receipt for the user
					echo "<script>window.location = 'receipt1.php?accNo=" . $receipt->getAccNo() . "&plateNum=" . $receipt->getPlateNum() . "&time=" . $receipt->getTime() . "'</script>";
					
				}
				else
				{
					echo "<script>alert('Booking failed, check your duration or credit!');</script>";
				}
				
			}
			
		}
		
		// Check if there are any reviews 
		if(!empty($_GET['action']) && isset($_GET['action']) && $_GET['action'] == 'review')
		{
			$from = $myAccount->getAccNo();
			$to = $car->getOwnerAcc();
			$timeGive = date("Y-m-d");
			$plateNum = $car->getPlateNum();
			$content = $_GET['rc'];
			$rating = $_GET['star'];
			
			Review::createReview($dbconnect, $from, $to, $timeGive, $plateNum, $content, $rating);
			
			// The re-direct to normal
			
			echo "<script>window.location = 'cardetail.php?carPlateNum=$plateNum';</script>";
		}
		

	?>
	
	

	<!--banner-->
	<body>
		<div class="bigtop">
			<!--class="darken"-->
		  <div class="darken">

			 <div id="banner">
				<div id="topText"> UDRIVE </div>
			 </div>
				<div class="topnav">
					<a href="main.php">Home</a>
					<a href="myAccount.php"> My Account</a>
					<a href="messages.php" >Messages</a>
					<a href="receipt.php"> My Receipt </a>
					<a href="main.php">Contact</a>
				</div>
			</div>
		</div>
	
	<!--car infomation-->
	<div class="cif" id="cif">
		<div class="cif-top">
			<h3>D</h3>
		</div>
		<div class="w3l-cif">
			<div class="container">
				<div class="w3ls-heading">
					<h2>Detail</h2>
				</div>
				<div class="cif-info">
					<p>You can see the car 's detailed information. You can also message owner and check owner's information. Cras tincidunt rhoncus turpis. Nulla elit nibh, vehicula vitae tortor a, fermentum euismod erat. Phasellus vel eros sed sem luctus fringilla sed eleifend eros. Sed et elementum lectus. Aenean ultrices pharetra vestibulum. Praesent a turpis sed nunc auctor vehicula id a sapien. Proin at nulla commodo, pretium enim et, fringilla elit.</p>
					
					</div>
				</div>
			</div>
		</div>
	<!-- Second section -->
	     	<div class="padding-100"></div>
		<div class="picture-section container-fluid no-padding">
		<div class="container">
			
		</div>
		<div class="col-md-6 img-block">
			<img src=<?php echo $car->getImageURL(); ?> class="img-thumbnail" alt="car_pi">
		</div>
		
		<div class="col-md-6">
	
			<div class="section-header">
				<h3>Booking Information</h3>
				
					<table class="table table-striped">
						<thead>
						  <tr>
							<th>PLATE NUMBER</th>
							<th>PRICE</th>
							<th>LOCATION</th>
							<th>AVAIABLE TO DATE</th>
						  </tr>
						</thead>
						<tbody>
						  <tr>
							<td id = "plateNum"><?php echo $car->getPlateNum(); ?></td>
							<td>$<?php echo $car->getPrice(); ?>/Per Day</td>
							<td><?php echo $car->getLocation(); ?></td>
							<td><?php echo $car->getAvaiableTo(); ?></td>
						  </tr>
						</table>  
					</div>
				<?php 
					$ownerAcc = $car->getOwnerAcc();
					$messageChannel = "MBox.php?otherAcc=$ownerAcc";
				?>
			<?php
				if($myAccount->getAccNo() != $ownerAcc)
				{
					?>
					<button class="bu1" onClick="window.location = '<?php echo $messageChannel; ?>'" title="Read More">Message</button>
					<a class="bu2" onClick = "bookCar()" title="Read More">Book</a>
				<?php
				}
			?>
			
			<!--picture open the Modal-->
			
			<div class="profile_container" >
				<?php 
					$carOwner = Account::queryAccount($dbconnect, $ownerAcc);
				?>
				<a href="#">
				<image class="profile"  data-toggle="modal" data-placement="left" title="Press me please!"data-target="#myModal" src="<?php echo $carOwner->getProfile()->getPictureURL(); ?>"/>
				</a>
			</div>

			<!--The Modal -->
			<div class="modal fade" id="myModal">
				<div class="modal-dialog modal-lg ">
					<div class="modal-content">
			  
			<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Modal Heading</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						 <!-- Modal body -->
						<div class="modal-body">
						  Modal body..
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						</div>
						
						<!-- Modal footer -->
						<div class="modal-footer">
						  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
						
					  </div>
					</div>
				  </div>
        

			<!-- End of Modal -->
			
		</div><!--section 2 right side-->
			<div class="padding-100"></div>
		
		</div><!--section 2 all container-->
		
		
	<!-- //second section-->
	
	<!-- //third section-->
		<div class="padding-100"></div>
		<div class="about w3layouts agileits" id="about">
		<div class="container">

			<h3>Car information</h3>
			<p class="p1 w3layouts agileits">You can see the following information about the car you like.</p>

			<div class="about-grids w3layouts agileits">
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-1">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon1.jpg" alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Number Of Seats</h4>
						<p><?php echo display($car->getNumberSeats()); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-2">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon2.jpg" alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Car Type</h4>
						<p><?php echo display($car->getBobyType()); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-3">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon3.jpg" alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Fuel Type</h4>
						<p><?php echo display($car->getFuelType()); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-4">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon4.jpg"  alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Odometer</h4>
						<p><?php echo display($car->getOdometer()); ?>KM</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-5">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon5.jpg" alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Purchase Date</h4>
						<p><?php echo display($car->getYearBought()); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-6">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon6.jpg"  alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Brand</h4>
						<p><?php echo display($car->getBrand()); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-7">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon7.jpg"  alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Model</h4>
						<p><?php echo display($car->getModel()); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-8">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon8.jpg" alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Transmission</h4>
						<p><?php echo display($car->getTransmission()); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 w3layouts agileits about-grid about-grid-9">
					<div class="about-image w3layouts agileits">
						<img src="images/detailImage/icon9.jpg" alt="W3layouts Agileits">
					</div>
					<div class="about-info w3layouts agileits">
						<h4>Description</h4>
						<p><?php echo display($car->getFullDescription()); ?></p>
					</div>
				</div>
				
				</div>
				<div class="clearfix"></div>
			</div>
	<!-- //third section-->
	<!-- fourth section-->
	<div class="padding-100"></div>
	
	<div class="beijing">
			<div class="container" >
			  <h3>REVIEW</h3>
			  <?php
				if($myAccount->getAccNo() != $ownerAcc)
				{
					?>
					<button onClick = "addReview()" class="btn success">ADD A REVIEW </button>
				<?php
				}
			  ?>
			  <div class="padding-50"></div>
			  <!-- Left-aligned -->
				<!--<div class="media"> -->
				<?php
					// Get all reviews for this car
					// Frist write the query
					$plateNum = $car->getPlateNum();
					$getReviewQuery = "select * from Review where plateNum = '$plateNum';";
					$reviewsToDisplay = Review::queryReviews($dbconnect, $getReviewQuery);
					
					// Loop through and display the results
					if(sizeof($reviewsToDisplay) > 0)
					{
						foreach($reviewsToDisplay as $rev)
						{
							$accObj = Account::queryAccount($dbconnect, $rev->getRenter());
							//print_r($accObj);
							
							$profileImageURL = $accObj->getProfile()->getPictureURL();
							?>
							<div class="media-left">
								<img src="<?php echo $profileImageURL; ?>" class="media-object" style="width:60px">
							</div>
							<div class="media-body">
								<h4 class="media-heading"><?php echo $accObj->getFirstName() . " " . $accObj->getLastName(); ?></h4>
								<?php
									// Loop through to display rating
									$rating = $rev->getRating();
									$checkedStars = $rating;
									$unCheckedStars = 5 - $rating;
									// Print checked stars
									for($i = 0; $i < $checkedStars; $i++)
									{
										?>
										<span class="fa fa-star checked"></span>
								<?php
									}
									// Print unchecked stars
									for($i = 0; $i < $unCheckedStars; $i++)
									{
										?>
										<span class="fa fa-star nochecked"></span>
								<?php
									}
									
								?>
								<p><?php echo $rev->getContent(); ?></p>
							</div>
							 <hr>
				<?php			
						}
					}
					else
					{
						echo "Currently no reviews for this car";
					}
				?>
				
				  <!--
					<div class="media-left">
					  <img src="images/detailImage/person3.png" class="media-object" style="width:60px">
					</div>
					<div class="media-body">
						<h4 class="media-heading">William</h4>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star nochecked"></span>
						<span class="fa fa-star nochecked"></span>
					  <p>The car is really nice,Thanks Crusie!!!</p>
					</div>
				 <hr>
				
				  <div class="media-left">
					 <img src="images/detailImage/person2.jpg" class="media-object" style="width:60px">
					</div>
					<div class="media-body">
					  <h4 class="media-heading">James</h4>
					  <span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star nochecked"></span>
					  <p>Crusie is really nice man.Tell us a lot of travelling information and shared a useful experience.The car is also very nice.Overally,Thanks!!</p>
					</div>
					<hr>
				 
				 
				  <div class="media-left">
					  <img src="images/detailImage/person1.jpg" class="media-object" style="width:60px">
					</div>
					<div class="media-body">
					  <h4 class="media-heading">Nichkun</h4>
					  <span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
					  <p>perfect!!!</p>
					</div>
					<hr>
					
					
					<div class="media-left">
					  <img src="images/detailImage/person4.jpg" class="media-object" style="width:60px">
					</div>
					<div class="media-body">
					  <h4 class="media-heading">Chloe</h4>
					  <span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
					  <p>This car is very suit for my familly and had a very good trip!</p>
					</div>
					<hr>
				-->
	
			</div>
	</div>
	<!--// fourth section-->
	
	</body>
</html>
