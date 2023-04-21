<?php include('connect.php'); ?>
<!DOCTYPE html>
<html>
 <head>
    <title>LOGIN</title>
 </head>
 <body>
    <h1>Already registered</h1>
    <section>
        <form>
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
            <input type="text" name="new-password">
            <input type="submit" value="submit">
        </form>
    </section>
    <?php
    if (isset($_POST['submit'])) {
        save();
        header("location:shop.php");
    }

    function save(){
        //get names from database, if !=, then add user into database

    }

    ?>
 </body>
</html>