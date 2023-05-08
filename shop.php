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
<section>
    <form action="shop.php" method="POST">
    <select name="selection">
        <option value="1">Add to favourites</option>
        <option value="2">Remove from favourites</option>
        <option value="3">Filter by </option>
        <option value="4">Sort by </option>
    </select>
        <input type="submit" value="submit"><br />
    </form>
</section>
<label>Car</label>
<input type="checkbox" name="car" value="checkbox_value">
<label>Diesel</label>
<input type="checkbox" name="diesel" value="checkbox_value">
<label>Coffee</label>
<input type="checkbox" name="coffee" value="checkbox_value">
<label>Food</label>
<input type="checkbox" name="food" value="checkbox_value">
<p> <a href="shop.php?logout='1'" style="color: red;">logout</a> </p>
<?php
// $favStr = JSON.parse($favQuery) ?? [];
// var_dump($favStr);
// display all items
 $disAllSql = "SELECT img FROM items WHERE 1";
 $disAllquery = mysqli_query($conn, $disAllSql);
 $itemsArr = mysqli_fetch_all($disAllquery);
 foreach($itemsArr as $itemArr) {
    echo "<img src='img/" . $itemArr[0] . "' width='500'>";
 }
if (isset($_POST['submit'])){
    switch ($_POST['selection']){
        case '1':
            add();
        case '2':
            remove();
        case '3':
            filterItems();
        case '4':
            sortItems();
        case '5':
            displayFav();
    }
}
if (isset($_POST['logout'])) {
    $_SESSION['loggedin'] = false;
    header("location: register.php");
}

function add(){

}
function remove(){

}
function filterItems(){

}
function sortItems(){

}
function displayFav(){
$getFavSql = "SELECT favourites FROM users WHERE username = '$_SESSION['loggedas']'";
$favQuery = mysqli_query($conn, $getFavSql);
$favItemsArr = mysqli_fetch_all($favQuery);
 foreach($favItemsArr as $itemArr) {
    echo "<img src='img/" . $itemArr[0] . "' width='500'><br />";
 }
}
?>
</body>
</html>