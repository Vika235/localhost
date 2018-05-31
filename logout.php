<?php
	session_start();
	unset($_SESSION['session_Username']);
    unset($_SESSION['session_UserEntity']);
    unset($_SESSION['session_UserOrder']);
	session_destroy();
	header("location:login.php");
