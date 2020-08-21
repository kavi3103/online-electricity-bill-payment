<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $customerno = $email = $mobileno = "";
$name_err = $customerno_err = $email_err = $mobileno_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
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
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter the Email Address.";     
    } elseif(!filter_var($input_email,FILTER_VALIDATE_EMAIL)){
        $email_err = "Please enter valid email address";
    } else{
        $email = $input_email;
    }
    
    $input_mobileno = trim($_POST["mobileno"]);
    if(empty($input_mobileno)){
        $mobileno_err = "Please enter Mobile Number.";          
    } elseif(!filter_var($input_mobileno,FILTER_VALIDATE_INT)){
        $mobileno_err = "Please enter valid Mobile Number.";
    }elseif(strlen($input_mobileno) != 10){
        $mobileno_err = "Mobile Number must be 10 digits long";
    }
    else{
        $mobileno = $input_mobileno;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($customerno_err) && empty($email_err) && empty($mobileno_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO customer (name, customerno, email, mobileno) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_customerno, $param_email, $param_mobileno);
            
            // Set parameters
            $param_name = $name;
            $param_customerno = $customerno;
            $param_email = $email;
            $param_mobileno = $mobileno;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: registeruser.php");

            } else{

                echo "Something went wrong. Please try again later.";

            }
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
    <title>Register User</title>
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
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12"><center>
                    <div class="page-header">
                        <h2>REGISTER USER</h2>
                    </div>
                    <p>Please fill this form </p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($customerno_err)) ? 'has-error' : ''; ?>">
                            <label>Customer Number</label>
                            <input type="text" name="customerno" class="form-control" value="<?php echo $customerno; ?>">
                            <span class="help-block"><?php echo $customerno_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mobileno_err)) ? 'has-error' : ''; ?>">
                            <label>Mobile Number</label>
                            <input type="text" name="mobileno" class="form-control" value="<?php echo $mobileno; ?>">
                            <span class="help-block"><?php echo $mobileno_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-danger" value="Clear">
                    </form>
                    <a href="userlogin.php">Already a User?Login</a></center>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>