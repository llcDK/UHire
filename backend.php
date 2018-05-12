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
		private $bankCard;
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
			
			$this->bankCard = BankCard::createBankCard($dbconnect, $this->accNo);
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
		
		function getPassword()
		{
			return $this->password;
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
			return $this->bankCard;
		}
		
		function getBankAccount()
		{
			return $this->bankAccounts;
		}
		
		function equal($other)
		{
			if($this->accNo == $other->accNo && $this->type == $other->type && $this->fname == $other->fname && $this->lname == $other->lname
				&& $this->address == $other->address && $this->profile->equal($other->profile) && $this->bankAccounts == $other->bankAccounts 
				&& $this->bankCard->equal($other->bankCard))
				return true;
			else
				return false;
		}
		
		// Mutators
		function setProfile($profile)
		{
			$this->profile = $profile;
		}
		
		function setBankAccount($bankAcc)
		{
			$this->bankAccounts = $bankAcc;
		}
		
		function setBankCard($bankCard)
		{
			$this->bankCard = $bankCard;
		}
		
		
		function setDetail($dbconnect, $updatingObj)
		{
			if(!$this->equal($updatingObj))
			{	
				// Update profile then account.
				$this->profile->setDetail($dbconnect, $updatingObj->profile, $this->accNo);
				
				// Update database for account
				// Change the information of this object
				$this->accNo = $updatingObj->accNo;
				$this->type = $updatingObj->type;
				$this->fname = $updatingObj->fname;
				$this->lname = $updatingObj->lname;
				$this->address = $updatingObj->address;
				
				$updateAcc = "update Account set type = '$this->type', fname = '$this->fname', lname = '$this->lname', address = '$this->address' where accNo = '$this->accNo';";
				$dbconnect->executeCommand($updateAcc);
				
				// Update the bankAcc
				$this->bankAccounts = $updatingObj->bankAccounts;
				$bankAccQuery = "update BankAccount set bankAccNo = '$this->bankAccounts' where accNo = '$this->accNo';";
				
				// Sometimws you can't change as the bankAccount has to exists.
				$dbconnect->executeCommand($bankAccQuery);
				
				// Update bankCard Information in database
				$this->bankCard->setDetail($dbconnect, $updatingObj->bankCard);
				
				//$this->bankCards->setDetail($dbconnect, $updatingObj->bankCards, $this->accNo);
				
				// Change verified to to-be verified
				
				return true;
			}
			else
			{
				return true;
			}
			
		}
		
		
	}
	
	class Profile
	{
		private $dob;
		private $email;
		private $gender;
		private $pictureName;
		
		public static $imageDir = "images/profileImage/";
		public static $defaultPicName = "default.jpg";
		
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
		
		static function getDefaultPictureName()
		{
			return Profile::$defaultPicName;
		}
		
		static function createProfile($dbconnect, $accNo)
		{
			$profileQuery = "select * from Profile where accNo = '$accNo';";
			$queryResult = $dbconnect->executeCommand($profileQuery);
			if(mysqli_num_rows($queryResult) > 0)
			{
				$profileRow = mysqli_fetch_row($queryResult);
				$profileObj = new Profile($profileRow[1], $profileRow[2], $profileRow[3], $profileRow[4]);
			}
			else
			{
				$profileObj = new Profile("", "", "", Profile::getDefaultPictureName());
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
			if(empty($this->pictureName) || !isset($this->pictureName))
				return Profile::getImageDir() . Profile::getDefaultPictureName();
			return Profile::getImageDir() . $this->pictureName;
		}
		
		function equal($other)
		{
			if($this->dob == $other->dob && $this->email == $other->email && $this->gender == $other->gender)
				return true;
			
			return false;
		}
		
		function setProfilePicture($dbconnect, $tempFileLocation, $accNo)
		{
			if(!isset($this->pictureName) || empty($this->pictureName) || $this->pictureName == Profile::getDefaultPictureName())
			{
				// It used to use a default image.
			}
			else
			{
				// It is replacing the previous image
				// First clean up the old file
				echo "deleting ... ";
				unlink($this->getPictureURL());
			}
			
			// it currently uses default profile picture
			$temp = explode(".", $tempFileLocation);
			$newFileName = round(microtime(true)) . "." . end($temp);
			
			// Rename until the new file exits;
			while(file_exists($newFileName)) $newFileName = round(microtime(true)) . "." . end($temp);
			
			// Save the file to the directory
			move_uploaded_file($tempFileLocation, Profile::getImageDir() . $newFileName);
			
			// Update the database
			$updatePictureQuery = "update Profile set pictureName = '$newFileName' where accNo = '$accNo';";
			$dbconnect->executeCommand($updatePictureQuery);
			
			// Update the current object
			$this->pictureName = $newFileName;
		}
		
		function setDetail($dbconnect, $updatingObj, $accNo)
		{
			if(!$this->equal($updatingObj))
			{
				// Change the information of this object
				$this->dob = $updatingObj->dob;
				$this->email = $updatingObj->email;
				$this->gender = $updatingObj->gender;
				
				// Update the database
				$updateAcc = "update Profile set dob = '$this->dob', email = '$this->email', gender = '$this->gender' where accNo = '$accNo';";
				$dbconnect->executeCommand($updateAcc);
				
				
				return true;
			}
			else
			{
				return false;
			}
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
		
		function equal($other)
		{
			if($this->cardNo == $other->cardNo && $this->type == $other->type && $this->expireDate == $other->expireDate)
			{
				return true;
			}
			
			return false;
		}
		
		function setDetail($dbconnect, $updatingObj)
		{
			if(!$this->equal($updatingObj))
			{
				//echo "TRUE";
				//echo serialize($updatingObj) . "<br/>";
				//echo serialize($this);
				
				// Update the database
				$updateQuery = "update BankCard set type = '$updatingObj->type', expireDate = '$updatingObj->expireDate' where cardNo = '$this->cardNo';";
				// Update this object
				$this->cardNo = $updatingObj->cardNo;
				$this->type = $updatingObj->type;
				$this->expireDate = $updatingObj->expireDate;
				
				$dbconnect->executeCommand($updateQuery);
				return true;
			}
			else
			{
				return false;
			}
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
			$dbconnect = new DBConnection();
		?>
	</body>
</html>