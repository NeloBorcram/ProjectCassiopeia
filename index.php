<?php include 'esp.php' ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<title>ProjectCassiopeia</title>
  </head>
  <body>
    <h1>TestApp by NexX</h1>
	<div>
		<p>
      This is the first version of the test page showing the <br>
      Data transmitted from the DHT11 Temperature and Humidity <br>
      Sensor via the WeMos D1 Mini.
    </p>
		</div>

	<div style="background-color: yellow;font-size:40px">
		<object data="output.html">
			NoObjectTag support
		</object>

		<?php //include 'output.php' ?>
	</div>


	<?php
		echo "<div><br>That's actually a PHP output!<br></div><br>";
		echo date('Y-m-d H:i:s');
		echo "<br>This is the current date and time!<br><br><br><br><br><br>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>Now some boring PHP Info:";
		phpinfo();

	?>
  </body>
</html>
