<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action = "index2.php" method = "post"> 
        <lable>username:</lable><br>
        <input type = "text" name = "username"><br>
        <lable>password:</lable><br>
        <input type = "password" name = "password"><br>
        <input type = "submit" value = "log in">
    </form>
</body>
</html>


<?php
    // echo $_POST["username"] . "<br>";
    // echo $_POST["password"];
    
?>