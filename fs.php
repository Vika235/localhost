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
</head>

<body>
<p>
   <?php
   require("const.php");

   $con = mysql_connect(DB_SERVER,DB_USER, DB_PASS) or die(mysql_error());
   mysql_select_db(DB_NAME) or die("Cannot select DB");
	?>
</p><table width="200" border="0" align="right">
  <tbody>
    <tr>
      <th width="58" height="35" scope="col"><a href="register.php"><img src="image/adduser.png" width="50" height="50" alt=""/></a><br></th>
      
      <th width="64" scope="col"><a href="login.php"><img src="image/in.png" width="50" height="50" alt=""/></a></th>
      <th width="64" scope="col"><img src="image/basket.png" width="50" height="50" alt=""/></th>
    </tr>
  </tbody>
</table>

<p><img src="image/logo.png" width="684" height="184" alt=""/></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>
</html>