<!DOCTYPE html>
<html>
<?php
	if (!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION["useraccount"])){
		echo "<script> 
				const useraccount=".$_SESSION["useraccount"]."[0]
				window.onload=function(){
					document.getElementById('password').value=useraccount.password;
					document.getElementById('retypepassword').value=useraccount.password;
					document.getElementById('name').value=useraccount.name;
					document.getElementById('email').value=useraccount.email;
					document.getElementById('address').value=useraccount.address;
					document.getElementById('postalcode').value=useraccount.postalcode;
					document.getElementById('cardtype').value=useraccount.cardtype;
					document.getElementById('cardno').value=useraccount.cardno;
					document.getElementById('ccv').value=useraccount.ccv;
				}
			  </script>";
	}else{
		echo "<script>const useraccount=null</script>";
		header("Location: ./index.php");
	}
	

?>

<head>
	<title>Movies</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<script type="text/javascript" src='./scripts/globalinit.js'></script>
	<script>
		function checkBeforeSave(){
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




			if(checkName(document.getElementById('name'))&&checkEmail(document.getElementById('email'))&&checkAddress(document.getElementById('address'))&&checkPostal(document.getElementById('postalcode'))&&checkCardNumber(document.getElementById('cardno'))&&checkCardVerification(document.getElementById('ccv'))&&checkCardType(document.getElementById('cardtype'))&&checkPassword()){
				console.log("checkpw",checkPassword());
				if(confirm("Confirm changes?")){
					let form = new FormData();
					let ajax = new XMLHttpRequest();
					let method = "POST";
					let url = "./php/changeaccinfo.php";
					let asynchronous=true;
					form.append('address',document.getElementById('address').value);
					form.append('postalcode',document.getElementById('postalcode').value);
					form.append('cardno',document.getElementById('cardno').value);
					form.append('ccv',document.getElementById('ccv').value);
					form.append('cardtype',document.getElementById('cardtype').value);
					form.append('password',document.getElementById('password').value);
					ajax.open(method, url, asynchronous);	
					ajax.send(form);
					console.log("Form sent",form);
					alert("Details Updated")
					location.reload();

				}else{

				}
			}else{
				document.getElementById('address').readOnly=false;
				document.getElementById('postalcode').readOnly=false;
				document.getElementById('cardno').readOnly=false;
				document.getElementById('ccv').readOnly=false;
				document.getElementById('cardtype').readOnly=false;
				document.getElementById('retypepassword').readOnly=false;
				document.getElementById('password').readOnly=false;
				alert('Try again! Incorrect inputs!');
			};


		}

		function checkPassword(){
			passwordEle=document.getElementById('password');
			retypePasswordEle=document.getElementById('retypepassword');
			if(passwordEle.value!=''&&retypePasswordEle.value!=''){
				if(passwordEle.value==retypePasswordEle.value){
					passwordEle.style.border='1px solid #00B3B3';
					retypePasswordEle.style.border='1px solid #00B3B3';				
					return true;
				}else{
					passwordEle.style.border='1px solid #B91D47';
					retypePasswordEle.style.border='1px solid #B91D47';
					return false;
				}
			}else{
					passwordEle.style.border='1px solid #B91D47';
					retypePasswordEle.style.border='1px solid #B91D47';
					return false;
			}
		}


		function onChange(){
			document.getElementById('address').readOnly=false;
			document.getElementById('postalcode').readOnly=false;
			document.getElementById('cardno').readOnly=false;
			document.getElementById('ccv').readOnly=false;
			document.getElementById('cardtype').readOnly=false;
			document.getElementById('retypepassword').readOnly=false;
			document.getElementById('password').readOnly=false;

			document.getElementById('address').style.borderColor="#008080";
			document.getElementById('postalcode').style.borderColor="#008080";
			document.getElementById('cardno').style.borderColor="#008080";
			document.getElementById('ccv').style.borderColor="#008080";
			document.getElementById('cardtype').style.borderColor="#008080";
			document.getElementById('retypepassword').style.borderColor="#008080";
			document.getElementById('password').style.borderColor="#008080";

			document.getElementById('saveBtn').style.display="inline";
			document.getElementById('cancelBtn').style.display="inline";
			document.getElementById('changeBtn').style.display="none";
			
		}
		function onSave(){
			document.getElementById('address').readOnly=true;
			document.getElementById('postalcode').readOnly=true;
			document.getElementById('cardno').readOnly=true;
			document.getElementById('ccv').readOnly=true;
			document.getElementById('cardtype').readOnly=true;
			document.getElementById('retypepassword').readOnly=true;
			document.getElementById('password').readOnly=true;

			document.getElementById('address').style.borderColor="#00B3B3";
			document.getElementById('postalcode').style.borderColor="#00B3B3";
			document.getElementById('cardno').style.borderColor="#00B3B3";
			document.getElementById('ccv').style.borderColor="#00B3B3";
			document.getElementById('cardtype').style.borderColor="#00B3B3";
			document.getElementById('retypepassword').style.borderColor="#00B3B3";
			document.getElementById('password').style.borderColor="#00B3B3";
			checkBeforeSave();
		}
		function onCancel(){
			location.reload();
		}
		document.onload=function(){
			readOnlyTrue();
		}
		

	</script>
	<style>
		table {width:100%;text-align:left;padding:0px;border-collapse: collapse;}
		tr:nth-child(even) {background-color: #f2f2f2;}
		form input{height:30px;width:40%;font-size:15px;}
		form select option{height:30px;width:40%;font-size:15px}
		form textarea{height:30px;width:40%;font-size:15px}
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
	<div style="height:600px;">
		<div>
			<input id="nowShowingBtn" type="button" value="Account" class="teal-border-button" style="float:left;outline:none;border-radius:0px;width:10%" onclick="document.getElementById('nowShowing').style.visibility = 'visible';
			 document.getElementById('comingSoon').style.visibility = 'hidden';
			 document.getElementById('comingSoon').style.height = '0px';
			 document.getElementById('nowShowing').style.height = '600px';
			 this.classList.remove('grey-button');
			 this.classList.add('teal-border-button');
			 document.getElementById('comingSoonBtn').classList.remove('teal-border-button');
			 document.getElementById('comingSoonBtn').classList.add('grey-button');
			 console.log(document.getElementById('comingSoonBtn').classList);"
			 >
		<input id="comingSoonBtn" type="button" value="Purchases" class="grey-button" style="float:left;outline:none;border-radius:0px;width:10%;" onclick="document.getElementById('nowShowing').style.visibility = 'hidden';
			 document.getElementById('comingSoon').style.visibility = 'visible';
			 document.getElementById('nowShowing').style.height = '0px';
			 document.getElementById('comingSoon').style.height = '600px';
			 this.classList.remove('grey-button');
			 this.classList.add('teal-border-button');
			 document.getElementById('nowShowingBtn').classList.remove('teal-border-button');
			 document.getElementById('nowShowingBtn').classList.add('grey-button');">
		</div>
		<span id="nowShowing" class="full" style="height:600px;overflow-y:none">
			<div id='accountinfo' style="height:40%;width:100%">
				<form>
				  <fieldset>
				    <legend>Personal Details</legend>
					<label>Name</label><br>
					<input id='name' type="text" style="border-color:#b3b3b3" class="teal-input" value='' readonly="readonly"><br>
					<label>Email</label><br>
					<input id='email'type="email" style="border-color:#b3b3b3"   class="teal-input" value='' readonly="readonly"><br>
					<label>Address</label><br>
					<textarea id='address' style="height:50px;border-color:#b3b3b3;"  class="teal-input" value='' readonly="readonly"></textarea><br>
					<label>Postalcode</label><br>
					<input id='postalcode'type="number" style="border-color:#b3b3b3"   class="teal-input" value='' readonly="readonly"><br>
					<label>Password</label><br>
					<input id='password' type="password" style="border-color:#b3b3b3"  class="teal-input" value='' readonly="readonly" required=""><br>
					<label>Retype password</label><br>
					<input id='retypepassword'type="password" style="border-color:#b3b3b3"  class="teal-input" value='' onkeyup="checkPassword()" readonly="readonly"><br>

				  </fieldset>
				  <fieldset>
				    <legend>Payment Details</legend>
					<label>Card type*</label><br>
					<select id="cardtype" class="grey-input" style="height:30px" readonly="readonly">
						<option value="" disabled selected>-Please Select-</option>
						<option>Mastercard</option>
						<option>VISA</option>
					</select><br>
					<label>CreditCard Number*</label><br>
					<input id='cardno' type="text" value="" class="grey-input" readonly="readonly"><br>
				    <label>Card Verification Number*</label><br>
				    <input id='ccv' type="number" name="" class="grey-input"  readonly="readonly"><br>
				    <input id='changeBtn' type="button" value="Enable Edit" class="teal-border-button" onclick="onChange()" style="margin-top:10px;width:80px;font-size:10px">
				    <input id='saveBtn' type="button" value="Save" class="teal-border-button" onclick="onSave()" style="margin-top:10px;display: none;width:80px;font-size:10px;">
				    <input id='cancelBtn' type="button" value="Cancel" class="red-border-button" onclick="onCancel()" style="margin-top:10px;display: none;width:80px;font-size:10px;">
				  </fieldset>
				</form>
			</div>
		</span>
		<span id="comingSoon" class="full" style="height:600px;position:relative;z-index:-2px;visibility:hidden;overflow-y:auto;" >
			<table cellpadding="15px" style="margin-top:2px">
				<tr>
					<th>No.</th>
					<th>Movie Title</th>
					<th>Cinema</th>
					<th>Time</th>
					<th>Seats</th>
					<th>Date Of Purchase</th>
				</tr>
				<?php
					$servername="localhost";
					$dbusername="myuser";
					$dbpassword="xxxx";
					$dbname="ntucinematics";
					$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
					$useraccount=json_decode($_SESSION["useraccount"])[0];
					$query="select * from purchase_history inner join loc_address on purchase_history.uniqueID=loc_address.unique_id where userid='".$useraccount->userid."'";
					$result=$conn->query($query);
					if ($result->num_rows > 0) {
					    // output data of each row
					    $i=0;
					    while($row = $result->fetch_assoc()) {
					    	$i++;
					        echo "<tr>";
					        echo "<td>".$i."</td>";
					        echo "<td>".$row["MOVIE_NAME"]."</td>";
					        echo "<td>".$row["CINEMA"]."</td>";
					        echo "<td>".$row["movieDate"]."</td>";
					        echo "<td>".preg_replace("/[\[\]\"]/", "",$row["seatNumber"])."</td>";
					        echo "<td>".$row["purchaseDate"]."</td>";
					        echo "</tr>";
					    }
					}else{
						echo "<tr><td colspan='5'>No information available</td></tr>";
					}
				?>
			</table>
		</span>
	</div>



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
</html>