<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
<?php

require("credentials.php");

$conn = new mysqli($servername, $username, $password, $dbname);

$deputies = Array();
$sql = "SELECT FirstName, LastName FROM vouleutes ";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        //echo "Onoma: " . $row["FirstName"]. " - Epitheto: " . $row["LastName"]. "<br>";
			        $name =  Array("name"=>$row["FirstName"],"last"=> $row["LastName"],"query"=>$row["FirstName"]."%20".$row["LastName"]);
			        array_push($deputies, $name);
			    }
			} else {
			    echo "0 results";
			}


			foreach ($deputies as $key => $value) {
				echo $value["name"]." ".$value["last"]." url:  ".$value["query"]."<br>";
				$sql = "UPDATE vouleutes SET image='".GetImage($value["query"])."' WHERE FirstName='".$value["name"]."' AND LastName='".$value["last"]."'";
				echo $sql."<br>";
				if ($conn->query($sql) === TRUE) {
				    echo "Record updated successfully";
				} else {
				    echo "Error updating record: " . $conn->error;
				}
			}



			



function GetImage($name){

			

			$google_search_api = "https://www.googleapis.com/customsearch/v1";
			$key = "AIzaSyDrIcRT3ETSei8Rhh09StVO2dUwrudWPn0";
			$id="010381646192131644412:zp1d2xj-tmk";
			$google_search_api = $google_search_api."?key=".$key;
			$google_search_api = $google_search_api."&cx=".$id;
			$google_search_api = $google_search_api."&q=".$name;
			$google_search_api = $google_search_api.'&searchType=image';
			echo "</br>".$google_search_api."</br>";
			$body = file_get_contents($google_search_api);
			$json = json_decode($body);
			$link = $json->items[1]->link;
			return $link;
		}
?>
</body>
</html>