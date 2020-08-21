<?php

session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: userlogin.php");
    exit();
}

require_once "config.php";
// Define variables and initialize with empty values
$feedback = "";
$feedback_err =  "";
$username = $_SESSION["username"];
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_feedback = trim($_POST["feedback"]);
    if(empty($input_feedback)){
        $feedback_err = "Please enter some feedback.";
    } else{
        $feedback = $input_feedback;
    }

        // Prepare an insert statement
        $sql = "INSERT INTO userfeedback (username,feedback) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_feedback);
            
            // Set parameters
            $param_username = $username;
            $param_name = $feedback;
            // Attempt to execute the prepared statement
           // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)){
                echo "<script> alert('submitted successfully');</script>";
                header("location: userpage.php");
            }     // Records created successfully. Redirect to landing page
                
        }
        // Close statement
        mysqli_stmt_close($stmt);
    
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User feedback</title>
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($feedback_err)) ? 'has-error' : ''; ?>">
                            <label>Please give your valuable Feedback</label>
                            <textarea name="feedback" class="form-control"><?php echo $feedback; ?></textarea>
                            <span class="help-block"><?php echo $feedback_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
            </div>
        </div>
    </div></div>
    </center>
</body>
</html>