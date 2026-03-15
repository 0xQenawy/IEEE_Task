CREATE DATABASE auth_system;

USE auth_system;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(100),
 username VARCHAR(50) UNIQUE,
 email VARCHAR(100),
 password VARCHAR(255)
);
