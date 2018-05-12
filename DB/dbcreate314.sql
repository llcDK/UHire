create table Account(
  accNo varchar(20) NOT NULL,
  password varchar(30) NOT NULL,
  type varchar(10) NOT NULL, /* Indicates the type of users: Car renter, Car owner or Admin */
  fname varchar(50) NULL,
  lname varchar(50) NULL,
  address varchar(100) NULL,
  rating decimal(2,1) NULL,
  constraint acc_pk primary key(accNo)
);

create table Profile(
  accNo varchar(20) NOT NULL,
  dob Date NULL,
  email varchar(50) NULL,
  gender varchar(10) NULL,
  pictureName varchar(100) NULL,
  verified varchar(20) NULL,
  constraint pro_pk primary key(accNo),
  constraint pro_fk foreign key(accNo) references Account(accNo) on delete cascade  
);

create table Car(
  plateNum varchar(20) NOT NULL,
  price decimal(10,2) NOT NULL,
  available integer NOT NULL, /*1: Avaiable; 0: not avaiable*/
  location varchar(100) NOT NULL,
  carOwnerAcc varchar(20) NOT NULL,
  avaiableTo DATE NOT NULL,
  year Date NULL,
  model varchar(50) NULL,
  description varchar(500) NULL,
  brand varchar(50) NULL,
  transmission varchar(100) NULL,
  numSeat integer NULL,
  odometer integer NULL,
  fuelType varchar(30) NULL,
  bodyType varchar(50) NULL,
  constraint car_pk primary key(plateNum),
  constraint car_fk foreign key(carOwnerAcc) references Account(accNo) on delete cascade
);

create table CarImage(
  plateNum varchar(20) NOT NULL,
  imageFileName varchar(100) NOT NULL,
  constraint carimg_pk primary key(imageFileName),
  constraint carimg_fk foreign key(plateNum) references Car(plateNum)
);

create table Booking(
  accNo varchar(20) NOT NULL,
  plateNum varchar(20) NOT NULL,
  requestingTime DATETIME NOT NULL,
  bookuntil Date NOT NULL,
  deleted integer NULL, /*0: not deleted, 1: deleted*/
  constraint book_pk primary key(accNo, plateNum, requestingTime),
  constraint book_fk1 foreign key(accNo) references Account(accNo) on delete cascade,
  constraint book_fk2 foreign key(plateNum) references Car(plateNum) on delete cascade
);

/*No need for BookedDate as it can be calculated by Booking and indicated by column available*/

create table Receipt(
  accNo varchar(20) NOT NULL,
  plateNum varchar(20) NOT NULL,
  requestingTime DATETIME NOT NULL,
  moneyPaid decimal(8,2) NOT NULL,
  commision decimal(8,2) NOT NULL,
  constraint rpt_pk primary key(accNo, plateNum, requestingTime),
  constraint rpt_fk1 foreign key(accNo, plateNum, requestingTime) references Booking(accNo, plateNum, requestingTime) on delete cascade,
  constraint rpt_fk2 foreign key(accNo) references Account(accNo) on delete cascade
);

create table Review(
  renter varchar(20) NOT NULL, /* renter is renter's account number */
  owner varchar(20) NOT NULL, /* owner is owner's account number */
  timeGive Date NOT NULL,
  plateNum varchar(20) NULL,
  content varchar(300) NOT NULL, 
  rating integer NOT NULL,
  anonymous integer NOT NULL, /* 1: Anonymous, 0: Not anonymous*/
  constraint rev_pk primary key(renter, owner, timeGive),
  constraint rev_fk1 foreign key(renter) references Account(accNo) on delete cascade,
  constraint rev_fk2 foreign key(owner) references Account(accNo) on delete cascade,
  constraint rev_fk3 foreign key(plateNum) references Car(plateNum) on delete cascade
);

create table BankAccount(
  bankAccNo varchar(30) NOT NULL,
  accNo varchar(20) NULL,
  constraint bac_pk primary key(bankAccNo),
  constraint bac_fk foreign key(accNo) references Account(accNo) on delete cascade
);

create table BankCard(
  cardNo varchar(20) NOT NULL,
  type varchar(20) NOT NULL,
  balance decimal(10,2) NOT NULL,
  expireDate Date NOT NULL,
  accNo varchar(20) NOT NULL,
  bankAcc varchar(30) NULL,
  constraint card_pk primary key(cardNo),
  constraint card_fk1 foreign key(accNo) references Account(accNo) on delete cascade,
  constraint card_fk2 foreign key(bankAcc) references BankAccount(bankAccNo) on delete cascade
);

create table Transaction(
  cardNo varchar(20) NOT NULL,
  bankAccNo varchar(30) NOT NULL,
  time DATETIME NOT NULL,
  amount decimal(10,2) NOT NULL,
  commision decimal(10,2) NOT NULL,
  constraint trans_pk primary key(cardNo, bankAccNo, time),
  constraint trans_fk1 foreign key(cardNo) references BankCard(cardNo) on delete cascade,
  constraint trans_fk2 foreign key(bankAccNo) references BankAccount(bankAccNo) on delete cascade
);

create table Message(
  senderAcc varchar(20) NOT NULL,
  receiverAcc varchar(20) NOT NULL,
  time DATETIME NOT NULL,
  content varchar(800) NOT NULL,
  constraint meg_pk primary key(senderAcc, receiverAcc, time),
  constraint meg_fk1 foreign key(senderAcc) references Account(accNo) on delete cascade,
  constraint meg_fk2 foreign key(receiverAcc) references Account(accNo) on delete cascade
);

create table SocialMedia(
  socialAcc varchar(50) NOT NULL,
  type varchar(50) NOT NULL,
  accNo varchar(20) NOT NULL,
  constraint sm_pk primary key(socialAcc),
  constraint sm_fk foreign key(accNo) references Account(accNo) on delete cascade
);

create table Policy(
  content varchar(3000) NOT NULL,
  version decimal(3,1) NOT NULL,
  datePublished Date NOT NULL,
  commisionRate decimal(3,3) NOT NULL,
  adminAcc varchar(20) NOT NULL,
  sysOwnerBankAcc varchar(30) NOT NULL,
  constraint policy_fk1 foreign key(adminAcc) references Account(accNo),
  constraint policy_fk2 foreign key(sysOwnerBankAcc) references BankAccount(bankAccNo) 
);




