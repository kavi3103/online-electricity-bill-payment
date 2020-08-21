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
        <h2>INVALID BILL NUMBER</h2>
        <P>There is no bill with this number</P>
        <a href="customer4.php" class="btn btn-primary">back</a></center>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>