<!DOCTYPE html>
<html>
<head>
	<title>Tools</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<?php
		$movieNameDB=array("CRAZY RICH ASIANS","THE FIRST PURGE","DOWN A DARK HALL","A STAR IS BORN","VENOM","THE NUN");
		$cinemaNameDB=array("JURONG","YISHUN","HABOURFRONT");
		if (!isset($_SESSION)){
			session_start();
		}
		if(!isset($_SESSION["movieID"])){
			$_SESSION["movieID"]="001";
		}else if (isset($_GET["movieID"])){
			$_SESSION["movieID"]=$_GET["movieID"];
		}
		if(!isset($_SESSION["cinemaID"])){
			$_SESSION["cinemaID"]="001";
		}else if (isset($_GET["cinemaID"])){
			$_SESSION["cinemaID"]=$_GET["cinemaID"];
		}
		echo "<script> window.onload=function(){ document.getElementById('movieID')[".(intval($_SESSION["movieID"])-1)."].selected='selected'; document.getElementById('cinemaID')[".(intval($_SESSION["cinemaID"])-1)."].selected='selected';}</script>";

		$servername="localhost";
		$dbusername="myuser";
		$dbpassword="xxxx";
		$dbname="ntucinematics";
		//create connection  
		$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
		if(isset($_GET["movieID"])&&isset($_GET["cinemaID"])&&isset($_GET["time"])){
			for ($i=1; $i <=7 ; $i++) { 
				$query="delete from loc_address where movie_id='".$_GET["movieID"]."' and cinema_id='".$_GET["cinemaID"]."'"." and time='".$_GET["time"]."'";
				$conn->query($query);
			}
			
			echo "<script>alert('Movie timing deleted!')</script>";
		}
		if(isset($_POST["timestamp"])){
			$movieID=$_SESSION["movieID"];
			$cinemaID=$_SESSION["cinemaID"];
			$query="select max(TIME) as maxTime from loc_address where MOVIE_ID='".$_SESSION["movieID"]."'and CINEMA_ID='".$_SESSION["cinemaID"]."'";
			$result = mysqli_query($conn, $query);
			$var = $result->fetch_array();
			//Check if got any entry
			if((int)$var["maxTime"]!=0&&(int)$var["maxTime"]<7){
				//If there is an entry 
				//Increment time index by 1
				$buildTimeString=(string)((int)$var["maxTime"]+1);
				if(strlen($buildTimeString)<=1){
					$buildTimeString="00".$buildTimeString;
				}else if(strlen($buildTimeString)<=2){
					$buildTimeString="0".$buildTimeString;
				}else if(strlen($buildTimeString)<=3){
					$buildTimeString=$buildTimeString;
				}	
				//Check for duplicated timing
				$query="select * from loc_address where MOVIE_ID='".$_SESSION["movieID"]."'and CINEMA_ID='".$_SESSION["cinemaID"]."' and timestamp='".$_POST["timestamp"]."'";
				$result=$conn->query($query);

				//If no duplicated timing, start insertion must be less than 7 timings a day
				if(!($result->num_rows>0)){
					for ($i=1;$i<8;$i++){
						$query="INSERT INTO `loc_address`(`MOVIE_ID`, `MOVIE_NAME`, `CINEMA_ID`, `CINEMA`, `DAY`, `TIME`, `TIMESTAMP`, `UNIQUE_ID`) VALUES ('".$_SESSION["movieID"]."','".$movieNameDB[$movieID-1]."','".$_SESSION["cinemaID"]."','".$cinemaNameDB[$cinemaID-1]."','00".$i."','".$buildTimeString."','".$_POST["timestamp"]."'".",'".$_SESSION["movieID"].$_SESSION["cinemaID"]."00".$i."00".((int)$var["maxTime"]+1)."')";
						$conn->query($query);
					}
				}

			}else if((int)$var["maxTime"]<7){
				for ($i=1;$i<8;$i++){
					$query="INSERT INTO `loc_address`(`MOVIE_ID`, `MOVIE_NAME`, `CINEMA_ID`, `CINEMA`, `DAY`, `TIME`, `TIMESTAMP`, `UNIQUE_ID`) VALUES ('".$movieID."','".$movieNameDB[$movieID-1]."','".$_SESSION["cinemaID"]."','".$cinemaNameDB[$cinemaID-1]."','00".$i."','"."001"."','".$_POST["timestamp"]."'".",'".$_SESSION["movieID"].$_SESSION["cinemaID"]."00".$i."00".((int)$var["maxTime"]+1)."')";
					$conn->query($query);
				}
				

			}

		}
	?>
	<style>
		.a{text-decoration: none;color:black;}
	</style>
