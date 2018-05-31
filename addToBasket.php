<?php
session_start();

if(!isset($_SESSION["session_Username"])) {
    printResult(false, "Вы не авторизованы");
}
else {
    require("const.php");
    $db = mysql_connect("localhost", "root", "") or die ("Ошибка подключения к бд!" . mysql_error());
    mysql_select_db("delivery", $db);


    $product_id = intval($_POST["product_id"]);


    $query = mysql_query("SELECT
    Count(product.id_product)
    FROM
    product
    WHERE
    product.id_product = " . $product_id);

    $row = mysql_fetch_assoc($query);
    $row = array_values($row);
    $count = $row[0];

    if ($count != 1) {
        printResult(false, "Неверный ID товара");
        die();
    }


    $query = mysql_query("SELECT
    `order`.id_order
    FROM
    `order`
    WHERE
    `order`.id_status = 1 AND
    `order`.id_customer = " . $_SESSION["session_UserEntity"]["id_customer"]);

    $count = mysql_num_rows($query);


    if ($count > 1) {
        printResult(false, "Ошибка в БД (Заказ)");
        die();
    }


    if ($count == 0) {
        mysql_query("INSERT INTO `order` (`order`.id_customer) VALUES(" . $_SESSION["session_UserEntity"]["id_customer"] . ")");
        $orderID = mysql_insert_id();
    } else
    {
        $row = mysql_fetch_assoc($query);
        $orderID = $row["id_order"];
    }


    $product = getProductInfo($product_id);


    $query = mysql_query("SELECT
basket.id_order
FROM
basket
WHERE
basket.id_order = " . $orderID ." AND basket.id_product = " . $product["id_product"]);

    $count = mysql_num_rows($query);


    if ($count > 1) {
        printResult(false, "Ошибка в БД (Корзина)");
        die();
    }



    if ($count == 0)
    {
        mysql_query("INSERT INTO basket VALUES(". $orderID .", ".$product["id_product"]. ", 1, ". $product["Price"] .")");
    }
    else
    {

        $query = mysql_query("SELECT
*
FROM
basket
WHERE
basket.id_order = ". $orderID ." AND basket.id_product = " . $product["id_product"]);


        $row = mysql_fetch_assoc($query);

        mysql_query("UPDATE basket SET Amount = ". ($row["Amount"] + 1) .", Total = ". ($product["Price"] * ($row["Amount"] + 1)) ."
WHERE
basket.id_order = ". $orderID ." AND basket.id_product = " . $product["id_product"]);



    }

    $_SESSION['session_UserOrder'] = $orderID;

    printResult(true, "Товар успешно добавлен в корзину");

}

/**
 * @param bool $result Результат
 * @return string JSON с результатом
 */
function printResult($result, $data)
{
    echo json_encode(
     array("result" => $result, "data" => $data));
}

/**
 * Поличение информации о товаре
 * @param int $id ID товара
 * @return array
 */
function getProductInfo($id)
{

    $query = mysql_query("SELECT
    *
    FROM
product
WHERE
product.id_product = " . $id);

    return
        $row = mysql_fetch_assoc($query);

}