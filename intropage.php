<?php
 
session_start();

if(!isset($_SESSION["session_Username"])):
header("Location: /login.php");
else:
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

<div id="welcome">
<h2>Добро пожаловать, <span><?php echo $_SESSION['session_Username'];?>! </span></h2>
  <p><a href="logout.php">Выйти</a> из системы</p>
</div>
    </body>
</html>
	
<?php endif; ?>
