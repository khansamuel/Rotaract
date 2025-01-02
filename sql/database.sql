CREATE DATABASE Rotaract;
USE Rotaract;

-- Users Table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(40),
    email VARCHAR(60),
    password VARCHAR(100),
    date_joined DATE DEFAULT (CURRENT_DATE)
);

-- Contribution Type Table
CREATE TABLE contribution_type (
    type_id INT PRIMARY KEY AUTO_INCREMENT,
    contribution_name VARCHAR(39),
    amount_per_member INT,
    deadline DATE
);

-- Contributions Table
CREATE TABLE contributions (
    contribution_id INT PRIMARY KEY AUTO_INCREMENT,
    amount INT,
    contribution_date DATE,
    contributor_id INT,
    contribution_type_id INT,
    balance INT DEFAULT 0,
    FOREIGN KEY (contributor_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (contribution_type_id) REFERENCES contribution_type(type_id) ON DELETE SET NULL
);


alter table users
add column user_role varchar(30);

CREATE TABLE messages(message_id INTEGER PRIMARY KEY AUTO_INCREMENT,
message varchar(300),
date_sent varchar(20),
receiver_id integer,
foreign key (receiver_id) references users(user_id));

-- MPESA UPDATES

use rotaract;
create table mpesa_codes(code_id INTEGER PRIMARY KEY AUTO_INCREMENT,
mpesa_code VARCHAR(200),
member_paid INTEGER,
FOREIGN KEY (member_paid) REFERENCES users(user_id));


ALTER TABLE mpesa_codes ADD COLUMN contribution_name VARCHAR(90);
ALTER TABLE mpesa_codes ADD COLUMN contributor_email VARCHAR(90);
ALTER TABLE mpesa_codes ADD COLUMN amount_paid INTEGER;
ALTER TABLE mpesa_codes ADD COLUMN contribution_status VARCHAR(90);