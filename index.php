<?php include 'esp.php' ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<title>ProjectCassiopeia</title>
  </head>
  <body>
	<div>
		Halli hallo! That's my first <br>
		Linux/Apache/Pi hosted Website!<br>
		New features coming soon!<br><br>
		Are you already impressed <b>Joey</b>??<br><br>
		You better are! Love you, NexX!!!
		</div>
	
	<div>
		<object data="output.html">
			NoObjectTag support
		</object>

		<?php //include 'output.php' ?>
	</div>


	<?php
		echo "<div><br>That's actually a PHP output!<br></div><br>";
		echo date('Y-m-d H:i:s');
		echo "<br>yes! that was actually a date and a time!<br><br><br><br><br><br>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>Now some boring PHP Info:";
		phpinfo();

	?>
  </body>
</html>

