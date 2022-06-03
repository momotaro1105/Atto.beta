<?php
    // ログイン状態のセッション
    function loggedIn(){
        session_start();
        $_SESSION["loggedInStatus"] = true;
        $_SESSION["sessionID"] = session_id();
        $_SESSION["sessionName"] = session_name();
    }

    // ログアウト状態のセッション
    function loggedOut(){
        session_start();
        $_SESSION = array();
        session_destroy();
    }
?>