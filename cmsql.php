<?php

$dbhost='localhost:3306';
$dbuser='root';
$dbpass='';
$conn=mysqli_connect($dbhost,$dbuser,$dbpass);
if (!$conn){
    die('connection failed:'.mysqli_connect_error());
}
echo 'connected successfully<br>';

?>