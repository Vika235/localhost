<?php
 
session_start();

var_dump($_SESSION);
die();
 
if(!isset($_SESSION["session_Username"])):
header("location:login.php");
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
	
<div id="welcome">
<h2>Добро пожаловать, <span><?php echo $_SESSION['session_Username'];?>! </span></h2>
  <p><a href="logout.php">Выйти</a> из системы</p>
</div>
	
<?php include("includes/footer.php"); ?>
	
<?php endif; ?>
