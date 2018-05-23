<html>

	<head>
		<title> Messages </title>
		<link href="css/messages.css" rel="stylesheet" type="text/css">
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
			$myAccount = Account::queryAccount($dbconnect, $myAccount->getAccNo());
			
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
					<a href="messages.php" class="active">Messages</a>
					<a href="receipt.php">  My Receipt </a>
					
				</div>
			</div>
		</div>
		
		<div class="padding-100"></div>
		<div class="tittle"> <h2>.MESSAGES.</h2><div>
		<div class="padding-100"></div>
		
	<div class="container1">
		<?php
			// Get all current Chat
			$allChats = Chat::getRelatedChats($dbconnect, $myAccount->getAccNo());
			// Loop for all chat bot
			if(!empty($allChats) && isset($allChats) && count($allChats))
			{
				foreach($allChats as $chatObj)
				{
					// Get another accounts detail
					$otherAccount = Account::queryAccount($dbconnect, $chatObj->getLastMessage()->getOppsoiteAcc($myAccount->getAccNo()));
					$otherAcc = $otherAccount->getAccNo();
					$chatBotLocation = "window.location = 'MBox.php?otherAcc=$otherAcc';" ;
					?>
					<div class="container" onclick="<?php echo $chatBotLocation; ?>">
					  <img src="images/messages/person2.jpg" alt="Avatar" style="width:90px">
					  <p class="text-left"><span><?php echo $otherAccount->getFirstName() . " " . $otherAccount->getLastName(); ?></span></p>
					  <p><?php echo $chatObj->getLastMessage()->getContent(); ?></p>
					  
					  <a><i class="material-icons" style="color:#da4d83">chat</i></a><p class="text-right"><?php echo $chatObj->getLastMessage()->getTime(); ?></p>
					</div>
				<?php
				}
			}
			else
			{
				?>
				<h2>Currently No Chats</h2>
			<?php
			}
		?>
	
		<!--
		<div class="container" onclick="window.open(*http://www.baidu.com*)">
		  <img src="images/messages/person2.jpg" alt="Avatar" style="width:90px">
		  <p class="text-left"><span>Chris Robet.</span></p>
		  <p>Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? </p>
		  
		  <a><i class="material-icons">chat</i></a><p class="text-right">30/03/18 04:00pm</p>
		</div>
		<div class="container">
		  <img src="images/messages/person3.jpg" alt="Avatar" style="width:90px">
		  <p class="text-left"><span>Jeremy Clarkson.</span></p>
		  <p>Hi, just wondering if it's okay if I return the car around 3pm today? </p>
		  <p class="text-right">30/03/18 12:00am </p>
		</div>
		<div class="container">
		  <img src="images/messages/person2.jpg" alt="Avatar" style="width:90px">
		  <p class="text-left"><span>Chris Robet.</span></p>
		  <p>Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? </p>
		  <p class="text-right">30/03/18 11:30am</p>
		</div>
		<div class="container">
		  <img src="images/messages/person3.jpg" alt="Avatar" style="width:90px">
		  <p class="text-left"><span>Jeremy Clarkson.</span></p>
		  <p>Hi, just wondering if it's okay if I return the car around 3pm today? </p>
		  <p class="text-right">30/03/18 10:32am </p>
		</div>
		<div class="container">
		  <img src="images/messages/person2.jpg" alt="Avatar" style="width:90px">
		  <p class="text-left"><span>Chris Robet.</span></p>
		  <p>Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? Hey there, just wondering if your car would be able to fit 2 large suitcases in the boot? </p>
		  <p class="text-right">30/03/18 9:30am</p>
		</div>
		-->
	</div>
	<div class="padding-100"></div>
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
</html>