<?php
    // ログイン状態のセッション
    function logIn(){
        session_start();
        $_SESSION["loggedIn"] = true;
        $_SESSION["sessionID"] = session_id();
        if (isset($_POST['email'])){
            $_SESSION['email'] = $_POST['email'];
        }
    }
    // logIn();


    
    // ログアウト状態のセッション
    function logOut(){
        session_start();
        $_SESSION = [];
        session_destroy();
    }
    // logOut();
?>