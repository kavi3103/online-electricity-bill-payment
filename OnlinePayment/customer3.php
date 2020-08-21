<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: adminlogin.php");
    exit;
}
if(isset($_POST["customerno"]) && !empty(trim($_POST["customerno"]))){
  require_once "config.php";
 
// Define variables and initialize with empty values
  $customerno = trim($_POST["customerno"]);

// Processing form data when form is submitted
    // Validate name
    // Validate address
    $sql =  "SELECT * FROM  customer  WHERE customerno = ?"; 
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_customerno);
        
        // Set parameters
        $param_customerno = $customerno;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
               
                $name = $row["name"];
                $email = $row["email"];
                $mobileno = $row["mobileno"];
               
            
            }

            else{
                // URL doesn't contain valid id parameter. Redirect to error page
                 header("location: error1.php");
            }
        }
    // Close connection
        else{

            echo "Oops! Something went wrong. Please try again later.";
        }
    
     
    // Close statement
    mysqli_stmt_close($stmt);

   } 

   
    // Close connection
    mysqli_close($link);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>customer details</title>
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
                        <h1>CUSTOMER DETAILS</h1>
                    </div>
                    <h3><center>
                    <div class="form-group">
                        <label>CUSTOMER NAME :</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>CUSTOMER NUMBER :</label>
                        <p class="form-control-static"><?php echo $customerno ?></p>
                    </div>
                    <div class="form-group">
                        <label>EMAIL :</label>
                        <p class="form-control-static"><?php echo $row["email"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>MOBILE NUMBER :</label>
                        <p class="form-control-static"><?php echo  $row["mobileno"]; ?></p>
                    </div></center></h3>
                    <center>
                    <a href="customer2.php" class="btn btn-primary">back</a></center>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>