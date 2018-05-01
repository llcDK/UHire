<html>
<head>
   <link href="css/main/topStyle.css" rel="stylesheet" type="text/css"/ >
   <link href="css/main/midStyle.css" rel="stylesheet" type="text/css"/ >
   <link href="css/main/botStyle.css" rel="stylesheet" type="text/css"/ >
   <!-- <link href="css/global.css" rel="stylesheet" type="text/css"/ > -->
   <script type="text/javascript" src="css/main/products.js"></script>
   <title>Main</title>
</head>


<!-- <body style="margin:0% 5% 0% 5%;"> -->
<body onload="loadRecent()">
	
	<?php
		include 'backend.php';
		
	?>



   <div id="top"> <div class="darken">
      <div id="topBanner">
         <div id="logo">            
         </div>

         <div id="altLinks">
            <button class="topButton">HOME</button>
            <button class="topButton">MY ACCOUNT</button>
            <button class="topButton">MESSAGE</button>
            <button class="topButton">HELP</button>
            <button class="topButton">CONTACT</button>
            <button class="topButton" id="topSearch"></button>
         </div>
      </div>



      <div id="topMain">

         <div id="title">
            <h2> <span id="txtUDRIVE"> UDRIVE </span> </h2>
            <h1> <span style="color:green;">ONLINE</span>
                 <span style="color:white;"> RENT </span>
                 <span style="color:green;"> YOUR </span>
                 <span style="color:white;"> CAR </span>
            </h1>
            <h5 style="color:white;"> IN YOUR OWN WAY </h4>
         </div>

         <div id="mainSearch">
            <form>
               <div id="topInputs">
                  <input type="text" id="txtAddress"/>
                  <input type="text" id="txtPrice"/>
                  <input type="date" id="txtAvaliable"/>
                  <select id="txtBrand">
                     <option value="value1">Value1</option>
                     <option value="value2">Value1</option>
                     <option value="value3">Value1</option>
                     <option value="value4">Value1</option>
                  </select>
               </div>

               <div id="mainSubmit">
                  <input type="submit" id="SearchNow" />
               </div>
            </form>
         </div>




      </div>
   </div></div>


   <div id="mid">
      <div id="midBanner">
         <div id="midBannerHeader">
            <h3 class="headerPipe">|</h3>
            <h4 id="midBannerText">UPLOAD</h4>
            <h3 class="headerPipe">|</h3>
         </div>

         <p class="midBannerSub"> Here is the latest information on cars</p> <p class="midBannerSub"> You can pick what interests you</p>
      </div>


      <div id="productDisplay">
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
      </div>
   </div>


   <div id="bot">
      <div id="botBanner">


         <div id="botBannerHeader">
            <h3 class="headerPipe">|</h3>
            <h4 id="botBannerText">CONTACT US</h4>
            <h3 class="headerPipe">|</h3>
         </div>


         <p class="botBannerSub">If you have any problems, please fill the following form</p> <p class="botBannerSub"> so that you can contact us</p>
      </div>

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