<?php
    include("php/util.php");
    include("php/header.php");
    session_start();
    $_SESSION["loggedin"] = true;
    $header = logStatus();

    $email = $_POST["email"];
    $password = $_POST["password"];
    $userName = $_POST["userName"];
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>User Dashboard</title>
</head>
<body id="dashboard">
    <header><?=$header?></header>
    <div id="dashboardAll">
        <div id="userStatus">
            <div id="userGeneral">
                <div id="userIcon">
                    <i class="fa fa-user fa-5x"></i>
                </div>
                <form id="userName_form" method="post" action="">
                    <input id="new_displayname" type="text" name="userName" placeholder="Username: blank">
                    <input type="submit" id="set_displayname" value="Change username">
                </form>
            </div>
            <table>
                <tr>
                    <td class="user_category">Member since:</td>
                    <td id="since"></td>
                </tr>
                <tr>
                    <td class="user_category">Asked:</td>
                    <td id="num_ask"></td>
                </tr>
                <tr>
                    <td class="user_category">Answered:</td>
                    <td id="num_answer"></td>
                </tr>
                <tr>
                    <td class="user_category">Current score:</td>
                    <td id="score"></td>
                </tr>
                <tr>
                    <td class="user_category">Achievements:</td>
                    <td id="achievements"></td>
                </tr>
            </table>
        </div>
        <div id="userFeed">
            <!-- display feed of existing questions in order of posted and not answered -->
            <div class="feed" id="userQuestions">
                <h2>Questions asked:</h2>
                <div class="feed_filters">
                    <button>date</button>
                    <button>javascript</button>
                    <button>unanswered</button>
                </div>
                <div class="append_feed" id="append_questions">
                    <!-- append div here -->
                </div>
            </div>
            <!-- display feed of recently answered questions that require voting -->
            <div class="feed" id="userAnswers">
                <h2>Answered:</h2>
                <div class="feed_filters">
                    <button>javascript</button>
                    <button>votes</button>
                </div>
                <div class="append_feed" id="append_answers">
                    <!-- append div here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="module">   
        // open user dashboard on click icon in header
        $("#goto_userdashboard").on("click", function(){
            window.open("dashboard.html", '_blank');
        });
    </script>
</body>
</html>

<!-- 発見：auth complete からの realtime database 作成時にuid等authに紐づいているvalueをdatabaseに入れてもauth削除の影響を受けない。作る作業はコピペに近いという事。 -->
