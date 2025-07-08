<?php

require "cmsql.php";
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
mysqli_select_db($conn, "Trip");
$qur = mysqli_query($conn, $sql);
if (!$qur) {
    echo 'could not create table:' . mysqli_error($conn);
} else {
    echo "table created successfully";
}
mysqli_close($conn);
