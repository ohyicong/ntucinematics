<?php

$servername="localhost";
$dbusername="myuser";
$dbpassword="xxxx";
$dbname="user_data";

//[name, password, email, address, cardno];
$table_name=$_POST["table_name"];
$name=$_POST["name"];
$password=$_POST["password"];
$email=$_POST["email"];
$address=$_POST["address"];
$cardno=$_POST["cardno"];
$ccv=$_POST["ccv"];

//create connection  

$userid=$name[1] . $email[1] . $address[1] . $email[2] . $name[2];

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

$result = mysqli_query($conn, "INSERT INTO ". $table_name . "(userid ,name, password, email, cardno, address, ccv)" . " VALUES ('". $userid . "','" . $name . "','" . $password . "','" . $email . "','" . $cardno . "','" . $address . "','" . $ccv . "');");

	
$conn->close();

?>

