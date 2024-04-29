CREATE DATABASE covid_tracker;

USE covid_tracker;

CREATE TABLE covaxin (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    date_requested DATE NOT NULL
);

CREATE TABLE covishield (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    date_requested DATE NOT NULL
);
