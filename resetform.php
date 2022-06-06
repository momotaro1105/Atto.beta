<?php
    include("php/header.php");
    include("php/util.php");
    $header = logStatus();
    session_start();

    include("php/database.php");
    // $db = DbConn('userInfo'); // DB接続
    $db = DbConn('momo115_atto_demo', 'mysql57.momo115.sakura.ne.jp', 'momo115', 'atto_demo9'); // さくらDB接続
    $emails = fldArray('email', 'loginProfile', $db);
    $frozEmail = fldArray('email', 'frozenAccounts', $db);

    console_log(strtotime("now"));
    console_log(strtotime("+ 10 minutes"));


    if (in_array($_POST['email'], $emails) || in_array($_POST['email'], $frozEmail)){
        $url = 'https://momo115.sakura.ne.jp/atto_php/reset.php?key=';
        $secret_key = md5(uniqid(mt_rand(), true));
        $url .= $secret_key;
        $title = 'Atto: password reset';
        $content = "Please reset your password from below. The link is only active for the next 10 minutes.\n " . $url;
        mb_send_mail($_POST['email'], $title, $content); 

        $_POST['id'] = $secret_key;
        $_POST['expires'] = strtotime("+ 10 minutes");
        addData('token', 'id,expires', $db, $_POST);
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?<?php echo date('YmdHis')?>">
    <title>Reset Form</title>
</head>
<body id="reset">
    <header><?=$header?></header>
    <div>
        <form method="post" id="resetForm">
            <label for="email">Email:</label>
                <input type="text" name="email" id="checkEmail" required>
            <input id="resetSubmit" type="submit" value="Confirm email">
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        const sessionEmail = '<?php echo $_SESSION['email'] ?>';
        if (sessionEmail !== ''){
            document.getElementById('checkEmail').value = sessionEmail;
        }
    </script>
</body>
</html>