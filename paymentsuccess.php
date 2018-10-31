<!DOCTYPE html>
<html>
<?php
	if (!isset($_SESSION)){
		session_start();
	}
	if (!isset($_SESSION['usercart'])){
		$_SESSION['usercart'] = array();
	}
	if(isset($_SESSION["useraccount"])){
		echo "<script>const useraccount=".$_SESSION["useraccount"]."[0];console.log(useraccount)</script>";
	}else{
		echo "<script>const useraccount=null</script>";
	}
	$servername="localhost";
	$dbusername="myuser";
	$dbpassword="xxxx";
	$dbname="ntucinematics";
	$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
	$purchaseString="";
	foreach ($_SESSION['usercart'] as $uniqueID => $item) {
		foreach ($item->tickets as $keyTicket => $ticket) {
			$insert="insert into `unique_seats` (`UNIQUE_ID`, `SEAT_NO`, `DATETIME`) values ('".$uniqueID."','".$ticket."','".$item->date." ".$item->time."')";
			$conn->query($insert);
		}
		$insert="insert into `purchase_history`(`userID`, `movieID`, `quantity`, `purchaseDate`, `movieDate`, `seatNumber`,`cinemaID`,`uniqueID`) values ('".sha1($_POST['email'])."','".substr($uniqueID,0,3)."',".count($item->tickets).",'".date("Y-m-d h:i")."','".$item->date." ".$item->time."','".preg_replace('/[\"\[\]]/'," ",json_encode($item->tickets))."','".substr($uniqueID,3,3)."','".$uniqueID."')";
			$conn->query($insert);
		$purchaseString=$purchaseString.$item->movie." (".$item->cinema."), ".$item->date." at ".$item->date." hrs \r\n";
		echo $insert;
	}
	//$to      = "ohyicong@hotmail.com";
	//$message = 'Dear '.$_POST['name'].",\r\n".$purchaseString."\r\n\r\n Kind Regards,\r\nNTUCinematics";
	//$headers = 'From: f32ee@localhost' . "\r\n" .
	//    'Reply-To: f32ee@localhost' . "\r\n" .
	//    'X-Mailer: PHP/' . phpversion();

	//mail($to, "NTUCinematics: Payment confirmation", $message, $headers,'-ff32ee@localhost');
	//echo ("mail sent to : ".$to);
	$_SESSION['usercart'] = array();
?>
<head>
	<title>Movies</title>
</head>
<script type="text/javascript">
	window.onload= function(){
		redirect= document.getElementById('redirect');
		oldTime=new Date();
		const countdown= setInterval(function(){
			newTime = new Date();
			redirect.innerHTML="You will be redicted in...."+(5-parseInt((newTime-oldTime)/1000));
			if((newTime-oldTime)>=5000){
				clearInterval(countdown);
				location.href="./index.php";
				console.log("intervalcleared");
			}
		},1000)
	}

</script>
<body>
	<div style="border:1px solid grey;width:20%;height:450px;padding:10px;margin:auto">
		<center>
			<h1>Payment Successful</h1>
			<img src="./img/payment-success.png"><br>
			<label style="font-size:20px">E-ticket has been sent to:</label><br>
			<label style="font-size:15px"><?php echo $_POST['email']; ?></label><br><br>
			<a href="./index.html" id='redirect' style="font-size:15px">You will be redicted in....5</a>
		</center>	
	</div>
	
</body>
</html>