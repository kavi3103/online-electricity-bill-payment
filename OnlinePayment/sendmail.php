<? php
if(isset($_POST["customerno"]) && !empty(trim($_POST["customerno"]))){
  require_once "config.php";
 
// Define variables and initialize with empty values
  $customerno = trim($_POST["customerno"]);
  $billno = trim($_POST["billno"]);
  $unitsused = trim($_POST["unitsused"]);
  $amount = trim($_POST["amount"]);
$sql="SELECT email ,name from customer where customerno= ?";
 //$sql =  "SELECT * FROM  customer  WHERE customerno = ?"; 
    
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
                
            }
        }
     mysqli_stmt_close($stmt);

   } 

   
    // Close connection
    mysqli_close($link);
}

$to = 'kavithas31032000@gmail.com';
$subject = 'ELECTRICITY BILL PAY';
$from = 'kavitha.s.2017.cse@rajalakshmi.edu.in';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
$message = '<html><body>';
$message .= '<h1 style="color:#f40;">Hi </h1>';
$message .= '<p style="color:#080;font-size:18px;">PAYMENT STATUS</p>';
//$message .= 'BILL NUMBER :'.$billno.'<br>UNITS USED:'.$unitsused.'<br>AMOUNT TO BE PAYED:'.$amount;
$message .='<br><br><p> please pay as soon as possible</p>'
$message .= '</body></html>';
 
// Sending email
if(mail($to, $subject, $message, $headers)){
    echo "<script> alert('Your mail has been sent successfully.');</script>";
} else{
    echo "<script> alert('Unable to send email. Please try again');</script>";
}

?>