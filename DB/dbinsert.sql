INSERT INTO Account
VALUES ('1001', 'renterpass1', 'Car renter', 'Thanos', 'Whatever', '21 Gipps St, Keiraville', 4.5);

INSERT INTO Account
VALUES ('1002', 'renterpass2', 'Car renter', 'Ethan', 'Smith', '14 Bligh St, Wollongong', 4.2);

INSERT INTO Account
VALUES ('1003', 'renterpass3', 'Car renter', 'Chris', 'Blaze', '20A Smith St, Sydney', 4.1);

INSERT INTO Account
VALUES ('1004', 'renterpass4', 'Car renter', 'Sam', 'Smith', '10 Mangerton St, West Wollongong', 3.0);

INSERT INTO Account
VALUES ('2001', 'ownerpass1', 'Car owner', 'Sherlock', 'Holmes', '221B Baker St, Wollongong', 4.5);

INSERT INTO Account
VALUES ('2002', 'ownerpass2', 'Car owner', 'Alex', 'Reedtz', '100 Keira St, Wollongong', 3.5);

INSERT INTO Account
VALUES ('2003', 'ownerpass3', 'Car owner', 'Nicolai', 'Rossander', '21 Blaze St, Thirroul', 4.5);

INSERT INTO Account
VALUES ('1', 'admin', 'Admin', 'Tianming', 'Zhao', 'Northfields Ave, Wollongong', 5.0);



INSERT INTO Car
VALUES ('SPLY-350', 20.50, 1, 'Bligh St, Wollongong', '2001', '2010-05-10', 'Accord', null, 'Honda', 'auto',
		4, 175000, 'gas', 'sedan');
		
INSERT INTO Car
VALUES ('SPLY-375', 22.50, 0, 'Bligh St, Wollongong', '2001', '2005-05-10', 'Yaris', null, 'Toyota', 'manual',
		4, 250000, 'gas', 'sedan');
		
INSERT INTO Car
VALUES ('AXN-100', 25.50, 1, 'Keira St, Wollongong', '2002', '2010-05-20', 'Civic', null, 'Honda', 'auto',
		4, 175000, 'gas', 'sedan');
		
INSERT INTO Car
VALUES ('AXN-200', 20.50, 1, 'Blaze St, Thirroul', '2003', '2010-10-10', 'Astra', null, 'Holden', 'auto',
		4, 200000, 'diesel', 'sedan');
		
		

INSERT INTO Booking
VALUES ('1001', 'SPLY-350', '2018-04-28 11:00:00', '2018-04-30', 0);

INSERT INTO Booking
VALUES ('1002', 'AXN-100', '2018-04-20 12:00:00', '2018-04-24', 0);

INSERT INTO Booking
VALUES ('1003', 'AXN-200', '2018-04-27 11:00:00', '2018-04-29', 0);

INSERT INTO Booking
VALUES ('1004', 'SPLY-375', '2018-04-28 08:00:00', '2018-04-30', 0);

INSERT INTO Booking
VALUES ('1002', 'AXN-100', '2018-04-25 11:00:00', '2018-04-26', 0);

INSERT INTO Booking
VALUES ('1002', 'SPLY-350', '2018-04-25 10:00:00', '2018-04-26', 1);



INSERT INTO Receipt
VALUES ('2001', 'SPLY-350', '2018-04-28 11:00:00', '2018-04-30', 0);

INSERT INTO Receipt
VALUES ('2002', 'AXN-100', '2018-04-28 11:00:00', '2018-04-30', 0);

INSERT INTO Receipt
VALUES ('2003', 'AXN-200', '2018-04-28 11:00:00', '2018-04-30', 0);

INSERT INTO Receipt
VALUES ('2001', 'SPLY-375', '2018-04-28 11:00:00', '2018-04-30', 0);

INSERT INTO Receipt
VALUES ('2002', 'AXN-100', '2018-04-28 11:00:00', '2018-04-30', 0);



INSERT INTO Review
VALUES ('1001', '2001', '2018-04-31', 'SPLY-350', 'Owner is nice and friendly, brake was not really sensitive.',
		4, 0);
		
INSERT INTO Review
VALUES ('1002', '2002', '2018-04-25', 'AXN-100', 'Condition of car was in an extremely bad state.',
		1, 1);
		
INSERT INTO Review
VALUES ('1003', '2003', '2018-04-31', 'AXN-200', 'Helpful owner, car is in great state.',
		5, 1);
		
