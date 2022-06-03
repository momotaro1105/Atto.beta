<?php
    // ログイン状態のセッション
    function logIn(){
        session_start();
        $_SESSION["loggedInStatus"] = true;
        $_SESSION["sessionID"] = session_id();
    }


    
    // ログアウト状態のセッション
    function logOut(){
        session_start();
        $_SESSION = [];
        session_destroy();
    }
?>