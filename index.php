<?php
    // include("database.php");
    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "csdl";
    $conn = "";
    try{
        $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
    }
    catch(mysqli_sql_exception) {
        echo "You are not connected<br>";
    }
    if($conn) {
      echo "You are connnected<br>";
    }
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo $row["userID"] . "<br>";
            echo $row["firstName"] . "<br>";
            echo $row["lastName"] . "<br>";
            echo $row["userName"] . "<br>";
            echo $row["userPermission"] . "<br>";
            echo $row["followers"] . "<br>";
            echo $row["dateRegistration"] . "<br><br>";
        }
    } else {
        echo "no user found";
    }
    mysqli_close($conn);
?>