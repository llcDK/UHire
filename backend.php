<?php
	class DBConnection
	{
		private $connection;
		private $connectionStatus; // 0: Good connection, 1: Bad connection
		
		public static $serverName = "localhost:3306";
		public static $userName = "root";
		public static $password = "";
		public static $dbName = "udrive";
		
		// Accessor of class static vairables
		private static function getServerName()
		{
			return DBConnection::$serverName;
		}
		
		private static function getUserName()
		{
			return DBConnection::$userName;
		}
		
		private static function getPassword()
		{
			return DBConnection::$password;
		}
		
		private static function getDBName()
		{
			return DBConnection::$dbName;
		}
		
		function __construct()
		{
			$this->connection = mysqli_connect(DBConnection::getServerName(), DBConnection::getUserName(), DBConnection::getPassword());
			mysqli_select_db($this->connection, DBConnection::getDBName());
			
			if(!$this->connection)
			{
				die("Connection failed: " . mysqli_connect_error());
				$this->connectionStatus = 1;
			}
			else
			{
				$this->connectionStatus = 0;
			}
			
		}
		
		function executeCommand($command)
		{
			return mysqli_query($this->connection, $command);
		}
		
		function status()
		{
			return $this->connectionStatus;
		}
	}
	
	class PageManager
	{
		
	}
	
	class Account
	{
		private $accNo;
		private $password;
		private $type; // 0: Car renter; 1: Car owner; 2: System owner
		private $fname;
		private $lname;
		private $address;
		private $rating; // -1 indicates less than 10 people rated
		
		// Links to references of cars, bankCards, BankAccounts, socialMedias, reviews, messages
		private $cars;
		private $bankCards;
		private $bankAccounts;
		private $socialMedias;
		private $reviews;
		private $messages;
		
		
		function __construct($accNo = "", $password = "", $type = 0, $fname = "", $lname = "", $address = "", $rating = -1)
		{
			$this->accNo = $accNo;
			$this->password = $password;
			$this->type = $type;
			$this->fname = $fname;
			$this->lname = $lname;
			$this->address = $address;
			$this->rating = $rating;
		}
		
		// Factory method
		public static function createAccount($dbconnect, $accNo = "", $password = "", $fname = "", $lname = "", $address = "")
		{
			
			// Create an instance of an account
			
			// Update the database
			
			// Print feedback to user
			
			// Return the account
		}
		
		public static function getAccount($dbconnect, $query)
		{
			// Return a list of accounts according to the query
			
			
		}
		
		/*Accessor functions*/
		function getAccNo()
		{
			return $this->accNo;
		}
		
		function type()
		{
			return $this->type;
		}
		
		function getFirstName()
		{
			return $this->fname;
		}
		
		function getLastName()
		{
			return $this->lname;
		}
		
		function getAddress()
		{
			return $this->address;
		}
		
		function getRating()
		{
			return $this->rating;
		}
		
		function setDetail($accNo, $password, $fname, $lname, $address)
		{
			// Change the information of this object
			
			// Update database
			
			// Update the page
			
		}
		
		
	}
	
	class Car
	{
		private $plateNum;
		private $price;
		private $avaiable; // 1: Avaiable, 0: Not avaiable
		private $location;
		private $carOwnerAcc;	// reference to a car owner
		private $year;
		private $model;
		private $description;
		private $brand;
		private $transmission;
		private $seatNumber;
		private $odometer;
		private $fuelType;
		private $bodyType;
		private $image;
		
		// Static variables
		public static $imageDir = "images/carImage/";
		
		private static function getImageDir()
		{
			return Car::$imageDir;
		}
		
		function __construct($plateNum, $price, $avaiable, $location, $carOwnerAcc, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image)
		{
			$this->updateCar($plateNum, $price, $avaiable, $location, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image);
			$this->carOwnerAcc = $carOwnerAcc;
		}
		
		// Factory method
		public static function createCar()
		{
			// Create a car instance
			
			// Update the database
			
			// Update page
			
		}
		
		public function updateCar($plateNum, $price, $avaiable, $location, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image)
		{
			$this->plateNum = $plateNum;
			$this->price = $price;
			$this->avaiable = $avaiable;
			$this->location = $location;
			$this->year = $year;
			$this->model = $model;
			$this->description = $description;
			$this->brand = $brand;
			$this->transmission = $transmission;
			$this->seatNumber = $seatNumber;
			$this->odometer = $odometer;
			$this->fuelType = $fuelType;
			$this->bodyType = $bodyType;
			$this->image = $image;
		}
		
		// Return a list of cars with certain certira
		public static function getCars($dbconnect, $query)
		{
			$queryResult = $dbconnect->executeCommand($query);
			$cars = array();
			if(mysqli_num_rows($queryResult) > 0)
			{
				while($row = mysqli_fetch_row($queryResult))
				{
					// Find the image of the car
					$imageQuery = "select imageFileName from CarImage where plateNum = '$row[0]';";
					$imageNameRow = $dbconnect->executeCommand($imageQuery);
					// Currently only one image is for each car
					$imageRow = mysqli_fetch_row($imageNameRow);
					$imageName = $imageRow[0];
					
					$newCar = new Car($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $imageName);
					$cars[] = $newCar;
				}
			}
			
			return $cars;
		}
		
		public function setDetail($dbconnect, $plateNum, $price, $avaiable, $location, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType)
		{
			// Change the information of this object 
			updateCar($plateNum, $price, $avaiable, $location, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType);
			// Update database
			
			// Update page
			
		}
		
		public function book($acc)
		{
			// Check if there are enough credit
			
				// If ther are enough credit, Set avaiable to 0
				
				// Send a receipt to the renter
				
				// Update page
			
				// If not having enough credit, update page
				
		}
		
		public function getBrand()
		{
			return $this->brand;
		}
		
		public function getLocation()
		{
			return $this->location;
		}
		
		public function getPrice()
		{
			return $this->price;
		}
		
		public function getModel()
		{
			if($this->model == "") return "No model provided!";
			else return $this->model;
		}
		
		public function getFullDescription()
		{
			if($this->description == "") return "No Description provided!";
			else return $this->description;
		}
		
		public function getImageURL()
		{
			return Car::getImageDir() . $this->image;
		}
	}
	
	class BankAccount
	{
		
	}
	
	
	
?>

<html>
	<head>
		
	</head>
	<body>
		<?php
		/*
			//echo DBConnection::getServerName();
			$dbconnect = new DBConnection();
			//$connection = mysqli_connect("localhost:808", "root", "") or die (mysqli_error());;
			
			$acc = new Account("John");
			$objString = serialize($acc);
			echo unserialize($objString)->getAccNo();
		*/
		?>
	</body>
</html>