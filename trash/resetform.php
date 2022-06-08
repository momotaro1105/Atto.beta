<?php
    include("php/util.php");
    include("php/header.php");
    include("php/database.php");
    $header = logStatus();

    $db = DbConn('userInfo');
    // $db = DbConn();
    $validEmail = fldArray('email', 'loginCred', $db);
    $frozEmail = fldArray('email', 'frozenAcct', $db);

    if (in_array($_POST['email'], $validEmail) || in_array($_POST['email'], $frozEmail)){   
        $url = 'https://momo115.sakura.ne.jp/atto_php/reset.php?key=';
        $secretKey = md5(uniqid(mt_rand(), true));
        $url .= $secretKey;
        $title = 'Atto: Password Reset Link';
        $content = "Please reset your password from below. The link is only active for the next 10 minutes.\n " .$url;

        include("php/email.php");
        sendEmail($_POST['email'], $title, $content);
        
        mkTbIF('token', 'email VARCHAR(256),tokenid VARCHAR(256),expires INT(10)', $db);
        $_POST['tokenid'] = $secretKey;
        $_POST['expires'] = strtotime("+ 10 minutes");
        addData('token', 'email,tokenid,expires', $db, $_POST);
        redirect('login.php');
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