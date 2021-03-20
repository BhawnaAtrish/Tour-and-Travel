<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Flight Ticket Booking Form</title>
<style>
  .text1{
    background-color: #66e0ff;
  }
</style>

<!-- <link rel="stylesheet" href="http://stackpack.bootstrapcdn.com"> -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="abcd.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
</head>
<body>
    <header>
        <ul> 
            <li><a href="tour.html">HOME&nbsp<i class="fa fa-home"></i></a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a href="blog.html">BLOG</a></li>
            <!-- <li><a href="#">CONTACT</a></li> -->
            <li class="active"><a href="booking.html">BOOK NOW</a></li>
        </ul>
        <div style="clear:both;"></div>
        <br><br>
        <div class="text1">
        <center>
          <font color ="black">
            <h3><br>
    ACCORDING TO YOUR CHOICE FOR THE JOURNEY.. THIS FLIGHT IS BEST FOR YOUR BOOKING..
    <br>
    KINDLY SEE THE BELOW FLIGHT DETAILS AND MATCH YOUR DETAILS OF PLACE AND JOURNEY WHEREEVER<br> YOU WANT TO GO
    IS CORRECT OR NOT..
    <br>
    WE WILL BE VERY THANKFUL TO GIVE YOU THE WONDERFUL JOURNEY.. MAKE SURE TO<br>
    GIVE THE TRUE FEEDBACK AFTER TAKING OUR TRAVEL SERVICE .. 
    <br>
    ...THANK YOU... </h3>
    <h1>
    <font color="red"><strong>- <b>TEAM TRAVELLO</b></strong><br></font><br>
  </h1>
</div>
  </font>
</center>
   
        <div class="container">


    <?php

include_once 'dbconnect2.php';


function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}


$from = test_input($_POST["from"]);
$to = test_input($_POST["to"]);
$departdate = $_POST["depart"];
$class = $_POST["class"];
//$stop = $_POST["stop"];

global $sql1,$sql2,$result, $availableNumber;

      
    //search by (code and code) or (city and city)
    $sql1 = "SELECT FL.number AS FLnumber, company, type, departure, d_time, arrival, a_time, C.name AS classname, capacity, price, COUNT(*)
            FROM flight FL,  class C, airplane AP , airport A
            WHERE (FL.number = C.number) AND (FL.airplane_id = AP.ID) AND C.name = '$class' AND            
           ((((city LIKE '%$from%') AND (code = departure)) OR  ((city LIKE '%$to%') AND (code = arrival)))
           OR (((departure LIKE '%$from%') AND (arrival LIKE '%$to%'))) )
            GROUP BY FL.number
            HAVING COUNT(*)>1
            ORDER BY FL.number";
//echo $sql1;  
  $result = mysqli_query($con,$sql1);

    if(mysqli_num_rows($result))
      { $result = mysqli_query($con,$sql1);}
    else{
      //search by (code and city) or (city and code)
      $sql2 = "SELECT FL.number AS FLnumber, company, type, departure, d_time, arrival, a_time, C.name AS classname, capacity, price
            FROM flight FL,  class C, airplane AP , airport A
            WHERE (FL.number = C.number) AND (FL.airplane_id = AP.ID) AND C.name = '$class' AND            
           ((((city LIKE '%$from%') AND (code = departure)) AND (arrival LIKE '%$to%'))
           OR ((departure LIKE '%$from%') AND ((city LIKE '%$to%') AND (code = arrival)))  )
            GROUP BY FL.number            
            ORDER BY FL.number";
      $result = mysqli_query($con,$sql2);
    }



    $rowcount = mysqli_num_rows($result);

    echo "<br/><br/>";

    if($rowcount == 0){
        echo "<div class='alert alert-info'><strong>Search Result: </strong>".$rowcount." result. <br>THERE IS NO SUCH FLIGHT.</div>";
    }
    else{
		//echo"<br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		


    echo "<div class='alert alert-info'><strong>Search Result: </strong>".$rowcount." result(s)</div>";
    $col='black';
    echo"<font color='$col'>";
    echo "<table class='table table-bordered table-striped table-hover'>
          <thead>
          <tr>
          <font color='$col'>
            <th>Flight</th>
            <th>Aircraft</th>
            <th>Date</th>
            <th>Departure</th>
            <th>Departure Time</th>
            <th>Arrival</th>
            <th>Arrival Time</th>
            <th>Class</th>
            
            <th>Price</th>
            
          </tr>
          </thead>";
          echo"</font>";
          //$col2='black';
          //echo"<font color='$col2'>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tbody><tr>";
        echo "<td>" . $row['FLnumber'] . "</td>";
        echo "<td>" . $row['company']." ".$row['type']. "</td>";
        echo "<td>" . $departdate . "</td>";
        echo "<td>" . $row['departure'] . "</td>";
        echo "<td>" . $row['d_time'] . "</td>";
        echo "<td>" . $row['arrival'] . "</td>";
        echo "<td>" . $row['a_time'] . "</td>";
        echo "<td>" . $row['classname'] . "</td>";
        
        echo "<td>" . $row['price'] . "</td>";
        
       
                
        
        
        echo "</tr>";
    }
    echo " </tbody></table>
    </div>

    ";

    }
	

  
  

mysqli_close($con);
?>

</header>
</body>
</html>