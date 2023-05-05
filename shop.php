<?php 
session_start();
// Check if the user is logged in, if not then redirect to login page
if ( $_SESSION["loggedin"] == false){
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

<input type="checkbox" name="car" value="checkbox_value">
<input type="checkbox" name="diesel" value="checkbox_value">
<input type="checkbox" name="coffee" value="checkbox_value">
<input type="checkbox" name="food" value="checkbox_value">
<input type="submit" value="submit">
<p> <a href="shop.php?logout='1'" style="color: red;">logout</a> </p>

<?php
//get id of favourited items from users table to display
$sql = "SELECT * FROM users WHERE favourites = '$username'"; 
$getFavSql = "SELECT * FROM items WHERE ID = '$favID'"
$getFavSql = "SELECT favourites FROM items WHERE username = '$_SESSION['loggedas']'"
$favQuery = mysqli_query($conn, $getFavSql);
JSON.parse($favQuery) ?? [];

// display favourited items
$favItemsArr = mysqli_fetch_all($favQuery);
 foreach($favItemsArr as $itemArr) {
    echo "<img src='img/" . $itemArr[0] . "' width='500'><br />";
 }
 echo $_SESSION['loggedas'];
// display all items
 $disAllSql = "SELECT img FROM items WHERE 1";
 $query = mysqli_query($conn, $disAllSql);
 $itemsArr = mysqli_fetch_all($query);
 var_dump($itemsArr);
 foreach($itemsArr as $itemArr) {
    echo "<img src='img/" . $itemArr[0] . "' width='500'><br />";
 }
if (isset($_POST['submit'])){
    $sql = "SELECT `ID`, `username`, `passwords` FROM `users` WHERE 1";
}
if (isset($_POST['logout'])) {
    $_SESSION['loggedin'] = false;
    header("location: register.php");
}
?>

</body>
</html>