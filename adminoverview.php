<!DOCTYPE html>
<html>
<head>
	<title>Tools</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">

	<?php

		$movieNameDB =array("CRAZY RICH ASIANS","THE FIRST PURGE","DOWN A DARK HALL","A STAR IS BORN","VENOM","THE NUN");
		$cinemaNameDB=array("JURONG","YISHUN","HABOURFRONT");
		if (!isset($_SESSION)){
			session_start();
		}
		if(!isset($_SESSION["salesOptions"])){
			$_SESSION["salesOptions"]=1;
		}
		if(isset($_GET["salesOptions"])){
			$_SESSION["salesOptions"]=$_GET["salesOptions"];
		}

		$servername="localhost";
		$dbusername="myuser";
		$dbpassword="xxxx";
		$dbname="ntucinematics";
		//create connection  
		$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
		echo "<script> window.onload= function(){document.getElementById('salesOptions')[".$_SESSION["salesOptions"]."].selected='selected';}</script>";
		
	?>
	<style>
		table {width:100%;text-align:left;padding:0px;border-collapse: collapse;}
		tr:nth-child(even) {background-color: #f2f2f2;}
		.a{text-decoration: none;color:black;}
	</style>
</head>
<body>
	<div class="clearfix">
		<header>
			<img src="./img/logo.jpg" style="width:80%;height:100%;">
		</header>
		<nav style="text-align:right;padding-right:0px">
			<a href="./index.php" class="menu">Home</a>
			<a href="./adminoverview.php" class="menu">Overview</a>
			<a href="./admintools.php" class="menu">Tools</a>
			<span class="account-box" style="float:right;">
				<?php
					if (isset($_SESSION["useraccount"])){
						$useraccount= json_decode($_SESSION["useraccount"])[0];
						echo "	<span id='account' class='menu' style='padding-right:0px;'>
									<a>".strtoupper($useraccount->name)."</a>
								</span>
								<span id='account-option' class='account-option' style='width:100%;text-align: center;''>
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
		</nav>
	</div>
	<div class="two-third" style="width:55%;margin-right:0.5%;height:700px;border:solid #008080 2px;border-radius:5px">
		<h2 style="margin-left:2%;margin-top:10px;color:#008080;position:relative">Most Popular Movie</h2>
		<span class="full" style="height:200px;position:relative;z-index:-2px;" >
			<?php  
				$query="select current_movies.MOVIE_NAME,current_movies.MOVIE_TYPE,count(purchase_history.quantity) as POP from purchase_history, current_movies where purchase_history.movieID=current_movies.MOVIE_ID group by current_movies.MOVIE_NAME order by POP desc;";
				$result=$conn->query($query);
				$count=0;
				foreach ($result as $key => $value) {
					if($count<4){
						echo "<div class='one-fifth' style='z-index:3px;'>";
						echo "<img src='./img/".$value["MOVIE_NAME"].".jpg' style='margin-left:10%;height:80%;width:80%;''>";
						echo "</div>";
					}
				}

			?>
		</span>
		<h2 style="margin-left:2%;margin-top:10px;color:#008080;position:relative;display:inline-block;margin-right:10px">Sales report</h2>
		<select id="salesOptions" class="teal-input" onchange="location.href=this.value;" style="height:35px;display:inline-block;">
			<option value=<?php echo "'".$_SERVER['PHP_SELF']."?salesOptions=0'" ?> >
				MOVIE
			</option>
			<option value=<?php echo "'".$_SERVER['PHP_SELF']."?salesOptions=1'" ?> >
				CINEMA
			</option>
		</select>
		<?php if($_SESSION["salesOptions"]==0){ ?>
		<span class="full" style="height:500px;position:relative;z-index:-2px;overflow-y:auto;" >
			<table cellpadding="10px" style="padding:10px;margin-left:2%;width:96%">
				<tr>
					<th>No</th>
					<th>Movie</th>
					<th>Qty</th>
					<th>Subtotal</th>
				</tr>
				<?php  
					$query="select SUM(purchase_history.quantity) as TOTAL, current_movies.MOVIE_NAME as MOVIE_NAME  from purchase_history,current_movies where purchase_history.movieID=current_movies.MOVIE_ID group by current_movies.MOVIE_NAME";
					$results=$conn->query($query);
					$countTotal=0;
					foreach ($results as $key => $value) {
						$countTotal+=intval($value["TOTAL"]);
						echo "<tr>";
						echo "<td style='width:10%'>".$key."</td>";
						echo "<td style='width:50%'>".$value["MOVIE_NAME"]."</td>";
						echo "<td style='width:20%'>".$value["TOTAL"]."</td>";
						echo "<td style='width:20%'> $".number_format(intval($value["TOTAL"])*12,2,'.','')."</td>";
						echo "</tr>";
					}
					echo "<tr><td></td><td></td><td>Total</td><td>$".number_format(intval($countTotal)*12,2,'.','')."</td></tr>";
				?>
			</table>
		</span>
		<?php }else {?>
		<span class="full" style="height:500px;position:relative;z-index:-2px;overflow-y:auto;" >
			<table cellpadding="10px" style="padding:10px;margin-left:2%;width:96%">
				<tr>
					<th>No</th>
					<th>Cinema</th>
					<th>Qty</th>
					<th>Subtotal</th>
				</tr>
				<?php  
					$query="select SUM(purchase_history.quantity) as TOTAL, loc_address.CINEMA as CINEMA  from purchase_history,loc_address where purchase_history.uniqueID=loc_address.UNIQUE_ID group by loc_address.CINEMA";
					$results=$conn->query($query);
					$countTotal=0;
					foreach ($results as $key => $value) {
						$countTotal+=intval($value["TOTAL"]);
						echo "<tr>";
						echo "<td style='width:10%'>".$key."</td>";
						echo "<td style='width:50%'>".$value["CINEMA"]."</td>";
						echo "<td style='width:20%'>".$value["TOTAL"]."</td>";
						echo "<td style='width:20%'> $".number_format(intval($value["TOTAL"])*12,2,'.','')."</td>";
						echo "</tr>";
					}
					echo "<tr><td></td><td></td><td>Total</td><td>$".number_format(intval($countTotal)*12,2,'.','')."</td></tr>";
				?>
			</table>
		</span>
		<?php }?>
			
	</div>
	<div class="one-third" style="width:44.33%;height:700px;border:solid #008080 2px;border-radius:5px">
		<center>
			<h2 style="margin:0px;margin-top:10px;color:#008080;position:relative;">Trending
			</h2>
		</center>
			<table cellpadding="15px" style="padding:10px;width:100%">
				<tr>
					<th>Movie</th>
					<th>Cinema</th>
					<th>Time</th>
					<th>Seats</th>
				</tr>
				<?php 
					$query="select count(*) as TOTAL, loc_address.MOVIE_NAME,loc_address.CINEMA,unique_seats.DATETIME,loc_address.TIMESTAMP FROM unique_seats, loc_address where unique_seats.UNIQUE_ID=loc_address.UNIQUE_ID and unique_seats.DATETIME>'".date("Y-m-d")."' and unique_seats.DATETIME<'".date('Y-m-d', strtotime(date("Y-m-d"). ' + 1 days'))."'";
					$result=$conn->query($query);
					$count=1;
					foreach ($result as $key => $value) {
						if($value["TOTAL"]>2){
							echo "<tr>";
							echo "<td>".$value["MOVIE_NAME"]."</td>";
							echo "<td>".$value["CINEMA"]."</td>";
							echo "<td>".$value["TIMESTAMP"]."</td>";
							echo "<td>".$value["TOTAL"]."/30</td>";
							echo "</tr>";
						}
					}	
					
					
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