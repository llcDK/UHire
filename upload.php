<html>

<head>
	<title>Upload Vehicle</title>
	<link href="css/upload.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="top">
		<div class="darken">

			<div id="Banner">
				<div id="topText"> UDRIVE </div>
			</div>

			<div class="topnav">
				<a href="main.php">Home</a>
				<a href="myAccount.php"> My Account</a>
				<a href="messages.html" class="active">Messages</a>
				<a href="#help"> Help </a>
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


<form action="uplaodCar" method="post">


	<div id="infoHeadings">

		<h2>

			<div>
				<div class="infoHeading">
					<span> Brand </span>
				</div>
				<div class="infoInput">
					<select id="brand">
						<option value="default"> Default </option>
					</select>
				</div>
			</div>
			<div>
				<div class="infoHeading">
					<span> Price / Day  </span>
				</div>
				<div class="infoInput">
					<input type="text" id="price"/>
				</div>

			</div>
			<div>
				<div class="infoHeading">
					<span> Location </span>
				</div>
				<div class="infoInput">
					<select id="location">
						<option value="sydney"> Sydney </option>
					</select>
				</div>
			</div>
			
			<div id="submitDiv">
				<input id="submit" type="submit" value="COMPLETE">	
			</div>
		</div>

	</h2>
</div>

		

	</form>


	<div id="footer">
		<div id="footerData"> <span id="footerText">COPYRIGHT © 2018 Design By Wenjuan Sun </span></div>
		<div id="footerImage"> <img src="images/myAccount/socialIcons.png" id="socialMedia"/> </div>
	</div>


</body>

</html>