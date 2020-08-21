<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: userlogin.php");
    exit;
}
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$billno = $customerno = $unitsused = $amount = "";
$billno_err = $customerno_err = $unitsused_err = $amount_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_billno = trim($_POST["billno"]);
    if(empty($input_billno)){
        $billno_err = "Please enter Bill Number.";     
    } elseif(!filter_var($input_billno,FILTER_VALIDATE_INT)){
        $billno_err = "Please enter valid Bill Number.";
    }elseif(strlen($input_billno) != 4){
        $billno_err = "Bill Number must be 4 digits long";
    }
    else{
        $billno = $input_billno;
    }
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
    
    // Validate salary
    $input_units = trim($_POST["units"]);
    if(empty($input_units)){
        $unitsused_err = "Please enter unit used.";     
    } elseif(!filter_var($input_units,FILTER_VALIDATE_INT)){
        $unitsused_err = "Please enter valid unitsused";
    } else{
        $unitsused = $input_units;
    }
    
   /* $input_amount = trim($_POST["amount"]);
    if(empty($input_amount)){
        $amount_err = "Please enter Amount .";          
    } elseif(!filter_var($input_amount,FILTER_VALIDATE_INT)){
        $amount_err = "Please enter valid Amount.";
    }
    else{
        $amount = $input_amount;
    }*/
    //$amount = var amount;
    $amount = $unitsused*3;

    // Check input errors before inserting in database
    if(empty($billno_err) && empty($customerno_err) && empty($unitsused_err) && empty($amount_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO billpayment (billno, customerno, unitsused, amount) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_billno, $param_customerno, $param_unitsused, $param_amount);
            
            // Set parameters
            $param_billno = $billno;
            $param_customerno = $customerno;
            $param_unitsused = $unitsused;
            $param_amount = $amount;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
                echo "<script> alert ('added successfully');</script>";
                
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
    <title>Add bill</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/basic.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
    <script type="text/javascript" src="calcbill.js"></script>
</head>
<body>
    <h1>ONLINE ELECTRICITY BILL PAYMENT</h1><br><br>
    <center>   <a href="logout.php" class="btn btn-danger">Sign Out</a>
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1><br><br>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                       <center> <h2>ADD BILL</h2></center>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name ="myForm">
                        <div class="form-group <?php echo (!empty($billno_err)) ? 'has-error' : ''; ?>">
                            <label>Bill Number</label>
                            <input type="text" name="billno" class="form-control" value="<?php echo $billno; ?>">
                            <span class="help-block"><?php echo $billno_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($customerno_err)) ? 'has-error' : ''; ?>">
                            <label>Customer Number</label>
                            <input type="text" name="customerno" class="form-control" value="<?php echo $customerno; ?>">
                            <span class="help-block"><?php echo $customerno_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($unitsused_err)) ? 'has-error' : ''; ?>">
                            <label>Units Used</label>
                            <input type="text" name="units" class="form-control" value="<?php echo $unitsused; ?>">
                            <span class="help-block"><?php echo $unitsused_err;?></span>
                        </div>
                       <button onclick="calculate()">calculate amount</button><br><br>
                       <label>Amount</label>
                       <p id = "demo"></p>
                        <input type="submit" class="btn btn-primary" value="Add">
                        <input type="reset" class="btn btn-danger" value="Clear">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>