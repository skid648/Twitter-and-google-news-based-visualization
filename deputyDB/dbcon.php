<html>
		<head>
		
		</head>
			
			<?php
			
				echo '<label class="mylabel">';

					$dbc = mysql_connect("localhost","root","1q2w3e4r") OR DIE ("A database error occured, please contact sites administrator.<br>
		 													  					We are sorry for the inconvenience! <br>
		 													  					unable to connect to msql server: " . msql_error());


					$db_selected = mysql_select_db('XORIAORIA', $dbc);


			?>


		</body>
</html>