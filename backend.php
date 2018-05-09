<?php
	class DBConnection
	{
		private $connection;
		private $connectionStatus; // 0: Good connection, 1: Bad connection
		
		/*
		public static $serverName = "localhost";
		public static $userName = "tianming_uhire";
		public static $password = "testingenv2";
		public static $dbName = "tianming_uhire";
		*/
		
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
		private $profile;
		
		
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
		
		function initProfile($dbconnect)
		{
			$this->profile = Profile::createProfile($dbconnect, $this->accNo);
			$this->initBankInfo($dbconnect);
		}
		
		function initBankInfo($dbconnect)
		{
			$bankAccQuery = "select * from BankAccount where accNo = '$this->accNo';";
			
			$queryResult = $dbconnect->executeCommand($bankAccQuery);
			if(mysqli_num_rows($queryResult) > 0)
			{
				$bankAccRow = mysqli_fetch_row($queryResult);
				$this->bankAccounts = $bankAccRow[0];
			}
			else
			{
				$this->bankAccounts = "";
			}
			
			$this->bankCards = BankCard::createBankCard($dbconnect, $this->accNo);
		}
		
		function getCars($dbconnect)
		{
			$carsOfThisAccount = "select * from Car where carOwnerAcc = {$this->accNo} ;";
			return Car::getCars($dbconnect, $carsOfThisAccount);
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
		
		function getProfile()
		{
			return $this->profile;
		}
		
		function getBankCard()
		{
			return $this->bankCards;
		}
		
		function getBankAccount()
		{
			return $this->bankAccounts;
		}
		
		function setDetail($accNo, $password, $fname, $lname, $address)
		{
			// Change the information of this object
			
			// Update database
			
			// Update the page
			
		}
		
		
	}
	
	class Profile
	{
		private $dob;
		private $email;
		private $gender;
		private $pictureName;
		
		public static $imageDir = "images/profileImage/";
		
		function __construct($dob, $email, $gender, $pictureName)
		{
			$this->dob = $dob;
			$this->email = $email;
			$this->gender = $gender;
			$this->pictureName = $pictureName;
		}
		
		static function getImageDir()
		{
			return Profile::$imageDir;
		}
		
		static function createProfile($dbconnect, $accNo)
		{
			$profileQuery = "select * from Profile where accNo = '$accNo';";
			$queryResult = $dbconnect->executeCommand($profileQuery);
			if(mysqli_num_rows($queryResult) > 0)
			{
				$profileRow = mysqli_fetch_row($queryResult);
				$profileObj = new Profile($profileRow[1], $profileRow[2], $profileRow[3], Profile::getImageDir() . $profileRow[4]);
			}
			else
			{
				$profileObj = new Profile("", "", "", Profile::getImageDir() . "default.jpg");
			}
			
			return $profileObj;
		}
		
		function getDOB()
		{
			return $this->dob;
		}
		
		function getEmail()
		{
			return $this->email;
		}
		
		function getGender()
		{
			return $this->gender;
		}
		
		function getPictureURL()
		{
			return $this->pictureName;
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
			if($queryResult != false && mysqli_num_rows($queryResult) > 0)
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
		
		public static function getBrands($dbconnect)
		{
			$brandQuery = "select distinct(brand) from Car order by brand;";
			$queryResult = $dbconnect->executeCommand($brandQuery);
			$brands = array();
			if(mysqli_num_rows($queryResult) > 0)
			{
				while($row = mysqli_fetch_row($queryResult))
				{
					$brands[] = $row[0];
				}
			}
			
			return $brands;
		}
		
		public static function searchCars($dbconnect, $loc, $price, $ava, $brand)
		{
			// First perpare the SQL statement
			// First consider the price and avaiable and brand
			
			$price = empty($price) || !isset($price)? PHP_INT_MAX : $price;
			
			$query = "select * from Car where price <= $price and avaiableTo > '$ava' and brand like '%$brand%';";
			
			// Call getCars function to return a list of cars that match the cirteria
			$partialResult = Car::getCars($dbconnect, $query);
			
			// Filter the returned data by location 
			$result = array();
			if(trim($loc) != "")
			{
				foreach($partialResult as $car)
				{
					similar_text($car->getLocation(), $loc, $sim_percent);
					if($sim_percent > 35)
					{
						$result[] = $car;
					}
				}
			}
			
			return $result;
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
			if(empty($this->image) || !isset($this->image))
				return Car::getImageDir() . "car0.jpg";
			
			return Car::getImageDir() . $this->image;
		}
	}
	
	class BankCard
	{
		private $cardNo;
		private $type;
		private $balance;
		private $expireDate;
		private $accNo;
		private $bankAcc;
		
		function __construct($cardNo, $type, $balance, $expireDate, $accNo, $bankAcc = "")
		{
			$this->cardNo = $cardNo;
			$this->type = $type;
			$this->balance = $balance;
			$this->expireDate = $expireDate;
			$this->accNo = $accNo;
			$this->bankAcc = $bankAcc;
		}
		
		static function createBankCard($dbconnect, $accNo)
		{
			$bankCardQuery = "select * from BankCard where accNo = '$accNo';";
			
			$queryResult = $dbconnect->executeCommand($bankCardQuery);
			if(mysqli_num_rows($queryResult) > 0)
			{
				$bankCardRow = mysqli_fetch_row($queryResult);
				$bankCardObj = new BankCard($bankCardRow[0], $bankCardRow[1], $bankCardRow[2], $bankCardRow[3], $bankCardRow[4], $bankCardRow[5]);
			}
			else
			{
				$bankCardObj = new BankCard("", "", "", "", "", $accNo, "");
			}		
			
			return $bankCardObj;
		}
		
		function getCardNo()
		{
			return $this->cardNo;
		}
		
		function type()
		{
			return $this->type;
		}
		
		function getBalance()
		{
			return $this->balance;
		}
		
		function getExpireDate()
		{
			return $this->expireDate;
		}
		
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