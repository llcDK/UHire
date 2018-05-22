<html>
	<head>
		<title>Receipt</title>
	</head>
	<body>
		<?php
			include 'backend.php';
			session_start();
			
			$accNo = $_GET['accNo'];
			$plateNum = $_GET['plateNum'];
			$requestingTime = $_GET['time'];
			
			$receiptObj = Receipt::queryReceipt($dbconnect, "select * from Receipt where accNo = '$accNo' and plateNum = '$plateNum' and requestingTime = '$requestingTime' ;");
			
		?>
		<h1>This is your Receipt: </h1>
		<br/>
		<p>Account Number: <?php echo $receiptObj->getAccNo(); ?></p>
		<br/>
		<p>Plate Number: <?php echo $receiptObj->getPlateNum(); ?></p>
		<br/>
		<p>Booking Time: <?php echo $receiptObj->getTime(); ?></p>
		<br/>
		<p>Total amount: $<?php echo $receiptObj->getAmount(); ?></p>
		<br/>
		<p>Commision: $<?php echo $receiptObj->getAmount(); ?></p>
		<br/>
		<p>Bond: $<?php echo Car::$bond; ?></p>
		<br/>
		<button onClick = "window.location = 'main.php';">CONTINUE</button>
	</body>
</html>