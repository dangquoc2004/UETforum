<html>
<head><title>REGISTER AN ACCOUNT</title></head>
<body>
    <form action = "register.php" method = "POST">
        Username: <input type = "text" name = "username">
        <br />Password: <input type = "password" name = "password">
        <br />Confirm password: <input type = "password" name = "repassword">
        <br />Email: <input type = "text" name = "email">
        <br /><input type = "submit" name = "submit" value = " Register"> or <a href = "login.php">Login</a>   
    </form>
</body>
</html>
<?php
require("connect.php");
    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
    $username = @$_POST['username'];
    $password = @$_POST['password'];
    $repass = @$_POST['repassword'];
    $email = @$_POST['email'];
    $date = date("Y-M-D");
    echo $date;
    $pass_en = sha1("password");

    if(isset($_POST['submit'])) {
        // echo "Username - " . $username; 
        // echo "Password - " . $password; 
        // echo "ConfirmedPassword - " . $confirmedPassword; 
        // echo "Email - " . $email; 

        if($username && $password && $repass && $email) {
            if(strlen($username) >= 5 && strlen($username) < 25 && strlen($password) > 6) {
                if($repass == $password) {
                    $stmt = "INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES ('', '".$username."', '".$password."', '".$email."')";
                    if($conn->query($stmt)){
                        echo "You have been registered as $username. Click <a href = 'login.php'>here</a> to login";
                    } else {
                        echo "Failure";
                    }
                } else {
                    echo "Password do not match";
                }
            } else {
                if(strlen($username) < 5 || strlen($username) > 25) {
                    echo "Username lenght must be between 5 and 25 characters";
                }

                if(strlen($password) < 6) {
                    echo "Password length must be longer than 6 characters";
                }
            }
        } 
        // $stmt = "INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES ('', '".$username."', '".$password."', '".$email."')";
        //             if($conn->query($stmt)){
        //                 echo "You have been registered. Click <a href = 'login.php'>here</a> to login";
        //             } else {
        //                 echo "fail";
        //             }
    }   
?>