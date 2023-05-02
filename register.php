<?php session_start(); 
// Check if the user is already logged in, if yes then redirect him to shop page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: shop.php");
    exit;
}
include('connect.php'); ?>
<!DOCTYPE HTML>
<html>
 <head>
    <title>LOGIN</title>
 </head>
<body>
<h1>Already registered</h1>
<section>
    <form action="register.php" method="POST">
        <label>Username</label>
        <input type="text" name="username"><br />
        <label>Password</label>
        <input type="text" name="password">
        <input type="submit" name="submit1">
    </form>
</section>
<h1>New user</h1>
<section>
    <form action="register.php" method="POST">
        <label>Username</label>
        <input type="text" name="new-username"><br />
        <label>Password</label>
        <input type="text" name="new-password"><br />
        <label>Confirm new password</label>
        <input type="text" name="confirm-password">
        <input type="submit" name="submit2">
    </form>
</section>
<?php
if (isset($_POST['submit1'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['loggedin'] = true;
        header('location: shop.php');
    } else {
        echo "That user does not exist";
    }
}
require_once('connect.php');
if(isset($_POST['submit2'])){
    $newUsername = $_POST['new-username'];
    $newPassword = $_POST['new-password'];
    $sql = "INSERT INTO users (username, passwords) VALUES ('$newUsername','$newPassword')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['loggedin'] = true;
        header('location: shop.php');
    }
}
?>
</body>
</html>