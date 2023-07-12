<?php
$DB_NAME = "vistaar";
$DB_HOST = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";

// connection to database
$conn = mysqli_connect($DB_HOST,$DB_USERNAME,$DB_PASSWORD,$DB_NAME);

// if connection failed die and show error
if(!$conn){
    die('Connection Unsuccessfull' . mysqli_connect_error());
}

