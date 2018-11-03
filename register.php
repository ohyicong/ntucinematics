<!DOCTYPE html>
<html>
<?php 
	if (!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION["useraccount"])){
		echo "<script>alert('You are logged in');location.href='./index.php';</script>";
	}else{
		echo "<script>const useraccount=null</script>";
	}
	if(isset($_POST["table_name"])){
		$servername="localhost";
		$dbusername="myuser";
		$dbpassword="xxxx";
		$dbname="ntucinematics";

		//[name, password, email, address, cardno];
		$table_name=$_POST["table_name"];
		$name=$_POST["name"];
		$password=$_POST["password"];
		$email=$_POST["email"];
		$address=$_POST["address"];
		$cardno=$_POST["cardno"];
		$ccv=$_POST["ccv"];
		$cardtype=$_POST["cardtype"];
		$postalcode=$_POST["postalcode"];

		//create connection  
		$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
		$result = $conn->query("select * from user_accounts where userid = '".sha1($email)."'");
		if($result->num_rows>0){
			echo "<script>alert('Email has been used!')</script>";
		}else{
			$query="INSERT INTO ". $table_name . "(userid ,name, password, email, cardno, address, ccv, cardtype,postalcode)" . " VALUES ('". sha1($email) . "','" . $name . "','" . $password . "','" . $email . "','" . $cardno . "','" . $address . "','" . $ccv ."','". $cardtype  ."','".$postalcode."')";
			$result = mysqli_query($conn,$query);
			echo "<script>console.log('Sucessful!');location.href='./login.php';</script>";
		}
		$conn->close();
	}
	
?>
<head>
	<title>Movies</title>
	<script type="text/javascript" src="./scripts/globalInit.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<script type="text/javascript" src='./scripts/register.js'></script>
</head>
<body>
	<div class="clearfix">
		<header>
			<img src="./img/logo.jpg" style="width:80%;height:100%;">
		</header>
		<nav style="text-align:right;padding-right:0px">
			<a href="./index.php" class="menu">Home</a>
			<a href="./movies.php" class="menu">Movies</a>
			<a href="./promotions.php" class="menu">Promotions</a>
			<a href="./cart.php" class="menu" > Cart</a>
			<span class="account-box" style="float:right;">
				<?php
					if (isset($_SESSION["useraccount"])){
						$useraccount= json_decode($_SESSION["useraccount"])[0];
						echo "	<span id='account' class='menu' style='padding-right:0px;'>
									<a>".strtoupper($useraccount->name)."</a>
								</span>
								<span id='account-option' class='account-option' style='width:100%;text-align: center;''>
									<a href='./useraccount.php'>Profile</a>
									<a href='./logout.php'>Logout</a>
								</span>	";		
					}else{
						echo"	<span id='account' class='menu' style='padding-right:0px'> 
									Account
								</span>
								<span id='account-option' class='account-option' style='width:100%;text-align: center;''>
									<a href='./login.php'>Login</a>
									<a href='./register.php'>Register</a>
								</span>	";
					}
				?>
			</span>			
			<span class="dot" >
				<?php
						if(isset($_SESSION['usercart'])){
							$tempcount=0;
							foreach ($_SESSION['usercart'] as $item) {
							   	foreach ($item->tickets as $ticket) {
							   		$tempcount=$tempcount+1;
								}
							}
							echo $tempcount;
						}else{
							echo "0";
						}
					?>
			</span>
		</nav>
	</div>
	<span class="two-third" style="height:600px;">
		<form id="registerForm" style="margin:0px" method="POST" action="./register.php" onsubmit="return false;" >
			<input type="" name="table_name" value="user_accounts" style="display:none">
		  <fieldset style="margin:0px">
		    <legend>Personal Information</legend>
			<label>Name</label><label id='nameWarning' style="color:red;display:none" >&nbsp*min 6 characters</label><br>
			<input id='name' name='name' type="text" style="height:30px;width:33.33%" class="teal-input" value='yicong'><br>
			<label>Email</label><label id='emailWarning' style="color:red;display:none">&nbsp*invalid email</label><br>
			<input id='email' name='email' type="email" style="height:30px;width:33.33%" class="teal-input" value='ohyicong123@hotmail.com'><br>
			<label>Address</label><label id='addressWarning' style="color:red;display:none">&nbsp*required</label><br>
			<textarea id='address' name='address' style="height:50px;width:33.33%" class="teal-input" value='Ang mo kio 123'></textarea><br>
			<label>Postalcode</label><label id='postalcodeWarning'style="color:red;display:none">&nbsp*invalid postalcode</label><br>
			<input id='postalcode' name='postalcode' type="number" style="height:30px;width:33.33%" class="teal-input" value='123456'><br>
		  </fieldset>
		  <fieldset style="margin:0px">
		    <legend>Payment Information</legend>
			<label>Card type</label><label id='cardtypeWarning' style="color:red;display:none">&nbsp*please make a selection</label><br>
			<select id="cardtype" name='cardtype' class="grey-input" style="height:30px">
				<option value="" disabled selected>-Please Select-</option>
				<option>Mastercard</option>
				<option>VISA</option>
			</select><br>
			<label>CreditCard Number</label><label id='cardnoWarning' style="color:red;display:none">&nbsp*invalid card number</label><br>
			<input id='cardno' type="number" name='cardno' value="1234512345123451" class="grey-input" style="height:30px"><br>
		    <label>Card Verification Number</label><label id='ccvWarning' style="color:red;display:none">&nbsp*invalid card number</label><br>
		    <input id='ccv' type="number" name="ccv" value="123" class="grey-input" style="height:30px"><br>
		  </fieldset>
		  <fieldset>
		  	<legend>Account Information</legend>
		  	<label>Password (min. 6)</label><label id='passwordWarning' style="color:red;display:none">&nbsp*check inputs</label><br>
			<input id='password'type="password" name='password' style="height:30px;width:33.33%" class="teal-input" value='123123'><br>
			<label>Retype-Password</label><label id='retypepasswordWarning' style="color:red;display:none">&nbsp*check inputs</label><br>
			<input id='retypepassword'type="password" style="height:30px;width:33.33%" class="teal-input" value='123123'><br>
			<input id='registerbtn' type="button" value="Register" class="teal-border-button" onclick="onRegister()" style="margin-top:10px;">
		  </fieldset>
		  
		</form>
	</span>
	<footer style="text-align:center;">
		<label style="border-right:1px solid black;margin-right:10px">
			Careers
		</label>
		<label style="border-right:1px solid black;margin-right:10px">
			FAQ
		</label>
		<label>
			Contact us
		</label>	
		<br>
		<label>
			Copyright to this website belongs to MyMovie Pte Ltd. The contents of this website shall not be reproduced in any form in whole or in part. We reserve all rights.
		</label>
	</footer>
</body>

</html>