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
<h1>OPTIONS: </h1>
<section>
    <form action="shop.php" method="POST">
        <label>Car</label>
        <input type="checkbox" value="car" name="option[]">
        <label>Diesel</label>
        <input type="checkbox" value="diesel" name="option[]">
        <label>Coffee</label>
        <input type="checkbox" value="coffee" name="option[]">
        <label>Food</label>
        <input type="checkbox" value="food" name="option[]">
        <label>Hat 1</label>
        <input type="checkbox" value="hat1" name="option[]"><br />
        <select name="s">
            <option value="1">Add to favourites</option>
            <option value="2">Remove from favourites</option>
            <option value="3">Filter by </option>
            <option value="4">Alphabetize</option>
            <option value="5">Only display favourites </option>
        </select><br />
        <input type="submit" value="submit" name="submit"><br />
    </form>
</section>

<?php
// display all item images with their price
$fetchImgSql = "SELECT img FROM items WHERE 1";
$imgQuery = mysqli_query($conn, $fetchImgSql);
$imgArr = mysqli_fetch_all($imgQuery);
$fetchPriceSql = "SELECT price FROM items WHERE 1";
$priceQuery = mysqli_query($conn, $fetchPriceSql);
$priceArr = mysqli_fetch_all($priceQuery);
    for ($i = 0; $i < count($imgArr); $i++) {
        echo "<br /><img src='img/" . $imgArr[$i][0] . "' width='300'>" . "<h3>Price: </h3> $" . $priceArr[$i][0];
    }
if (isset($_POST['submit'])){
    switch ($_POST['s']){
        case "1":
            if (empty($_POST['option'])) {
                $checkboxArr = [];
                echo "<h2>Please choose an item from above...</h2>";
            } else {
                $checkboxArr = $_POST['option'];
            }
            add($conn, $checkboxArr);
            break;
        case "2":
            if (empty($_POST['option'])) {
                $checkboxArr = [];
                echo "<h2>Please choose an item from above...</h2>";
            } else {
                $checkboxArr = $_POST['option'];
            }
            remove($conn, $checkboxArr);
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

function add($conn, $favArr){
    echo "<h2>favArr<</h2>";
    print_r($favArr);

    // parse array of favourite item IDs 
    $curr_user = $_SESSION["loggedas"];
    $getFavSql = "SELECT favourites FROM users WHERE username = '$curr_user'";
    $favQuery = mysqli_query($conn, $getFavSql);
    
    $arrFromDB = fetchIntoArr($favQuery);
    echo "<h2>Array from DB</h2>";
    print_r($arrFromDB);

    //merge DB and form array only if not a duplicate value
    $arrToAdd = [];
    if ($favQuery && !empty($arrFromDB)) {
        if (inArr($arrFromDB, $favArr) == -1) {
            array_push($arrToAdd, $favArr);
        }
    } else {
        $arrToAdd = $favArr;
    }
    
    //delete duplicate values and insert into user favourite list
    $favStr = json_encode($arrToAdd);
    echo "<h2>favstr</h2>" . $favStr;
    $sql = "UPDATE users SET favourites = '$favStr' WHERE username = '$curr_user'";
    $query = mysqli_query($conn, $sql);
}
function remove($conn, $checkboxArr){
    //for each element in array if its equal to value to delete, remove from arrray
    // foreach ()
    // $sql = "UPDATE users SET favourites = '$'";
}
function filterItems(){

}
function alphabetItems($conn){
    $sql = "SELECT * FROM 'users' ORDER BY 'price' ASC";
    fetchIntoArr(mysqli_query($conn, $sql)); 
    
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
function inArr($arr, $item){
    for ($i = 0; $i < count($arr); $i++) {
        if (array_key_exists($item[$i], $arr)) {
            return $i;
        } else {
            return -1;
        }
    }
}
function fetchIntoArr($query){
    $temp = mysqli_fetch_all($query);
    var_dump($temp);
    $json_str = $temp[0][0];
    return json_decode($json_str);
}

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