<?php

function setComments ($conn) {
    if (isset($_POST['commentSubmit'])) {
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        $parent_cid = isset($_POST['parent_cid']) ? $_POST['parent_cid'] : null;
        $sql = "INSERT INTO comments (uid, date, message) VALUES ('$uid', '$date', '$message')"; 
        $result = $conn->query($sql);
    }
}

function setComments2($conn) {
    if (isset($_POST['commentSubmit'])) {
        if (isset($_POST['uid'], $_POST['date'], $_POST['message'])) {
            $uid = $_POST['uid'];
            $date = $_POST['date'];
            $message = $_POST['message'];
            $parent_cid = isset($_POST['parent_cid']) ? $_POST['parent_cid'] : null;
            $sql = "INSERT INTO comments (uid, date, message, parent_cid) VALUES ($uid, $date, $message, $parent_cid)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssi', $uid, $date, $message, $parent_cid);
            $result = $stmt->execute();
            $stmt->close();
        }
    }
}

function getComments($conn) {
    $sql = "SELECT * FROM comments";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<div class='comment-box'><p>";
            echo $row['uid']."<br>";
            echo $row['date']."<br>";
            echo nl2br($row['message']);
        echo "</p>
            <form class='reply-form' method='POST' action='replyComment.php'> 
                <input type='hidden' name='parent_cid' value='" . $row['cid'] . "'>
                <input type='hidden' name='uid' value='" . $row['uid'] . "'> 
                <input type='hidden' name='date' value='" . $row['date'] . "'>
                <button type='submit' name='replyComment'>Reply</button>
            </form>   

            <form class='delete-form' method='POST' action='".deleteComments($conn)."'> 
                <input type='hidden' name='cid' value='".$row['cid']."'>
                <button type = 'submit' name = 'commentDelete'>Delete</button>
            </form>    

            <form class='edit-form' method='POST' action='editcomment.php'> 
                <input type='hidden' name='cid' value='".$row['cid']."'>
                <input type='hidden' name='uid' value='".$row['uid']."'>
                <input type='hidden' name='date' value='".$row['date']."'>
                <input type='hidden' name='message' value='".$row['message']."'>
                <button>Edit</button>
            </form>    
        </div>";
    }
}


function editComments($conn) {
    if (isset($_POST['commentSubmit'])) {
        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        $sql = "UPDATE comments SET message = '$message' WHERE cid = '$cid'";
        $result = $conn->query($sql);
        header("Location: indexCom.php");
    }
}

function deleteComments($conn) {
    if (isset($_POST['commentDelete'])) {
        $cid = $_POST['cid'];
        $sql = "DELETE FROM comments WHERE cid = '$cid'";
        $result = $conn->query($sql);
        header("Location: indexCom.php");
    }
}

function replyComment($conn) {
    if (isset($_POST['replyComment'])) {
        $parent_cid = $_POST['parent_cid'];
        $uid = $_POST['uid'];
        $date = date("Y-m-d H:i:s"); 
        $message = $_POST['message'];

        if (empty($message)) {
            header("Location: replyComment.php?error=emptymessage&parent_cid=$parent_cid");
            exit();
        }
        $sql = "INSERT INTO comments (uid, date, message, parent_cid) VALUES ($uid, $date, $message, $parent_cid)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssi", $uid, $date, $message, $parent_cid);
            $stmt->execute();
            $stmt->close();
            header("Location: indexCom.php");
            exit();
        } else {
            header("Location: replyComment.php?error=sqlerror&parent_cid=$parent_cid");
            exit();
        }
    }
}

