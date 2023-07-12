<?php
include_once('config.php');

//check if update button is set and not null
if (isset($_POST['update'])) {
    $id = $_POST['update_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    //query to update employee that matches the id from url
    $query = "update employees set name='{$name}',phone='{$phone}',email='{$email}' where employee_code = '{$id}'";
    
    //run the query
    $result = mysqli_query($conn,$query);
    if($result){
        echo "<script>alert('Data Updated')</script>";
        header("Location:index.php");
    }
}
