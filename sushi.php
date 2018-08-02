<!doctype html>
<html>
<head>
<link href="style.css" rel="stylesheet">
<meta charset="utf-8">
<title></title>
<style type="text/css">
body {
	background-image: url(image/fon1.jpg);
}
	
</style>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
</head>

<body>
<p>
   <?php $db=mysql_connect("localhost", "root", "") or die ("Ошибка подключения к бд!".mysql_error());
	mysql_select_db("delivery", $db);

	$categoryId = 101;
   $query = mysql_query("SELECT
        product.id_product,
        product.Product_name,
        product.id_category,
        product.Image,
        product.Price,
        product.Description,
        product.Weight,
        product.id_units_of_measure,
        units_of_measure.Name_value
        FROM
        product
        INNER JOIN units_of_measure ON product.id_units_of_measure = units_of_measure.id_units_of_measure
        WHERE
        product.id_category = ". $categoryId);


   while($row = mysql_fetch_assoc($query)){
       $arr[] = $row;
   }

	$countItems = sizeof($arr);
	$rowsCount = floor($countItems / 3) + ($countItems % 3 > 0 ? 1 : 0);
	?>
</p>
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
<p>&nbsp;</p>
<table width="200" border="0" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td width="149"><img src="image/sushi.png" width="200" height="90" alt=""/></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>

<?php
    echo "<table align=\"center\">";

    for ($i = 0; $i < $rowsCount; $i++)
    {
        echo "<tr>";
        for ($j = 0, $current_index = $i * 3 + $j; $j < 3; $j++, $current_index = $i * 3 + $j)
        {
            $needInflate =  $current_index + 1 <= $countItems;

            $id = $arr[$current_index]["id_product"];
            $image_url= $arr[$current_index]["Image"];
            $title = $arr[$current_index]["Product_name"];
            $description = $arr[$current_index]["Description"];
            $weight = $arr[$current_index]["Weight"];
            $unitsName = $arr[$current_index]["Name_value"];
            $cost = $arr[$current_index]["Price"];
            $visibility = "style=\"visibility: ". ($needInflate ? "inherit" : "hidden") .";\"";

echo <<<HTML
<td {$visibility}>
            <table class="shop-item-table">
                <tr class="shop-item-table-image-row">
                    <td colspan="2" class="shop-item-table-image-col">
                        <img src="{$image_url}" alt=""/></td>
                    </td>
                </tr>
                <tr class="shop-item-table-title-row">
                    <td colspan="2" class="shop-item-table-title-col">
                        <h3>{$title}</h3>
                    </td>
                </tr>
                <tr class="shop-item-table-desc-row">
                    <td colspan="2" class="shop-item-table-desc-col">
                        <p>
                            {$description}
                        </p>
                    </td>
                </tr>
                
                <tr>
                    <td>
                         {$weight} {$unitsName}.
                    </td>
                    <td rowspan="2"><a product-id="{$id}" class="add-to-basket-link" href="#">В корзину</a></td>
                </tr>
                <tr>
                    <td>
                        {$cost} р. 
                    </td>
                </tr>
            </table>
        </td>
HTML;
        }
        echo "</tr>";
    }
    echo "</table>";

?>

<script>
    $( ".add-to-basket-link" ).click(function() {
        $.ajax({
            type: "POST",
            url: "/addToBasket.php",
            data: {
                product_id: $(this).attr("product-id"),
            },
            success: function(msg){
                const json = JSON.parse(msg);
                if (json["result"] === true)
                    alert(json["data"]);
                else
                    alert("ОШИБКА! " + json["data"]);
            },
            error: function(xhr, ajaxOptions, thrownError) {
               alert(xhr.status + ' ' + thrownError);
            }
        });
    });
</script>
</body>
</html>