</head>
<body>

	<div class="clearfix">
		<header>
			<img src="./img/logo.jpg" style="width:80%;height:100%;">
		</header>
		<nav style="text-align:right;padding-right:0px">
			<a href="./adminoverview.php" class="menu">Overview</a>
			<a href="./admintools.php" class="menu">Tools</a>
			<span class="account-box" style="float:right;">
				<?php
					echo"	<span id='account' class='menu' style='padding-right:0px'> 
								Admin
							</span>
							<span id='account-option' class='account-option' style='width:100%;text-align: center;''>
								<a href='./index.php'>Logout</a>
							</span>	";
				
				?>
			</span>			
		</nav>
	</div>
	<div class="two-third" style="width:66.16%;margin-right:0.5%;height:600px;border:solid #008080 4px;border-radius:5px">
		<h2 style="background-color:#008080;padding-left:25px;padding-top:10px;padding-bottom:10px;margin:0px;color:white;position:relative">Add Movie Timing</h2>
			<table cellpadding="20px" border="0">
				<tr>
					<td>
						Movie:
					</td>
					<td>
						<select id="movieID" class="teal-input" onchange="location.href=this.value;" style="height:30px;width:100%;">
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?movieID=001'" ?> >
								CRAZY RICH ASIANS
							</option>
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?movieID=002'" ?> >
								THE FIRST PURGE
							</option>
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?movieID=003'" ?> >
								DOWN A DARK HALL
							</option>
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?movieID=004'" ?> >
								A STAR IS BORN
							</option>
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?movieID=005'" ?> >
								VENOM
							</option>
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?movieID=006'" ?> >
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
						<select id="cinemaID" class="teal-input" onchange="location.href=this.value;" style="height:30px;width:100%;">
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?cinemaID=001'" ?> >
								JURONG
							</option>
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?cinemaID=002'" ?> >
								YISHUN
							</option>
							<option value=<?php echo "'".$_SERVER['PHP_SELF']."?cinemaID=003'" ?> >
								HARBOURFRONT
							</option>
						</select>
					</td>
				</tr>
				<form method="POST" action="./admintools.php">
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
				</form>
			</table>
	</div>
	<div class="one-third" style="height:600px;border:solid #008080 4px;border-radius:5px">
		<center>
			<h2 style="background-color:#008080;padding-left:25px;padding-top:10px;padding-bottom:10px;margin:0px;color:white;position:relative;">Available Timings
			</h2>
		</center>
			<table cellpadding="15px" style="padding:10px;width:100%">
				<?php 
					$query="select * from loc_address where movie_id='".$_SESSION["movieID"]."' and cinema_id='".$_SESSION["cinemaID"]."' and day='002' order by timestamp asc";
					$result=$conn->query($query);
					echo "<tr>";
					$count=1;
					foreach ($result as $key => $value) {
						if($count%3==0){
							echo "</tr>";
							echo "<tr>";
						}	
						echo "<td style='border:solid 1px #b3b3b3;border-radius:5px'><a style='color:red;text-decoration:none' href='".$_SERVER['PHP_SELF']."?movieID=".$value["MOVIE_ID"]."&cinemaID=".$value["CINEMA_ID"]."&time=".$value["TIME"]."'>X<a> &nbsp ".$value["TIMESTAMP"]."</td>";
						$count++;
					}
					echo "</tr>";
				?>
			</table>
		
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