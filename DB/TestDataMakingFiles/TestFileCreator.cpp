#include <iostream>
#include <cstdlib>
#include <fstream>
#include <string>
#include <sstream>
using namespace std;

const char outName[] = "testData.txt";
const int DATALIMIT = 1000;

struct Account
{
   static const char tableName[];;
   static int currID;
   int accNo;
   string password;
   string userType;
   string fname;
   string lname;
   int streetNum;
   string streetName;
   string streetType;

   int ratingInt;
   int ratingDec;

   Account()
   {
      string temp = "100";

      accNo = stoi(temp + to_string(currID++));

      if((accNo % 2)) userType = "Car renter";
      else userType = "Car owner";

      streetNum = (rand() % 300) + 1;

      ratingInt = rand() % 6;
      ratingDec = rand() % 10;
   }

   friend ostream& operator<<(ostream& os, const Account& acc)
   {
      os << "(";
      os << "'";
      os << acc.accNo;
      os << "'";
      os << ", ";

      os << "'";
      os << acc.password;
      os << "'";
      os << ", ";

      os << "'";
      os << acc.userType;
      os << "'";
      os << ", ";

      os << "'";
      os << acc.fname;
      os << "'";
      os << ", ";

      os << "'";
      os << acc.lname;
      os << "'";
      os << ", ";

      os << "'";
      os << acc.streetNum;
      os << " ";
      os << acc.streetName;
      os << " ";
      os << acc.streetType;
      os << "'";
      os << ", ";

      
      os << acc.ratingInt;
      os << ".";
      os << acc.ratingDec;
      os << ")";
   }
};
int Account::currID = 100;
const char Account::tableName[] = "ACCOUNT";

struct Profile
{
   static const char tableName[];;
   static int currID;
   int accNo;

   string day;
   string month;
   string year;

   string email;
   string gender;
   string pictureName;
   string verified;

   Profile()
   {
      string temp = "100";
      accNo = stoi(temp + to_string(currID++));


      day = to_string((rand() % 28) + 1);
      month = to_string((rand() % 12) + 1);
      year = to_string((rand() % 100) + 1901);

      if(rand()%2) gender = "MALE";
      else gender = "FEMALE";

      if(rand()%2) verified = "YES";
      else verified = "NO";

   }

   friend ostream& operator<<(ostream& os, const Profile& p)
   {
      os << "(";
      os << "'";
      os << p.accNo;
      os << "'";
      os << ", ";

      os << "'";
      os << p.year;
      os << "-";
      os << p.month;
      os << "-";
      os << p.day;
      os << "'";
      os << ", ";

      os << "'";
      os << p.email;
      os << "'";
      os << ", ";

      os << "'";
      os << p.gender;
      os << "'";
      os << ", ";

      os << "'";
      os << p.pictureName;
      os << "'";
      os << ", ";

      os << "'";
      os << p.verified;
      os << "'";
      os << ")";
   }
};
int Profile::currID = 100;
const char Profile::tableName[] = "PROFILE";

struct Car
{
   static const char tableName[];

   static int currPlate;
   string plateNum;

   int priceInt;
   int priceDec;

   int avaliable;

   string streetName;
   string streetType;

   static int currID;
   int accNo;

   string avaliableDay;
   string avaliableMon;
   string avaliableYear;

   string year;
   string model;

   string desc;
   string brand;
   string transmission;
   int numSeat;
   int odometer;
   string fuelType;
   string bodyType;


   Car()
   {
      stringstream ss;
      ss << hex << currPlate;
      currPlate = currPlate + 1007;
      plateNum = ss.str();

      priceInt = rand()%100;
      priceDec = rand()%10;

      avaliable = rand()%2;

      string temp = "100";
      accNo = stoi(temp + to_string(currID));
      currID = currID + 2; //Plus 2 because only even ids are
                           //renters for the purpose of data generation
      //EVEN IS OWNER
      //ODD IS RENTER

      avaliableDay = to_string((rand() % 28) + 1);
      avaliableMon = to_string((rand() % 12) + 1);
      avaliableYear = to_string((rand() % 3) + 2018);

      year =  to_string((rand() % 28) + 1990) + "-01-01";

      if(rand()%2) transmission = "manual";
      else transmission = "auto";

      numSeat = (rand()%6) + 2;
      odometer = (rand()%550000);
   }

