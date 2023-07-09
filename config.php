<?php
$DB_NAME = "vistaar";
$DB_HOST = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";

$conn = mysqli_connect($DB_HOST,$DB_USERNAME,$DB_PASSWORD,$DB_NAME);
if(!$conn){
    die('Connection Unsuccessfull' . mysqli_connect_error());
}

