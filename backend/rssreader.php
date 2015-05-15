<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
		<?php




		/***************************************\

				GOOGLE RSS FEED READER

				1.The scripts connects to mysql Database in order to fetch this years elected deputies.
				2.It compares the deputies set with a set being constructed by the google news rss feed.
				3.In order to keep the comparison correct deputy array is being translated to uppercase with 
				no intonation and eliminates the last letter wich indicates a greek grammatical rule.
				4.If a deputy is a match , the script inserts him in the table 'Hot' of the
				Database, and finds a representative image.


		\****************************************/

		$url = "https://news.google.gr/news?pz=1&cf=all&ned=el_gr&hl=el&topic=p&output=rss";


		/***************************************\

				DATABASE CONNECTION
			   deputy fetch to array

		\****************************************/



		require("credentials.php");

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
		    while($row = $result->fetch_assoc()) {
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


		$time = time();
		$timeFormated = date("Y-m-d-H",$time);
		

		getFeed($url,$vouleutes,$conn);											//Get the feed!


		GenerateJson($servername,$username,$password,$dbname,$timeFormated);

		

		$conn->close(); 														// close sql connection

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

				/****************************************************\

						DEBUG

				
				\****************************************************/
				//echo "<div style='width:100%; background-color:#BFF9FF; border-bottom:1px dashed black;'>";
				//echo "<p>Is there: <b>".$key."</b> in <b>".$findme."?</b></p>";
				


				$isthere = strpos($findme, rtrim($key,"Σ"));
				if ($isthere === false) {

				/*	   UNCOMMENT TO DEBUG   *************/
				//echo "<p>No</p></div>";
				
				} else {

					/*  UNCOMMENT TO DEBUG   *************/
				   // echo "<p>Yes</p></div>"; 
				    $sql = "INSERT INTO Hot (Name,image_url ) VALUES ('".$key."','sample')";

					if ($conn->query($sql) === TRUE) {
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

		

		function GetPartyImage($name){

			$name = trim(preg_replace('/\s+/', ' ', $name));
			//echo "<font style='font-size:30px;'>".$name."</font>";

			$dir = "/PoliticalTweets/backend/assets/";

			switch ($name) {
				case "ΤΟ ΠΟΤΑΜΙ":
					$dir = $dir."topotami.jpeg";
					break;
				case "Ν.Δ.":
					$dir = $dir."nd.jpg";
					break;
				case "ΣΥΡΙΖΑ":
					$dir = $dir."syriza.jpg";
					break;
				case "ΠΑ.ΣΟ.Κ.":
					$dir = $dir."pasok.jpg";
					break;
				case "ΧΡΥΣΗ ΑΥΓΗ":
					$dir = $dir."xa.jpg";
					break;
				case "ΑΝΕΞΑΡΤΗΤΟΙ ΕΛΛ�":
					$dir = $dir."aneksarthtoi-ellhnes.jpg";
					break;
				case "Κ.Κ.Ε.":
					$dir = $dir."kke.jpg";
					break;
			
			}

			return $dir;
		}


		function GenerateJson($servername,$username,$password,$dbname,$timestamp){

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

			$sql = "SELECT vouleutes.FirstName as Name , vouleutes.LastName as Last, vouleutes.Komma as Koma, vouleutes.image as url
					FROM Hot,vouleutes
					Where vouleutes.LastName = Hot.Name";

			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        //echo "Onoma: " . $row["FirstName"]. " - Epitheto: " . $row["LastName"]. "<br>";
			       // echo $row["Name"]." ".$row["Last"]." ".$row["Koma"]."<br>";
			        //array_push($deputies,$row["Name"]." ".$row["Last"]);
			        //array_push($parties,$row["Koma"]);
			        //var_dump($row);
			        $koma = $row["Koma"];
			        $vouleuths = $row["Name"]." ".$row["Last"];
			        $url = $row["url"];


			        array_push($link,$row);//push entire row to create link

			        $node = Array("node" => $vouleuths,"url" => $url,"Type" => "D"); //create row for deputy
			        array_push($nodes,$node);
			        $found = false;
			        
			       
			        foreach ($nodes as $value) {
			        	
			        	if($koma === $value["node"]){
			        		
			        		$found = true;
			        	}
			        }

			        if($found){

			        }else{

			        $node = Array("node" => $koma,"url" => GetPartyImage($koma),"Type" => "P"); //create row for party
			        array_push($nodes,$node);

			        }
			        
				    
			    }
			} else {
			    echo "0 results";
			}

			$JSONnodes = Array("name" => "main","size" => "big","icon"=>"../backend/assets/center.png", "Type"=> "M");
			
			$json = Array("nodes"=>Array(),"links" => Array());
			array_push($json["nodes"], $JSONnodes);

			
			
				foreach ($nodes as $key => $value) {

				if($value["Type"] == "P"){

					$JSONnodes = Array("name" => $value["node"],"size" => "normal","icon"=>$value["url"], "Type"=> $value["Type"]);
					array_push($json["nodes"], $JSONnodes);

				}else if($value["Type"] == "D"){

					$JSONnodes = Array("name" => $value["node"],"size" => "small","icon"=>$value["url"], "Type"=> $value["Type"]);
					array_push($json["nodes"], $JSONnodes);

				}else if($value["Type"] == "T"){

					$JSONnodes = Array("name" => $value["node"],"size" => $size,"tiny"=>$value["url"], "Type"=> $value["Type"]);
					array_push($json["nodes"], $JSONnodes);


				}
			}

			
			
				
			/*$JSONlink = Array("source" => 0,"target" => $i);
			array_push($json["links"], $JSONlink);*/

			

			foreach ($link as $key => $value) {

					
							$deputy = $value["Name"]." ".$value["Last"];
							$source_party = $value["Koma"];
										
				
				foreach ($json["nodes"] as $innerKey => $innerValue) {
							//echo "<br> key: <b><br>";
							//print_r($innerKey);
							//echo "<br></b> value: <b><br>";
							//print_r($innerValue);
							//echo "<br></b></br>";
							if($innerValue["Type"] == "P"){

								$JSONlink = Array("source" => 0,"target" => $innerKey);
								array_push($json["links"], $JSONlink);	

							}else if($innerValue["Type"] == "D" && $innerValue["name"] == $deputy){


								$positionOfDeputy = $innerKey;
								$DeputyParty = $source_party;
								//echo "KRATAME TO KEY TOU ".$innerValue["name"]." tou opoiou to komma einai to ".$DeputyParty." kai einai to ".$positionOfDeputy."<br>"; //Kratame ti thesh tou vouleuth gia th dhmiourgia tou link
								

								foreach ($json["nodes"] as $key2 => $value2) {

									if($value2["Type"] == "P" && $value2["name"] == $DeputyParty){

										//echo "Vrhka to komma tou vouleuth".$innerValue["name"]." einai to :".$value2["name"]." kai einai sth thesi:".$key2."<br>";
										$JSONlink = Array("source" => $key2,"target" => $innerKey);
										//echo "<br>Uparxei to:";
										    //print_r($JSONlink);
										    //echo "<br>Sto:</br>";
										  //  print_r($json["links"]);
										    //echo "?<br>";
										if (in_array($JSONlink, $json["links"])) {
											//echo "NAI<br>";
										}
										array_push($json["links"], $JSONlink);	

									}
								}

							}

				}

			}



			print_r($json);
			$json_encoded = json_encode($json);

			$dir = "data/".$timestamp;

			print_r($json_encoded);
			    mkdir($dir);
			

			$myfile = fopen($dir."/basic-graph-data.json", "w") or die("Unable to open file!");
			foreach ($json["nodes"] as $key => $value) {

				if($value["Type"] == "D"){
					//echo "<font style='font-size:50px;'>O ".$value["name"]."</font><br>";
					$name = explode(" ",$value["name"]);
					
					GenerateTweetArray($name[1],$name[0],$value["icon"],$dir);

				}
				
			}
			fwrite($myfile, $json_encoded);
			fclose($myfile);

		}

		function GenerateTweetArray($originalName,$LastName,$image_url,$dir){

			$name = greeklish($originalName);
			$api_URL = 'https://api.twitter.com/1.1/search/tweets.json';
			$API_parameters = '&lang=el&count=20';

			$bearertok = "AAAAAAAAAAAAAAAAAAAAAC4CUAAAAAAAe4fo6tVR2jCYdwJ7yQ%2BKjlPIOmg%3DoeTz7MkA2F3fVOsTL9oEVhcLT2awxP03dwedxohbKCA";


			
			$API_query = "?&q=".$name.$API_parameters;
			$ch = curl_init();
			$headers = array( 
			    "Authorization: Bearer $bearertok"
			  ); 
			  
			  curl_setopt($ch, CURLOPT_URL, "$api_URL"."$API_query");
			  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			  curl_setopt($ch, CURLOPT_USERAGENT, " birdvisualization.comze.com Application / mailto:p11gkli@ionio.com ");
			  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			  $data = curl_exec($ch);
			  if(curl_exec($ch) === false)
							{
								echo 'Curl error: ' . curl_error($ch);//ERROR CHECKING
							}
							else
							{
								echo 'Operation completed without any errors';
							}
					
			  $info = curl_getinfo($ch); 
			  $http_code = $info['http_code'];
			  //print_r($info);//print_r($http_code); FOR DEBUG TO HTTP HEADERS
			  curl_close($ch);//CLOSING CURL
			  $json = json_decode($data, true);//decoding json from twitter 
			  //print_r($json);
			  $tweets_array= array();
			  foreach ($json["statuses"] as $tweet) {

			  	$text_tweet = $tweet["text"];
			  	
		 		$user_id = $tweet["user"]["name"];
				$datetime = $tweet["created_at"];
				$profile_image = $tweet["user"]['profile_image_url'];
		        $stripped_tweet = preg_replace('/(#|@)\S+|(RT:)|(RT)/', '', $text_tweet); // remove hashtags
		        $stripped_tweet = preg_replace('#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#', '', $stripped_tweet);
				$stripped_tweet = trim(preg_replace('/\s+/', ' ', $stripped_tweet ));

				$found = false;

				foreach ($tweets_array as $value) {
				        	
				        	if($stripped_tweet === $value["Tweet"]){
				        		
				        		$found = true;
				        	}
				        }

				        if($found){

				        }else{

				        array_push($tweets_array,Array("Tweet"=>$stripped_tweet,"UserName"=>$user_id,"Date"=>$datetime,"icon"=>$profile_image,"BelongsTo"=>$originalName,"size"=>"small","name"=>"basic-graph"));

				        }

				
				
			  }

				//print_r($tweets_array);
				
			  	$JSONnodes = Array("Tweet"=>"Deputy","UserName"=>$originalName,"Date"=>"null","icon"=>$image_url,"BelongsTo"=>"null","size"=>"big","name"=>"basic-graph");
			  	$json = Array("nodes"=>Array(),"links" => Array());
			  	array_push($json["nodes"], $JSONnodes);

			  	foreach ($tweets_array as $key => $value) {
			  		array_push($json["nodes"], $value);	
			  	}
			  	foreach ($tweets_array as $key => $value) {
			  		$JSONlink = Array("source" => $key+1,"target" => 0);
			  		array_push($json["links"], $JSONlink);
			  	}

			  	//print_r($json);
			  	$json = json_encode($json);
			  	//print_r($json);
			  	$myfile = fopen($dir."/".$LastName." ".$originalName."-data.json", "w") or die("Unable to open file!");
			  	fwrite($myfile, $json);
				fclose($myfile);

		}

		function greeklish($Name) {  

			$greek   = array('α','ά','Ά','Α','β','Β','γ', 'Γ', 'δ','Δ','ε','έ','Ε','Έ','ζ','Ζ','η','ή','Η','θ','Θ','ι','ί','ϊ','ΐ','Ι','Ί', 'κ','Κ','λ','Λ','μ','Μ','ν','Ν','ξ','Ξ','ο','ό','Ο','Ό','π','Π','ρ','Ρ','σ','ς', 'Σ','τ','Τ','υ','ύ','Υ','Ύ','φ','Φ','χ','Χ','ψ','Ψ','ω','ώ','Ω','Ώ',' ',"'","'",','); 
			$english = array('a', 'a','A','A','b','B','g','G','d','D','e','e','E','E','z','Z','i','i','I','th','Th', 'i','i','i','i','I','I','k','K','l','L','m','M','n','N','x','X','o','o','O','O','p','P' ,'r','R','s','s','S','t','T','u','u','Y','Y','f','F','ch','Ch','ps','Ps','o','o','O','O','%20','%20','%20','%20'); 
			$string  = str_replace($greek, $english, $Name); 
			return $string; 

		} 

		

		

		?>
	</body>
</html>
