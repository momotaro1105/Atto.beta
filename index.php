<?php
    include("php/header.php");
    include("php/util.php");
    console_log($_SESSION);
    $header = logStatus();
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?<?php echo date('YmdHis')?>">
    <title>Attōβ</title>
</head>
<body id="homepage">
    <header><?=$header?></header>
    <div id="hp_body">
        <h1>Google.β for Developers</h1>
        <p>The three problems we aim to solve</p>
        <ol>
            <li>Information <u>overload</u></li>
            <li>Information <u>quality gap</u></li>
            <li>Information <u>outdated</u></li>
        </ol>
    </div>
</body>
</html>