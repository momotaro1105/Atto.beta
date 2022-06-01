<?php
    function logStatus(){
        if (isset($_SESSION["loggedin"]) == false){
            // if user logged out
            return '<div class="header_left"><i id="hidden_navbar" class="material-icons">dehaze</i><a id="logo" href="index.php">Attōβ</a></div><div class="header_right"><form id="searchbar"><input name="query" type="search" placeholder="Search..." autocomplete="off" aria-label="Search" aria-controls="top-search"></form><ul id="login_signup_btns"><li><a href="">Log in</a></li><li><a href="signup.php">Sign up</a></li></ul></div>';
        } else {
            // if user logged in
            return '<div class="header_left"><i id="hidden_navbar" class="material-icons">dehaze</i><a id="logo" href="feed.php">Attōβ</a></div><div class="header_right"><div id="ask_answer_btns"><a href="ask.html">Ask</a><a href="answer.html">Answer</a></div><ul id="logout_dashbboard_btns"><li><i id="userdashboard_btn" class="material-icons">perm_identity</i></li><li><a id="logOut_btn" href="logout.php">Log out</a></li></ul></div>';
        }
    }
?>