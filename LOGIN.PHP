<html>
<head>
<title>
	login
	</title>
	<style>
</style>
</head>	
<body>
	<center>
<div class="color">
<?php

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname="myDB";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
//echo "<h1>"."<marquee>"."<center>"."Connected successfully"."</marquee>"."</h1>";
echo "<br>";
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}
if(!empty($_POST['LOGIN']))
{
$username=$_POST['username'];
$password=$_POST['password'];
$query="select * from data where username='$username' && password='$password'";
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);
if ($count>0) {
	echo"LOGIN SUCCESSFULL"."<br>"."WELCOME " .$username;
	$link_add = 'booking.html';
	echo"<br>";
	//echo'<a href="$link_add">BOOK NOW</a>';
	echo'<a href="booking.html">BOOK NOW</a>';
}
else
{
	echo"LOGIN FAILED - INCORRECT USERNAME OR PASSWORD";
	echo"<br>";
	echo"<br>";
	$link_address = 'loginmain.html';
echo '<a href="$link_address">LOGIN AGAIN</a>';
}
}
?>
</div>
</body>
</html>