   friend ostream& operator<<(ostream& os, const Car& c)
   {

      os << "(";
      os << "'";
      os << c.plateNum;
      os << "'";
      os << ", ";

      os << c.priceInt;
      os << ".";
      os << c.priceDec;
      os << ", ";

      os << "'";
      os << c.avaliable;
      os << "'";
      os << ", ";

      os << "'";
      os << c.streetName;
      os << " ";
      os << c.streetType;
      os << "'";
      os << ", ";

      os << "'";
      os << c.accNo;
      os << "'";
      os << ", ";


      os << "'";
      os << c.avaliableYear;
      os << "-";
      os << c.avaliableMon;
      os << "-";
      os << c.avaliableDay;
      os << "'";
      os << ", ";


      os << "'";
      os << c.year;
      os << "'";
      os << ", ";

      os << "'";
      os << c.model;
      os << "'";
      os << ", ";

      os << "'";
      os << c.desc;
      os << "'";
      os << ", ";

      os << "'";
      os << c.brand;
      os << "'";
      os << ", ";

      os << "'";
      os << c.transmission;
      os << "'";
      os << ", ";

      os << "'";
      os << c.numSeat;
      os << "'";
      os << ", ";

      os << "'";
      os << c.odometer;
      os << "'";
      os << ", ";

      os << "'";
      os << c.fuelType;
      os << "'";
      os << ", ";

      os << "'";
      os << c.bodyType;
      os << "'";
      os << ")";
   }
};
int Car::currPlate = 1048576;
int Car::currID = 100;
const char Car::tableName[] = "CAR";

struct CarImage
{
   static const char tableName[];

   static int currPlate;
   string plateNum;

   string imageFileName;

   CarImage()
   {
      stringstream ss;
      ss << hex << currPlate;
      currPlate = currPlate + 1007;
      plateNum = ss.str();
   }

   friend ostream& operator<<(ostream& os, const CarImage& ci)
   {
      os << "(";
      os << "'";
      os << ci.plateNum;
      os << "'";
      os << ", ";

      os << "'";
      os << ci.imageFileName;
      os << "'";
      os << ")";
   }
};
int CarImage::currPlate = 1048576;
const char CarImage::tableName[] = "CARIMAGE";

struct Booking
{
   static const char tableName[];

   static int currID;
   int accNo;

   static int currPlate;
   string plateNum;

   string requestingTime;
   string bookuntil;
   int deleted;

   Booking()
   {
      
      string temp = "100";
      accNo = stoi(temp + to_string(currID));
      currID = currID + 2; //Plus 2 because only even ids are
                           //renters for the purpose of data generation
      //EVEN IS OWNER
      //ODD IS RENTER

      stringstream ss;
      ss << hex << currPlate;
      currPlate = currPlate + 1007;
      plateNum = ss.str();

      requestingTime = "2019-04-28 11:00:00";


      bookuntil = "2019-04-30";





      deleted = rand()%2;


   }

   friend ostream& operator<<(ostream& os, const Booking& b)
   {
      os << "(";
      os << "'";
      os << b.accNo;
      os << "'";
      os << ", ";

            os << "'";
      os << b.plateNum;
      os << "'";
      os << ", ";

      os << "'";
      os << b.requestingTime;
      os << "'";
      os << ", ";

            os << "'";
      os << b.bookuntil;
      os << "'";
      os << ", ";

      os << b.deleted;
      os << ")";
   }
};
int Booking::currPlate = 1048576;
int Booking::currID = 100 + 1;
const char Booking::tableName[] = "BOOKING";


struct Receipt
{
   static const char tableName[];

