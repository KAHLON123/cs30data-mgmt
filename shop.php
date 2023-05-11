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
<p><a href="shop.php?logout='1'" style="color: red;">logout</a></p>
<h1>da  mall</h1>
<h2>les gooo</h2>
<img src="img/walmart-logo.jpeg"><br />
<h1>Toggle items into/out of cart: </h1>
<section>
    <form action="shop.php" method="POST">
    <select name="s">
        <option value="1">Add to favourites</option>
        <option value="2">Remove from favourites</option>
        <option value="3">Filter by </option>
        <option value="4">Alphabetize</option>
        <option value="5">Only display favourites </option>
    </select>
        <input type="submit" value="submit" name="submit"><br />
    </form>
</section>
<label>Car</label>
<input type="checkbox" value="car" name="option[]">
<label>Diesel</label>
<input type="checkbox" value="diesel" name="option[]">
<label>Coffee</label>
<input type="checkbox" value="coffee" name="option[]">
<label>Food</label>
<input type="checkbox" value="food" name="option[]">
<label>Hat 1</label>
<input type="checkbox" value="hat1" name="option[]">
<?php
// display all items
 $disAllSql = "SELECT img FROM items WHERE 1";
 $disAllquery = mysqli_query($conn, $disAllSql);
 $itemsArr = mysqli_fetch_all($disAllquery);
 foreach($itemsArr as $itemArr) {
    echo "<br /><img src='img/" . $itemArr[0] . "' width='300'>";
 }
if (isset($_POST['submit'])){
    switch ($_POST['s']){
        case "1":
            add($conn);
            break;
        case "2":
            remove($conn);
            break;
        case "3":
            filterItems();
            break;
        case "4":
            alphabetItems($itemsArr);
            break;
        case "5":
            displayFav($conn);
            break;
    }
}
if (isset($_POST['logout'])) {
    $_SESSION['loggedin'] = false;
    unset($_SESSION['loggedas']);
    header("location: register.php");
}

function add($conn){
    // parse array of favourite item IDs 
    $curr_user = $_SESSION["loggedas"];
    $getFavSql = "SELECT favourites FROM users WHERE username = '$curr_user'";
    $favQuery = mysqli_query($conn, $getFavSql);
    $favArr = mysqli_fetch_all($favQuery);
    var_dump($favArr);
// TURN FAVARR INTO STRING USING FOREACH PUSH INTO ARRAY

    //$oldFavArr = json_decode(mysqli_fetch_all($favQuery));
    // get values to add

    // $favArr = $_POST['option[]'];
    // foreach ($favArr as $item){
    //     array_push($oldFavArr, $item);
    // }

    //delete duplicate values and insert into user favourite list
    $finalFavArr = json_encode(array_unique($oldFavArr));
    $sql = "UPDATE users SET favourites = '$favStr' WHERE username = '$curr_user'";
    $query = mysqli_query($conn, $getFavSql);
}
function remove($conn){

    $sql = "UPDATE users SET favourites = '$'";
}
function filterItems(){

}
function alphabetItems($itemsArr){
    $temp = [];
    foreach($itemsArr as $itemArr) {
        array_push($temp, $itemArr[0]);
     }
     bubblesort($temp);
     for ($i = 0; $i < count($temp); $i++) {
        echo "<img src='img/" . $temp[$i] . "' width='300'><br />";
     }
}
function displayFav($conn){
$curr_user = $_SESSION["loggedas"];
$getFavSql = "SELECT favourites FROM users WHERE username = '$curr_user'";
$favQuery = mysqli_query($conn, $getFavSql);
$favItemsArr = mysqli_fetch_all($favQuery);
 foreach($favItemsArr as $itemArr) {
    echo "<img src='img/" . $itemArr[0] . "' width='300'><br />";
 }
}

// HELPERS?
function bubblesort($arr){
    for ($i = 1; $i < count($arr);$i++ ) {
        for ($n = 0; $n < count($arr) - 1; $n++) {
            if ($arr[$n] > $arr[$n + 1]) {
                $hold = $arr[$n];
                $arr[$n] = $arr[$n + 1];
                $arr[$n + 1] = $hold;
            }
        }
    }
}
function insertionSort($arr){
    $count = count($arr);
    for ($i = 1; $i < $count; $i++) {
        $insert = $arr[$i];
        $position = $i - 1;
        while ($insert < $arr[$position] && $position >= 0) {
            $arr[$position + 1] = $arr[$position];
            $arr[$position] = $insert;
            $position--;
        }
    }
}
function selectionSort($arr, $count){
    for ($i = 0; $i < $count - 1; $i++) {
        $mid = $i;
        for ($n = $i + 1; $n < $count; $n++) {
            if ($arr[$n] < $arr[$mid]) {
                $mid = $n;
            }
        }
        $hold = $arr[$mid];
        $arr[$mid] = $arr[$i];
        $arr[$i] = $hold;
    }
}
?>
</body>
</html>