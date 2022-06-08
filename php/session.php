<?php
    // ログイン状態のセッション
    function logIn(){
        session_start();
        $_SESSION["loggedIn"] = true;
        $_SESSION["sessionID"] = session_id();
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