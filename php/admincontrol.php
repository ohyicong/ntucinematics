<?php
	$movieNameDB=array("CRAZY RICH ASIANS","THE FIRST PURGE","DOWN A DARK HALL");
	$cinemaNameDB=array("JURONG","YISHUN","HABOURFRONT");
	$movieID=$_POST['movieID'];
	$cinemaID=$_POST['cinemaID'];
	$timestamp=$_POST['timestamp'];
	$servername="localhost";
	$dbusername="myuser";
	$dbpassword="xxxx";
	$dbname="ntucinematics";
	
	$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
	$query="select max(TIME) as maxTime from loc_address where MOVIE_ID='".$movieID."'and CINEMA_ID='".$cinemaID."'";
	$result = mysqli_query($conn, $query);
	$var = $result->fetch_array();
	$fp = fopen('./log.txt', 'w');
	//Check if got any entry
	if((int)$var["maxTime"]!=0){
		//If there is an entry 
		//Increment time index by 1
		$buildTimeString=(string)((int)$var["maxTime"]+1);
		if(strlen($buildTimeString)<=1){
			$buildTimeString="00".$buildTimeString;
			echo $buildTimeString;
		}else if(strlen($buildTimeString)<=2){
			$buildTimeString="0".$buildTimeString;
		}else if(strlen($buildTimeString)<=3){
			$buildTimeString=$buildTimeString;
		}	
		//Check for duplicated timing
		$query="select * from loc_address where MOVIE_ID='".$movieID."'and CINEMA_ID='".$cinemaID."' and timestamp='".$timestamp."'";
		$result=$conn->query($query);
		fwrite($fp, $query);
		echo var_dump($result);
		//If no duplicated timing, start insertion must be less than 7 timings a day
		if(!($result->num_rows>0)){
			for ($i=1;$i<8;$i++){
				$query="INSERT INTO `loc_address`(`MOVIE_ID`, `MOVIE_NAME`, `CINEMA_ID`, `CINEMA`, `DAY`, `TIME`, `TIMESTAMP`, `UNIQUE_ID`) VALUES ('".$movieID."','".$movieNameDB[$movieID-1]."','".$cinemaID."','".$cinemaNameDB[$cinemaID-1]."','00".$i."','".$buildTimeString."','".$timestamp."'".",'".$movieID.$cinemaID."00".$i."001"."')";
				$conn->query($query);
			}
		}

	}else{
		echo $movieNameDB[$movieID-1]."<br>";
		echo $cinemaNameDB[$cinemaID-1]."<br>";
		for ($i=1;$i<8;$i++){
			$query="INSERT INTO `loc_address`(`MOVIE_ID`, `MOVIE_NAME`, `CINEMA_ID`, `CINEMA`, `DAY`, `TIME`, `TIMESTAMP`, `UNIQUE_ID`) VALUES ('".$movieID."','".$movieNameDB[$movieID-1]."','".$cinemaID."','".$cinemaNameDB[$cinemaID-1]."','00".$i."','"."001"."','".$timestamp."'".",'".$movieID.$cinemaID."00".$i."001"."')";
			$conn->query($query);
			
		}
		

	}
	
	
	$conn->close();
	fclose($fp);

?>