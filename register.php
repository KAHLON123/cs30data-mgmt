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
        <input type="submit" value="submit">
    </form>
</section>
<h1>New user</h1>
<section>
    <form>
        <label>Username</label>
        <input type="text" name="new-username"><br />
        <label>Password</label>
        <input type="text" name="new-password"><br />
        <label>Confirm new password</label>
        <input type="text" name="confirm-password">
        <input type="submit" value="submit">
    </form>
</section>
<?php
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if(isset($_POST['submit'])){
    $newUsername = $_POST['new-username'];
    $newPassword = $_POST['new-password'];
    // enter username in database after validation (not empty, no weird characters)
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $sql = "INSERT INTO `users`(`username`, `passwords`) VALUES (?, ?)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ss", $, $);
        $stmt->execute();
        if (mysqli_query($conn, $sql)) {
            echo "Ready to shop!";
            header("location: shop.php");
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
        // if($stmt = mysqli_prepare($link, $sql)){
        //     // Bind variables to the prepared statement as parameters
        //     mysqli_stmt_bind_param($stmt, "s", $param_username);
            
        //     // Set parameters
        //     $param_username = trim($_POST["username"]);
            
        //     // Attempt to execute the prepared statement
        //     if(mysqli_stmt_execute($stmt)){
        //         /* store result */
        //         mysqli_stmt_store_result($stmt);
                
        //         if(mysqli_stmt_num_rows($stmt) == 1){
        //             $username_err = "This username is already taken.";
        //         } else {
        //             $username = trim($_POST["username"]);
        //         }
        //     } else {
        //         echo "Oops! Something went wrong. Please try again later.";
        //     }

        //     // Close statement
        //     mysqli_stmt_close($stmt);
        // }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
       
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}

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