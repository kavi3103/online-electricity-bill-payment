<?php 
ini_set('SMTP', "server.com");
ini_set('smtp_port', "25");
ini_set('sendmail_from', "kavithas31032000@gmail.com");    
$to_email = 'kavitha.s.2017.cse@rajalakshmi.edu.in';
$subject = 'Testing PHP Mail';
$message = 'This mail is sent using the PHP mail function';
$headers = 'From: noreply @ company . com';
mail($to_email,$subject,$message,$headers);
?>