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
	$servername="localhost";
	$dbusername="myuser";
	$dbpassword="xxxx";
	$dbname="ntucinematics";
	$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
?>

<head>
	<title>Movies</title>
	<link rel="stylesheet" type="text/css" href="./css/ee4717.css">
	<script type="text/javascript" src='./scripts/globalinit.js'></script>
</head>
<script type="text/javascript">
	const days=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
	const cinemas=['JURONG','YISHUN','HABOURFRONT'];
	const movie="THE NUN"
	const movieImage="./img/THE NUN.jpg"
	var userSelection=[];
	
	function generateUserSelection(movie,movieImage){
		for(let i=0;i<cinemas.length;i++){
			userSelection[cinemas[i]]={"day":"0","date":"","cinema":cinemas[i],"time":"","movie":movie,"movieImage":movieImage,"tickets":[]};
		}
	}
	generateUserSelection(movie,movieImage);
	window.onload=function(){
		console.log('javascript functioning');
		for(let x=0;x<cinemas.length;x++){
			for(let i=0;i<7;i++){
				var element = document.getElementById(cinemas[x]+(i+1));
				var date = addDays(i);
				console.log("mydate",date);
				console.log("myday",date.getDay());
				
				//Generate timing tables
				if(i==0){
					element.innerHTML='Today<br>'+ date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()
					//Update user's selection
					userSelection[String(cinemas[x])].date=date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()
					userSelection[String(cinemas[x])].day= date.getDay();
					userSelection[String(cinemas[x])].cinema=String(cinemas[x]);
					//User's selection end
				}else{
					console.log(date.getDay());
					element.innerHTML=days[date.getDay()]+'<br>'+ date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()	
				}
			}	
		}
		
	}	
	function selectedDay(element){
		let selectedCinema = element.id.slice(0,element.id.length-1);
		let date = addDays(element.id.slice(element.id.length-1,element.id.length))
		//Update user's selection
		userSelection[selectedCinema].date=date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
		userSelection[selectedCinema].day= date.getDay();
		userSelection[selectedCinema].cinema=selectedCinema;
		//User's selection end
		for(let i=1;i<8;i++){
			document.getElementById(selectedCinema+i).classList.remove('showtimetd');
			document.getElementById(selectedCinema+i).classList.add('showtimetr');
		}

		element.classList.add('showtimetd');
	}
	function selectedTime(cinema,ele,uniqueID){
		userSelection[cinema].time=ele.innerHTML;
		console.log(userSelection[cinema]);
		localStorage.setItem("userSelection",JSON.stringify(userSelection[cinema]));
		let date=new Date();
		reconstructUniqueID=uniqueID.slice(0,8)+date.getDay()+uniqueID.slice(9);
		window.location.href="./checkout.php?uniqueID="+reconstructUniqueID+"&userSelection="+JSON.stringify(userSelection[cinema]);
	}
	function addDays(days){
		const date = new Date();
		date.setDate(date.getDate() + parseInt(days));
		return date;
	}
	
