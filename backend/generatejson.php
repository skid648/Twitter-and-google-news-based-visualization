<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
		<?php



		function GenerateJson($servername,$username,$password,$dbname){

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

			$sql = "SELECT vouleutes.FirstName as Name , vouleutes.LastName as Last, vouleutes.Komma as Koma, Hot.image_url as url
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

			$JSONnodes = Array("name" => "main","size" => "big","icon"=>"http://static.guim.co.uk/sys-images/Guardian/Pix/pictures/2014/4/11/1397210130748/Spring-Lamb.-Image-shot-2-011.jpg", "Type"=> "M");
			
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
								echo "KRATAME TO KEY TOU ".$innerValue["name"]." tou opoiou to komma einai to ".$DeputyParty." kai einai to ".$positionOfDeputy."<br>"; //Kratame ti thesh tou vouleuth gia th dhmiourgia tou link
								

								foreach ($json["nodes"] as $key2 => $value2) {

									if($value2["Type"] == "P" && $value2["name"] == $DeputyParty){

										echo "Vrhka to komma tou vouleuth".$innerValue["name"]." einai to :".$value2["name"]." kai einai sth thesi:".$key2."<br>";
										$JSONlink = Array("source" => $key2,"target" => $innerKey);
										echo "<br>Uparxei to:";
										    print_r($JSONlink);
										    echo "<br>Sto:</br>";
										    print_r($json["links"]);
										    echo "?<br>";
										if (in_array($JSONlink, $json["links"])) {
											echo "NAI<br>";
										}
										array_push($json["links"], $JSONlink);	

									}
								}

							}

				}

			}


			$json = json_encode($json);

			//print_r($json);
			$myfile = fopen("data/data.json", "w") or die("Unable to open file!");
			fwrite($myfile, $json);
			fclose($myfile);
		}
		

		

		?>
	</body>
</html>