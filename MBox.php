<html>

	<head>
		<title> MBox </title>
		<link href="css/MBox.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- font -->
		<link href="http://fonts.googleapis.com/css?family=Kaushan+Script&amp;subset=latin-ext" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<!-- //font -->
	 </head>
	 <body class="bg">
		 <?php
			include 'backend.php';
			session_start();
			
			$myAccount = unserialize($_SESSION['account']);
			$myAccount = Account::queryAccount($dbconnect, $myAccount->getAccNo());
			
			$thisAcc = $myAccount->getAccNo();
			$otherAcc = $_GET['otherAcc'];
			
			$otherAccount = Account::queryAccount($dbconnect, $otherAcc);
			
			// Process any possible added message before querying the entire chat
			/*
				$state records the state of the page
				0: 
				1: Intermediate mode, for sending a message
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
			
			if($state == 1)
			{
				// Sending a message
				$sender = $thisAcc;
				$reciever = $otherAcc;
				$time = date('Y-m-d h:i:s', time());
				$content = $_POST['nMessage'];
				Message::createMessage($dbconnect, $sender, $reciever, $time, $content);
								
				echo "<script>window.location = 'MBox.php?otherAcc=$reciever';</script>";
			}
			
			$chatObj = new Chat($dbconnect, $thisAcc, $otherAcc);
			
		 ?>
		<div class="titM"><h1>Message Box</h1></div>
		<button onClick = "window.location = 'messages.php';">RETURN</button>	
		<div class="container1">
			<div class="upchat">
				<?php
					// Loop the chat to display messages one by one
					foreach($chatObj->getMessages() as $message)
					{
						if($message->getSender() == $thisAcc)
						{
							// Right picture : Me sending it
							?>
							<div class="container2 darker">
								<img src="<?php echo $myAccount->getProfile()->getPictureURL(); ?>" alt="<?php echo Profile::getImageDir() . '/' . Profile::getDefaultPictureName(); ?>" class="right" style="width:100%;">
								<p><?php echo $message->getContent(); ?></p>
								<span class="time-left"><?php echo $message->getTime(); ?></span>
							</div>
						<?php
						}
						else
						{
							// Left picture : Other sending it
							?>
							<div class="container2">
								<img src="<?php echo $otherAccount->getProfile()->getPictureURL(); ?>" alt="<?php echo Profile::getImageDir() . '/' . Profile::getDefaultPictureName(); ?>" style="width:100%;">
								<p><?php echo $message->getContent(); ?></p>
								<span class="time-right"><?php echo $message->getTime(); ?></span>
							</div>						
						<?php	
						}
					}
				
				?>
				
				<!--
				<div class="container2">
				  <img src="images/messages/person2.jpg" alt="Avatar" style="width:100%;">
				  <p>Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?</p>
				  <span class="time-right">11:00</span>
				</div>

				<div class="container2 darker">
				  <img src="images/messages/person3.jpg" alt="Avatar" class="right" style="width:100%;">
				  <p>Hey! I'm fine. Thanks for asking!</p>
				  <span class="time-left">11:01</span>
				</div>

				<div class="container2">
				  <img src="images/messages/person2.jpg" alt="Avatar" style="width:100%;">
				  <p>Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?</p>
				  <span class="time-right">11:00</span>
				</div>

				<div class="container2 darker">
				  <img src="images/messages/person3.jpg" alt="Avatar" class="right" style="width:100%;">
				  <p>Hey! I'm fine. Thanks for asking!</p>
				  <span class="time-left">11:01</span>
				</div>

				<div class="container2">
				  <img src="images/messages/person2.jpg" alt="Avatar" style="width:100%;">
				  <p>Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?Hello. How are you today?</p>
				  <span class="time-right">11:00</span>
				</div>
				
				<div class="container2 darker">
				  <img src="images/messages/person3.jpg" alt="Avatar" class="right" style="width:100%;">
				  <p>Hey! I'm fine. Thanks for asking!</p>
				  <span class="time-left">11:01</span>
				</div>
				-->
				
			</div>			
		
				<div class="inputBox">
					<form method = "POST" action = '<?php echo "MBox.php?state=1&otherAcc=$otherAcc"; ?>'>
						<textarea id="dope" name = "nMessage" style="width: 100%;height: 125px; border: none;outline: none;resize: none;" name="" rows="" cols=""></textarea>
						<button class="sendBtn" type = "submit" >SEND</button>
					</form>
				</div>
				
		</div>
		
		<footer>
		<div class="copyright">
	    <div class="line">
			<div class="margin">
				<!-- left -->
				<div class="s-12 m-12 l-8 footer-links">
					
					<p>Copyright &copy; 2018.Designed by WENJUANSUN.</p>
				</div>
				
			</div>
		</div>
	</div>
</footer>
	
	 </body>

</html>