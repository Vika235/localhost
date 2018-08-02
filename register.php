<?php

session_start();
//Проверка на логин
if(isset($_SESSION["session_Username"])){
    header("Location: /");
    die();
} ?>

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
	
<?php

	require("const.php");
 
	$con = mysql_connect(DB_SERVER,DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME) or die("Cannot select DB");
	
	if(isset($_POST["register"])){
	
	if(!empty($_POST['Name']) && !empty($_POST['Surname']) && !empty($_POST['Phone_number']) && !empty($_POST['Username']) && !empty($_POST['Password'])) {
  $Name= htmlspecialchars($_POST['Name']);
  $Surname= htmlspecialchars($_POST['Surname']);
	$Phone_number=htmlspecialchars($_POST['Phone_number']);
 $Username=htmlspecialchars($_POST['Username']);
 $Password=htmlspecialchars($_POST['Password']);
 $query=mysql_query("SELECT * FROM customer WHERE Username='".$Username."'");
  $numrows=mysql_num_rows($query);
if($numrows==0)
   {
	$sql="INSERT INTO customer
  (Name, Surname, Phone_number, Username, Password)
	VALUES('$Name', '$Surname', '$Phone_number', '$Username', '$Password')";
  $result=mysql_query($sql);
 if($result){
	$message = "Account Successfully Created";
} else {
 $message = "Failed to insert data information!";
  }
	} else {
	$message = "That username already exists! Please try another one!";
   }
	} else {
	$message = "All fields are required!";
	}
	}
	?>
 
	
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
<div class="container mregister">
<div id="login">
 <h1>Registration</h1>
<form action="register.php" id="registerform" method="post"name="registerform">
 <p><label for="user_login">Name<br>
 <input class="input" placeholder="Иван" id="Name" name="Name" size="30"  type="text" value=""></label></p>
<p><label for="user_login">Surname<br>
<input class="input" placeholder="Иванов" id="Surname" name="Surname" size="30" type="text" value=""></label></p>
<p><label for="user_login">Phone<br>
<input class="input" placeholder="+77879996655" id="Phone_number" name="Phone_number" size="12" type="text" value=""></label></p>
<p><label for="user_pass">Login<br>
<input class="input" placeholder="ivan" id="Username" name="Username" size="30" type="text" value=""></label></p>
<p><label for="user_pass">Password<br>
<input class="input" placeholder="tTy76wn8" id="Password" name="Password" size="30"   type="password" value=""></label></p>
<p class="submit"><input class="button" id="register" name= "register" type="submit" value="Registration"></p>
	  <p class="regtext">Are you register already? <a href= "login.php">Enter login</a>!</p>
 </form>
</div>
</div>
</body>
</html>