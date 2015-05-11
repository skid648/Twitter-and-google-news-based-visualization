<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
		<?php

		$servername = "localhost";
		$username = "root";
		$password = "1q2w3e4r";
		$dbname = "xoria";
		$deputies = array();
		$parties = array();
		$nodes = array();
		$link = array();
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "SELECT vouleutes.FirstName as Name , vouleutes.LastName as Last, vouleutes.Komma as Koma
				FROM Hot,vouleutes
				Where vouleutes.LastName = Hot.Name";

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        //echo "Onoma: " . $row["FirstName"]. " - Epitheto: " . $row["LastName"]. "<br>";
		        //echo $row["Name"]." ".$row["Last"]." ".$row["Koma"]."<br>";
		        //array_push($deputies,$row["Name"]." ".$row["Last"]);
		        //array_push($parties,$row["Koma"]);
		        //var_dump($row);
		        $koma = $row["Koma"];
		        $vouleuths = $row["Name"]." ".$row["Last"];
		        array_push($link,$row);
		        $node = Array( "Party"=>$koma );
		        array_push($nodes,$node);
		        $node = Array( "Deputy"=>$vouleuths );
		        array_push($nodes,$node);


		    }
		} else {
		    echo "0 results";
		}

		echo "<br>=======LINKS============<br>";


		//array_multisort($link);
		//print_r($link);



		echo "<br>========NODES===========<br>";

		
		//print_r($nodes);
		$nodes = Array("name" => "main","size" => "50","icon"=>"http://static.guim.co.uk/sys-images/Guardian/Pix/pictures/2014/4/11/1397210130748/Spring-Lamb.-Image-shot-2-011.jpg", "id"=>"1");
		$link = Array("source" => "0","target" => "0");
		$json = Array("nodes"=>Array(),"links" => Array());

		//print_r($json);

		array_push($json["nodes"], $nodes);
		array_push($json["links"], $link);

		$json = json_encode($json);

		print_r($json);
		$myfile = fopen("data/data.json", "w") or die("Unable to open file!");
		fwrite($myfile, $json);
		fclose($myfile);
		
		$conn->close();

		?>
	</body>
</html>
