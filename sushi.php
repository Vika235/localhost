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
   <?php $db=mysql_connect("localhost", "root", "") or die ("Ошибка подключения к бд!".mysql_error());
	mysql_select_db("delivery", $db);
	?></p>
<table width="200" border="0" align="right">
  <tbody>
    <tr>
      <th width="58" height="35" scope="col"><a href="reg.html"><img src="image/adduser.png" width="50" height="50" alt=""/></a><br></th>
      
      <th width="64" scope="col"><img src="image/in.png" width="50" height="50" alt=""/></th>
      <th width="64" scope="col"><img src="image/basket.png" width="50" height="50" alt=""/></th>
    </tr>
  </tbody>
</table>

  </tbody>
</table>
<p><img src="image/logo.png" width="684" height="184" alt=""/></p>
<p>&nbsp;</p>
<table width="200" border="0" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td width="149"><img src="image/sushi.png" width="200" height="90" alt=""/></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
<table width="200" border="0" align="center" cellpadding="10" cellspacing="50">
  <tbody>
    <tr>
      <td width="218" height="80"><p><img src="image/su1.jpg" width="172" height="119" alt=""/></p>
      <p><img src="image/image (14).png" width="150" height="50" alt=""/></p></td>
      <td><p><img src="image/Su2.jpg" width="176" height="151" alt=""/></p>
      <p><img src="image/image (15).png" width="230" height="50" alt=""/></p></td>
      <td><p><img src="image/Su3.jpg" width="183" height="161" alt=""/></p>
      <p><img src="image/image (16).png" width="200" height="75" alt=""/></p></td>
    </tr>
  </tbody>
</table>
</body>
</html>