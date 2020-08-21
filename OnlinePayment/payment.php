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
$billno = $name = $cardno = $cvvno =  "";
$billno_err = $name_err = $cardno_err = $cvvno_err  =  "";
 
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
    
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a Card Holder name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid  card holder name.";
    } else{
        $name = $input_name;
    }
    

    $input_cardno = trim($_POST["cardno"]);
    if(empty($input_cardno)){
        $cardno_err = "Please enter Card Number.";     
    } elseif(!filter_var($input_cardno,FILTER_VALIDATE_INT)){
        $cardno_err = "Please enter valid Card Number.";
    }elseif(strlen($input_cardno) != 12){
        $cardno_err = "Card Number must be 12 digits long";
    }
    else{
        $cardno = $input_cardno;
    }
    

    $input_cvvno = trim($_POST["cvvno"]);
    if(empty($input_cvvno)){
        $cvvno_err = "Please enter CVV Number.";     
    } elseif(!filter_var($input_cvvno,FILTER_VALIDATE_INT)){
        $cvvno_err = "Please enter valid CVV Number.";
    }elseif(strlen($input_cvvno) != 3){
        $cvvno_err = "CVV Number must be 3 digits long";
    }
    else{
        $cvvno = $input_cvvno;
    }
    
    // Check input errors before inserting in database
    if(empty($billno_err) && empty($name_err) && empty($cardno_err) && empty($cvvno_err)){
        // Prepare an insert statement
        $sql = "UPDATE billpayment SET cardholdername = ?, cardno = ?, cvv = ?, status = ? WHERE billno = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_name ,$param_cardno, $param_cvvno, $param_status , $param_billno);
            
            // Set parameters
            $param_billno = $billno;
            $param_name = $name;
            $param_cardno = $cardno;
            $param_cvvno = $cvvno;
            $param_status = "paid";
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)){
                echo "<script> alert('paid successfully');</script> ";
                header("location: userpage.php");
            }     // Records created successfully. Redirect to landing page
                
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
    <title>Payment</title>
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
    <h1>ONLINE ELECTRICITY BILL PAYMENT</h1><br><br>
    <center>   <a href="logout.php" class="btn btn-danger">Sign Out</a>
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1><br><br>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                       <center> <h2>PAY VIA CREDIT CARD</h2></center>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($billno_err)) ? 'has-error' : ''; ?>">
                            <label>Bill Number</label>
                            <input type="text" name="billno" class="form-control" value="<?php echo $billno; ?>">
                            <span class="help-block"><?php echo $billno_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cardno_err)) ? 'has-error' : ''; ?>">
                            <label>Card Number</label>
                            <input type="text" name="cardno" class="form-control" value="<?php echo $cardno; ?>">
                            <span class="help-block"><?php echo $cardno_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Card Holder Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cvvno_err)) ? 'has-error' : ''; ?>">
                            <label>CVV Number</label>
                            <input type="text" name="cvvno" class="form-control" value="<?php echo $cvvno; ?>">
                            <span class="help-block"><?php echo $cvvno_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="PAY">
                        <input type="reset" class="btn btn-danger" value="Clear">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>