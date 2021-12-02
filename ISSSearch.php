<?php 
	//fetching data from API
	if(!empty($_GET['answer'])){
		$datetimevar = strtotime($_GET['answer']);
		
		//storing data for outputs within 1 hour before
		$isspositionb4="https://api.wheretheiss.at/v1/satellites/25544/positions?timestamps=".urlencode($datetimevar).",".urlencode(strtotime('-10 minutes', $datetimevar )).
		",".urlencode(strtotime('-20 minutes', $datetimevar )).",".urlencode(strtotime('-30 minutes', $datetimevar )).",".urlencode(strtotime('-40 minutes', $datetimevar )).
		",".urlencode(strtotime('-50 minutes', $datetimevar )).",".urlencode(strtotime('-60 minutes', $datetimevar ))."&units=miles";
		$isspos_json = file_get_contents($isspositionb4);
		$isspos_array = json_decode($isspos_json, true);
		
		//storing data for outputs within 1 hour after
		$isspositionaft="https://api.wheretheiss.at/v1/satellites/25544/positions?timestamps=".urlencode($datetimevar).",".urlencode(strtotime('+10 minutes', $datetimevar )).
		",".urlencode(strtotime('+20 minutes', $datetimevar )).",".urlencode(strtotime('+30 minutes', $datetimevar )).",".urlencode(strtotime('+40 minutes', $datetimevar )).
		",".urlencode(strtotime('+50 minutes', $datetimevar )).",".urlencode(strtotime('+60 minutes', $datetimevar ))."&units=miles";
		$isspos2_json = file_get_contents($isspositionaft);
		$isspos2_array = json_decode($isspos2_json, true);
		
		//stores data retrieved into variables
		$a=6;
		for($n=0; $n<7; $n++){
		$lat[$a] = $isspos_array[$n]['latitude'];
		$lon[$a] = $isspos_array[$n]['longitude'];
		$chronos[$a] = $isspos_array[$n]['timestamp'];
		$a--;
		}
		for($n=0; $n<7; $n++){
		$lat2[$n] = $isspos2_array[$n]['latitude'];
		$lon2[$n] = $isspos2_array[$n]['longitude'];
		$chronos2[$n] = $isspos2_array[$n]['timestamp'];
		}
		
		//variable output
		echo "ISS Location:<br><br>";
		for($m=0;$m<7;$m++){
			if($m==6){echo"<b>";}
			
				echo "Date and Time: ".date('Y-m-d H:i:s',$chronos[$m])."<br>";
				echo "Latitude: ".$lat[$m]."<br>";
				echo "Longitude: ".$lon[$m]."<br>";
			
				echo "<br>";
			
			if($m==6){echo"</b>";}
		}
		
		
		for($m=1;$m<7;$m++){
			echo "Date and Time: ".date('Y-m-d H:i:s',$chronos2[$m])."<br>";
			echo "Latitude: ".$lat2[$m]."<br>";
			echo "Longitude: ".$lon2[$m]."<br>";
			
			echo "<br>";
		}
		

	}
?>
<html>
<body>
	<form action = "/hello.php" name = "helloform">
	<h3>Enter the date and time of your preference:</h3>
	<p><i>This will show you the position of the ISS within an hour before and after the time selected.</i></p>
	<input type="datetime-local" name="answer">
	<input type="submit" name="submit">
	</form>
	
	
</body>
</html>