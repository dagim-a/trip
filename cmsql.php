<?php

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('connection failed:' . mysqli_connect_error());
}


$sql = "CREATE DATABASE IF NOT EXISTS Trip";
if (mysqli_query($conn, $sql)) {
    mysqli_select_db($conn, "Trip");
} else {
    echo "could not create database:", mysqli_error($conn);
}

// Create user table FIRST
$sql = "CREATE TABLE IF NOT EXISTS user(
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(254) UNIQUE NOT NULL,
    Password_hash VARCHAR(60) NOT NULL
)";
$qur = mysqli_query($conn, $sql);
if (!$qur) {
    echo 'could not create user table:' . mysqli_error($conn) . '<br>';
}

// Now create Trip table (after user table exists)
$sql = "CREATE TABLE IF NOT EXISTS Trip(
    Id INT AUTO_INCREMENT PRIMARY KEY,
    img VARCHAR(255) DEFAULT NULL,
    Trip_name VARCHAR(100) NOT NULL,
    Destination VARCHAR(100) NOT NULL,
    Start_date DATE NOT NULL,
    End_date DATE NOT NULL,
    Trip_description TEXT NOT NULL,
    Email VARCHAR(254) NOT NULL,
    transportation_type VARCHAR(100) NOT NULL,
    Number_of_Travelers INT NOT NULL,
    status ENUM('planned', 'in_progress', 'completed', 'canceled') NOT NULL DEFAULT 'planned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    userId INT NOT NULL,
    FOREIGN KEY (userId) REFERENCES user(Id)
)";
mysqli_select_db($conn, "Trip");
$qur = mysqli_query($conn, $sql);
if (!$qur) {
    echo 'could not create Trip table:' . mysqli_error($conn) . '<br>';
}

// Create user_info table
$sql = "CREATE TABLE IF NOT EXISTS user_info(
    userId INT,
    FOREIGN KEY (userId) REFERENCES user(Id),
    Name VARCHAR(254) NOT NULL,
    Phone VARCHAR(15) NULL,
    Country VARCHAR(100) NULL,
    Travel_level ENUM('Bronze', 'Silver', 'Gold') NOT NULL DEFAULT 'Bronze',
    Travel_preferences TEXT,
    Trip_taken INT NOT NULL DEFAULT 0,
    Favorite_destination VARCHAR(100)
)";
$qur = mysqli_query($conn, $sql);
if (!$qur) {
    echo "could not create user_info table: " . mysqli_error($conn) . '<br>';
}

// booking table
$sql = "CREATE TABLE IF NOT EXISTS Booking(
    Id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    TripId INT NOT NULL,
    FOREIGN KEY (userId) REFERENCES user(Id),
    FOREIGN KEY (TripId) REFERENCES Trip(Id)
)";
mysqli_select_db($conn, "Trip");
$qur = mysqli_query($conn, $sql);
if (!$qur) {
    echo 'could not create Booking table:' . mysqli_error($conn) . '<br>';
}
