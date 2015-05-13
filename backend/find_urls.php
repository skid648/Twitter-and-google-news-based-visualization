<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<body>
<?php

require("credentials.php");

$conn = new mysqli($servername, $username, $password, $dbname);

$deputies = Array();
$sql = "SELECT FirstName, LastName ,image FROM vouleutes ";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        //echo "Onoma: " . $row["FirstName"]. " - Epitheto: " . $row["LastName"]. "<br>";
			        $name =  Array("name"=>$row["FirstName"],"last"=> $row["LastName"],"image"=>$row["image"]);
			        array_push($deputies, $name);
			    }
			} else {
			    echo "0 results";
			}

				echo "<div style='background-color:#799DA2;'>";
			foreach ($deputies as $key => $value) {
				//echo $value["name"]." ".$value["last"]." url:  ".$value["image"]."<br>";
				echo "<form id='JqAjaxForm' style='background-color:#799DA2; margin:5px;'action='updatedb.php' method='post'>";
				echo "<div style='margin: 10px; padding-bottom:150px; background-color:#BFF9FF; border:1px solid dashed'>";
				echo "<img src=".$value['image']." style =' margin:5px; width:50px;height:50px;float:left;'></img>";
				echo "<div style=' margin:5px; height:80px; width:100%;'><div style=' margin:5px; overflow:hidden;'>".$value["name"]." ".$value["last"]."<br>url: ".$value["image"]."</div>";
				echo "<input name='url' id='url' style='width:80%;'></input><button style='width:9%; background-color:black; color:white;' id='button'>Submit</button></div>";
				echo "<input name='name' id='name' value='".$value["name"]."' style='display:none;'></input>";
				echo "<input name='last' id='last' value='".$value["last"]."' style='display:none;'></input>";
				echo "No:".$key;
				echo "</div>";
				echo "</form>";
				

			}
				echo "</div>";

				




?>
<script>
$(function(){
    $("#button").on("click",function(e){
     $("#JqAjaxForm").on("submit", function(e){
    e.preventDefault();
    $this = $(this);
    $.ajax({
       type: "POST",
       url: $this.attr('action'),
       data: $this.serialize(),
       success : function(){
          alert('Done');
       }
    });
});
 });
});

</script>
</body>
</html>