<?php
    include("php/header.php");
    include("php/util.php");
    $header = logStatus();
    session_start();

    include("php/database.php");
    $db = DbConn('userInfo'); // DB接続
    if (isset($_POST['password']) && isset($_SESSION['email'])){ // signup画面から来た場合
        $truePwd = CondSQL('password', 'basicProfile', 'email="'.$_SESSION['email'].'"', $db); // 登録済みパスを取得
        $error = '';
        if (password_verify($_POST['password'], $truePwd['password'])){ // 入力されたパス確認
            $_SESSION = [];
            header('Location:dashboard.php');
        } else {
            $error = 'Incorrect password';
        }
    }    
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

        // pre-populate input of email if user exists
        const sessionEmail = '<?php echo $_SESSION['email'] ?>';
        if (sessionEmail !== ''){
            document.getElementById('loginEmail').value = sessionEmail;
        }

        const pwdError = '<?php echo $error ?>';
        if (pwdError !== ''){
            document.getElementById('loginPwd').placeholder = pwdError;
            document.getElementById('forgot').style.color = 'red';
        }
    </script>
</body>
</html>