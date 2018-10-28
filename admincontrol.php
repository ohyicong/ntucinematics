<!DOCTYPE html>
<html>
<head>
	<title>Admin Control</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<?php
		if (!isset($_SESSION)){
			session_start();
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
		//create connection  
		$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
	?>
</head>
<body>
	<div class="clearfix">
		<header>
			<img src="./img/logo.jpg" style="width:80%;height:100%;">
		</header>
	</div>	
	<div class="one-fifth vertical-nav" style="height:604px;border:solid #008080 2px; border-radius:5px">
		<ul >
			<li><a href="./overview.php">Overview</a></li>
		  	<li><a href="./addmovie.php">Add Movie Time</a></li>
		  	<li><a href="./deletemovie.php">Delete Movie Time</a></li>
		  
		</ul>
	</div>
	<div class="four-fifth" style="height:600px;border:solid #008080 2px;border-radius:5px">
		<center>
			<h1 style="margin:0px;margin-top:10px;color:#008080;position:relative">Add Movie Timing</h1>
		</center>
		<hr>
		<form method="POST" action='./php/admincontrol.php'>
			<table cellpadding="20px" border="0">
				<tr>
					<td>
						Movie:
					</td>
					<td>
						<select name="movieID" class="teal-input" style="height:30px;width:100%;">
							<option value="001">
								CRAZY RICH ASIANS
							</option>
							<option value="002">
								THE FIRST PURGE
							</option>
							<option value="003">
								DOWN A DARK HALL
							</option>
							<option value="004">
								A STAR IS BORN
							</option>
							<option value="005">
								VENOM
							</option>
							<option value="006">
								THE NUN
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Venue:
					</td>
					<td>
						<select name="cinemaID" class="teal-input" style="height:30px;width:100%;">
							<option value="001">
								JURONG
							</option>
							<option value="002">
								YISHUN
							</option>
							<option value="003">
								HARBOURFRONT
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Time:
					</td>
					<td>
						<input type="time" name="timestamp" class="teal-input" step="900" style="height:30px;width:60%">
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" class="teal-button" value="Submit" style="height:35px;width:50%">
					</td>
				</tr>
			</table>
		</form>
		
	</div>
</body>
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
</html>