   static int currID;
   int accNo;

   static int currPlate;
   string plateNum;

   string requestingTime;

   int moneyPaidInt;
   int moneyPaidDec;

   int commisionInt;
   int commisionDec;

   Receipt()
   {
      
      string temp = "100";
      accNo = stoi(temp + to_string(currID));
      currID = currID + 2; //Plus 2 because only even ids are
                           //renters for the purpose of data generation
      //EVEN IS OWNER
      //ODD IS RENTER

      stringstream ss;
      ss << hex << currPlate;
      currPlate = currPlate + 1007;
      plateNum = ss.str();

      requestingTime = "2019-04-28 11:00:00";

      moneyPaidInt = (rand()%20) + 10;
      moneyPaidDec = rand()%10;

      commisionInt = rand()%6;
      commisionDec = rand()%10;
   }

   friend ostream& operator<<(ostream& os, const Receipt& r)
   {
      os << "(";
      os << "'";
      os << r.accNo;
      os << "'";
      os << ", ";

      os << "'";
      os << r.plateNum;
      os << "'";
      os << ", ";

      os << "'";
      os << r.requestingTime;
      os << "'";
      os << ", ";

      os << r.moneyPaidInt;
      os << ".";
      os << r.moneyPaidDec;
      os << ", ";

      os << r.commisionInt;
      os << ".";
      os << r.commisionDec;
      os << ")";
   }
};
int Receipt::currPlate = 1048576;
int Receipt::currID = 100 + 1;
const char Receipt::tableName[] = "Receipt";


struct Review
{
   static const char tableName[];

   static int currID;
   int renter;

   int owner;
   string timeGiven;
   string plateNum;
   string content;
   int rating;
   int annoymous;

   Review()
   {
      
      string temp = "100";
      renter = stoi(temp + to_string(currID));
      currID = currID + 2; 

      timeGiven = "2017-04-31";
      rating = rand() % 6;
      annoymous = rand()%2;
   }

   friend ostream& operator<<(ostream& os, const Review& r)
   {
      os << "(";
      os << "'";
      os << r.renter;
      os << "'";
      os << ", ";

      os << "'";
      os << r.owner;
      os << "'";
      os << ", ";

      os << "'";
      os << r.timeGiven;
      os << "'";
      os << ", ";

      os << "'";
      os << r.plateNum;
      os << "'";
      os << ", ";

      os << "'";
      os << r.content;
      os << "'";
      os << ", ";

      os << r.rating;
      os << ", ";

      os << r.annoymous;
      os << ")";
   }
   
};
int Review::currID = 100 + 1;
const char Review::tableName[] = "Review";




struct BankAccount
{

   static const char tableName[];

   static int currID;
   static int currBankID;
   int bankAccNo;
   int accNo;

   BankAccount()
   {
      string temp = "100";
      string temp2 = "9754";

      accNo = stoi(temp + to_string(currID));
      currID = currID + 1; 

      bankAccNo = stoi(temp2 + to_string(currBankID));
      currBankID = currBankID + 1; 
   }

   friend ostream& operator<<(ostream& os, const BankAccount& b)
   {
      os << "(";
      os << "'";
      os << b.bankAccNo;
      os << "'";
      os << ", ";

      os << "'";
      os << b.accNo;
      os << "'";
      os << ")";

   }
};

int BankAccount::currID = 100;
int BankAccount::currBankID = 1000;
const char BankAccount::tableName[] = "BankAccount";




struct BankCard
{
   static const char tableName[];
   static int currCard;

   int cardNo;
   string type;
   int balance;
   string expDate;

   int accNo;
   int bankAcc;

   BankCard()
   {
      cardNo = currCard++;
      type = "credit card";
      balance = rand()%10000;
      expDate = "2020-12-31";
   }

