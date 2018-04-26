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
			$this->connection = mysqli_select_db($this->connection, DBConnection::getDBName());
			
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
		
		function __destruct()
		{
			
		}
		
		function executeCommand($command)
		{
			
		}
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
		
		
		function __construct($accNo = "", $password = "", $fname = "", $lname = "", $address = "")
		{
			$this->accNo = $accNo;
			$this->password = $password;
			$type = 0;
			$this->fname = $fname;
			$this->lname = $lname;
			$this->address = $address;
			$rating = -1;
		}
		
		// Factor method
		static function createAccount($accNo = "", $password = "", $fname = "", $lname = "", $address = "")
		{
			// Create a instance of an account
			
			// Update the database
			
			// Print feedback to user
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
		
		
		
	}
	
	
?>

<html>
	<head>
		
	</head>
	<body>
		<?php
		
			//echo DBConnection::getServerName();
			$dbconnect = new DBConnection();
			//$connection = mysqli_connect("localhost:808", "root", "") or die (mysqli_error());;
			
			$acc = new Account("John");
			$objString = serialize($acc);
			echo unserialize($objString)->getAccNo();
		?>
	</body>
</html>