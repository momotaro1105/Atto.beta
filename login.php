<?php
    include("php/header.php");
    include("php/util.php");
    $header = logStatus();
    session_start();

    include("php/database.php");
    include("php/session.php");
    $db = DbConn('userInfo'); // DB接続
    $error = '';
    $pwdErr = '';
    $emailErr = '';
    $failedLogInAttempt = 0;
    if (isset($_POST['password']) && isset($_SESSION['email'])){ // signup画面から来た場合
        $truePwd = CondSQL('password', 'basicProfile', 'email="'.$_SESSION['email'].'"', $db); // 登録済みpwdを取得
        if (password_verify($_POST['password'], $truePwd['password'])){ // 入力されたpwd確認
            logIn();
            header('Location:dashboard.php');
        } else {
            $error = 'Incorrect password';
        }
    } else if (!(isset($_SESSION['email'])) && (count($_POST) > 0)) { // loginボタンから来た場合
        console_log(count($_POST));
        $emailList = fldArray('email', 'basicProfile', $db);
        if (in_array($_POST['email'], $emailList)){ // メール確認
            $truePwd = CondSQL('password', 'basicProfile', 'email="'.$_POST['email'].'"', $db); // 登録済みパスを取得
            if (password_verify($_POST['password'], $truePwd['password'])){ // pwd確認
                logIn();
                $_SESSION['email'] = $_POST['email'];
                $failedLogInAttempt = 0;
                header('Location: dashboard.php');
            } else { // pwdが間違っていた場合
                $pwdErr = 'Password incorrect';
            }
        } else { // メルが間違っていた場合
            $emailErr = 'Email does not exist'; 
        }
    }
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
                <input type="text" name="email" id="loginEmail" value='' required>
            <label for="password">Password: <a style="" id="forgot" href="">Forgot password?</a></label>
                <input type="password" name="password" id="loginPwd" required>
            <input id="loginSubmit" type="submit" value="Log in">
        </form>
        <i class="material-icons" id="toggle">remove_red_eye</i>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // toggle password
        const $toggle = document.getElementById("toggle");
        const $pwd = document.getElementById("loginPwd");
        $toggle.addEventListener("click", function (){
            const inputtype = $pwd.getAttribute("type") != "password" ? "password" : "text";
            $pwd.setAttribute("type", inputtype);
        })

        // セッションにメールが既に登録されていれば
        const sessionEmail = '<?php echo $_SESSION['email'] ?>';
        if (sessionEmail !== ''){
            document.getElementById('loginEmail').value = sessionEmail;
        }

        // エラー表記
        const pwdError = '<?php echo $error ?>';
        if (pwdError !== ''){
            document.getElementById('loginPwd').placeholder = pwdError;
            document.getElementById('forgot').style.color = 'red';
        }
        const pwdErr = '<?php echo $pwdErr ?>';
        if (pwdErr !== ''){
            document.getElementById('loginPwd').placeholder = pwdErr;
            document.getElementById('forgot').style.color = 'red';
        }
        const emailErr = '<?php echo $emailErr ?>';
        if (emailErr !== ''){
            document.getElementById('loginEmail').placeholder = emailErr;
        }
    </script>
</body>
</html>