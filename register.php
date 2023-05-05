<?php session_start(); 
// Check if the user is already logged in, if yes then redirect him to shop page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: shop.php");
    exit;
}
include('connect.php'); 
// paste all items from db
?>
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
        <input type="text" name="username" required><br />
        <label>Password</label>
        <input type="text" name="password" required>
        <input type="submit" name="submit1">
    </form>
</section>
<h1>New user</h1>
<section>
    <form action="register.php" method="POST">
        <label>Username</label>
        <input type="text" name="new-username" required><br />
        <label>Password</label>
        <input type="text" name="new-password" required><br />
        <input type="submit" name="submit2">
    </form>
</section>
<?php
if (isset($_POST['submit1'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $query = mysqli_query($conn, $sql);
    $usersArr = mysqli_fetch_assoc($query);
    foreach ($usersArr as $x => $x_value) {
        echo "Key=" . $x . ", Value=" . $x_value;
        echo "<br>";
    }
    if ($query) {
        $_SESSION['loggedin'] = true;
        $_SESSION['loggedas'] = $username;
        header('location: shop.php');
        
    } else {
        echo "That user does not exist";
    }
}
if (isset($_POST['submit2'])){
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