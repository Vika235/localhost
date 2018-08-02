<?php
session_start();
require("const.php");


//Проверка на логин
if(!isset($_SESSION["session_Username"])){
    header("Location: /login.php");
    die();
}

//Проверка на заказ
if(!isset($_SESSION["session_UserOrder"])){
    header("Location: /");
    die();
} else {
    $con = mysql_connect(DB_SERVER,DB_USER, DB_PASS) or die(mysql_error());
    mysql_select_db(DB_NAME) or die("Cannot select DB");
}

//Проверка на заполненность полей
if (empty($_POST['district']) || empty($_POST['street']) || empty($_POST['house']) || empty($_POST['room']))
{
    header("Location: /");
    die();
}

$district_id = intval($_POST["district"]);

$query = mysql_query("SELECT
*
FROM
district
WHERE
district.id_district = " . $district_id);

//Проверка на корректность id района
if (mysql_num_rows($query) != 1)
{
    header("Location: /");
    die();
}

$district = mysql_fetch_assoc($query);

//Проверка на корректность полей
if (strlen($_POST['street']) > 30 || strlen($_POST['letter']) > 2 || strlen($_POST['comment']) > 50)
{
    header("Location: /");
    die();
}


$street = "'" . htmlspecialchars($_POST['street']) . "'";
$house = intval($_POST['house']);
$letter = empty($_POST['letter']) ? "NULL" : "'" . htmlspecialchars($_POST['letter']) . "'";
$floor = empty($_POST['floor']) ? "NULL" : intval($_POST['floor']);
$room = intval($_POST['room']);
$comment= empty($_POST['comment']) ? "NULL" : "'" . htmlspecialchars($_POST['comment']) . "'";

$letterWhereStr = empty($_POST['letter']) ? " delivery_address.letter IS NULL " : " delivery_address.letter = ". $letter ." ";
$floorWhereStr = empty($_POST['floor']) ? " delivery_address.floor IS NULL " : " delivery_address.floor = ". $floor ." ";


$query = mysql_query("SELECT
delivery_address.id_delivery_address
FROM
delivery_address
WHERE
delivery_address.id_district = ".$district_id ." AND
delivery_address.street = ". $street ." AND
delivery_address.house = ". $house ." AND
". $letterWhereStr ." AND
". $floorWhereStr ." AND
delivery_address.`flat/room` = ". $room );


if (mysql_num_rows($query) == 0)
{
    mysql_query("INSERT INTO delivery_address(id_district, street, house, letter, floor, `flat/room`) 
    VALUES(".$district_id . ", ". $street .", ".$house .", ". $letter .", ". $floor .", ". $room .")");
    $delivery_address_id = mysql_insert_id();
}
else
{
    $row =  mysql_fetch_assoc($query);
    $delivery_address_id = intval($row["id_delivery_address"]);
}


$total = 0;
$query = mysql_query("SELECT
basket.id_order,
basket.id_product,
basket.Amount,
basket.Total,
product.Product_name
FROM
basket
INNER JOIN product ON basket.id_product = product.id_product
WHERE
basket.id_order = ". $_SESSION["session_UserOrder"]);

while($row = mysql_fetch_assoc($query)){
    $total += $row["Total"];
}

$total += intval($district["Cost_of_delivery"]);
$dateNow = date('Y-m-d');
$timeNow = date('H:i:s');



mysql_query("UPDATE `order` SET Total=". $total .", Order_date='". $dateNow ."', Order_time='". $timeNow ."', id_status=2, id_delivery_address = ". $delivery_address_id .", Comment_to_the_order = ". $comment ." WHERE id_order = ". $_SESSION["session_UserOrder"]);
unset($_SESSION['session_UserOrder']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="style.css" media="screen" rel="stylesheet">
    <link href="style2.css" media="screen" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
    <style type="text/css">
        body {
            background-image: url(image/fon1.jpg);
        }
    </style>
    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>

<table width="200" border="0" align="right">
    <tbody>
    <tr>
        <th width="58" height="35" scope="col"><a href="/register.php"><img src="image/adduser.png" width="50" height="50" alt=""/></a><br></th>
        <th width="64" scope="col"><a href="/login.php"><img src="image/in.png" width="50" height="50" alt=""/></a></th>
        <th width="64" scope="col"><a href="/basket.php"><img src="image/basket.png" width="50" height="50" alt=""/></a></th>
    </tr>
    </tbody>
</table>
<p><a href="/"><img src="image/logo.png" width="684" height="184" alt=""/></a></p>

<div class="container mlogin">
    <h3>Заказ успешно передан</h3><br>
    <p><a href="/">Вернуться к магазину</a></p>
</div>

</body>
</html>