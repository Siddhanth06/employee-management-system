<?php
include_once('config.php');
if (isset($_POST['update'])) {
    $id = $_POST['update_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $query = "update employees set name='{$name}',phone='{$phone}',email='{$email}' where employee_code = '{$id}'";
    $result = mysqli_query($conn,$query);
    if($result){
        echo "<script>alert('Data Updated')</script>";
        header("Location:index.php");
    }
}
