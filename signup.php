<?php
    // file is created on page loaded
    // whenever a file is opened, a new line is created so that 
    $email = $_POST["email"];
    $file = fopen("data/email.txt","a");
    fwrite($file, $email."\n");
    fclose($file);

    include("php/util.php");
    console_log($email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    Redirecting shortly
</body>
</html>