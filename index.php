<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: ./views/login.php');
    }
    if(isset($_SESSION['name'])){
        echo $_SESSION['name'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>asdasd</h1>
    <a href="./views/logout.php">dangxuat</a>
</body>
</html>