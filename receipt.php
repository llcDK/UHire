<html>

	<head>
		<title> Messages </title>
		<link href="css/receipt.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- font -->
		<link href="http://fonts.googleapis.com/css?family=Kaushan+Script&amp;subset=latin-ext" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<!-- //font -->
		
	</head>
	<body>
	<?php
			include 'backend.php';
			session_start();
			$myAccount = unserialize($_SESSION['account']);
			$accNo = $myAccount->getAccNo();
			
			//$accNo = $_GET['accNo'];
			//$plateNum = $_GET['plateNum'];
			//$requestingTime = $_GET['time'];
			
			//$receiptObj = Receipt::queryReceipt($dbconnect, "select * from Receipt where accNo = '$accNo' and plateNum = '$plateNum' and requestingTime = '$requestingTime' ;");
			
			$allReceipt = Receipt::queryReceipts($dbconnect, "select * from Receipt where accNo = '$accNo' order by requestingTime desc;");
			
			
	?>
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
					<a href="receipt.php"class="active">  My Receipt </a>
					<a href="#contact">Contact</a>
				</div>
			</div>
		</div>
		
		<div class="padding-100"></div>
		<div class="tittle"> <h2>.RECEIPT.</h2><div>
		<div class="padding-100"></div>
		
	<div class="container1"><div>
	<h1>This Is Your Receipt </h1>
	
	<?php
	
		if(count($allReceipt) > 0)
		{
			$i = 1;
			foreach($allReceipt as $receiptObj)
			{
				?>
				<div class="container">
					  <div class="table-responsive">
							<table class="table">
							  <thead>
								<tr>
								  <th>#</th>
								  <th>Account Number</th>
								  <th>Plate Number</th>
								  <th>Booking Time</th>
								  <th>Total amount</th>
								  <th>Commision</th>
								  <th>Bond</th>
								 
								</tr>
							  </thead>
							  <tbody>
								<tr>
								  <td><?php echo $i; ?></td>
								  <td><?php echo $receiptObj->getAccNo(); ?></td>
								  <td><?php echo $receiptObj->getPlateNum(); ?></td>
								  <td><?php echo $receiptObj->getTime(); ?></td>
								  <td>$<?php echo $receiptObj->getAmount(); ?></td>
								  <td>$<?php echo $receiptObj->getCommission(); ?></td>
								  <td>$<?php echo Car::$bond; ?></td>
								  
								</tr>
							  </tbody>
							</table>
						  </div>
				</div>
			<?php
			$i++;
			}
		}
	?>
	
	</div>
	<div class="padding-100"><!-- <button onClick = "window.location = 'main.php';">CONTINUE</button></div> -->
	<footer>
		<div class="copyright">
	    <div class="line">
			<div class="margin">
				<!-- left -->
				<div class="s-12 m-12 l-8 footer-links">
					<p>Copyright &copy; 2017.Company name All rights reserved.</p>
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


</body>	
</html>