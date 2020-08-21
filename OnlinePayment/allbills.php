<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: adminlogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/basic.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>ONLINE ELECTRICITY BILL PAYMENT</h1><br><br>
    <center>   <a href="logout.php" class="btn btn-danger">Sign Out</a>
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1><br><br>
        <table>
            <tr>
                <th>CUSTOMER NO</th>
                <th>BILL NUMBER</th>
                <th>UNITS USED BY CUSTOMER </th>
                <th>AMOUNT </th>
                <th>STATUS</th>
            </tr>

        
        <?php

require_once "config.php";

            $sql = "SELECT * FROM  billpayment "; 
    

            $result = mysqli_query($link,$sql);
    
            if(mysqli_num_rows($result)>0){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                while($row = mysqli_fetch_assoc($result)){
                $customerno = $row["customerno"];
                $billno = $row["billno"];
                $unitsused = $row["unitsused"];
                $amount = $row["amount"];
                $status = $row["status"]; 

             echo "<tr><td>".$customerno;
                echo "</td><td>".$billno;
                echo "</td><td>".$unitsused;
                echo "</td><td>".$amount;
                echo "</td><td>".$status;
                echo "</td></tr>";
               /* echo "<br>CUSTOMER NUMBER : ".$customerno;
                echo "<br>BILL NUMBER : ".$billno;
                echo "<br>UNITS USED BY CUSTOMER : ".$unitsused;
                echo "<br>AMOUNT : ".$amount;
                echo "<br>STATUS : ".$status;
                echo "<br><br>";*/
            }

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                 echo "NO BILLS<br><br>";
            }// Close connection
            mysqli_close($link);
        ?>
    </table>
   
<a href="adminpage.php" class="btn btn-primary">go to admin home page</a>

</center>
</div>
</div>
</div>
</div>
</div>
</body>
</html>