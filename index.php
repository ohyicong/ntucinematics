<!DOCTYPE html>
<html>
<?php 
	if (!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION["useraccount"])){
		echo "<script>const useraccount=".$_SESSION['useraccount']."[0];console.log(useraccount)</script>";
	}else{
		echo "<script>const useraccount=null</script>";
	}
	
?>
<head>
	<title>Movies</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<script type="text/javascript" src="./scripts/index.js"></script>
	<script type="text/javascript" src='./scripts/globalinit.js'></script>
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
	<div class="slider" style="height:522px" >
		<a id='imglink' href='./crazyrichasian.php'>
			<img id="banner" src="./img/crazyrichasian-banner.jpg" style="width:100%;height:100%">
		</a>
		<div style="width:200px;height:150px;position:absolute;bottom:10px;left:10px;background-color: grey;opacity: 0.7;padding:10px">
			<h1 id='movie'style="margin:0px;margin-bottom:5px">Crazy Rich Asians (PG)</h1>
			<p style="margin:0px;margin-bottom:5px">Showing now</p>
			<input id='booknow'type="button" class="teal-button" value="Book Now" onclick="onBookNow()">	
		</div>
	</div>
	<?php
		$servername="localhost";
		$dbusername="myuser";
		$dbpassword="xxxx";
		$dbname="ntucinematics";
		$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

		// TOP 3 MOST POPULAR
		$queryTop3="select current_movies.MOVIE_NAME,current_movies.MOVIE_TYPE,count(purchase_history.quantity) as POP from purchase_history, current_movies where purchase_history.movieID=current_movies.MOVIE_ID group by current_movies.MOVIE_NAME order by POP desc LIMIT 3;";

		$resultTop3 = mysqli_query($conn, $queryTop3);
		while($row = mysqli_fetch_assoc($resultTop3)){
			$dataTop3[]=$row['MOVIE_NAME'];
		}

		if (isset($_SESSION["useraccount"])){

			$useraccount= json_decode($_SESSION["useraccount"])[0];
			$userid=$useraccount->userid;
			/* Query 1 - Select the movies from current movies that are - SUBQUERY 1
				(subQuery 1.1 = same movietype as purchase history (where movie id from current movies is the same as purchase history))  ~ANDDDD~
				(subQuery 1.2 = movie id that are not in purchase history (where movie id from current movies is the same as purchase history)) */
			$queryUser = "SELECT MOVIE_NAME FROM current_movies WHERE MOVIE_TYPE IN (SELECT MOVIE_TYPE FROM current_movies WHERE MOVIE_ID IN (SELECT MOVIEID FROM purchase_history WHERE userID = '" . $userid . "')) AND MOVIE_ID NOT IN (SELECT MOVIEID FROM purchase_history WHERE userID = '" . $userid . "') LIMIT 3";
			
			$resultUser = mysqli_query($conn, $queryUser);

			while($row = mysqli_fetch_assoc($resultUser)){
					$dataUser[]=$row['MOVIE_NAME'];
				}
			//Based on customer purchase
			if(@$resultUser->num_rows > 0){
				echo "<div class='full' style='width:100%; height:400px'>";
				echo "<h1 style='text-align: left;margin-bottom:5px;' class='teal'> Recommended For You</h1><hr style='margin-bottom:10px;'>";
				echo "<div id='recommendation' class='full' style='position:relative; z-index:-2px;'>";
				for($i=0; $i<sizeof($dataUser); $i++){
					$link= str_replace(' ', '', $dataUser[$i]);
					echo "<div class='one-fifth' >
							<a id='imglink' href='./" . strtolower($link). ".php' >
								<img src='./img/" . $dataUser[$i] . ".jpg' style='height:300px;width:90%;'>
							</a>
						</div>";
				}
				echo "</div></div>";
			}
			echo "<div class='full' style='width:100%; height:400px'>";
			echo "<h1 style='text-align: left;margin-bottom:5px;' class='teal'>Most Popular</h1><hr style='margin-bottom:10px;'>";
			for($i=0; $i<sizeof($dataTop3); $i++){
				$link= str_replace(' ', '', $dataTop3[$i]);
				echo "<div class='one-fifth'>
						<a id='imglink' href='./" . strtolower($link) . ".php'>
							<img src='./img/" . $dataTop3[$i] . ".jpg' style='height:300px;width:90%;'>
						</a>
					</div>";
			}
			echo "</div></div>";
			
		}else{
			//Default
			echo "<div style='text-align: center; width:100%; height:400px'>";
				for($i=0; $i<sizeof($dataTop3); $i++){
					$link= str_replace(' ', '', $dataTop3[$i]);
					echo "<h1 style='text-align: left;margin-bottom:5px' class='teal'> Most Popular</h1><hr style='margin-bottom:10px;'>";
					for($i=0; $i<sizeof($dataTop3); $i++){
						$link= str_replace(' ', '', $dataTop3[$i]);
						echo "<div class='one-fifth'>
								<a id='imglink' href='./" .strtolower($link). ".php'>
									<img src='./img/" . $dataTop3[$i] . ".jpg' style='height:300px;width:90%;'>
								</a>
							</div>";
					}
					echo "</span>";
				}
		}
	?>
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