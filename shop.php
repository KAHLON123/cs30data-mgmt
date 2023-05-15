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

function add($conn, $favToAdd){
    // parse array of favourite item IDs 
    $curr_user = $_SESSION["loggedas"];
    $getFavSql = "SELECT favourites FROM users WHERE username = 'user1'";
    $favQuery = mysqli_query($conn, $getFavSql);

    $arrFromDB = fetchIntoArr($favQuery);
    if ($favQuery){ 
        if (!empty($arrFromDB)) {
        $favArr = fetchIntoArr($favQuery);
        }
    }

    // put new values into array from sql
    foreach ($favToAdd as $item){
        array_push($favArr, $item);
    }

    //delete duplicate values and insert into user favourite list

    $favStr = json_encode(array_unique($favArr));
    echo $favStr;
    $sql = "UPDATE users SET favourites = 'favouriteTEST' WHERE username = 'vlody'";
    $query = mysqli_query($conn, $getFavSql);
}
function remove($conn, $checkboxArr){
    //for each element in array if its eqal to value to delete, remove from arrray
    // foreach ()
    // $sql = "UPDATE users SET favourites = '$'";
}
function filterItems(){

}
function alphabetItems($itemsArr){
    $sql = "SELECT * FROM 'users' ORDER BY 'price' ASC";
    // $temp = [];
    // foreach($itemsArr as $itemArr) {
    //     array_push($temp, $itemArr[0]);
    //  }
    //  bubblesort($temp);
    //  for ($i = 0; $i < count($temp); $i++) {
    //     echo "<img src='img/" . $temp[$i] . "' width='300'><br />";
    //  }
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
function fetchIntoArr($query){
    $temp = mysqli_fetch_all($query);
    $arr = [];
    foreach ($temp as $value){
        array_push($arr, $value[0]);
    }
    return $arr; 
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