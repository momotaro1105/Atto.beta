<?php
    $loggedIn = '<div class="header_left"><i id="hidden_navbar" class="material-icons">dehaze</i><a id="logo" href="index.html">Attōβ</a></div><div class="header_right"><form id="searchbar"><input name="query" type="search" placeholder="Search..." autocomplete="off" aria-label="Search" aria-controls="top-search"></form><ul id="login_signup_btns"><li><a href="">Log in</a></li><li><a href="signup.html">Sign up</a></li></ul></div>';
    $loggedOut = '<div class="header_left"><i id="hidden_navbar" class="material-icons">dehaze</i><a id="logo" href="index.html">Attōβ</a></div><div class="header_right"><div id="ask_answer_btns"><a href="ask.html">Ask</a><a href="answer.html">Answer</a></div><ul id="logout_dashbboard_btns"><li><a href="">Log out</a></li><li><i id="userdashboard_btn" class="material-icons">perm_identity</i></li></ul></div>';

    function logStatus(){
        if (){
            return $loggedIn;
        } else {
            return $loggedOut;
        }
    }
?>