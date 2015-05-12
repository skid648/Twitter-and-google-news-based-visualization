<html>
	<head> 
	
	</head>
		<?php
				include 'dbcon.php';
				$db_selected = mysql_select_db('XORIA', $dbc);
				$handle = @fopen("voul.txt", "r");
				$values='';
				
				while (!feof($handle))
				{
					$buffer = fgets($handle, 4096); 
					list($FirstName,$LastName,$Nomos,$Komma)=explode(",",$buffer);
					
					echo $FirstName,$LastName,$Nomos,$Komma;
					
					$sql = "INSERT INTO VOULEUTES (FirstName, LastName, Nomos, Komma) VALUES('".ToUpper($FirstName)."','".ToUpper($LastName)."','".ToUpper($Nomos)."','".ToUpper($Komma)."')";   
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



</html>