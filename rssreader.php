<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
		<?php




		/***************************************\

				GOOGLE RSS FEED

		\****************************************/

		$url = "https://news.google.gr/news?pz=1&cf=all&ned=el_gr&hl=el&topic=p&output=rss";


		/***************************************\

				DATABASE CONNECTION
			   deputy fetch to array

		\****************************************/



		$servername = "localhost";
		$username = "root";
		$password = "1q2w3e4r";
		$dbname = "xoria";
		$vouleutes=array();
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "SELECT FirstName, LastName FROM vouleutes";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        //echo "Onoma: " . $row["FirstName"]. " - Epitheto: " . $row["LastName"]. "<br>";
		        array_push($vouleutes,$row["LastName"]);
		    }
		} else {
		    echo "0 results";
		}
		
		$sql = "TRUNCATE TABLE Hot";

					if ($conn->query($sql) === TRUE) {
					    echo "Emptied";
					} else {
					    echo "Error emptying record: " . $conn->error;
					}

		/***************************************\

				TRANSFORM DEPUTY ARRAY
				 TO UPPERCASE LETTERS
				 FOR COMPARISON

		\****************************************/

		foreach ($vouleutes as $key => $value) {
			$vouleutes[$key] = ToUpper($value);
		}


		getFeed($url,$vouleutes,$conn);//Get the feed!

		/***************************************\

			FUNCTION: getFeed , parse rss feed
			Check if is deputy 
			INPUT: the rss feed , array of deputies
			OUTPUT: void

		\****************************************/


		function getFeed($feed_url,$vouleutes,$conn) {
		     
		    $content = file_get_contents($feed_url);
		    $x = new SimpleXmlElement($content);

		    foreach($x->channel->item as $entry) {
		        IsVouleuths(ToUpper($entry->title),$vouleutes,$conn);
		    }
		    
		}

		/***************************************\

			FUNCTION: IsVouleuths , Check if 
			a string '$vouleutes' is in '$findme'

			
			INPUT: the string to check from, 
			the string to check

			OUTPUT: void

		\****************************************/

		function IsVouleuths($findme,$vouleutes,$conn){

			foreach ($vouleutes as $key) {
			
				$isthere = strpos($findme, $key);
				if ($isthere === false) {

				} else {
				    
				    //$link = GetImage($key);
				    //echo "<div style='overflow:hidden; text-align:center; width:220px; height:220px; float:left; border-radius:250px;'><img style='width:auto; height:200px;' src=".$link."></img>".$key."</div>";
				    $sql = "INSERT INTO Hot (Name,image_url ) VALUES ('".$key."','".GetImage($key,$conn)."')";

					if ($conn->query($sql) === TRUE) {
					    //echo "done";
					} else {
					    echo "Error adding record: " . $conn->error;
					}
				    
				}
			}

		}

		function ToUpper($string) 
		{ 
				
		        $search  = array("Ά", "Έ", "Ή", "Ί", "Ϊ", "ΐ", "Ό", "Ύ", "Ϋ", "ΰ", "Ώ"); 
		        $replace = array("Α", "Ε", "Η", "Ι", "Ι", "Ι", "Ο", "Υ", "Υ", "Υ", "Ω"); 
		        $string  = mb_strtoupper($string, "UTF-8"); 

		        return str_replace($search, $replace, $string); 
		} 

		function GetImage($name,$conn){

			$sql = "SELECT FirstName, LastName FROM vouleutes WHERE LastName = '".$name."'";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        //echo "Onoma: " . $row["FirstName"]. " - Epitheto: " . $row["LastName"]. "<br>";
			        $name =  $row["FirstName"]."%20".$row["LastName"];
			    }
			} else {
			    echo "0 results";
			}

			$google_search_api = "https://www.googleapis.com/customsearch/v1";
			$key = "AIzaSyDrIcRT3ETSei8Rhh09StVO2dUwrudWPn0";
			$id="010381646192131644412:zp1d2xj-tmk";
			$google_search_api = $google_search_api."?key=".$key;
			$google_search_api = $google_search_api."&cx=".$id;
			$google_search_api = $google_search_api."&q=".$name;
			$google_search_api = $google_search_api.'&searchType=image';
			$body = file_get_contents($google_search_api);
			$json = json_decode($body);
			$link = $json->items[0]->link;
			return $link;
		}
		$conn->close();

		?>
	</body>
</html>
