<?php
date_default_timezone_set('Europe/Copenhagen');
include 'dbh.inc.php';
include 'comments.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Title of the document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
echo "<form method='POST' action='".setComments($conn)."'>
    <textarea name='message' placeholder='Reply to this comment'></textarea><br>
    <button type='submit' name='commentSubmit'>Add Comment</button>
</form>";


?>
</body>
</html>
