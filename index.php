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
	?></p>
<table width="200" border="0" align="right">
  <tbody>
    <tr>
      <th width="58" height="35" scope="col"><a href="register.php"><img src="image/adduser.png" width="50" height="50" alt=""/></a><br></th>
      
      <th width="64" scope="col"><a href="login.php"><img src="image/in.png" width="50" height="50" alt=""/></a></th>
        <th width="64" scope="col"><a href="/basket.php"><img src="image/basket.png" width="50" height="50" alt=""/></a></th>
    </tr>
  </tbody>
</table>

  </tbody>
</table>
<p><img src="image/logo.png" width="684" height="184" alt=""/></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="710" border="0" align="center">
  <tbody>
    <tr>
      <td width="218" height="80"><a href="sushi.php"><img src="image/sushi.png" width="212" height="90" alt=""/></a></td>
      <td width="256"><img src="image/sashimi.png" width="229" height="90" alt=""/></td>
      <td width="222"><img src="image/roll.png" width="210" height="90" alt=""/></td>
    </tr>
    <tr>
      <td height="80"><img src="image/hot.png" width="250" height="90" alt=""/></td>
      <td><img src="image/sup.png" width="200" height="90" alt=""/></td>
      <td><img src="image/zak.png" width="210" height="90" alt=""/></td>
    </tr>
    <tr>
      <td height="80"><img src="image/sety.png" width="200" height="90" alt=""/></td>
      <td><img src="image/salad.png" width="250" height="90" alt=""/></td>
      <td><img src="image/sous.png" width="200" height="90" alt=""/></td>
    </tr>
    <tr>
      <td height="80"><img src="image/sweet.png" width="250" height="90" alt=""/></td>
      <td><img src="image/drink.png" width="250" height="90" alt=""/></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
</body>
</html>