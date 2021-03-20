<!DOCTYPE html>
<html lang="en">
<head>
<title>Flight Ticket Booking Form</title>

<!-- <link rel="stylesheet" href="http://stackpack.bootstrapcdn.com"> -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
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
   
        <div class="container">

    <?php

include_once 'dbconnect2.php';

// Check connection
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
} 


function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}


$from = test_input($_POST["from"]);
$to = test_input($_POST["to"]);
$depart = $_POST["depart"];
$return = $_POST["return"];
$class = $_POST["class"];


global $sql,$sql2, $availableNumber;

    //search by code only, non-stop
    $sql = "SELECT FL.number AS FLnumber, company, type, departure, d_time, arrival, a_time, C.name AS classname, capacity, price
            FROM flight FL,  class C, airplane AP , airport A
            WHERE (FL.number = C.number) AND (FL.airplane_id = AP.ID) AND C.name = '$class' AND
            ((departure = '$from') AND (arrival = '$to'))
            GROUP BY FL.number            
            ORDER BY FL.number";
    $result = mysqli_query($con,$sql);

    
    $rowcount = mysqli_num_rows($result);


    //search return flight

    $sql2 = "SELECT FL.number AS FLnumber, company, type, departure, d_time, arrival, a_time, C.name AS classname, capacity, price
            FROM flight FL,  class C, airplane AP , airport A
            WHERE (FL.number = C.number) AND (FL.airplane_id = AP.ID) AND C.name = '$class' AND
            ((departure = '$to') AND (arrival = '$from'))
            GROUP BY FL.number            
            ORDER BY FL.number";
    $result2 = mysqli_query($con,$sql2);

     $rowcount2 = mysqli_num_rows($result2);

    $rowtotal = $rowcount*$rowcount2;

    
    echo "<br/><br/>";

    if($rowtotal == 0){
        echo "<div class='alert alert-info'><strong>Search Result: </strong>".$rowtotal." result<br>THEERE IS NO SUCH FLIGHT.</div>";
    }
    else{
    echo "<div class='alert alert-info'><strong>Search Result: </strong>".$rowtotal." result(s)</div>";

    echo "<table class='table table-bordered table-striped table-hover'>
          <thead>
          <tr>
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
    while($row = mysqli_fetch_array($result)) {

        echo "<tbody>";


        $result2 = mysqli_query($con,$sql2);
        $rowcount2 = mysqli_num_rows($result2);
        
        if($rowcount2>0){
            while($row2 = mysqli_fetch_array($result2)){
                echo "<tr>";
                echo "<td>" . $row['FLnumber'] . "</td>";
                echo "<td>" . $row['company']." ".$row['type']. "</td>";
                echo "<td>" . $depart . "</td>";
                echo "<td>" . $row['departure'] . "</td>";
                echo "<td>" . $row['d_time'] . "</td>";
                echo "<td>" . $row['arrival'] . "</td>";
                echo "<td>" . $row['a_time'] . "</td>";
                echo "<td>" . $row['classname'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>" . $row2['FLnumber'] . "</td>";
                echo "<td>" . $row2['company']." ".$row2['type']. "</td>";
                echo "<td>" . $return . "</td>";
                echo "<td>" . $row2['departure'] . "</td>";
                echo "<td>" . $row2['d_time'] . "</td>";
                echo "<td>" . $row2['arrival'] . "</td>";
                echo "<td>" . $row2['a_time'] . "</td>";
                echo "<td>" . $row2['classname'] . "</td>";
                echo "<td>" . $row2['price'] . "</td>";
                echo "</tr>";
 
            }
        }
    }
    echo " </tbody></table>";
  }


  
  

mysqli_close($con);
?>

</header>
</body>
</html>