<?php
include_once('config.php');

//Function to validate input data
function validateInputData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


$nameErr = $phoneErr = $emailErr = '';
$employee_name = $employee_phone = $employee_email = "";


//check if the method is post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $employee_name = validateInputData($_POST["name"]);
        // 
        if (!preg_match("/^[a-zA-Z-' ]*$/", $employee_name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $employee_email = validateInputData($_POST["email"]);
        // check if email follows a specific email format
        if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email";
        }
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $employee_phone = validateInputData($_POST["phone"]);
        // check if phone number contains only numbers and contains 10 digits only
        if (!preg_match('/^[0-9]{10}+$/', $employee_phone)) {
            $phoneErr = "Invalid phone number";
        }
    }

    //If there are no errors then execute the sql query
    if (!$nameErr && !$emailErr && !$phoneErr) {
        $sql = "insert into employees (name,phone,email) values ('{$employee_name}','{$employee_phone}','{$employee_email}')";
        if (mysqli_query($conn, $sql)) {
            echo "Employee added successfully";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="container d-flex justify-content-center min-vh-100 align-items-center">

            <div class="container d-flex flex-column align-items-center">
                <h1 class="text-center mb-5">Employee Management System</h1>

                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="John Doe" name="name">
                    <span style="color:red"><?php echo $nameErr ?></span>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="" class="form-label">Phone</label>
                    <input type="text" class="form-control" placeholder="238943968" name="phone">
                    <span style="color:red"><?php echo $phoneErr ?></span>
                </div>
                <div class="mb-4 col-md-6">
                    <label for="" class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="john@gmail.com" name="email">
                    <span style="color:red"><?php echo $emailErr ?></span>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">Add Employee</button>
                </div>
            </div>
        </div>
    </form>
    
    <hr class="mt-5">
    <div class="container">
        <h1 class="text-center mb-3 mt-5">Employees List</h1>
        <?php
        //Select all records from employee table
        $sql1 = "select * from employees";
        $result = mysqli_query($conn, $sql1);

        //check if we get atleast one record or more
        if (mysqli_num_rows($result) > 0) {
        ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Employee Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- loop through all the records -->
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['employee_code'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td>
                                <a href="#" class="editbtn btn btn-primary">Edit</a>
                                <a href="deleteEmployee.php?id=<?php echo $row['employee_code'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else{
            echo "<h4 class='text-center text-danger'>No Records Found</h4>";
        }?>
    </div>
    <hr class="mt-5">

    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Employee</h1>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="updateEmployee.php" method="post">
                        <input type="hidden" id="update_id" name="update_id">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="update_name" placeholder="John Doe" name="name">
                            <span style="color:red"><?php echo $nameErr ?></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">Phone</label>
                            <input type="text" class="form-control" placeholder="238943968" name="phone" id="update_phone">
                            <span style="color:red"><?php echo $phoneErr ?></span>
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="john@gmail.com" name="email" id="update_email">
                            <span style="color:red"><?php echo $emailErr ?></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="update">Update Employee</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <h1 class="text-center mb-3 mt-5">Archived Employees List</h1>
        <?php
        $sql2 = "select * from archive_employees";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
        ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Employee Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
                        <tr>
                            <td><?php echo $row['employee_code'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            //open modal when clicked on edit button
            $('.editbtn').on("click", function() {
                $("#editmodal").modal("show");

                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                //fill all the input fields with data 
                $('#update_id').val(data[0]);
                $('#update_name').val(data[1]);
                $('#update_phone').val(data[2]);
                $('#update_email').val(data[3]);

            });
        });
    </script>
</body>

</html>