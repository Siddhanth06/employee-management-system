<?php
include_once('config.php');

//get the user id from url
$id = $_GET['id'];

//select employee record from table that matched with the id
$select_query = "select * from employees where employee_code='{$id}'";

//run the query
$result = mysqli_query($conn,$select_query);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $phone = $row['phone'];
    $email = $row['email'];

    //insert the deleted record into archive employees table
    $insert_query = "insert into archive_employees (employee_code,name,phone,email) values('{$id}','{$name}','{$phone}','{$email}')";
    
    //run the query
    $result = mysqli_query($conn,$insert_query);
}

//delete employee that matched the id
$delete_query = "delete from employees where employee_code = '{$id}'";

if(mysqli_query($conn,$delete_query)){
    //redirect to index page
    header("Location:index.php");
}