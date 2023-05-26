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
            <option value="3">Sort by price</option>
            <option value="4">Only display favourites </option>
        </select><br />
        <input type="submit" value="submit" name="submit"><br />
    </form>
</section>

<?php
// display all item images with their price
$sql = "SELECT img, price FROM items WHERE 1";
$query = mysqli_query($conn, $sql);
$arr = mysqli_fetch_all($query);
display($arr);
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
            priceSort($conn);
            break;
        case "4":
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
    // parse array of favourite item IDs 
    $curr_user = $_SESSION["loggedas"];
    $getFavSql = "SELECT favourites FROM users WHERE username = '$curr_user'";
    $favQuery = mysqli_query($conn, $getFavSql);
    
    $arrFromDB = fetchIntoArr($favQuery);

    //merge DB and form array only if not a duplicate value
    $arrToAdd = [];
    if ($favQuery && !empty($arrFromDB)) {
        addToArr($arrFromDB, $favArr, $arrToAdd);
    } else {
        $arrToAdd = $favArr;
    }
    // Insert into user favourite list
    $favStr = json_encode($arrToAdd);
    $sql = "UPDATE users SET favourites = '$favStr' WHERE username = '$curr_user'";
    $query = mysqli_query($conn, $sql);
}
function remove($conn, $checkboxArr){
    //for each element in array if its equal to value to delete, remove from arrray
    // foreach ()
    // $sql = "UPDATE users SET favourites = '$'";
}
function priceSort($conn){
    $sql = "SELECT img FROM items ORDER BY price ASC";
    $arr = fetchIntoArr(mysqli_query($conn, $sql));
    display($arr);
}
function displayFav($conn){
    // get users favourite items
    $curr_user = $_SESSION["loggedas"];
    $sql = "SELECT favourites FROM users WHERE username = '$curr_user'";
    $favFromUsers = fetchIntoArr(mysqli_query($conn, $sql));
    echo "fav from users<br />";
    var_dump($favFromUsers);
    for ($i = 0; count($favFromUsers); $i++) {
        
    }
    $sql = "SELECT img, price FROM items WHERE itemName = '$favFromUsers'";
    $temp = mysqli_query($conn, $sql);
    echo "arr of favs from DB<br />";
    var_dump($temp);
}

// HELPERS?
function display($arr){
    for ($i = 0; $i < count($arr); $i++) {
        echo "<br /><img src='img/" . $arr[$i][0] . "' width='300'>" . "<h3>Price: </h3> $" . $arr[$i][1];
    }
}
function addToArr($checkArr, $itemArr, $addArr){
    for ($i = 0; $i < count($itemArr); $i++) {
        //if value isnt in arr to check (favArr from form), put it in arr to add
        if (!array_key_exists($itemArr[$i], $checkArr)) {
            array_push($addArr, $itemArr[$i]);
        }
    }
}
function fetchIntoArr($query){
    $temp = mysqli_fetch_all($query);
    $json_str = $temp[0][0];
    return json_decode($json_str);
}
function binarySearch($arr, $item){
    $lowI = 0;
    $highI = sizeof($arr) - 1;
    while ($lowI<= $highI) {
        $midI = (int)floor(($lowI + $highI) / 2);
        if ($arr[$midI] == $item) {
            return $midI;
        } elseif ($arr[$midI] > $item) {
            $highI = $midI - 1;
        } else if($arr[$midI+1] < $item){
          $lowI = $midI + 1;
        }
    }
    return -1;
}

?>
</body>
</html>