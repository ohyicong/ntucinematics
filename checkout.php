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
?>
<head>
	<title>Movies</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<script type="text/javascript" src="./scripts/globalinit.js"></script>
	<style type="text/css">
		.taken{border-radius:6px;background-color:pink}
		.available{border-radius:6px;background-color:green}
		.choosen{border-radius:6px;background-color:grey}
	</style>
</head>
<?php  
		if(isset($_GET['uniqueID'])&&isset($_GET['userSelection'])){
			//if init seats
			$_SESSION['uniqueID']=$_GET['uniqueID'];
			$_SESSION['userSelection']=json_decode($_GET['userSelection']);
			//Get movie info
			$query = "select timestamp from loc_address where UNIQUE_ID='".$_GET['uniqueID']."'";
			$result=$conn->query($query);
			$movieinfo = $result->fetch_assoc();
			//Get all seating info
			$query = "select seat_no from unique_seats where UNIQUE_ID='".$_GET['uniqueID']."' and DATETIME >='".date("Y-m-d")." ".$movieinfo["timestamp"]."'";
			$result=$conn->query($query);
			$seatArray=array();
			if (@$result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        array_push($seatArray, $row['seat_no']);
			    }

			} 
			$seats=array();
			for($i=0;$i<30;$i++){
				$isChecked=False;
				for($x=0;$x<count($seatArray);$x++){
					if($seatArray[$x]==(string)$i&&!$isChecked){
						array_push($seats,"0");
						$isChecked=True;	
					}
				}
				if(!$isChecked){
					array_push($seats,"1");
				}
			}
			echo "<script>obj.seat_status=".json_encode($seats).";console.log('My seats status',obj.seat_status)</script>";
		}else if(isset($_SESSION['uniqueID'])&&isset($_SESSION['userSelection'])&&isset($_GET['add'])){
			//if add seats
			if(!isset($_SESSION['usercart'][$_SESSION['uniqueID']])){
				//if not set feed into global usercart
				$_SESSION['usercart'][$_SESSION['uniqueID']]=$_SESSION['userSelection'];
			}
			if(!in_array($_GET['add'],$_SESSION['usercart'][$_SESSION['uniqueID']]->tickets)){
				array_push($_SESSION['usercart'][$_SESSION['uniqueID']]->tickets,$_GET['add']);
			}
			$query = "select timestamp from loc_address where UNIQUE_ID='".$_SESSION['uniqueID']."'";
			$result=$conn->query($query);
			$movieinfo = $result->fetch_assoc();
			$query = "select seat_no from unique_seats where UNIQUE_ID='".$_SESSION['uniqueID']."' and DATETIME >='".date("Y-m-d")." ".$movieinfo["timestamp"]."'";
			$result=$conn->query($query);
			$seatArray=array();
			if (@$result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        array_push($seatArray, $row['seat_no']);
			    }

			} 
			$seats=array();
			for($i=0;$i<30;$i++){
				$isChecked=False;
				for($x=0;$x<count($seatArray);$x++){
					if($seatArray[$x]==(string)$i&&!$isChecked){
						array_push($seats,"0");
						$isChecked=True;	
					}
				}
				if(!$isChecked){
					array_push($seats,"1");
				}
			}
			echo "<script>obj.seat_status=".json_encode($seats).";console.log('My seats status',obj.seat_status)</script>";
		}else if(isset($_SESSION['uniqueID'])&&isset($_SESSION['userSelection'])&&isset($_GET['remove'])){
			//remove seats
			if (($key = array_search($_GET['remove'], $_SESSION['usercart'][$_SESSION['uniqueID']]->tickets)) !== false) {
			    unset($_SESSION['usercart'][$_SESSION['uniqueID']]->tickets[$key]);
			}
			$query = "select timestamp from loc_address where UNIQUE_ID='".$_SESSION['uniqueID']."'";
			$result=$conn->query($query);
			$movieinfo = $result->fetch_assoc();
			$query = "select seat_no from unique_seats where UNIQUE_ID='".$_SESSION['uniqueID']."' and DATETIME >='".date("Y-m-d")." ".$movieinfo["timestamp"]."'";
			$result=$conn->query($query);
			$seatArray=array();
			if (@$result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        array_push($seatArray, $row['seat_no']);
			    }

			} 
			$seats=array();
			for($i=0;$i<30;$i++){
				$isChecked=False;
				for($x=0;$x<count($seatArray);$x++){
					if($seatArray[$x]==(string)$i&&!$isChecked){
						array_push($seats,"0");
						$isChecked=True;	
					}
				}
				if(!$isChecked){
					array_push($seats,"1");
				}
			}
			echo "<script>obj.seat_status=".json_encode($seats).";console.log('My seats status',obj.seat_status)</script>";
		}else if(isset($_SESSION['uniqueID'])&&isset($_SESSION['userSelection'])&&isset($_GET['removeall'])){
			//remove all 
			$_SESSION['usercart'][$_SESSION['uniqueID']]->tickets=array();
			$query = "select timestamp from loc_address where UNIQUE_ID='".$_SESSION['uniqueID']."'";
			$result=$conn->query($query);
			$movieinfo = $result->fetch_assoc();
			$query = "select seat_no from unique_seats where UNIQUE_ID='".$_SESSION['uniqueID']."' and DATETIME >='".date("Y-m-d")." ".$movieinfo["timestamp"]."'";
			$result=$conn->query($query);
			$seatArray=array();
			if (@$result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        array_push($seatArray, $row['seat_no']);
			    }

			} 
			$seats=array();
			for($i=0;$i<30;$i++){
				$isChecked=False;
				for($x=0;$x<count($seatArray);$x++){
					if($seatArray[$x]==(string)$i&&!$isChecked){
						array_push($seats,"0");
						$isChecked=True;	
					}
				}
				if(!$isChecked){
					array_push($seats,"1");
				}
			}
			echo "<script>obj.seat_status=".json_encode($seats).";console.log('My seats status',obj.seat_status)</script>";
		}
		
