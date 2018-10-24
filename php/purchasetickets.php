<?php
	if (!isset($_SESSION)){
		session_start();
	}
	$servername="localhost";
	$dbusername="myuser";
	$dbpassword="xxxx";
	$dbname="user_data";
	$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
	$email=$_POST['email'];
	$userID=sha1($_POST['email']);
	$movie=$_POST['movie'];
	$quantity=$_POST['quantity'];
	$purchaseDate=$_POST['purchaseDate'];
	$movieDate=$_POST['movieDate'];
	$tickets=$_POST['tickets'];
	$ticketsArray=json_decode($_POST['tickets']);
	$uniqueID=$_POST['uniqueID'];
	$cinema=$_POST['cinema'];
	//Query for movie_id
	$query="select movie_id from current_movies where movie_name='".$movie."'";
	$result=$conn->query($query);
	$movieID=$result->fetch_assoc();
	$movieID=$movieID['movie_id'];

	$insert="insert into `purchase_history`(`userID`, `movieID`, `quantity`, `purchaseDate`, `movieDate`, `seatNumber`,`cinema`,`movieName`) values ('".$userID."','".$movieID."',".$quantity.",'".$purchaseDate."','".$movieDate."','".$tickets."','".$cinema."','".$movie."')";
	$conn->query($insert);
	$fp = fopen('./purchasetix.txt', 'w');
	fwrite($fp, 'hello,');
	foreach ($ticketsArray as $key => $value) {
		$insert="insert into `unique_seats` (`UNIQUE_ID`, `SEAT_NO`, `DATETIME`) values ('".$uniqueID."','".$value."','".$movieDate."')";
		$conn->query($insert);
		fwrite($fp, $insert);
	}
	fclose($fp);


?>