<!DOCTYPE html>
<html>
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
		<form style="margin:0px">
		  <fieldset style="margin:0px">
		    <legend>Personal Details</legend>
			<label>Name</label><br>
			<input id='name' type="text" style="height:25px;width:33.33%" class="teal-input" value='yicong'><br>
			<label>Email</label><br>
			<input id='email'type="email" style="height:25px;width:33.33%" class="teal-input" value='ohyicong123@hotmail.com'><br>
			<label>Password</label><br>
			<input id='password'type="password" style="height:25px;width:33.33%" class="teal-input" value='123123'><br>
			<label>Retype-Password</label><br>
			<input id='retypepassword'type="password" style="height:25px;width:33.33%" class="teal-input" value='123123'><br>
			<label>Address</label><br>
			<textarea id='address' style="height:50px;width:33.33%" class="teal-input" value='Ang mo kio 123'></textarea><br>
			<label>Postalcode</label><br>
			<input id='postalcode'type="number" style="height:25px;width:33.33%" class="teal-input" value='123456'><br>
		  </fieldset>
		  <fieldset style="margin:0px">
		    <legend>Payment Details</legend>
			<label>Card type*</label><br>
			<select id="cardtype" class="grey-input" style="height:25px">
				<option value="" disabled selected>-Please Select-</option>
				<option>Mastercard</option>
				<option>VISA</option>
			</select><br>
			<label>CreditCard Number*</label><br>
			<input id='cardno' type="number" value="1234512345123451" class="grey-input" style="height:25px"><br>
		    <label>Card Verification Number*</label><br>
		    <input id='ccv' type="number" name="" value="123" class="grey-input" style="height:25px"><br>
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