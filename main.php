<html>
<head>
   <link href="css/main/topStyle.css" rel="stylesheet" type="text/css"/ >
   <link href="css/main/midStyle.css" rel="stylesheet" type="text/css"/ >
   <link href="css/main/botStyle.css" rel="stylesheet" type="text/css"/ >
   <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Sunflower:300" rel="stylesheet">
   <!-- <link href="css/global.css" rel="stylesheet" type="text/css"/ > -->
   <script type="text/javascript" src="css/main/products.js"></script>
   <title>Main</title>
</head>


<!-- <body style="margin:0% 5% 0% 5%;"> -->
<body onload="loadRecent()">
	<script>
		function noMatchRecord()
		{
			alert("No matched record!");
		}
		
		function goHome()
		{
			window.location = "main.php";
		}
		
		function goAccount()
		{
			window.location = "myAccount.php";
		}

      function goMessage() 
	  {
         window.location = "messages.php";
      }
	</script>
	
	
	<?php
		include 'backend.php';
		// Connect to the DB
		
		
		if(!empty($_GET['action']) && $_GET['action'] == "search")
		{
			$carsToDisplay = Car::searchCars($dbconnect, $_GET['loc'], $_GET['price'], $_GET['ava'], $_GET['brd']);
			
		}
		else
		{
			// Process 6 cars as default
			$carQuery = "select * from Car where available = 1 limit 6;";		
			$carsToDisplay = Car::getCars($dbconnect, $carQuery);
		}	
		
		
	?>



   <div id="top"> 
   
      <div id="topBanner">
         <div id="logo">            
         </div>

         <div id="altLinks">
            <button class="topButton" onclick = "goHome()" >HOME</button>
            <button class="topButton" onclick = "goAccount()" >MY ACCOUNT</button>
            <button class="topButton" onclick = "goMessage()" >MESSAGE</button>
            <button class="topButton" onclick = "goHelp()" > MY RECEIPT</button>
            <button class="topButton" onclick = "goContact()" >CONTACT</button>
            <button class="topButton" id="topSearch"></button>
         </div>
      </div>



      <div id="topMain">

         <div id="title">
            <h1> <span id="txtUDRIVE"> UDRIVE </span> </h1>
            <h1> <span style="color:#6ec34a;">ONLINE</span>
                 <span style="color:white;"> RENT </span>
                 <span style="color:#6ec34a;"> YOUR </span>
                 <span style="color:white;"> CAR </span>
            </h1>
            <h5 style="color:white;"> IN YOUR OWN WAY </h4>
         </div>

         <div id="mainSearch">
            <form action = "main.php?" method = "get">
               <div id="topInputs">
				  <input type = "hidden" name = "action" value = "search" />
                  <input type="text" id="txtAddress" name = "loc" value = "<?php echo empty($_GET['loc'])? "" : $_GET['loc']; ?>" placeholder = "Location" />
                  <input type="text" id="txtPrice" name = "price" value = "<?php echo empty($_GET['price'])? "" : $_GET['price']; ?>" placeholder = "Price" />
                  <input type="date" id="txtAvaliable" name = "ava" value = "<?php echo empty($_GET['ava'])? "" : $_GET['ava']; ?>" placeholder = "availableDate" />
                  <select id="txtBrand" name = "brd">
					 <option value = "" selected = "selected">All</option>
					 <?php
						$allBrand = Car::getBrands($dbconnect);
						foreach($allBrand as $bd)
						{
							?>
							<option value = "<?php echo $bd; ?>" ><?php echo $bd; ?></option>
					<?php
						}
					 ?>
					 
					 <!--
                     <option value="value1">Value1</option>
                     <option value="value2">Value1</option>
                     <option value="value3">Value1</option>
                     <option value="value4">Value1</option>
					 -->
                  </select>
               </div>

               <div id="mainSubmit">
                 <button id="SearchNow">Submit</button>
               </div>
            </form>
         </div>




      </div>
   </div>

	<div class="padding-100"></div>
	<div id="mid">
		<div id="midBanner">
			<div id="midBannerHeader">
				<h3 class="headerPipe">|</h3>
				<h4 id="midBannerText">UPLOAD</h4>
				<h3 class="headerPipe">|</h3>
			</div>
			
			<div class="padding-50"></div>
		<p class="midBannerSub"> Here is the latest information on cars</p> <p class="midBannerSub"> You can pick what interests you</p>
		</div>
		
		<div id="productDisplay">
		
			<?php
				$rowCount = count($carsToDisplay);
				if($rowCount == 0)
				{
					echo "<script> noMatchRecord(); </script>";
				}
				for($i = 0; $i < $rowCount/3; $i++)
				{
					?>
					<div class="midRow">
					
					<?php
						for($j = 0; $j < 3; $j++)
						{
							if(3*$i + $j < $rowCount)
							{
								$carString = serialize($carsToDisplay[3*$i + $j]);
								?>
								<div class="cell">
									<div class="carImage tdImg">
										<img src = <?php echo $carsToDisplay[3*$i + $j]->getImageURL(); ?> width="100%" />
									</div>
									<span class="ownerText"> LOCATION:<?php echo $carsToDisplay[3*$i + $j]->getLocation(); ?></span>
									<br/>
									<span class="ownerText"> PRICE: <?php echo $carsToDisplay[3*$i + $j]->getPrice(); ?></span>
									<br/>
									<span class="modelText"> BRAND: <?php echo $carsToDisplay[3*$i + $j]->getBrand(); ?></span>
									<br/>
									<p class="descText">DESCRIPTION: <?php echo $carsToDisplay[3*$i + $j]->getFullDescription(); ?></p>
									<br/>
									<form action = "cardetail.php">
										<input type = "hidden" name = "carPlateNum" value = "<?php echo $carsToDisplay[3*$i + $j]->getPlateNum(); ?>" />
										<button type = "submit"> Read More </button>
									</form>
								</div>
					<?php
							}
						}
					?>
					</div>	
			<?php		
				}
				
			?>
			
		
			<!--
		
            <div class="midRow">
               <div class="cell">
                     <div class="carImage tdImg">
                         <img src="images/main/car1.jpg" width="100%" />
                     </div>
                     <span class="ownerText"> OWNER: SMITE JAMES SOME IMAG</span>
                     <p class="modelText">2017 VolksWagon Golf R SportWagen</p>
                     <hr/>
                     <p class="descText">Awesome Grande Toure 2.2L Turbo Diesel 4WD Auto with log books, it is very new. Just 36000KM. The space is very big enough for whole family</p>
                     <button> Read More </button>
				</div> 

               <div class="cell">
                     <div class="carImage tdImg">
                         <img src="images/main/car2.jpg" width="100%" />
                     </div>
                     <span class="ownerText"> OWNER: SMITE JAMES SOME IMAG</span>
                     <p class="modelText">2017 VolksWagon Golf R SportWagen</p>
                     <hr/>
                     <p class="descText">Awesome Grande Toure 2.2L Turbo Diesel 4WD Auto with log books, it is very new. Just 36000KM. The space is very big enough for whole family</p>
                     <button> Read More </button>
               </div> 

               <div class="cell">
                     <div class="carImage tdImg">
                         <img src="images/main/car3.jpg" width="100%" />
                     </div>
                     <span class="ownerText"> OWNER: SMITE JAMES SOME IMAG</span>
                     <p class="modelText">2017 VolksWagon Golf R SportWagen</p>
                     <hr/>
                     <p class="descText">Awesome Grande Toure 2.2L Turbo Diesel 4WD Auto with log books, it is very new. Just 36000KM. The space is very big enough for whole family</p>
                     <button> Read More </button>
               </div> 
            </div>



            <div class="midRow">
               <div class="cell">
                     <div class="carImag tdImg">
                         <img src="images/main/car4.jpg" width="100%" />
                     </div>
                     <span class="ownerText"> OWNER: SMITE JAMES SOME IMAG</span>
                     <p class="modelText">2017 VolksWagon Golf R SportWagen</p>
                     <hr/>
                     <p class="descText">Awesome Grande Toure 2.2L Turbo Diesel 4WD Auto with log books, it is very new. Just 36000KM. The space is very big enough for whole family</p>
                     <button> Read More </button>
               </div> 

               <div class="cell">
                     <div class="carImage tdImg">
                         <img src="images/main/car1.jpg" width="100%" />
                     </div>
                     <span class="ownerText"> OWNER: SMITE JAMES SOME IMAG</span>
                     <p class="modelText">2017 VolksWagon Golf R SportWagen</p>
                     <hr/>
                     <p class="descText">Awesome Grande Toure 2.2L Turbo Diesel 4WD Auto with log books, it is very new. Just 36000KM. The space is very big enough for whole family</p>
                     <button> Read More </button>
               </div> 

               <div class="cell">
                     <div class="carImage tdImg">
                         <img src="images/main/car6.jpg" width="100%" />
                     </div>
                     <span class="ownerText"> OWNER: SMITE JAMES SOME IMAG</span>
                     <p class="modelText">2017 VolksWagon Golf R SportWagen</p>
                     <hr/>
                     <p class="descText">Awesome Grande Toure 2.2L Turbo Diesel 4WD Auto with log books, it is very new. Just 36000KM. The space is very big enough for whole family</p>
                     <button> Read More </button>
               </div> 
            </div>  
			
			-->
			
      </div>
	  
   </div>

	<div class="padding-100"></div>
	<div class="padding-100"></div>
   <div id="bot" >
      <div id="botBanner">

		
		<div class="padding-100"></div>
         <div id="botBannerHeader">
            <h3 class="headerPipe">|</h3>
            <h4 id="botBannerText">CONTACT US</h4>
            <h3 class="headerPipe">|</h3>
         </div>
          <div class="padding-50"></div>

         <p class="botBannerSub">If you have any problems, please fill the following form</p> <p class="botBannerSub"> so that you can contact us</p>
      </div>
	  
	  <div class="padding-50"></div>

      <div id="contactus">

         <form id="contactForm">
            <div id="row1">
               <input type="text" name="name" class="ContactBox" id="textName" placeholder="YOUR NAME"/> 
               <input type="text" name="email" class="ContactBox" id="textEmail" placeholder="YOUR EMAIL"/>
            </div>
            <div id="row2">
               <textarea name="problem" class="ContactBox" id="textProblem" rows="10" placeholder="YOUR MESSAGE"></textarea>

            </div>
            <div id="row3">
               <input type="submit" name="submit" value="SUBMIT" id="contactSubmit"/>
            </div>
         </form>

      </div>

      <div id="botFooter">
         <p id="botFooterText">Copyright © 2018 Design By Wenjuan Sun</p>
      </div>

   </div>
</body>



</html>