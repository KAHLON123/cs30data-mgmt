<?php 
session_start();
// Check if the user is logged in, if not then redirect to login page
if ( $_SESSION["loggedin"] !== true){
    header("location: register.php");
    exit;
}
include('connect.php'); 
$sql = "SELECT `ID`, `username`, `passwords` FROM `users` WHERE 1";
$query = mysqli_query($conn, $sql);
var_dump($query);
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: register.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>STORE</title>
</head>
<body>
<h1>da  mall</h1>
<h2>les gooo</h2>
<img src="img/walmart-logo.jpeg"><br />
<h1>Toggle items into/out of cart: </h1>
<!-- <section>
    <form action="shop.php" method="POST">
        <option value="1">Car</option>
        <option value="2">Diesel</option>
        <option value="3">Coffee</option>
        <option value="4">Food</option>
        <input type="submit" value="submit"><br />
        
    </form>
</section> -->
<p> <a href="shop.php?logout='1'" style="color: red;">logout</a> </p>
<input type="checkbox" name="car" value="checkbox_value">
<img src="img/daCar.png" width="500"><br />
<input type="checkbox" name="diesel" value="checkbox_value">
<img src="img/vin-diesel.jpg"> <br />
<input type="checkbox" name="coffee" value="checkbox_value">
<img src="img/coffee.jpg" width="500"> <br />
<input type="checkbox" name="food" value="checkbox_value">
<img src="img/food-img.jpg" width="500"> <br />
<label>Add</label>

<?php
if (isset($_POST['submit'])){
    $sql = "SELECT `ID`, `username`, `passwords` FROM `users` WHERE 1";
    echo "hi";
}
if (isset($_POST['logout'])) {
    echo "yo";
    $_SESSION['loggedin'] = false;
    header("location: register.php");
}
?>

</body>
</html>