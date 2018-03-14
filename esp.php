<?php
//var_dump($_GET);
/*If data is received from the ESP8266 it will be in the form of a HTTP GET request where the variable 'temp' brings the value of the
* current temperature and 'hum' of the humidity. The values are stored in plain text in html format and are overwritten atm.
* TODO: make db connection and safe multiple values in the db
*/

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
