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
	if(isset($_SESSION["usercart"])){
		foreach ($_SESSION["usercart"] as $key => $value) {	
			if(count($value->tickets)==0){
				unset($_SESSION["usercart"][$key]);
				echo "My console:".var_dump($value);
			}
		}
	}
	if(isset($_GET["remove"])){
		unset($_SESSION['usercart'][$_GET["remove"]]);
	}
?>
<head>
	<title>Movies</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<script type="text/javascript" src='./scripts/globalinit.js'></script>
	<script type="text/javascript" src='./scripts/moment.js'></script>
	<script type="text/javascript">
		var totalTickets=0;
		var userCart;
		window.onload=function(){
			globalInit();
			onInit();
		}
		function onInit(){
			totalTickets=0;
			console.log(userCart);
			if(userCart==''||userCart=='null'||userCart==null||userCart.length==0){
				//alert('No items in cart.... You will be redirected');
				//window.location.href="./index.php"	
			}
			//Check if accoun details exist
			autofill();
		}
		function onPurchase(){
			function checkName(ele){
				regex=/^[A-Za-z\s]+$/;
				if(!regex.test(ele.value)){
					console.log("name error");
					ele.style.border='1px solid #B91D47';
				}else{
					ele.style.border='1px solid #00B3B3';
				}
				return regex.test(ele.value);
			}
			function checkEmail(ele){
				regex=/^[\w.-]+@[A-Za-z](.[A-Za-z]{2,3})+$/;
				if(!regex.test(ele.value)){
					console.log("email error");
					ele.style.border='1px solid #B91D47';
				}else{
					ele.style.border='1px solid #00B3B3';
				}
				return regex.test(ele.value);
			}
			function checkAddress(ele){
				regex=/^[\w\s-.#@()]+$/;
				if(!regex.test(ele.value)){
					console.log("address error");
					ele.style.border='1px solid #B91D47';
				}else{
					ele.style.border='1px solid #00B3B3';
				}
				return regex.test(ele.value);
			}
			function checkPostal(ele){
				regex=/^[\d]{6}$/;
				if(!regex.test(ele.value)){
					console.log("postal error");
					ele.style.border='1px solid #B91D47';
				}else{
					ele.style.border='1px solid #00B3B3';
				}
				return regex.test(ele.value);
			}
			function checkCardNumber(ele){
				regex=/^[\d]{16}$/;
				if(!regex.test(ele.value)){
					console.log("cardno error");
					ele.style.border='1px solid #B91D47';
				}else{
					ele.style.border='1px solid #00B3B3';
				}
				return regex.test(ele.value); 
			}
			function checkCardVerification(ele){
				regex=/^[\d]{3}$/;
				if(!regex.test(ele.value)){
					console.log("cardveri error");
					ele.style.border='1px solid #B91D47';
				}else{
					ele.style.border='1px solid #00B3B3';
				}
				return regex.test(ele.value);
			}
			function checkCardType(ele){
				if(ele.value){
					ele.style.border='1px solid #00B3B3';
					return true;
				}else{
					ele.style.border='1px solid #B91D47';
					return false;
				}
			}
			if(checkName(document.getElementById('name'))&&checkEmail(document.getElementById('email'))&&checkAddress(document.getElementById('address'))&&checkPostal(document.getElementById('postalcode'))&&checkCardNumber(document.getElementById('cardno'))&&checkCardVerification(document.getElementById('ccv'))&&checkCardType(document.getElementById('cardtype'))){
				document.getElementById('confirmPage').style.display='block';
			}else{
				alert('Please check your inputs');
			};


		}

		function onConfirm(){
			document.getElementById('confirmPage').style.display='none';
			const spinner = document.getElementById('spinner');
			spinner.style.display="block";
			const confirmInterval=setInterval(function(){
				if(Math.random()>0){
					let cartForm=document.getElementById('cartForm');
					cartForm.submit();
				}else{
					spinner.style.display="none";
					alert('Payment failed... Please try again');
				}
				clearInterval(confirmInterval);
			},2000)
	
		}
		setInterval(function(){
			onInit();
		},3000)

		function autofill(){
			if(useraccount==null||useraccount==''){
				console.log("No login details");
				return;
			}
			// ARRAY FORMAT [userID, Name, Password, Email, Address, CardNo, CCV]
			console.log("My useraccount",useraccount);
			document.getElementById('name').value=useraccount.name;
			document.getElementById('email').value=useraccount.email;
			document.getElementById('address').value=useraccount.address;
			document.getElementById('postalcode').value=useraccount.postalcode;
			document.getElementById('cardno').value=useraccount.cardno;
			document.getElementById('ccv').value=useraccount.ccv;
			document.getElementById('cardtype').value=useraccount.cardtype;
		}
	
	</script>
	<script type="text/javascript" src='./scripts/globalinit.js'></script>
	<style>
		.table td,th{border:1px solid black;text-align:left;}
		.table tr:nth-child(even){background-color: #b3b3b3}
	</style>
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
	<div class="container clearfix" style="margin-bottom:10px">
		<center>
			<select id="SelectMovie" class="menu-select" onchange="onClick(1,'loc_address', 'MOVIE_ID', this, ['CINEMA_ID','CINEMA'],'OPTION','SelectCinema')" style="width:40%;margin-right:1.25%">
				<option value="" disabled selected>Select movie</option>
			</select>
			<select id="SelectCinema" class="menu-select" onchange="onClick(2,'loc_address', 'CINEMA_ID', this, ['DAY','DAY'],'OPTION', 'SelectDate')" style="width:15%;margin-right:1.25%">
				<option value="" disabled selected>Select cinema</option>
			</select>
			<select id="SelectDate" class="menu-select" onchange="onClick(3,'loc_address', 'DAY', this, ['TIME','TIMESTAMP'],'OPTION', 'SelectTime')" style="width:15%;margin-right:1.25%">
				<option value="" disabled selected>Select day</option>
			</select>
			<select id="SelectTime" class="menu-select" onchange="onClick(4,'loc_address', 'TIME', this, ['UNIQUE_ID','UNIQUE_ID'], 'BUTTON', 'BOOK')" style="width:15%;margin-right:1.25%">
				<option value="" disabled selected>Select time</option>
			</select>
			<input id="BOOK" type="button" class="teal-button" value="Book now" onclick="storeSend()" style="width:10%">
		</center>
	</div>
	<span class="two-third" style="height:600px">
		<form id='cartForm' method="POST" action="./paymentsuccess.php">
		  <fieldset>
		    <legend>Personal Details</legend>
			<label>Name</label><br>
			<input name='name' id='name' type="text" style="height:25px;width:33.33%" class="teal-input" value=''><br>
			<label>Email</label><br>
			<input name='email' id='email'type="email" style="height:25px;width:33.33%" class="teal-input" value=''><br>
			<label>Address</label><br>
			<textarea name='address' id='address' style="height:50px;width:33.33%" class="teal-input" value=''></textarea><br>
			<label>Postalcode</label><br>
			<input name='postalcode' id='postalcode'type="number" style="height:25px;width:33.33%" class="teal-input" value=''><br>
		  </fieldset>
		  <fieldset>
		    <legend>Payment Details</legend>
			<label>Card type*</label><br>
			<select name='cardtype' id="cardtype" class="grey-input" style="height:25px">
				<option value="" disabled selected>-Please Select-</option>
				<option>Mastercard</option>
				<option>VISA</option>
			</select><br>
			<label>CreditCard Number*</label><br>
			<input name='cardno' id='cardno' type="text" value="" class="grey-input" style="height:25px"><br>
		    <label>Card Verification Number*</label><br>
		    <input name='ccv' id='ccv' type="number" name="" class="grey-input" style="height:25px"><br>
		  </fieldset>
		</form>
	</span>
	<span class="one-third" style="height:600px">
		<div style="width:90%;padding:10px;border:1px solid black;margin:auto;border-radius:5px;">
			<label style="font-size:20px;color:#008080">Your Basket</label>
			<hr>
			<div style="height:300px">
				<table style="width:100%;border:none" id='carttable'> 
					<?php
						foreach ($_SESSION['usercart'] as $key => $item) {
							echo "<tr>";
							echo "<td><a style='color:red;text-decoration:none' href='".$_SERVER['PHP_SELF']."?remove=".$key."''>X</a></td>";
							echo "<td>";
							echo $item->movie." (";
							echo $item->cinema.")";
							echo "<td>";
							echo "<td>";
							echo "x ".count($item->tickets);
							echo "<td>";
							echo "</tr>";
							echo "<tr><td></td>";
							echo "<td> Time: ";
							echo $item->time;
							echo "</td><td></td><td></td>";
							echo "</tr>";
							echo "<tr><td></td>";
							echo "<td> Seats: ";
							echo preg_replace('/[\"\[\]]/'," ",json_encode($item->tickets));
							echo "</td><td></td><td></td>";
							echo "</tr>";
						}
					?>
				</table>
			</div>
			<table style="width:100%;border:none"> 
				<tr>
					<td>
						Total
					</td>
					<td id="total" style="text-align:right"></td>
				</tr>
			</table>
			<br><br>
			<center>
				<input type="button" class="teal-border-button" Value="Purchase" onclick="onPurchase()" style="width:80%;"><br><br>
			</center>
		</div>
		
	</span>
	<footer>
		<center>
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
		</center>
	</footer>
</body>
<div id='confirmPage' style="z-index:2;margin:auto;width:100%;height:100%;padding:0px;top:0px;right:0;position:absolute;background-color: white;opacity:0.9;display: none;">
	<center style="margin-top:10%">
		<h2  style="margin-bottom:15px">Tickets Confirmation</h2>
		<table id='tableConfirm' class="table" style="margin-bottom:15px" cellpadding="15px">
			<tr>
				<th>Movie</th>
				<th>Cinema</th>
				<th>Time</th>
				<th>Seats</th>
				<th>Quantity</th>
				<th>Subtotal</th>
			</tr>
			<?php
				foreach ($_SESSION['usercart'] as $key => $item) {
					echo "<tr>";
					echo "<td>".$item->movie."</td>";
					echo "<td>".$item->cinema."</td>";
					echo "<td>".$item->time."</td>";
					echo "<td>".preg_replace('/[\"\[\]]/'," ",json_encode($item->tickets));
					echo "<td>".count($item->tickets)."</td>";
					echo "<td>".number_format(count($item->tickets)*12,2,'.','')."</td>";
					echo "</tr>";
				}
			?>
		</table>
		<input type="" name="" value="Confirm" class="teal-button" style="width:100px;" onclick="onConfirm()">
		<input type="" name="" value="Cancel" class="red-button" style="width:100px" onclick="document.getElementById('confirmPage').style.display='none'; ">
	</center>
</div>
<div id='spinner' style="z-index:2;margin:auto;width:65%;height:100%;padding:0px;top:0px;position:absolute;background-color: white;opacity:0.9;display: none;">
	<center style="margin-top:20%">
		<h1 style="color:#008080;display:inline;">NTU|</h1>
		<h1 style="display:inline;">Cinematics</h1><br><br>
		<div class="spinner"></div><br>
		<p>Payment in progress...</p>
	</center>
</div>
</html>