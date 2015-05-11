<html>
	<head>
		<title>Database</title>
		
			<?php
					include 'dbcon.php';
					if (!$db_selected) {   //if database does not exist
  
					  $sql = "CREATE DATABASE XORIA"; // create it

					  if (mysql_query($sql, $dbc)) { //if query succeded
						  echo '</br>Database created successfully<br>';
						  
						  $db_selected = mysql_select_db('XORIA', $dbc); //select the new database
						  
						  $sql1 = "CREATE TABLE VOULEUTES (FirstName CHAR(30),LastName CHAR(30),PRIMARY KEY(FirstName,LastName),Nomos CHAR(30),Komma CHAR(30))";
						  if (mysql_query($sql1, $dbc)) {
						  	echo "Tables Created<br>";
						  }else{
						  	echo "Error creating required tables.." . mysql_error() . "<br>";
						  }
					  } else {
						  echo "</br>Error creating database:" . mysql_error() . "<br>";
					  }
				  
					}else{
				
					$sql3 = "CREATE TABLE VOULEUTES(FirstName CHAR(30),LastName CHAR(30),PRIMARY KEY(FirstName,LastName),Nomos CHAR(30),Komma CHAR(30))";
						  if (mysql_query($sql3, $dbc)) {
						  echo "</br>Tables Created or already exist<br>";
						  }else{
							echo "</br>Error creating required tables.." . mysql_error() . "<br>"; 
						  }
					}

					mysql_close($dbc);
					

					echo '</label>';


			?>

</body>
</html>