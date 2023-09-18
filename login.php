<!-- login.php : 
What it does:
    - Logs in users -> allowed to access up_for_adoption and adoption_process
    - Logs in admin -> allowed to go to Up_for_adoption_admin and up_for_adoption_admin_edit -->


<!DOCTYPE html>
<html lang="EN">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Grow A Pup</title>
    <link rel="icon" type="image/x-icon" href="/images/logo.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<header>
    <div class="logo"><a href="/growapup/index.php">
            <img src="/growapup/images/logo.png" alt="logo" /> </a>
    </div>
    <div class="header-content">
        <h1> Welcome to Grow A Pup</h5>
            <h3> Adoption Edition </h3>
    </div>
</header>

<body>
    <form method="post" action="login.php">
        <div class="form-container login-form-container">
            <!-- <label for="name">Name:</label><br>
            <input type="text" name="name" placeholder="name"><br> -->
            <label for="username">Username:</label><br>
            <input type="text" name="username" placeholder="username"><br>

            <label for="password">Password</label><br>
            <input type="password" name="password"><br>

            <input type="submit" value="Login" name="login-button" class="indexbutton">
        </div>
    </form>
</body>

</html>


<?php
include_once 'dbconnection.php';
session_start();
//was the login form submitted? CHECK
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['logout-submit'])) {
        //if logout is active -> destroy session to log the user out
        session_destroy();
        var_dump($_SESSION);
    }
    //store user input:
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $adminPassword = password_hash('adminpassword', PASSWORD_DEFAULT);

    var_dump($username);
    var_dump($_POST['password']);

    if ($username === 'admin' && password_verify($_POST['password'], $adminPassword)) {
        //admin login successful
        $_SESSION['adminLoggedIn'] = true;
        $_SESSION['role'] = 'admin';
        header("Location: up_for_adoption_admin.php");
        var_dump($username);
        die();
    }
    //sql query - insert user's input into the 'users' table in db
    $insertQuery = $conn->prepare(
        "INSERT INTO users (username, password) VALUES (:username, :password)"
    );
    $insertQuery->bindParam(':username', $username);
    $insertQuery->bindParam(':password', $password);
    $insertQuery->execute();
    $results = $insertQuery->fetch();
    //:username placeholder - bound to a specific value when the query is executed
    $loginQuery = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $loginQuery->bindParam(':username', $_POST['username']);
    $loginQuery->execute();
    $results = $loginQuery->fetch();

    if ($results) {
        // Verify the password
        if (password_verify($_POST['password'], $results['password']) && !($username === 'admin' && password_verify($_POST['password'], $adminPassword))) {
            // Password is correct, set session variables, and redirect
            $_SESSION['loggedIn'] = true;
            $_SESSION['adoption'] = array();
            $_SESSION['role'] = 'user';
            header("Location: index.php");
            die();
        }
    }
    header("Location: login.php");
}
if (isset($_SESSION['adminLoggedIn']) || isset($_SESSION['loggedIn'])) {
    // Redirect to a different page or display a message
    header("Location: index.php");
    exit(); // Terminate the script to prevent further execution
}
?>