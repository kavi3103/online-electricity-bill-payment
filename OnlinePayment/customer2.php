<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: adminlogin.php");
    exit;
}

require_once "config.php";
 
// Define variables and initialize with empty values
$customerno = "";
 $customerno_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    // Validate address
    $input_customerno = trim($_POST["customerno"]);
    if(empty($input_customerno)){
        $customerno_err = "Please enter Customer Number.";     
    } elseif(!filter_var($input_customerno,FILTER_VALIDATE_INT)){
        $customerno_err = "Please enter valid Customer Number.";
    }elseif(strlen($input_customerno) != 6){
        $customerno_err = "Customer Number must be 6 digits long";
    }
    else{
        $customerno = $input_customerno;
    }


    header("location : customer3.php");
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
        <center> <h2>CUSTOMER DETAILS</h2></center>
                    </div>
                    <form action="customer3.php"method="post">
                        <div class="form-group <?php echo (!empty($customerno_err)) ? 'has-error' : ''; ?>">
                            <label>ENTER CUSTOMER NUMBER</label>
                            <input type="text" name="customerno"  class="form-control" value="<?php echo $customerno; ?>">
                            <span class="help-block"><?php echo $customerno_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="View"><br>
                        <input type="reset" class="btn btn-danger" value="Clear">
                    </form>
<a href="adminpage.php" class="btn btn-primary">go to admin home page</a>
                </center>
            </div>
        </div>
    </div>
</div>
</div></body></html>
