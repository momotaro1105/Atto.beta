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
    if (in_array($_GET['key'], $allTokens)){ // トークンID照合
        $expires = CondSQL('expires', 'token', 'tokenid="'.$_GET['key'].'"', $db);
        $email = CondSQL('email', 'token', 'tokenid="'.$_GET['key'].'"', $db);
        if (strtotime('now') > $expires['expires']){ // 有効期限確認
            $error = 'Link has expired';
        } else if (strtotime('now') < $expires['expires'] && isset($_POST['password'])){
            $exisEmail = fldArray('email', 'loginProfile', $db);
            $frozEmail = fldArray('email', 'frozenAccounts', $db);
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT); // 再登録用pwdハッシュ化
            if (in_array($email['email'], $exisEmail)){
                updateSQL('loginProfile', 'attempts=0', 'email="'.$email['email'].'"', $db); // attemptsリセット
                updateSQL('loginProfile', 'password="'.$_POST['password'].'"', 'email="'.$email['email'].'"', $db); // パスワードリセット
                delData('token', 'email="'.$email['email'].'"', $db);
                header('Location: login.php');
            } else if (in_array($email['email'], $frozEmail)){
                updateSQL('frozenAccounts', 'attempts=0', 'email="'.$email['email'].'"', $db);
                updateSQL('frozenAccounts', 'password="'.$_POST['password'].'"', 'email="'.$email['email'].'"', $db);
                copyData('loginProfile(email, password, displayName, attempts)', 'email, password, displayName, attempts', 'frozenAccounts', 'email="'.$email['email'].'"', $db);
                delData('frozenAccounts', 'email="'.$email['email'].'"', $db);
                delData('token', 'email="'.$email['email'].'"', $db);
                header('Location: login.php');
            }
        }
    } else {
        $error = 'Link is invalid';
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?<?php echo date('YmdHis')?>">
    <title>Reset Password</title>
</head>
<body id="urlReset">
    <header><?=$header?></header>
    <div>
        <form method="post" id="urlResetForm">
            <label for="password">Password:</label>
                <input type="text" name="password" id="pwd1" required>
                <i class="material-icons togglepwd" id="toggle1">remove_red_eye</i>
            <label for="password">Re-enter password:</label>
                <input type="text" name="password1" id="pwd2" required>
                <i class="material-icons togglepwd" id="toggle1">remove_red_eye</i>
            <input id="resetPwd" type="button" value="Reset password">
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // check password match
        const $resetPwd = document.getElementById("resetPwd");
        $resetPwd.addEventListener("click", function(){
            const $pwd1 = document.getElementById("pwd1");
            const $pwd2 = document.getElementById("pwd2");
            if (($pwd2 != "") && ($pwd1.value === $pwd2.value)){ // 両パスが合わないと、type submitに変更されずPHPにデータが送信されない
                $resetPwd.setAttribute("type", "submit");
            } else {
                $pwd1.style.borderColor = "red";
                $pwd2.style.borderColor = "red";
            }
        })

        // エラー表示
        const error = '<?php echo $error ?>';
        if (error !== ''){
            $resetPwd.value = error;
            $resetPwd.style.backgroundColor = 'black';
        }
    </script>
</body>
</html>