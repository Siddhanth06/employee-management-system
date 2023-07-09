<?php
include_once('config.php');
$id = $_GET['id'];
$select_query = "select * from employees where employee_code='{$id}'";
$result = mysqli_query($conn,$select_query);
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $phone = $row['phone'];
    $email = $row['email'];
    $insert_query = "insert into archive_employees (employee_code,name,phone,email) values('{$id}','{$name}','{$phone}','{$email}')";
    $result = mysqli_query($conn,$insert_query);
}
$delete_query = "delete from employees where employee_code = '{$id}'";
if(mysqli_query($conn,$delete_query)){
    header("Location:main.php");
}