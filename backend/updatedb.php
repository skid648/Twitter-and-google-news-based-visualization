<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
<?php

require("credentials.php");

//$conn = new mysqli($servername, $username, $password, $dbname);


$url = $_POST["url"];
$name = $_POST["name"];
$last = $_POST["last"];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE vouleutes SET image='".$url."' WHERE FirstName='".$name."' AND LastName='".$last."'";

if ($conn->query($sql) === TRUE) {
    //echo $name;
} else {
    //echo "Error updating record: " . $conn->error;
}

$conn->close();

?>
</body>
</html>