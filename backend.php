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
		private $rating; // -1 indicates less than 5 people rated
		
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
		
		public static function queryAccount($dbconnect, $accNo)
		{
			$accQuery = "select * from Account where accNo = '$accNo';";
			$resultTable = $dbconnect->executeCommand($accQuery);
			$accRow = mysqli_fetch_row($resultTable);
			$accObj = new Account($accRow[0], $accNo[1], $accRow[2], $accRow[3], $accRow[4], $accRow[5], $accRow[6]);
			$accObj->initProfile($dbconnect);
			$accObj->initBankInfo($dbconnect);
			$accObj->initReview($dbconnect);
			
			return $accObj;
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
		
		function initReview($dbconnect)
		{
			// Init the list of reviews given to the account
			$this->reviews = Review::getReviews($dbconnect, $this->accNo);
			
			// Set the ratings
			$this->rating = Review::calcRating($dbconnect, $this->accNo);
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
			if($this->rating == -1)
				return 0;
			
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
		
		function getReviews()
		{
			return $this->reviews;
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
		
		function setUserType($dbconnect, $type)
		{
			$this->type = $type;
			// Update the database
			$updateTypeQuery = "update Account set type = '$type' where accNo = '$this->accNo';";
			$dbconnect->executeCommand($updateTypeQuery);
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
		
		function verify($dbconnect)
		{
			if((empty($this->fname) || !isset($this->fname) || empty(trim($this->fname))) && (empty($this->lname) || !isset($this->lname) || empty(trim($this->lname))))
			{
				$this->profile->setVerify($dbconnect, "NO", $this->accNo);
				//echo "<script>alert('1');</script>";
			}
			else if(empty($this->address) || !isset($this->address) || empty(trim($this->address)))
			{
				$this->profile->setVerify($dbconnect, "NO", $this->accNo);
				//echo "<script>alert('2');</script>";
			}
			else if(!$this->profile->verify())
			{
				$this->profile->setVerify($dbconnect, "NO", $this->accNo);
				//echo "<script>alert('3');</script>";
			}	
			else if(empty($this->bankAccounts) || !isset($this->bankAccounts) || empty(trim($this->bankAccounts)))
			{
				$this->profile->setVerify($dbconnect, "NO", $this->accNo);
				//echo "<script>alert('4');</script>";
			}
			else if(!$this->bankCard->verify())
			{
				$this->profile->setVerify($dbconnect, "NO", $this->accNo);
				//echo "<script>alert('5');</script>";
			}
			else
			{
				$this->profile->setVerify($dbconnect, "YES", $this->accNo);
				//echo "<script>alert('6');</script>";
			}
			
			return $this->profile->verified();
		}
		
	}
	
	class Profile
	{
		private $dob;
		private $email;
		private $gender;
		private $pictureName;
		private $verified;
		
		public static $imageDir = "images/profileImage/";
		public static $defaultPicName = "default.jpg";
		
		function __construct($dob, $email, $gender, $pictureName, $verified = "NO")
		{
			$this->dob = $dob;
			$this->email = $email;
			$this->gender = $gender;
			$this->pictureName = $pictureName;
			$this->verified = $verified;
		}
		
		static function getImageDir()
		{
			return Profile::$imageDir;
		}
		
		static function getDefaultPictureName()
		{
			return Profile::$defaultPicName;
		}
		
		function verified()
		{
			if(strtoupper($this->verified) == "YES")
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		static function createProfile($dbconnect, $accNo)
		{
			$profileQuery = "select * from Profile where accNo = '$accNo';";
			$queryResult = $dbconnect->executeCommand($profileQuery);
			if(mysqli_num_rows($queryResult) > 0)
			{
				$profileRow = mysqli_fetch_row($queryResult);
				$profileObj = new Profile($profileRow[1], $profileRow[2], $profileRow[3], $profileRow[4], $profileRow[5]);
			}
			else
			{
				$profileObj = new Profile("", "", "", Profile::getDefaultPictureName(), "NO");
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
		
		function setVerify($dbconnect, $newState, $accNo)
		{
			// Update the database
			$verifyQuery = "update Profile set verified = '$newState' where accNo = '$accNo';";
			$dbconnect->executeCommand($verifyQuery);
		}
		
		function setDetail($dbconnect, $updatingObj, $accNo)
		{
			if(!$this->equal($updatingObj))
			{
				// Change the information of this object
				$this->dob = $updatingObj->dob;
				$this->email = $updatingObj->email;
				$this->gender = $updatingObj->gender;
				$this->verified = "NO";
				
				// Update the database
				$updateAcc = "update Profile set dob = '$this->dob', email = '$this->email', gender = '$this->gender', verified = '$this->verified' where accNo = '$accNo';";
				$dbconnect->executeCommand($updateAcc);
				
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function verify()
		{
			// DOB has to be in form YYYY-MM-DD
			if(!Profile::validateDate($this->dob))
				return false;
			else if(!Profile::checkEmail($this->email))
				return false;
			else if(empty($this->gender) || !isset($this->gender) || empty(trim($this->gender)))
				return false;
			else
				return true;
		}
		
		
		// Private (Helper) functions 
		
		static function validateDate($date, $format = 'Y-m-d')
		{
			$d = DateTime::createFromFormat($format, $date);
			return $d && $d->format($format) == $date;
		}
		
		static function checkEmail($email) 
		{
			if ( strpos($email, '@') !== false ) 
			{
				$split = explode('@', $email);
				return (strpos($split['1'], '.') !== false ? true : false);
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
		private $avaiableTo;
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
		public static $commissionRate = 0.1;
		public static $bond = 200;
		
		private static function getImageDir()
		{
			return Car::$imageDir;
		}
		
		function __construct($plateNum, $price, $avaiable, $location, $carOwnerAcc, $avaiableTo, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image)
		{
			$this->updateCar($plateNum, $price, $avaiable, $location, $avaiableTo, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image);
			$this->carOwnerAcc = $carOwnerAcc;
		}
		
		// Factory method
		public static function createCar($dbconnect, $plateNum, $price, $location, $carOwnerAcc, $avaiableTo, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image = "car0.jpg")
		{
			// Create a car instance
			$car = new Car($plateNum, $price, 1, $location, $carOwnerAcc, $avaiableTo, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image);
			
			// Update the database
			$insertQuery = "insert into Car values('$plateNum', '$price', 1, '$location', '$carOwnerAcc', '$avaiableTo', '$year', '$model', '$description', '$brand', '$transmission', '$seatNumber', '$odometer', '$fuelType', '$bodyType');";
			$flag = $dbconnect->executeCommand($insertQuery);
			
			if($flag)
			{
				return $car;
			}
			else
				return false;
						
		}
		
		public static function modifyCar($dbconnect, $plateNum, $price, $location, $carOwnerAcc, $avaiableTo, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image)
		{
			// Update the database
			$updateQuery = "update Car set plateNum = '$plateNum', price = '$price', location = '$location', carOwnerAcc = '$carOwnerAcc', avaiableTo = '$avaiableTo', 
			year = '$year', model = '$model', description = '$description', brand = '$brand', transmission = '$transmission', numSeat = '$seatNumber', odometer = '$odometer', fuelType = '$fuelType', bodyType = '$bodyType'
			where plateNum = '$plateNum';";
			$flag = $dbconnect->executeCommand($updateQuery);
			
			if($flag)
			{
				return true;
			}
			else
				return false;
			
		}		
		
		private static function getCommissionRate()
		{
			return Car::$commissionRate;
		}
		
		private static function getBond()
		{
			return Car::$bond;
		}
		
		public function updateCar($plateNum, $price, $avaiable, $location, $avaiableTo, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType, $image)
		{
			$this->plateNum = $plateNum;
			$this->price = $price;
			$this->avaiable = $avaiable;
			$this->location = $location;
			$this->avaiableTo = $avaiableTo;
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
		
		public function setAvaiable($dbconnect, $newSate)
		{
			$this->avaiable = $newSate;
			// Update the database
			$updateCarStatusQuery = "update Car set available = $newSate where plateNum = '$this->plateNum';";
			$dbconnect->executeCommand($updateCarStatusQuery);
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
					
					$newCar = new Car($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $imageName);
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
			$ava = empty($ava) || !isset($ava)? '0000-00-00' : $ava;
			
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
		
		public function setDetail($dbconnect, $plateNum, $price, $avaiable, $location, $avaiableTo, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType)
		{
			// Change the information of this object 
			updateCar($plateNum, $price, $avaiable, $location, $avaiableTo, $year, $model, $description, $brand, $transmission, $seatNumber, $odometer, $fuelType, $bodyType);
			// Update database
			
		}
		
		
		public function book($dbconnect, $acc, $day)
		{
			$comission = Car::getCommissionRate() * $this->price * $day;
			
			// Check if there are enough credit
			$totalAmount = $this->price * $day + $comission + Car::getBond();
			
			if($acc->getBankCard()->getBalance() >= $totalAmount && date_diff(new DateTime($this->avaiableTo), new DateTime()) >= $day)
			{	
				// If ther are enough credits, Set avaiable to 0
				$this->setAvaiable($dbconnect, 0);
				
				// Make a transaction
				// Frist we need to get the bankAcc of the car owner
				$findCarownerBankAccQuery = "select bankAccNo from BankAccount where accNo = '$this->carOwnerAcc';";
				$carOwnerBankAccResult = $dbconnect->executeCommand($findCarownerBankAccQuery);
				$carOwnerBankAccRow = mysqli_fetch_row($carOwnerBankAccResult);
				$carOwnerAcc = $carOwnerBankAccRow[0];
				
				$currentTime = date("Y-m-d h:i:s");
				
				$transaction = Transaction::createTransaction($dbconnect, $acc->getBankCard()->getCardNo(), $carOwnerAcc, $currentTime, $totalAmount, $comission);
				
				// Create a booking
				$bookingTill = new DateTime($currentTime);
				$bookingTill->add(new DateInterval('P' . $day . 'D'));
				$bookingTill = $bookingTill->format('Y-m-d');
				
				$bookingObj = Booking::createBooking($dbconnect, $acc->getAccNo(), $this->plateNum, $currentTime, "$bookingTill", 0);
								
				//print_r($bookingObj);
				
				// Execute the transaction
				$receipt = $transaction->process($dbconnect, $acc->getAccNo(), $this->plateNum);
				
				return $receipt;
			}
			else
			{
				// If not having enough credit or invalid length, update page
				return false;
			}
				
		}
		
		public function getReview($dbconnect)
		{
			
		}
		
		public function getPlateNum()
		{
			return $this->plateNum;
		}
		
		public function getBrand()
		{
			return $this->brand;
		}
		
		public function getLocation()
		{
			return $this->location;
		}
		
		public function getAvaiableTo()
		{
			return $this->avaiableTo;
		}
		
		public function getYearBought()
		{
			return $this->year;
		}
		
		public function getDescription()
		{
			return $this->description;
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
		
		public function getTransmission()
		{
			return $this->transmission;
		}
		
		public function getNumberSeats()
		{
			return $this->seatNumber;
		}
		
		public function getOdometer()
		{
			return $this->odometer;
		}
		
		public function getFuelType()
		{
			return $this->fuelType;
		}
		
		public function getBobyType()
		{
			return $this->bodyType;
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
		
		function verify()
		{
			if(empty($this->cardNo) || !isset($this->cardNo) || empty(trim($this->cardNo)))
				return false;
			else if(empty($this->type) || !isset($this->type) || empty(trim($this->type)))
				return false;
			else if(empty($this->expireDate) || !isset($this->expireDate) || empty(trim($this->expireDate)) || !BankCard::validateDate($this->expireDate))
				return false;
			else 
				return true;
		}
		
		// Private functions
		
		private static function validateDate($date, $format = 'Y-m-d')
		{
			$d = DateTime::createFromFormat($format, $date);
			return $d && $d->format($format) == $date;
		}
		
	}
	
	class Review
	{
		private $renter;
		private $owner;
		private $time;
		private $plateNum;
		private $content;
		private $rating;
		private $anon;
		
		function __construct($renter, $owner, $time, $plateNum, $content, $rating, $anon)
		{
			$this->renter = $renter;
			$this->owner = $owner;
			$this->time = $time;
			$this->plateNum = $plateNum;
			$this->content = $content;
			$this->rating = $rating;
			$this->anon = $anon;
		}
		
		function getRenter()
		{
			return $this->renter;
		}
		
		function getOwner()
		{
			return $this->owner;
		}
		
		function getTime()
		{
			return $this->time;
		}
		
		function getPlateNum()
		{
			return $this->plateNum;
		}
		
		function getContent()
		{
			return $this->content;
		}
		
		function getRating()
		{
			return $this->rating;
		}
		
		function anon()
		{
			return $this->anon;
		}
		
		static function calcRating($dbconnect, $accNo)
		{
			$reviewsQuery = "select count(*), avg(rating) from Review where owner = '$accNo' and rating is not NULL;";
			$reviewResult = $dbconnect->executeCommand($reviewsQuery);
			if(mysqli_num_rows($reviewResult) > 0)
			{
				$reviewSum = mysqli_fetch_row($reviewResult);
				// If there are 10 more reviews, then it is valuable
				if($reviewSum[0] >= 5)
				{
					return $reviewSum[1];
				}
				else
				{
					return -1;
				}
			}
			else
			{
				return -1;
			}
		}
		
		static function getReviews($dbconnect, $accNo)
		{
			//$allReviews = array();
			$reviewQuery = "select * from Review where owner = '$accNo';";
			/*
			$reviewsTable = $dbconnect->executeCommand($reviewQuery);
			if($reviewsTable != false && mysqli_num_rows($reviewsTable) > 0)
			{
				while($row = mysqli_fetch_row($reviewsTable))
				{
					$review = new Review($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
					$allReviews[] = $review;
				}
			}
			*/
			return Review::queryReviews($dbconnect, $reviewQuery);
		}
		
		static function queryReviews($dbconnect, $query)
		{
			$allReviews = array();
			$reviewsTable = $dbconnect->executeCommand($query);
			if($reviewsTable != false && mysqli_num_rows($reviewsTable) > 0)
			{
				while($row = mysqli_fetch_row($reviewsTable))
				{
					$review = new Review($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
					$allReviews[] = $review;
				}
			}
			
			return $allReviews;
		}
	}
	
	class Transaction
	{
		private $cardNo;
		private $bankAccNo;
		private $time;
		private $amount;
		private $commission;
		
		public static $adminBankAcc = "11";
		
		function __construct($cardNo, $bankAccNo, $time, $amount, $commission)
		{
			$this->cardNo = $cardNo;
			$this->bankAccNo = $bankAccNo;
			$this->time = $time;
			$this->amount = $amount;
			$this->commission = $commission;
		}
		
		static function createTransaction($dbconnect, $cardNo, $bankAccNo, $time, $amount, $commission)
		{
			$transObj = new Transaction($cardNo, $bankAccNo, $time, $amount, $commission);
			// insert an transaction object into the database
			$insertTransQuery = "insert into Transaction values('$cardNo', '$bankAccNo', '$time', $amount, $commission);";
			$dbconnect->executeCommand($insertTransQuery);
			
			return $transObj;
		}
		
		private static function getAdminBankAcc()
		{
			return Transaction::$adminBankAcc;
		}
		
		function process($dbconnect, $accNo, $plateNum)
		{
			// Note that when a transaction is created, it has been stored in the database
			// Process will actually, transfer money from the cardNo to bankAccNo and transfer money from cardNo to admin Account
			
			// Frist decrease the balance in the card
			$change = $this->amount;
			$bankCardNo = $this->cardNo;
			$updateBalanceQueryForRenter = "update BankCard set balance = balance - $change where cardNo = '$bankCardNo'; ";
			$flag = $dbconnect->executeCommand($updateBalanceQueryForRenter);
			
			// Detail of bank account is invisible in this system
			
			// Create Receipts
			$receiptObj = Receipt::createReceipt($dbconnect, $accNo, $plateNum, $this->time, $this->amount, $this->commission);
			
			return $receiptObj;
		}
	}
	
	class Booking
	{
		private $accNo;
		private $plateNum;
		private $requestingTime;
		private $bookTill;
		private $deleted;
		
		function __construct($accNo, $plateNum, $requestingTime, $bookTill, $deleted = 0)
		{
			$this->accNo = $accNo;
			$this->plateNum = $plateNum;
			$this->requestingTime = $requestingTime;
			$this->bookTill = $bookTill;
			$this->deleted = $deleted;
		}
		
		static function createBooking($dbconnect, $accNo, $plateNum, $requestingTime, $bookTill, $deleted = 0)
		{
			$booking = new Booking($accNo, $plateNum, $requestingTime, $bookTill, $deleted);
			
			// Insert into the database
			$insertBookingQuery = "insert into Booking values('$accNo', '$plateNum', '$requestingTime', '$bookTill', $deleted);";
			$dbconnect->executeCommand($insertBookingQuery);
			
			return $booking;
		}
	}
	
	class Receipt
	{
		private $accNo;
		private $plateNum;
		private $requestingTime;
		private $moneyPaid;
		private $commission;
		
		function __construct($accNo, $plateNum, $requestingTime, $moneyPaid, $commission)
		{
			$this->accNo = $accNo;
			$this->plateNum = $plateNum;
			$this->requestingTime = $requestingTime;
			$this->moneyPaid = $moneyPaid;
			$this->commission = $commission;
		}
		
		static function createReceipt($dbconnect, $accNo, $plateNum, $requestingTime, $moneyPaid, $commission)
		{
			// Frist create a Receipt object
			$receiptObj = new Receipt($accNo, $plateNum, $requestingTime, $moneyPaid, $commission);
			// Insert into the database
			$insertReceiptQuery = "insert into Receipt values('$accNo', '$plateNum', '$requestingTime', $moneyPaid, $commission);";
			$dbconnect->executeCommand($insertReceiptQuery);
			
			return $receiptObj;
		}
		
		static function queryReceipt($dbconnect, $query)
		{
			$receiptTable = $dbconnect->executeCommand($query);
			$receiptRow = mysqli_fetch_row($receiptTable);
			$receiptObj = new Receipt($receiptRow[0], $receiptRow[1], $receiptRow[2], $receiptRow[3], $receiptRow[4]);
			
			return $receiptObj;
		}
		
		function getAccNo()
		{
			return $this->accNo;
		}
		
		function getPlateNum()
		{
			return $this->plateNum;
		}
		
		function getTime()
		{
			return $this->requestingTime;
		}
		
		function getAmount()
		{
			return $this->moneyPaid;
		}
		
		function getCommission()
		{
			return $this->commission;
		}
	}
	
	class Message
	{
		private $sender;
		private $reciever;
		private $time;
		private $content;
		
		function __construct($sender, $reciever, $time, $content)
		{
			$this->sender = $sender;
			$this->reciever = $reciever;
			$this->time = $time;
			$this->content = $content;
		}
		
		static function createMessage($dbconnect, $sender, $reciever, $time, $content)
		{
			$MessageObj = new Message($sender, $reciever, $time, $content);
			$insertMessageQuery = "insert into Message values($sender, $reciever, $time, $content); ";
		}
	}
	
	class Chat
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
			$dbconnect = new DBConnection();
			
		?>
	</body>
</html>