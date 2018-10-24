<?php

$servername="localhost";
$dbusername="myuser";
$dbpassword="xxxx";
$dbname="ntucinematics";

$string=$_POST["string"];

//create connection  
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
$result = mysqli_query($conn, $string);
	
$conn->close();

?>