   friend ostream& operator<<(ostream& os, const BankCard& bc)
   {
      os << "(";
      os << "'";
      os << bc.cardNo;
      os << "'";
      os << ", ";

      os << "'";
      os << bc.type;
      os << "'";
      os << ", ";

      os << bc.balance;
      os << ", ";

      os << "'";
      os << bc.expDate;
      os << "'";
      os << ", ";

      os << "'";
      os << bc.accNo;
      os << "'";
      os << ", ";

      os << "'";
      os << bc.bankAcc;
      os << "'";
      os << ")";
   }
};
const char BankCard::tableName[] = "BankCard";
int BankCard::currCard = 147483647;


struct Transaction
{
};

// struct Message
// {
// };

struct SocialMedia
{
   static const char tableName[];

   static int currID;

   string socialAcc;
   string type;
   int accNo;

   SocialMedia()
   {
      if(currID%2) socialAcc = "owner" + to_string(currID);
      else socialAcc = "renter" + to_string(currID);

      type = "facebook";

      string temp = "100";
      accNo = stoi(temp + to_string(currID++));
   }

   friend ostream& operator<<(ostream& os, const SocialMedia& sm)
   {
      os << "(";
      os << "'";
      os << sm.socialAcc;
      os << "'";
      os << ", ";


      os << "'";
      os << sm.type;
      os << "'";
      os << ", ";

      os << "'";
      os << sm.accNo;
      os << "'";
      os << ")";
   }
};
int SocialMedia::currID = 100;
const char SocialMedia::tableName[] = "SocialMedia";


template <class T> void writeToFile(const char[], T[], string, int);
template <class T> int storeData(const char[], T*, int, int);
template <class T> int fill(T*, int, T*, int, int);
void writeExcess(const char[], const char[]);



int main(int argc, char const *argv[])
{
   ofstream fout(outName);
   fout.close();
   writeExcess("admin.txt", outName);


   Account aData[DATALIMIT];
   storeData<string> ("passwords.txt", &aData[0].password, (&aData[1].password - &aData[0].password), DATALIMIT);
   storeData<string> ("fNames.txt", &aData[0].fname, (&aData[1].fname - &aData[0].fname), DATALIMIT);
   storeData<string> ("lNames.txt", &aData[0].lname, (&aData[1].lname - &aData[0].lname), DATALIMIT);
   storeData<string> ("streets.txt", &aData[0].streetName, (&aData[1].streetName - &aData[0].streetName), DATALIMIT);
   storeData<string> ("streetSuffixes.txt", &aData[0].streetType, (&aData[1].streetType - &aData[0].streetType), DATALIMIT);
   writeToFile<Account>(outName, aData, Account::tableName, DATALIMIT);

   
   Profile pData[DATALIMIT];
   storeData<string> ("emailSuffixes.txt", &pData[0].email, (&pData[1].email - &pData[0].email), DATALIMIT);
   storeData<string> ("profilePictures.txt", &pData[0].pictureName, (&pData[1].pictureName - &pData[0].pictureName), DATALIMIT);
   for(int i = 0; i < DATALIMIT; i++) { pData[i].email = aData[i].fname + "_" + aData[i].lname + pData[i].email; }
   writeToFile<Profile>(outName, pData, Profile::tableName, DATALIMIT);

   Car cData[DATALIMIT/2];
   storeData<string> ("streets.txt", &cData[0].streetName, (&cData[1].streetName - &cData[0].streetName), DATALIMIT/2);
   storeData<string> ("streetSuffixes.txt", &cData[0].streetType, (&cData[1].streetType - &cData[0].streetType), DATALIMIT/2);
   storeData<string> ("carModels.txt", &cData[0].model, (&cData[1].model - &cData[0].model), DATALIMIT/2);
   storeData<string> ("carDesc.txt", &cData[0].desc, (&cData[1].desc - &cData[0].desc), DATALIMIT/2);
   storeData<string> ("brand.txt", &cData[0].brand, (&cData[1].brand - &cData[0].brand), DATALIMIT/2);
   storeData<string> ("fuelType.txt", &cData[0].fuelType, (&cData[1].fuelType - &cData[0].fuelType), DATALIMIT/2);
   storeData<string> ("bodyType.txt", &cData[0].bodyType, (&cData[1].bodyType - &cData[0].bodyType), DATALIMIT/2);
   writeToFile<Car>(outName, cData, Car::tableName, DATALIMIT/2);

   CarImage ciData[DATALIMIT/2];
   storeData<string> ("carImages.txt", &ciData[0].imageFileName, (&ciData[1].imageFileName - &ciData[0].imageFileName), DATALIMIT/2);
   writeToFile<CarImage>(outName, ciData, CarImage::tableName, DATALIMIT/2);


   Booking bData[DATALIMIT/2];
   writeToFile<Booking>(outName, bData, Booking::tableName, DATALIMIT/2);


   Receipt rData[DATALIMIT/2];
   writeToFile<Receipt>(outName, rData, Receipt::tableName, DATALIMIT/2);

   
   const int MAXREV = 50;
   Review reData[MAXREV];
   for(int i = 0; i < MAXREV; i++)
   {
      reData[i].plateNum = cData[i].plateNum;
      reData[i].owner = cData[i].accNo;
   }
   storeData<string> ("reviews.txt", &reData[0].content, (&reData[1].content - &reData[0].content), MAXREV);
   writeToFile<Review>(outName, reData, Review::tableName, MAXREV);


   BankAccount baData[DATALIMIT];
   writeToFile<BankAccount>(outName, baData, BankAccount::tableName, DATALIMIT);


   BankCard bcData[DATALIMIT];
   for(int i = 0; i < DATALIMIT; i++)
   {
      bcData[i].accNo = baData[i].accNo;
      bcData[i].bankAcc = baData[i].bankAccNo;
   }
   writeToFile<BankCard>(outName, bcData, BankCard::tableName, DATALIMIT);


   SocialMedia smData[DATALIMIT];
   writeToFile<SocialMedia>(outName, smData, SocialMedia::tableName, DATALIMIT);

   writeExcess("excess.txt", outName);

   return 0;
}


