<?php

$servername="localhost";
$dbusername="myuser";
$dbpassword="xxxx";
$dbname="user_data";

$table_name=$_POST["table_name"];
$condition=$_POST["condition"];
$value=$_POST["value"];


//create connection

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);


if ($condition=="updateSeats"){

	$ID = $_POST["ID"];
	$tickets = $_POST["tickets"];

	for($i=0; sizeof($tickets);$i++){
		$result=mysqli_query($conn, "UPDATE " . $table_name . " SET STATUS = '" . $value ."' WHERE (UNIQUE_ID, SEAT_NO) = (" . $ID . ',' . $tickets[$i] . ")");
	}

	$conn->close();
	echo ("UPDATE " . $table_name . " SET STATUS = '" . $value ."' WHERE (UNIQUE_ID, SEAT_NO) = (" . $col . ")");

} else {
	$return_column=$_POST["return_column"];
	$result = mysqli_query($conn, "SELECT " .  $return_column . " FROM " . $table_name . " WHERE " . $condition . "=" ."'". $value."'");
	//UPDATE `unique_seats` SET `STATUS`='True' WHERE UNIQUE_ID='1001001001' AND SEAT_NO='1';
	//$result = mysqli_query($conn, "INSERT INTO ". $table_name . "(" . $return_column . ")" . " VALUES (" . $value . ")". "WHERE");
	//$result = mysqli_query($conn, "SELECT*FROM " . $table_name);
	while($row = mysqli_fetch_assoc($result)){
		$data[]=$row;
	}
	//array_unshift($data,$value);
	$conn->close();
	echo json_encode($data);
}

?>

