drop database if exists dreamhome;
Create database DreamHome;
use dreamhome;

CREATE USER IF NOT EXISTS  'kiki'@'%'  IDENTIFIED BY 'andelous';
 
create table if not exists user(
id int primary key auto_increment,
email varchar(255) not null,
password varchar(255) not null,
created_at datetime not null,
updated_at datetime not null,
CONSTRAINT unique_email UNIQUE (email) 

);

create table if not exists propertyType(
id int primary key auto_increment,
name varchar(100) not null,
created_at datetime not null,
updated_at datetime not null,
CONSTRAINT unique_name UNIQUE (name) 
);

create table if not exists transactionType(
id int primary key auto_increment,
name varchar(100) not null,
created_at datetime not null,
updated_at datetime not null,
CONSTRAINT unique_name UNIQUE (name) 
);

drop table if exists listing;
create table if not exists listing(
id int primary key auto_increment,
title varchar(255) not null,
description text not null,
price int not null,
city varchar(150) not null,
image_url varchar(255),
property_type_id int,
transaction_type_id int,
user_id int,
created_at datetime not null,
updated_at datetime not null,
constraint pk_property_type_id foreign key (property_type_id) references propertyType (id),
CONSTRAINT pk_transaction_type_id foreign key (transaction_type_id) references transactionType (id),
constraint pk_user_id foreign key (user_id) references user (id)
);

insert into user(email,password, created_at, updated_at) 
values('user1@gmail.com', 'Azerty?1234', now(), now());


insert into propertyType(name, created_at, updated_at) values
('house', now(), now()),
('appartment', now(), now());


insert into transactionType(name, created_at, updated_at) values
('rent', now(), now()),
('sale', now(), now());



insert into listing (title,description,price,city, image_url, property_type_id,transaction_type_id, user_id,created_at, updated_at) values
('Appartement T2', 'Studio centre-ville', 1000,'Nice', 'img/img5.jpg',2, 1,1, now(),now()); 
insert into listing (title,description,price,city, image_url, property_type_id,transaction_type_id, user_id,created_at, updated_at) values
('Villa', 'Villa au bord de mer', 450000,'Nice', 'img/img1.jpg',1, 2,1, now(),now()); 


SELECT l.*, pt.name AS property_type, tt.name AS transaction_type
FROM listing l
JOIN propertyType pt ON l.property_type_id = pt.id
JOIN transactionType tt ON l.transaction_type_id = tt.id
WHERE pt.name = 'Appartment';


ALTER TABLE user ADD COLUMN role ENUM('user', 'agent', 'admin') DEFAULT 'user';
insert into user(email,password, created_at, updated_at,role) 
values('agent1@gmail.com', 'Agent?1234', now(), now(), 'agent');
insert into user(email,password, created_at, updated_at,role) 
values('admin1@gmail.com', 'Admin?1234', now(), now(), 'admin');

CREATE TABLE favorite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    listing_id INT NOT NULL,
    UNIQUE(user_id, listing_id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (listing_id) REFERENCES listing(id)
);