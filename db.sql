CREATE DATABASE socialnet;

USE socialnet;

CREATE TABLE account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE,
    fullname VARCHAR(100),
    password VARCHAR(100),
    description TEXT,
    avatar VARCHAR(255)
);

CREATE TABLE friend (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender VARCHAR(100),
    receiver VARCHAR(100),
    status VARCHAR(20)
);