?>
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
		<div class="two-third" style="height:600px">
			<div class="full">
				<img id='movieImage' src=<?php echo "'".$_SESSION['userSelection']->movieImage."'" ?> style="width:220px;height:320px;float:left;margin-right:10px">
				<h2 id='movie'style="color:#008080;margin:0px;padding-left:10px"><?php echo $_SESSION['userSelection']->movie ?></h2>
				<p style='margin-top:10px' id='instruction'>
					<?php
						echo "Showing on :".$_SESSION['userSelection']->date."<br>Time :".$_SESSION['userSelection']->time."hrs <br>Venue: ".strtoupper($_SESSION['userSelection']->cinema);
						echo $_SESSION["uniqueID"];
					?>
						

				</p>
			</div>
			<div class="full">
			<br>
			<hr>
			<table id='table' cellpadding="10px" style="margin:auto;">
			<tr>
				<td colspan=10 style="text-align:center;border:2px solid #008080;border-radius:5px">
					Screen
				</td>
			</tr>
			<?php
				if(!isset($_SESSION['usercart'][$_SESSION['uniqueID']])){
					for($x=0;$x<3;$x++){
						echo "<tr>";
						for($y=0;$y<10;$y++){
							if($x==0){
								if($seats[($x*10)+$y]==0){
									echo "<td id='".$y."' class='taken' >".$y."</td>";
								}else{
									echo "<td id='".$y."' class='available' >"."<a style='color:black;text-decoration: none;' href='".$_SERVER['PHP_SELF']."?add=".$y."'>".$y."</a></td>";
								}
							}else{
								if($seats[($x*10)+$y]==0){
									echo "<td id='".$x.$y."' class='taken'>".$x.$y."</td>";
								}else{
									echo "<td id='".$x.$y."' class='available' >"."<a style='color:black;text-decoration: none;' href='".$_SERVER['PHP_SELF']."?add=".$x.$y."'>".$x.$y."</a></td>";
								}
							}
							
						}
						echo "</tr>";
					}
				}else{
					for($x=0;$x<3;$x++){
						echo "<tr>";
						for($y=0;$y<10;$y++){
							if($x==0){
								if($seats[($x*10)+$y]==0){
									echo "<td id='".$y."' class='taken' >".$y."</td>";
								}else if (in_array((string)(($x*10)+$y),$_SESSION['usercart'][$_SESSION['uniqueID']]->tickets)){
									echo "<td id='".$y."' class='choosen' >"."<a style='color:black;text-decoration: none;' href='".$_SERVER['PHP_SELF']."?remove=".$y."'>".$y."</a></td>";
								}else{
									echo "<td id='".$y."' class='available' >"."<a style='color:black;text-decoration: none;' href='".$_SERVER['PHP_SELF']."?add=".$y."'>".$y."</a></td>";
								}
							}else{
								if($seats[($x*10)+$y]==0){
									echo "<td id='".$x.$y."' class='taken' >".$x.$y."</td>";
								}else if (in_array((string)(($x*10)+$y),$_SESSION['usercart'][$_SESSION['uniqueID']]->tickets)){
									echo "<td id='".$y."' class='choosen' >"."<a style='color:black;text-decoration: none;' href='".$_SERVER['PHP_SELF']."?remove=".$x.$y."'>".$x.$y."</a></td>";
								}else{
									echo "<td id='".$y."' class='available' >"."<a style='color:black;text-decoration: none;' href='".$_SERVER['PHP_SELF']."?add=".$x.$y."'>".$x.$y."</a></td>";
								}
							}
							
						}
						echo "</tr>";
					}
				}
			?>
			
			</table>
				
			</div>
		</div>
	<span class="one-third" style="height:600px">
		<div style="width:90%;padding:10px;border:1px solid black;margin:auto;border-radius:5px;">
			<label style="font-size:20px;color:#008080">Your Basket</label>
			<hr>
			<div style="height:400px">
				<table style="width:100%;border:none"> 
					<tr>
						<?php
							echo "<td id='cancel' onclick='clearCart()' ><a style='color:red;text-decoration: none;' href='".$_SERVER['PHP_SELF']."?removeall=1'>X</a></td>";
						?>
						<td id='selectedMovie'>
							<?php echo $_SESSION['userSelection']->movie ?>
						</td>
						<td id='quantity' style="text-align:right"> 
							x<?php 
							if(isset($_SESSION['usercart'][$_SESSION['uniqueID']])) {
								echo count($_SESSION['usercart'][$_SESSION['uniqueID']]->tickets);
							}else{
								echo "0";
							}?>
						</td>
					</tr>
				</table>
			</div>
			<table style="width:100%;border:none"> 
				<tr>
					<td>
						Total
					</td>
					<td id="total" style="text-align:right">
						<?php
							if(isset($_SESSION['usercart'][$_SESSION['uniqueID']])) {
								echo number_format(count($_SESSION['usercart'][$_SESSION['uniqueID']]->tickets)*12, 2, '.', '');;
							}else{
								echo "0.00";
							}
						?>
					
					</td>
				</tr>
			</table>
			<center>
				<input type="button" class="teal-border-button margin"  Value="Checkout" style="width:80%;" onclick="location.href='./cart.php'">
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
</html>