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
?>
<head>
	<title>Movies</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<script type="text/javascript">
	window.onload=function(){
		document.getElementById('nowShowing').style.visibility = 'visible';
		document.getElementById('comingSoon').style.visibility = 'hidden';
		document.getElementById('comingSoon').style.height = '0';
	}
	</script>
	<script type="text/javascript" src='./scripts/globalinit.js'></script>
</head>


<body style="overflow-y:auto">
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
	<div class="container clearfix" style="margin-bottom:10px;overflow-y:none">
		<input id="nowShowingBtn" type="button" value="Now showing" class="teal-border-button margin-right" style="float:left;outline: none" onclick="document.getElementById('nowShowing').style.visibility = 'visible';
			 document.getElementById('comingSoon').style.visibility = 'hidden';
			 document.getElementById('comingSoon').style.height = '0px';
			 document.getElementById('nowShowing').style.height = '600px';
			 this.classList.remove('grey-button');
			 this.classList.add('teal-border-button');
			 document.getElementById('comingSoonBtn').classList.remove('teal-border-button');
			 document.getElementById('comingSoonBtn').classList.add('grey-button');
			 console.log(document.getElementById('comingSoonBtn').classList);"
			 >
		<input id="comingSoonBtn" type="button" value="Coming soon" class="grey-button margin-right" style="float:left;outline: none" onclick="document.getElementById('nowShowing').style.visibility = 'hidden';
			 document.getElementById('comingSoon').style.visibility = 'visible';
			 document.getElementById('nowShowing').style.height = '0px';
			 document.getElementById('comingSoon').style.height = '600px';
			 this.classList.remove('grey-button');
			 this.classList.add('teal-border-button');
			 document.getElementById('nowShowingBtn').classList.remove('teal-border-button');
			 document.getElementById('nowShowingBtn').classList.add('grey-button');">
	</div>
	<span id="nowShowing" class="full" style="height:700px; overflow-y:none;" >
		<div class="one-fifth">
			<a href="./crazyrichasians.php"><img src="./img/crazyrichasianssmall.jpg" style="height:284px;width:80%;margin-top: 10px;"></a>
			<div class='movies'>
				<label style="font-size:20px">Crazy Rich Asian</label><br>
				<label style="font-size:15px">(PG)</label><br>
				<label style="font-size:15px">120 Mins</label><br>
				<label style="font-size:15px">English</label>
			</div>	
		</div>
		<div class="one-fifth">
			<a href="./thefirstpurge.php"><img src="./img/firstpurgesmall.jpg" style="height:284px;width:80%;margin-top: 10px;"></a>
			<div class='movies'>
				<label style="font-size:20px">The First Purge</label><br>
				<label style="font-size:15px">(M16)</label><br>
				<label style="font-size:15px">95 Mins</label><br>
				<label style="font-size:15px">English</label>
			</div>		
		</div>
		<div class="one-fifth">
			<a href="./downadarkhall.php"><img src="./img/downadarkhallsmall.jpg" style="height:284px;width:80%;margin-top: 10px;"></a>
			<div class='movies'>
				<label style="font-size:20px">Down a Dark Hall</label><br>
				<label style="font-size:15px">(M16)</label><br>
				<label style="font-size:15px">105 Mins</label><br>
				<label style="font-size:15px">English</label>
			</div>	
		</div>
		<div class="one-fifth">
			<a href="./astarisborn.php"><img src="./img/astarisbornsmall.jpg" style="height:284px;width:80%;margin-top: 10px;" ></a>
			<div class='movies'>
				<label style="font-size:20px">A Star Is Born</label><br>
				<label style="font-size:15px">(PG)</label><br>
				<label style="font-size:15px">110 Mins</label><br>
				<label style="font-size:15px">English</label>
			</div>	
		</div>
		<div class="one-fifth">
			<a href="./venom.php"><img src="./img/venomsmall.jpg" style="height:284px;width:80%;margin-top: 10px;"></a>
			<div class='movies'>
				<label style="font-size:20px">Venom</label><br>
				<label style="font-size:15px">(PG)</label><br>
				<label style="font-size:15px">135 Mins</label><br>
				<label style="font-size:15px">English</label>
			</div>		
		</div>
		<div class="one-fifth">
			<a href="./thenun.php"><img src="./img/thenunsmall.jpg" style="height:284px;width:80%;margin-top: 30px;"></a>
			<div class='movies'>
				<label style="font-size:20px">The Nun</label><br>
				<label style="font-size:15px">(M16)</label><br>
				<label style="font-size:15px">115 Mins</label><br>
				<label style="font-size:15px">English</label>
			</div>	
		</div>
	</span>

	<span id="comingSoon" class="full" style="height:700px;position:relative;z-index:-2px;visibility:hidden;" >
		<div class="one-fifth">
			<img src="./img/smallfootsmall.jpg" style="height:100%;width:80%">
			<div class='movies'>
				<label style="font-size:20px">Small Foot</label><br>
				<label style="font-size:15px">(PG)</label><br>
				<label style="font-size:15px">95 Mins</label><br>
				<label style="font-size:15px">English</label>
			</div>		
		</div>
		<div class="one-fifth">
			<img src="./img/johnnyenglishsmall.jpg" style="height:100%;width:80%">
			<div class='movies'>
				<label style="font-size:20px">Johnny English</label><br>
				<label style="font-size:15px">(PG)</label><br>
				<label style="font-size:15px">89 Mins</label><br>
				<label style="font-size:15px">English</label>
			</div>	
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