<?php session_start(); 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
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
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if (isset($_POST['submit1'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `users` WHERE 1";
    $query = mysql_query($sql, $conn);
    echo ``;
}

require_once('connect.php');
if(isset($_POST['submit2'])){
    echo "hi";
    $newUsername = $_POST['new-username'];
    $newPassword = $_POST['new-password'];
        $sql = "INSERT INTO users (username, passwords) VALUES ('$newUsername','$newPassword')";
$result=mysql_query($conn,$sql);
if($result){
return"Suck";
}
else{
return "FU";}
        // if (mysqli_query($conn, $sql)) {
        //     echo "Ready to shop!";
        //     header("location: shop.php");
        //   } else {
        //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        //   }
        //     // Close statement
        //     mysqli_stmt_close($stmt);
        // }
//helper
function indexOfUser($item, $arr) {
    for ($i = 0; $i < count($arr); $i++) {
      if ($item === $arr[$i]) {
        return $i;
      }
    }
    return -1;
  }
?>
</body>
</html>