INSERT INTO Review
VALUES ('1004', '2001', '2018-04-31', 'SPLY-375', 'Ran into some minor trouble with the car.',
		3, 1);
		
INSERT INTO Review
VALUES ('1004', '2002', '2018-04-31', 'AXN-100', 'Overall was a good experience.',
		5, 1);
		

		
INSERT INTO BankAccount
VALUES ('11001', '1001');

INSERT INTO BankAccount
VALUES ('11002', '1002');

INSERT INTO BankAccount
VALUES ('11003', '1003');

INSERT INTO BankAccount
VALUES ('11004', '1004');

INSERT INTO BankAccount
VALUES ('22001', '2001');

INSERT INTO BankAccount
VALUES ('22002', '2002');

INSERT INTO BankAccount
VALUES ('22003', '2003');

INSERT INTO BankAccount
VALUES ('11', '1');



INSERT INTO BankCard
VALUES ('0123456789012345', 'credit card', 1000.00, '2020-12-31', '1001', '11001');

INSERT INTO BankCard
VALUES ('1234567890123456', 'credit card', 2000.00, '2020-12-31', '1002', '11002');

INSERT INTO BankCard
VALUES ('2345678901234567', 'credit card', 1500.00, '2020-12-31', '1003', '11003');

INSERT INTO BankCard
VALUES ('3456789012345678', 'credit card', 5000.00, '2020-12-31', '1004', '11004');

INSERT INTO BankCard
VALUES ('4567890123456789', 'credit card', 4000.00, '2021-12-31', '2001', '22001');

INSERT INTO BankCard
VALUES ('5678901234567890', 'credit card', 5000.00, '2021-12-31', '2002', '22002');

INSERT INTO BankCard
VALUES ('6789012345678901', 'credit card', 3000.00, '2021-12-31', '2003', '22003');

INSERT INTO BankCard
VALUES ('7890123456789012', 'credit card', 10000.00, '2019-12-31', '1', '11');



INSERT INTO Transaction 
VALUES ('0123456789012345', '11001', '2018-04-01 18:00:00', 1000.00, 0.10);

INSERT INTO Transaction 
VALUES ('1234567890123456', '11002', '2018-04-02 18:00:00', 2000.00, 0.10);

INSERT INTO Transaction 
VALUES ('2345678901234567', '11003', '2018-04-01 18:00:00', 1000.00, 0.10);

INSERT INTO Transaction 
VALUES ('3456789012345678', '11004', '2018-04-05 10:00:00', 1500.00, 0.10);

INSERT INTO Transaction 
VALUES ('4567890123456789', '22001', '2018-04-01 12:00:00', 1000.00, 0.10);

INSERT INTO Transaction 
VALUES ('5678901234567890', '22002', '2018-04-10 18:00:00', 2000.00, 0.10);

INSERT INTO Transaction 
VALUES ('6789012345678901', '22003', '2018-04-10 20:00:00', 2000.00, 0.10);



INSERT INTO Message
VALUES ('1001', '2001', '2018-04-27 12:00:00', 'May I ask where you park your car?');

INSERT INTO Message
VALUES ('1001', '2001', '2018-04-19 12:00:00', 'May I ask where you park your car?');

INSERT INTO Message
VALUES ('1001', '2001', '2018-04-26 15:00:00', 'I will be there in 15 mins.');

INSERT INTO Message
VALUES ('1001', '2001', '2018-04-27 09:00:00', 'May I ask where you park your car?');

INSERT INTO Message
VALUES ('1001', '2001', '2018-04-24 12:00:00', 'I will be there in 30 mins.');



INSERT INTO SocialMedia
VALUES ('100001', 'Facebook', '1001');

INSERT INTO SocialMedia
VALUES ('100002', 'Facebook', '1002');

INSERT INTO SocialMedia
VALUES ('100003', 'Facebook', '1003');

INSERT INTO SocialMedia
VALUES ('100004', 'Facebook', '1004');

INSERT INTO SocialMedia
VALUES ('200001', 'Facebook', '2001');

INSERT INTO SocialMedia
VALUES ('200002', 'Facebook', '2002');

INSERT INTO SocialMedia
VALUES ('200003', 'Facebook', '2003');

INSERT INTO SocialMedia
VALUES ('100000', 'Facebook', '1');


INSERT INTO Policy
VALUES ('abc', 1.0, '2018-03-01', 10.000, '1', '11');



		