<?php
    include("php/header.php");
    include("php/util.php");
    $header = logStatus();
    session_start();
    console_log($_SESSION); // 中身確認

    // DB接続
    // PDOクラスを使ってアドレスに該当するハッシュ済みパスを取得
    // IF分でもしパスが一致していれば、ログイン
    // セッションの中身削除
    // dashboard.phpに移動
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css?<?php echo date('YmdHis')?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Log in</title>
</head>
<body id="loginBody">
    <header><?=$header?></header>
    <div>
        <form action="" method="post" id="loginForm">
            <label for="email">Email:</label>
            <input type="text" name="email" id="loginEmail" required>
            <label for="password">Password:</label>
            <input type="text" name="password" id="loginPwd" required>
            <!-- エラー表示 php -->
            
            <input id="loginSubmit" type="button" value="Log in">
        </form>
        <i class="material-icons togglepwd" id="toggle">remove_red_eye</i>
    </div>
</body>
</html>