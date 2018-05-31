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
Count(district.id_district)
FROM
district
WHERE
district.id_district = " . $district_id);

$row = mysql_fetch_assoc($query);
$row = array_values($row);
$count = $row[0];

//Проверка на корректность id района
if ($count != 1)
{
    header("Location: /");
    die();
}

//Проверка на корректность полей
if (strlen($_POST['street']) > 30 || strlen($_POST['letter']) > 2)
{
    header("Location: /");
    die();
}


$street = "'" . htmlspecialchars($_POST['street']) . "'";
$house = intval($_POST['house']);
$letter = empty($_POST['letter']) ? "NULL" : "'" . htmlspecialchars($_POST['letter']) . "'";
$floor = empty($_POST['floor']) ? "NULL" : intval($_POST['floor']);
$room = intval($_POST['room']);

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




mysql_query("UPDATE `order` SET Total=". $total .", Order_date='2018-05-31', Order_time='20:05:49', id_status=2, id_delivery_address = ". $delivery_address_id ." WHERE id_order = ". $_SESSION["session_UserOrder"]);
unset($_SESSION['session_UserOrder']);