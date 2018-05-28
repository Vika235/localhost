<?php
require("const.php");

$con = mysql_connect(DB_SERVER,DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME) or die("Cannot select DB");



$district_id = $_POST["district_id"];

$query = mysql_query("SELECT
street.id_street,
street.name_street
FROM
street
WHERE street.id_district = ". intval ($district_id));

$numrows = mysql_num_rows($query);

if ($numrows == 0)
    die(json_encode(array(array("id_street" => "-1", "name_street" => "Отсутствуют данные"))));

while($row = mysql_fetch_assoc($query)){
    $json[] = $row;
}

echo json_encode($json);