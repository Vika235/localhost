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

$districts = mysql_query("SELECT * FROM district");


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
<form id="checkout-form" action="doCheckout.php" method="post">

    <p>
        <label for="district">Район<br>
            <select name="district" onchange="getval(this);">
                <option value="0">Выберите район</option>
            </select>
        </label>
    </p>



    <p>
        <label for="street">Улица(*)<br>
            <input class="input" placeholder="Пушкина" name="street" size="30"
                   type="text" required="required" value="">
        </label>
    </p>

    <p>
        <label for="house">Дом(*)<br>
            <input class="input" placeholder="9" name="house" size="5"
                   type="text" required="required" value="">
        </label>
    </p>


    <p>
        <label for="letter">Буква<br>
            <input class="input" placeholder="б" name="letter" size="1"
                   type="text" value="">
        </label>
    </p>


    <p>
        <label for="floor">Этаж<br>
            <input class="input" placeholder="1" name="floor" size="2"
                   type="text" value="">
        </label>
    </p>

    <p>
        <label for="room">Квартира(*)<br>
            <input class="input" placeholder="1" name="room" size="3"
                   type="text" required="required" value="">
        </label>
    </p>


    <p>
        <label for="comment">Комментарий к заказу<br>
            <input class="input" name="comment" size="30"
                   type="text" value="">
        </label>
    </p>

    <table class="basket-table">
        <tr class="basket-item-row">
            <td class="basket-item-col-title">Итого</td>
            <td class="basket-item-col-cost"><?= $total ?>р.</td>
        </tr>
    </table>


    <a href="/doCheckout.php"><p class="submit"><input class="button" type= "submit" value="Заказать"></p></a>
</form>
</div>

<script>
    var total = <?= $total ?>;
    var districts = {
        <?
        while($row = mysql_fetch_assoc($districts))
            echo $row["id_district"]. ": { name: '".$row["District_name"]."', cost: '". $row["Cost_of_delivery"] ."' },";
        ?>
    };

    for (var key in districts) {
        $( "select[name='district']").append("<option value=\""+ key + "\">"+ districts[key].name + ". Цена - " + districts[key].cost + "р.</option>");
    }

    function getval(sel)
    {
        var value = sel.value;

        if (value <= 0)
            $(".basket-item-col-cost").text(total + "р.")
        else
            $(".basket-item-col-cost").text(total + " + " + districts[value].cost + " = " + (parseInt(total) + parseInt(districts[value].cost)) +"р.")
    }

    $( "#checkout-form" ).submit(function( event ) {
        if ( $( "select[name='district']").val() === "0") {
            alert("Ошибка. Не выбран район")
            event.preventDefault();
        }
    });


</script>
</body>
</html>