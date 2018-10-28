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
		<?php  
			if(!isset($_POST["cinemaID"])&&!isset($_POST["movieID"])){
		?>
		<center>
			<h1 style="margin:0px;margin-top:10px;color:#008080;position:relative">Remove Movie Timing</h1>
		</center>
		<hr>
		<form method="POST" action='<?php echo $_SERVER['PHP_SELF'];?>'" >
			<h3 style='margin-left: 20px'>Select parameters</h3>
			<table cellpadding="20px" border="0">
				<tr>
					<td>
						Movie:
					</td>
					<td>
						<select name="movieID" id="movieID" class="teal-input" style="height:37px;width:100%;" onclick="" ="document.getElementById('myform').submit()" required>
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
						<select name="cinemaID" id="cinemaID" class="teal-input" style="height:37px;width:100%;" required>
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
					<td></td>
					<td>
						<input type="submit" class="teal-button" value="Query timing" style="height:35px;width:80%">
					</td>
				</tr>
			</table>
		</form>
		<?php } else { ?>
		<span style="position:relative;float:left">
			<form method="POST" action='<?php echo $_SERVER['PHP_SELF'];?>'">
				<?php  
					$query="select * from loc_address where day='001' and cinema_id= '".$_POST["cinemaID"]."' and movie_id='".$_POST['movieID']."' order by TIMESTAMP asc";
					@$result = $conn->query($query);
					$loc_address=$result->fetch_assoc();
					if(isset($_POST["cinemaID"])&&isset($_POST["movieID"])&&@$result->num_rows>0){
						$_SESSION["cinemaID"]=$_POST["cinemaID"];
						$_SESSION["movieID"]=$_POST["movieID"];
						echo "<h3 style='margin-left: 20px'>".$loc_address["MOVIE_NAME"]." (".$loc_address["CINEMA"].")</h3>";
						echo "<select name='timestamp' class='teal-input' style='height:37px;margin-left:20px;width:100px' required>";
						echo var_dump($result);
						$query="select * from loc_address where day='001' and cinema_id= '".$_POST["cinemaID"]."' and movie_id='".$_POST['movieID']."' order by TIMESTAMP asc";
						@$result = $conn->query($query);
					    while($row = $result->fetch_assoc()) {
					        echo "<option>".$row['TIMESTAMP']."</option>";
					    }
						echo "</select>";
						echo "<input type='submit' class='red-button' style='margin-left:10px;' value='Delete'>";
					}else{ ?>
						<?php echo "<script>alert('No timing available')</script>"  ?>
						<h3 style='margin-left: 20px'>Select parameters</h3>
						<table cellpadding="20px" border="0">
							<tr>
								<td>
									Movie:
								</td>
								<td>
									<select name="movieID" id="movieID" class="teal-input" style="height:37px;width:100%;" onclick="" ="document.getElementById('myform').submit()" required>
										<option value="001">
											CRAZY RICH ASIANS
										</option>
										<option value="002">
											THE FIRST PURGE
										</option>
										<option value="003">
											DOWN A DARK HALL
										</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									Venue:
								</td>
								<td>
									<select name="cinemaID" id="cinemaID" class="teal-input" style="height:37px;width:100%;" required>
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
								<td></td>
								<td>
									<input type="submit" class="teal-button" value="Query timing" style="height:35px;width:80%">
								</td>
							</tr>
					</table>
					<?php } ?>
			<form>				
		</span>
		<?php } ?>
		<?php
			if(isset($_SESSION["cinemaID"])&&isset($_SESSION["movieID"])&&isset($_POST["timestamp"])){
				$query="delete from loc_address where cinema_id= '".$_SESSION["cinemaID"]."' and movie_id='".$_SESSION['movieID']."' and timestamp='".$_POST["timestamp"]."'";
				$conn->query($query);
				unset($_SESSION["cinemaID"]);
				unset($_SESSION["movieID"]);
				unset($_POST["timestamp"]);
			}
		?>
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