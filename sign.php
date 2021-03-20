<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<center>
<?php

$username=$_POST["username"];
$password=$_POST["password"];
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname="myDB";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
//echo "Connected successfully";
echo "<br>";
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

	$sql= "INSERT INTO data(username,password) values('$username','$password')";
	if($conn->query($sql)==TRUE){
	echo"RECORDS ADDED SUCCESSFULLY";
	echo"<br>";	
}
$conn->close();
?>
CLICK HERE TO <a href="loginmain.html">LOGIN</a> NOW 
</body>
</html>