<?php
session_start();

//Проверка на логин
if(!isset($_SESSION["session_Username"])){
    header("Location: /login.php");
    die();
}

require("const.php");

$db=mysql_connect("localhost", "root", "") or die ("Ошибка подключения к бд!".mysql_error());
mysql_select_db("delivery", $db);


if (isset($_SESSION["session_UserOrder"])){
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
        $basketItems[] = $row;
        $total += $row["Total"];
    }


}
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
    <?php if (empty($basketItems)): ?>
        <h3>Корзина пуста</h3>
    <?php else: ?>


        <table class="basket-table">
            <th>Товар</th>
            <th>Количество</th>
            <th>Цена</th>

            <?php

            foreach ($basketItems as $item)

                echo <<<HTML

            <tr class="basket-item-row">
                <td class="basket-item-col-title">{$item["Product_name"]}</td>
                <td class="basket-item-col-count">{$item["Amount"]}</td>
                <td class="basket-item-col-cost">{$item["Total"]}р.</td>
            </tr>
HTML;

            ?>

            <tr class="basket-item-row">
                <td class="basket-item-col-title">Итого</td>
                <td class="basket-item-col-count"></td>
                <td class="basket-item-col-cost"><?= $total ?>р.</td>
            </tr>
        </table>
        <a href="/checkout.php"><p class="submit"><input class="button" type= "submit" value="Оформить заказ"></p></a>

    <?php endif; ?>

</div>
</body>
</html>