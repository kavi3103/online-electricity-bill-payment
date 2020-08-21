<?php
    $command = escapeshellcmd('python \Users\ADMIN\Downloads\P14-Artificial-Neural-Networks\Artificial_Neural_Networks\sample2.py');
    $output = shell_exec($command);
    echo $output;
    
?>