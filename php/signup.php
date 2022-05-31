<?php
    include("console.php");

    $email = $_POST["email"];
    console_log($email);

    $file = fopen("data/email.txt","a");
    fwrite($file, $email."\n");
    fclose($file);
?>