<?php
session_start();
require("const.php");

$con = mysql_connect(DB_SERVER,DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME) or die("Cannot select DB");

//Проверка на логин
if(!isset($_SESSION["session_Username"])){
    header("Location: /login.php");
}

$query = mysql_query("SELECT * FROM district");

$districts = mysql_fetch_assoc($query);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="style2.css" media="screen" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
    <style type="text/css">
        body {
            background-image: none;
        }
    </style>
    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>

</body>
</html>