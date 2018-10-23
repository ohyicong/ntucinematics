<?php
	if (!isset($_SESSION)){
		session_start();
	}
	$servername="localhost";
	$dbusername="myuser";
	$dbpassword="xxxx";
	$dbname="user_data";
	$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
	$address=$_POST['address'];
	$postalcode=$_POST['postalcode'];
	$cardno=$_POST['cardno'];
	$ccv=$_POST['ccv'];
	$cardtype=$_POST['cardtype'];
	$password=$_POST['password'];
	$useraccount=json_decode($_SESSION['useraccount'])[0];
	$query="update user_accounts set address='".$address."', postalcode='".$postalcode."', cardno='".$cardno."', ccv='".$ccv."'".", cardtype='".$cardtype."', password='".$password."' where userid='".$useraccount->userid."'";
	$conn->query($query);

	fclose($fp);
?>