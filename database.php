<?php

require "cmsql.php";
$sql="CREATE DATABASE IF NOT EXISTS Trip";
if (mysqli_query($conn, $sql)){
    echo "database created successfully<br>";
}else{
    echo "could not create database:",mysqli_error($conn);
}

?>