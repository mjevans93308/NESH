/*These are all the Tables*/

/*Use the username and the password to login*/
Create Table Members(
uid int NOT NULL PRIMARY KEY AUTO_INCREMENT,
first varchar(20) NOT NULL,
last varchar(20) NOT NULL,
email varchar(20) NOT NULL UNIQUE,
username varchar(20) NOT NULL UNIQUE,
password varbinary(48) NOT NULL
);

/*Product name is linked with uid*/
Create Table Products(
product varchar(30) NOT NULL UNIQUE,
uid int NOT NULL UNIQUE,
pid int NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT,
tag0 varchar(30),
tag1 varchar(30),
tag2 varchar(30),
tag3 varchar(30),
tag4 varchar(30),
);

ALTER TABLE Products
ADD CONSTRAINT fk_user
FOREIGN KEY(uid) REFERENCES Members(uid)
ON DELETE CASCADE;

ALTER TABLE Products
ADD CONSTRAINT fk_product
FOREIGN KEY(pid) REFERENCES Members(pid)
ON DELETE CASCADE;

Create Table Hash_Products(
pid int NOT NULL Primary Key UNIQUE,
hash_number int NOT NULL);

ALTER TABLE Hash_Products
ADD CONSTRAINT fk_products
FOREIGN KEY(pid) REFERENCES Products(pid)
ON DELETE CASCADE;

Create Table Session(
hash_number int NOT NULL,
usession_id varchar(20) Primary Key NOT NULL,
tag0 varchar(30),
tag1 varchar(30),
tag2 varchar(30),
tag3 varchar(30),
tag4 varchar(30),
event_id int NOT NULL,
c_timestamp TIMESTAMP NOT NULL
);

ALTER TABLE Session
ADD CONSTRAINT fk_session
Foreign KEY(hash_number) References Hash_Products(hash_number)
ON DELETE CASCADE;

Create Table Events(
hash_number int NOT NULL,
event_id int Primary Key NOT NULL AUTO_INCREMENT,
description varchar(50) NOT NULL
);

ALTER TABLE Events
ADD CONSTRAINT fk_hash
FOREIGN KEY (hash_number) REFERENCES Hash_Products(hash_number);

ALTER TABLE Events
ADD CONSTRAINT fk_events
FOREIGN KEY (event_id) REFERENCES Session(event_id);
