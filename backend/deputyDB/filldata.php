<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	</head>
	<body>
		<?php
				include 'dbcon.php';

				$db_selected = mysql_select_db('XORIA', $dbc);
				$file = file_get_contents('vouleutes.txt', true);
				$rows = explode("|", $file);
				mysql_query("set names 'utf8'");

				foreach ($rows as $value) {

					$row = explode(",",$value);
					$sql = "INSERT INTO Deputy (FirstName, LastName, Nomos, Komma) VALUES('".ToUpper($row[0])."','".ToUpper($row[1])."','".ToUpper($row[2])."','".ToUpper($row[3])."')";   
					mysql_query($sql,$dbc) or die(mysql_error());
					
				}


				function ToUpper($string) 
				{ 
			        $search  = array("Ά", "Έ", "Ή", "Ί", "Ϊ", "ΐ", "Ό", "Ύ", "Ϋ", "ΰ", "Ώ"); 
			        $replace = array("Α", "Ε", "Η", "Ι", "Ι", "Ι", "Ο", "Υ", "Υ", "Υ", "Ω"); 
			        $string  = mb_strtoupper($string, "UTF-8"); 
			        return str_replace($search, $replace, $string); 
				} 
		?>


	</body>
</html>