</script>
<script type="text/javascript" src='./scripts/globalinit.js'></script>
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
	<span class="one-third" style="height:500px">
		<img src="./img/THE NUN.jpg" style="width:100%;height:100%;">
	</span>
	<span class="two-third" style="height:500px;padding:10px;">
		<h1 style="color:#008080">Crazy Rich Asian (PG13)</h1>
		<hr>
		<dl>
			<dt style="margin-bottom:5px">CAST</dt>
			<dd>Taissa Farmiga , Bonnie Aarons , Demián Bichir</dd>
			<br>
			<dt style="margin-bottom:5px">DIRECTOR</dt>
			<dd>Corin Hardy</dd>
			<br>
			<dt style="margin-bottom:5px">SYNOPSIS</dt>
			<dd>When a young nun at a cloistered abbey in Romania takes her own life, a priest with a haunted past and a novitiate on the threshold of her final vows are sent by the Vatican to investigate. Together, they uncover the order's unholy secret. Risking not only their lives but their faith and their very souls, they confront a malevolent force in the form of a demonic nun.</dd>
		</dl>
	</span>
	<span class="full" style="height:500px;">
		<h2>SHOWTIMES</h2>
		<table class="showtimetable" cellpadding="10px">
			<tr class="showtimetr">
				<th>JURONG</th>
				<th class='showtimetd' id='JURONG1' onclick="selectedDay(this)"></th>
				<th class='showtimetr' id='JURONG2' onclick="selectedDay(this)"></th>
				<th class='showtimetr' id='JURONG3' onclick="selectedDay(this)"></th>
				<th class='showtimetr' id='JURONG4' onclick="selectedDay(this)"></th>
				<th class='showtimetr' id='JURONG5' onclick="selectedDay(this)"></th>
				<th class='showtimetr' id='JURONG6' onclick="selectedDay(this)"></th>
				<th class='showtimetr' id='JURONG7' onclick="selectedDay(this)"></th>
			</tr>
			<tr>
				<td style="width:200px">
					Dolby Digital<br>
					English with Chinese subtitles
				</td>
				<?php
					$query="select timestamp from loc_address where movie_id='006' && cinema_id='001' && day='001' order by timestamp asc";
					$val=null;
					$result=$conn->query($query);
					while($row = mysqli_fetch_assoc($result)){
						$val[]=$row;
					}
					for($i=0;$i<@sizeof($val);$i++){
						echo "<td class='showtimetd'onclick='selectedTime(\"JURONG\",this,\"".$val[$i]['UNIQUE_ID']."\")'>".$val[$i]['TIMESTAMP']."</td>";
					}
				?>
			</tr>
		</table>
		<br>
		<table class="showtimetable" cellpadding="10px">
			<tr class="showtimetr">
				<th>YISHUN</th>
				<th class='showtimetd' id='YISHUN1' onclick="selectedDay(this)"></th>
				<th id='YISHUN2' onclick="selectedDay(this)"></th>
				<th id='YISHUN3' onclick="selectedDay(this)"></th>
				<th id='YISHUN4' onclick="selectedDay(this)"></th>
				<th id='YISHUN5' onclick="selectedDay(this)"></th>
				<th id='YISHUN6' onclick="selectedDay(this)"></th>
				<th id='YISHUN7' onclick="selectedDay(this)"></th>
			</tr>
			<tr>
				<td style="width:200px">
					Dolby Atmos<br>
					English only (No Subtitle)
				</td>
				<?php
					$query="select timestamp from loc_address where movie_id='006' && cinema_id='002' && day='001' order by timestamp asc";
					$val=null;
					$result=$conn->query($query);
					while($row = mysqli_fetch_assoc($result)){
						$val[]=$row;
					}
					for($i=0;$i<@sizeof($val);$i++){
						echo "<td class='showtimetd' onclick='selectedTime(\"YISHUN\",this,\"".$val[$i]['UNIQUE_ID']."\")'>".$val[$i]['TIMESTAMP']."</td>";
					}
				?>
			</tr>
		</table>
		<br>
		<table class="showtimetable" cellpadding="10px">
			<tr class="showtimetr">
				<th>HABOURFRONT</th>
				<th class='showtimetd' id='HABOURFRONT1' onclick="selectedDay(this)"></th>
				<th id='HABOURFRONT2' onclick="selectedDay(this)"></th>
				<th id='HABOURFRONT3' onclick="selectedDay(this)"></th>
				<th id='HABOURFRONT4' onclick="selectedDay(this)"></th>
				<th id='HABOURFRONT5' onclick="selectedDay(this)"></th>
				<th id='HABOURFRONT6' onclick="selectedDay(this)"></th>
				<th id='HABOURFRONT7' onclick="selectedDay(this)"></th>
			</tr>
			<tr>
				<td style="width:200px">
					Dolby Atmos<br>
					English only (No Subtitle)
				</td>
				<?php
					$query="select timestamp from loc_address where movie_id='006' && cinema_id='003' && day='001' order by timestamp asc";
					$result=$conn->query($query);
					$val=null;
					while($row = mysqli_fetch_assoc($result)){
						$val[]=$row;
					}
					for($i=0;$i<@sizeof($val);$i++){
						echo "<td class='showtimetd'onclick='selectedTime(\"HABOURFRONT\",this,\"".$val[$i]['UNIQUE_ID']."\")'>".$val[$i]['TIMESTAMP']."</td>";
					}
				?>
			</tr>
		</table>
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