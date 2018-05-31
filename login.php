<?php
session_start();
require("const.php");

$con = mysql_connect(DB_SERVER,DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME) or die("Cannot select DB");

if(isset($_SESSION["session_Username"])){
    // вывод "Session is set"; // в целях проверки
    header("Location: /intropage.php");
}

if(isset($_POST["login"])) {
    if (!empty($_POST['Username']) && !empty($_POST['Password'])) {
        $Username = htmlspecialchars($_POST['Username']);
        $Password = htmlspecialchars($_POST['Password']);
        $query = mysql_query("SELECT * FROM customer WHERE username='" . $Username . "' AND password='" . $Password . "'");
        $numrows = mysql_num_rows($query);
        if ($numrows != 0) {
            $row = mysql_fetch_assoc($query);
            $dbUsername = $row['Username'];
            $dbPassword = $row['Password'];

            if ($Username == $dbUsername && $Password == $dbPassword) {
                // старое место расположения
                $_SESSION['session_Username'] = $Username;
                $_SESSION['session_UserEntity'] = $row;

                //Поиск активного заказа
                $query = mysql_query("SELECT
                `order`.id_order
                FROM
                `order`
                WHERE
                `order`.id_status = 1 AND
                `order`.id_customer = ". $row["id_customer"]);

                if (mysql_num_rows($query) >= 1)
                {
                    $row = mysql_fetch_assoc($query);
                    $_SESSION['session_UserOrder'] = $row["id_order"];
                }

                /* Перенаправление браузера */
                header("Location: /intropage.php");
            }
        } else {
            //  $message = "Invalid username or password!";

            echo "Invalid username or password!";
        }
    } else {
        $message = "All fields are required!";
    }
}
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
body,td,th {
	font-family: "Open Sans", sans-serif;
}
</style>
	</head>


<body>
<table width="200" border="0" align="right">
  <tbody>
    <tr>
      <th width="58" height="35" scope="col"><a href="register.php"><img src="image/adduser.png" width="50" height="50" alt=""/></a><br></th>
      
      <th width="64" scope="col"><a href="login.php"><img src="image/in.png" width="50" height="50" alt=""/></a></th>
      <th width="64" scope="col"><img src="image/basket.png" width="50" height="50" alt=""/></th>
    </tr>
  </tbody>
  </table>
<p><a href="index.php"><img src="image/logo.png" width="684" height="184" alt=""/></a></p>


<div class="container mlogin">
  <div id="login">
<h1>Enter</h1>
<form action="" id="loginform" method="post"name="loginform">
<p><label for="user_login">Login<br>
<input class="input" id="Username" name="Username"size="30"
type="text" value=""></label></p>
<p><label for="user_pass">Password<br>
 <input class="input" id="Password" name="Password" size="30"
  type="password" value=""></label></p> 
	<p class="submit"><input class="button" name="login"type= "submit" value="Log In"></p>
	<p class="regtext">Are you don't registreded yet?<a href= "register.php">Registartion</a>!</p>
   </form>
 </div>
</div>
</body>
</html>