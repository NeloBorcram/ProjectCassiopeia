<?php
//var_dump($_GET);


if(isset($_GET['temp'])){
	$temp_in = $_GET['temp'];
	

	if (isset($_GET['hum'])){
		$hum_in= $_GET['hum'];
		$dt=date('Y-m-d H:i:s');
		$dts="".$dt;
		$write="<p>Temperature = <b>".$temp_in."°C</b><br>Humidity = <b>".$hum_in."%</b><br>Timestamp: ".$dts."</p>";

		file_put_contents('output.html', $write); //this file is simply implemented in the index.html
							//so a get request changes the file data and data is always loaded out of it
	}
}

?>
