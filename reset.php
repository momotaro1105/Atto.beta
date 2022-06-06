<?php
    include("php/header.php");
    include("php/util.php");
    $header = logStatus();
    session_start();

    include("php/database.php");
    // $db = DbConn('userInfo'); // DB接続
    $db = DbConn('momo115_atto_demo', 'mysql57.momo115.sakura.ne.jp', 'momo115', 'atto_demo9'); // さくらDB接続

    $allTokens = fldArray('tokenid', 'token', $db);
    $error = '';
    if (in_array($_GET['key'], $allTokens)){
        $expires = CondSQL('expires', 'token', 'tokenid="'.$_GET['key'].'"', $db);
        if (strtotime('now') > $expires){
            $error = 'Link has expired';
        } else if (isset($_POST['password'])){
            // パスワードの更新及び必要に応じてデータの移動
            console_log($error);
        }
    } else {
        $error = 'Link invalid';
    }
    console_log($error);
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?<?php echo date('YmdHis')?>">
    <title>Reset Password</title>
</head>
<body id="">
    <header><?=$header?></header>
    <div>
        <form method="post">
            <label for="password">Password:</label>
                <input type="text" name="password1" class="checkPwd" required>
            <label for="password">Re-enter password:</label>
                <input type="text" name="password2" class="checkPwd" required>
            <input id="resetPwd" type="submit" value="Reset password">
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        
    </script>
</body>
</html>