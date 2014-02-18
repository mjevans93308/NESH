/*These are all the Tables*/
Create Table Members(
uid varchar(20) NOT NULL PRIMARY KEY UNIQUE,
first varchar(20) NOT NULL,
last varchar(20) NOT NULL,
email varchar(20) NOT NULL UNIQUE,
password varbinary(48) NOT NULL
);

Create Table Products(
product varchar(30) NOT NULL UNIQUE,
uid varchar(20) NOT NULL PRIMARY KEY UNIQUE,
counter int NOT NULL AUTO INCREMENT UNIQUE
);

ALTER TABLE Products
ADD CONSTRAINT fk_product
FOREIGN KEY(uid) REFERENCES members(uid)
ON DELETE CASCADE;

Create Table Hash_Products(
counter int NOT NULL UNIQUE,
hash_number int PRIMARY KEY NOT NULL);

ALTER TABLE Hash_Products
ADD CONSTRAINT fk_products
FOREIGN KEY(product) REFERENCES Products(product)
ON DELETE CASCADE;

Create Table Session(
hash_number int NOT NULL,
usession_id varchar(20) Primary Key NOT NULL,
event_id int NOT NULL,
c_timestamp TIMESTAMP
);

ALTER TABLE Session
ADD CONSTRAINT fk_session
Foreign KEY(hash_number) References Hash_Products(hash_number)
ON DELETE CASCADE;

Create Table Events(
event_id int Primary Key NOT NULL,
description varchar(50) NOT NULL
);

ALTER TABLE Events
ADD CONSTRAINT fk_events
FOREIGN KEY (event_id) REFERENCES Session(event_id);

/*
Drop Table Events;
Drop Table Session;
Drop Table Hash_Products;
Drop Table Products;
Drop Table Members;
*/