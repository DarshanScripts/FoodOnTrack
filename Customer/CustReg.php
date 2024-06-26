<?php
$fName = $lName  = $email  = $pass = $conPass = "";
if (isset($_POST['btnRegister'])) {

    //    echo "<pre>";
    //    print_r($_POST);
    //    echo"</pre>";

    $fName = $_POST['txtFName'];
    $lName = $_POST['txtLName'];
    $email = $_POST['txtEmail'];
    $pass = $_POST['txtPass'];
    $conPass = $_POST['txtConPass'];

    //    validations
    //    first name
    if (!preg_match('/^[A-Z][a-z]{1,15}$/', $fName))
        echo "<script>alert('First character of name should be capital & length should be between 2-15 characters!');</script>";

    //    last name
    if (!preg_match('/^[A-Z][a-z]{1,15}$/', $lName))
        echo "<script>alert('First character of name should be capital & length should be between 2-15 characters!');</script>";

    //    email
    elseif (!preg_match("/^[a-z][a-z0-9]+@(gmail|outlook|hotmail|yahoo|icloud)[.](com|in)$/", $email))
        echo "<script>alert('Email format is incorrect!');</script>";

    //    pass
    elseif (strlen($pass) < 5 || strlen($pass) > 8)
        echo "<script>alert('Length of Password should be between 5 to 8 characters!');</script>";

    //    confirm password
    elseif ($pass != $conPass)
        echo "<script>alert('Password & Confirm Password should be matched!');</script>";

    // terms & conditions
    elseif (!isset($_POST['chkTerms']))
        echo "<script>alert('Please agree the terms & conditions!');</script>";

    else {
        require_once '../Database/DBConnection.php';
        $sql = "SELECT * FROM Customer WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
            echo "<script>alert('Email is already registered. Try with different Email ID!');</script>";
        else {
            $sql = "INSERT INTO Customer(firstName,lastName,email,password,creationDate) VALUES(?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $fName, $lName, $email, $pass, $creationDate);
            $pass = md5($pass);
            $creationDate = date("Y-m-d h-i-s");
            $stmt->execute();
            if ($stmt)
                echo "<script>alert('Registration Successful!');window.location.replace('./CustLogin.php');</script>";
            else
                echo "<script>alert('Registration Unsuccessful!');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Food On Track</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <h1 align="center">Food On Track Customer Registration Form</h1>
    <hr>
    <form method="POST">
        <!-- First Name input -->
        <div class="form-outline mb-3">
            <input type="text" name="txtFName" class="form-control" required="" />
            <label class="form-label" for="form2Example1">First Name</label>
        </div>

        <!-- Last Name input -->
        <div class="form-outline mb-3">
            <input type="text" name="txtLName" class="form-control" required="" />
            <label class="form-label" for="form2Example1">Last Name</label>
        </div>

        <!-- Email input -->
        <div class="form-outline mb-3">
            <input type="text" name="txtEmail" class="form-control" required="" />
            <label class="form-label" for="form2Example1">Email Address</label>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-3">
            <input type="password" name="txtPass" class="form-control" required="" />
            <label class="form-label" for="form2Example2">Password</label>
        </div>

        <!-- Confirm Password input -->
        <div class="form-outline mb-3">
            <input type="password" name="txtConPass" class="form-control" required="" />
            <label class="form-label" for="form2Example2">Retype Password</label>
        </div>

        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">
            <div class="col d-flex ">
                <!-- Checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="chkTerms" id="form2Example31" checked />
                    <label class="form-check-label" for="form2Example31"> I agree the terms & conditions </label>
                </div>
            </div>
        </div>

        <!-- Submit button -->
        <button type="submit" name="btnRegister" class="btn btn-primary btn-block mb-4">Sign Up</button>

        <!-- Register buttons -->
        <div class="text-center">
            <p>Already registered? <a href="./CustLogin.php">Login</a></p>
        </div>
    </form>

</body>

</html>