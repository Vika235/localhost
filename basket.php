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

die(var_dump($districts));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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

<form action="handler.php">

    <select name="district" onchange="getval(this);">
        <option value="0">Выберите район</option>
        <?
        foreach ($districts  as  $value)
            echo "<option value=\"" . $value["id_district"] ."\">". $value["District_name"]. ". Цена - ".$value["Cost_of_delivery"]."</option> "
        ?>
    </select>

    <input type="text" name="address"\>

    <p><input type="submit"></p>
</form>
</body>

<script>

    function getval(sel)
    {
        $.ajax({
            type: "POST",
            url: "/getStreetsByDistrict.php",
            // передача в качестве объекта
            // поля будут закодированые через encodeURIComponent автоматически
            data: {
                district_id: sel.value,
            },
            success: function(msg){
                $("select[name='street']").children().remove();

                var json = JSON.parse(msg);

                //if(!Array.isArray(json))
                //

                json.forEach(function(item) {
                    $("select[name='street']").append(" <option value=\""+ item.id_street + "\">"+ item.name_street + "</option>");
                });
            }
        });
    }
</script>
</html>