<?php
    session_start();

    // ログイン状態のセッション
    function loggedIn(){
        $_SESSION["loggedInStatus"] = true;
        $_SESSION["sessionID"] = session_id();
        $_SESSION["sessionName"] = session_name();
    }

    // ログアウト状態のセッション
    function loggedOut(){
        $_SESSION = array();
        $_SESSION["loggedInStatus"] = false;
    }
?>