void writeExcess(const char inName[], const char outName[])
{
   ifstream fin(inName);
   ofstream fout(outName, ios_base::app);

   string temp;
   getline(fin, temp);
   while(!fin.eof())
   {
      fout << temp;
      fout << "\n";
      getline(fin, temp);
   }
   fout << "\n\n\n";
   fin.close();
   fout.close();


}

template <class T>
int storeData(const char fileName[], T* data, int blockSize, int length)
{
   ifstream fin;
   fin.open(fileName);
   if(!fin.good()) {cerr << "IOERROR: Program will exit" << endl; exit(1);}

   int i = 0;
   // fin >> (*data);
   getline(fin, *data);
   i++;
   while(i < length && !fin.eof())
   {
      data = data + blockSize;
      // fin >> (*data);
      getline(fin, *data);
      i++;
   }
   fin.close();

   if(i < length) //REPEAT DATA IF NOT ENOUGH
   {
      cerr << "--- Insufficent data in file " << fileName << endl;
      i = fill<T>(data - ((i-1)*blockSize) , i, data, blockSize, length);
   }
   return i;
}

template <class T>
int fill(T* start, int total, T* curr, int blockSize, int length)
{
   int i = total - 1;
   while(i < length)
   {
      *curr = *(start + ((rand() % (total-1))*blockSize));
      curr = curr + blockSize;
      i++;
   }

   return i;
}



template <class T>
void writeToFile(const char fileName[], T data[], string type, int length)
{
   ofstream fout;
   fout.open(fileName, ios_base::app);
   if(!fout.good()) {cerr << "IOERROR: Program will exit" << endl; exit(1);}

   fout << "INSERT INTO ";
   fout << type;
   fout << " \nVALUES \n";

   for(int i = 0; i < length; i++)
   {
      fout << data[i];

      if(i != length - 1) fout << ", \n"; //SEPERATOR
      else fout << ";";
   }
   fout << "\n\n\n";

   fout.close();
}
