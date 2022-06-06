<?php
    include("php/header.php");
    include("php/util.php");
    $header = logStatus();
    session_start();

    include("php/database.php");
    include("php/session.php");
    $db = DbConn('userInfo'); // DB接続
    // $db = DbConn(); // さくらDB接続
    $error = '';
    $pwdErr = '';
    $emailErr = '';
    $LoginAttempts = CondSQL('attempts', 'loginProfile', 'email="'.$_POST['email'].'"', $db);

    if ($LoginAttempts['attempts'] < 3){ // can fail 3 times
        if (isset($_POST['password']) && isset($_SESSION['email'])){ // signupから
            $truePwd = CondSQL('password', 'loginProfile', 'email="'.$_SESSION['email'].'"', $db); // 登録済みpwdを取得
            if (password_verify($_POST['password'], $truePwd['password'])){ // pwd照合
                logIn();
                updateSQL('loginProfile', 'attempts=0', 'email="'.$_POST['email'].'"', $db); // リセット
                header('Location:dashboard.php');
            } else {
                $error = 'Incorrect password';
                updateSQL('loginProfile', 'attempts='.($LoginAttempts['attempts']+1), 'email="'.$_POST['email'].'"', $db);
            }
        } else if (!(isset($_SESSION['email'])) && (count($_POST) > 0)) { // loginから
            $emailList = fldArray('email', 'loginProfile', $db);
            $frozEmail = fldArray('email', 'frozenAccounts', $db);
            if (in_array($_POST['email'], $emailList)){ // メール登録済有無
                $truePwd = CondSQL('password', 'loginProfile', 'email="'.$_POST['email'].'"', $db);
                if (password_verify($_POST['password'], $truePwd['password'])){
                    logIn();
                    updateSQL('loginProfile', 'attempts=0', 'email="'.$_POST['email'].'"', $db);
                    $_SESSION['email'] = $_POST['email'];
                    header('Location: dashboard.php');
                } else {
                    $pwdErr = 'Password incorrect';
                    updateSQL('loginProfile', 'attempts='.($LoginAttempts['attempts']+1), 'email="'.$_POST['email'].'"', $db);
                }
            } else if (!in_array($_POST['email'], $emailList) && in_array($_POST['email'], $frozEmail)){
                $emailErr = 'Account has been locked'; 
            } else { // メール未登録の場合
                $emailErr = 'Email not registered'; 
            }
        }
    } else {
        copyData('frozenAccounts(email, password, displayName, attempts)', 'email, password, displayName, attempts', 'loginProfile', 'email="'.$_POST['email'].'"', $db);
        delData('loginProfile', 'email="'.$_POST['email'].'"', $db);
        $emailErr = 'Account has been locked'; 
    }

    // forgot password時に何をするか？
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
            <label for="password">Password: <a id="forgot" href="">Forgot password?</a></label>
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
        if (emailErr == 'Account has been locked'){
            document.getElementById('loginSubmit').value = 'Reactivate account';
        }
        if (document.getElementById('loginSubmit').value == 'Reactivate account'){
            $reactivate = document.getElementById('loginSubmit');
            // $reactivate.addEventListener('click', function(){
            //     window.location.href = "#";
            // })
        }
    </script>
</body>
</html>