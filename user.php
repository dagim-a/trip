<?php

require "cmsql.php";
$sql = "CREATE TABLE IF NOT EXISTS user(
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(254) /* CHECK(email ~* '^[^@]+@[^@]+\.com$')*/ UNIQUE NOT NULL,
    Password_hash VARCHAR(60) NOT NULL
)";
mysqli_select_db($conn, "Trip");
$qur=mysqli_query($conn,$sql);
if(!$qur){
    echo 'could not create table:'.mysqli_error($conn);
} else {
    echo "table created successfully";
}
mysqli_close($conn);

?>