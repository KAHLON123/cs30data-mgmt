<?php include('connect.php'); ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>STORE</title>
</head>
<body>
<h1>da  mall</h1>
<h2>les gooo</h2>
<img src="img/walmart-logo.jpeg"><br />
<h1>Add items to cart: </h1>
<input type="checkbox" name="car" value="checkbox_value">
<img src="img/daCar.png" width="500"><br />
<input type="checkbox" name="diesel" value="checkbox_value">
<img src="img/vin-diesel.jpg"> <br />
<input type="checkbox" name="coffee" value="checkbox_value">
<img src="img/coffee.jpg" width="500"> <br />
<input type="checkbox" name="food" value="checkbox_value">
<img src="img/food-img.jpg" width="500"> <br />
<label>Add</label>
<section><form><input type="submit" value="submit"></form></section>

<?php
if (isset($_POST['submit'])){
    //check if items are already in favourites
    
    echo "hi";
}


?>

</body>
</html>