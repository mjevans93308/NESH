/*Sample Queries*/

/*=============Insert===========*/
/*Insert Member*/
INSERT INTO Members (uid,first,last,email,password)
VALUES ('000001','Bryan','Silva','silva.bryan@gmail.com','558064bs');
	
/*Insert Product*/
INSERT INTO Products (product,uid)
VALUES ('Facebook','000001',0);

/*Insert Hash Number*/
INSERT INTO Hash_Products (product,hash_number)
VALUES ('Facebook','100000');

/*Insert Session with Event
TIMESTAMP - format: YYYY-MM-DD HH:MM:SS*/
INSERT INTO Session (hash_number,usession_id,event_id,c_timestamp)
VALUES ('100000','000001','01','2014-02-17 19:27:30');

/*Inserting New Events*/
INSERT INTO Events (event_id,description)
VALUES ('01','Failed Test');


/*=============Delete===========*/
/*Delete Member*/
DELETE FROM Members
WHERE email = 'silva.bryan@gmail.com';

/*Delete Product*/
DELETE FROM Products
WHERE product = 'Facebook';


/*=============Update===========*/
/*Update Member Details*/
UPDATE Members
SET password = 'scuetaho91'
WHERE email = 'silva.bryan@gmail.com' AND password = '558064bs';