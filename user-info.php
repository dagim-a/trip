<?php

require "cmsql.php";
$sql = "CREATE TABLE IF NOT EXISTS user_info(
    userId INT,
    FOREIGN KEY (userId) REFERENCES user(Id),
    Name VARCHAR(254) NOT NULL,
    Phone VARCHAR(15) NOT NULL,
    Country VARCHAR(100) NOT NULL,
    Travel_level ENUM('Bronze', 'Silver', 'Gold') NOT NULL,
    Travel_preferences TEXT,
    Trip_taken INT NOT NULL DEFAULT 0,
    Favorite_destination VARCHAR(100)
)";
mysqli_select_db($conn, "Trip");
$qur = mysqli_query($conn, $sql);
if (!$qur){
    die("could not create table: " .mysqli_error($conn));
}else {
    echo "table created successfully<br>";
}
mysqli_close($conn);

?>