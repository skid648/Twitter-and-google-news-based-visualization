<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	</head>
	<body>
<?php

require("credentials.php");

$conn = new mysqli($servername, $username, $password, $dbname);



$deputies = Array();
$sql = "SELECT * FROM vouleutes ";

			$result = $conn->query($sql);
			echo "<table style='width:50%'><tr><th>Onoma</th><th>Epi8eto</th><th>Komma</th><th>Url</th>";
			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        //echo "<tr><td>" . $row["FirstName"]."</td><td>".$row["LastName"]."</td><td>".$row["Komma"]."</td><td>".$row["Image"]. "</td></tr>";

			        echo $sql = "UPDATE Deputy SET Image='".mysql_real_escape_string($row["Image"])."' WHERE FirstName='".$row["FirstName"]."' AND LastName='".$row["LastName"]."';";

						if ($conn->query($sql) === TRUE) {
						    //echo "Record updated successfully";
						} else {
						    echo "Error updating record: " . $conn->error;
						}
			    }
			} else {
			    echo "0 results";
			}

			echo "</tr></table>";

				




?>


</script>
</body>
</html>