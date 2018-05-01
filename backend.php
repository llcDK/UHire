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
		static function createAccount($dbconnect, $accNo = "", $password = "", $fname = "", $lname = "", $address = "")
		{
			
			// Create an instance of an account
			
			// Update the database
			
			// Print feedback to user
			
			// Return the account
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
		
		
		function __construct($plateNum, $price, $location, $carOwnerAcc, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType)
		{
			updateCar($plateNum, $price, 1, $location, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType);
			$this->carOwnerAcc = $carOwnerAcc;
		}
		
		// Factory method
		public static function createCar()
		{
			// Create a car instance
			
			// Update the database
			
			// Update page
			
		}
		
		public function updateCar($plateNum, $price, $avaiable, $location, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType)
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