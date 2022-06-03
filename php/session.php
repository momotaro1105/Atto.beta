<?php
    // ログイン状態のセッション
    function logIn(){
        session_start();
        $_SESSION["loggedInStatus"] = true;
        $_SESSION["sessionID"] = session_id();
        $_SESSION["sessionName"] = session_name();
    }


    
    // ログアウト状態のセッション
    function logOut(){
        session_start();
        $_SESSION = array();
        session_destroy();
    }
?>