<?php
    include("php/util.php");

    include("php/session.php");
    logIn(); // $_SESSION中身設定

    include("php/header.php");
    $header = logStatus(); // ヘッダーを選択
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css?<?php echo date('YmdHis')?>">
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
                <form id="userName_form" method="post" action="dashboard.php">
                    <input id="new_displayname" type="text" name="userName" placeholder="Username: blank"><?=h($userName)?>
                    <input type="submit" id="set_displayname" value="Edit Profile">
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
    <script>   
        $new_displayname = document.getElementById("new_displayname");
        $set_displayname = document.getElementById("set_displayname");
        $set_displayname.addEventListener("click", function(){
            new_displayname = $new_displayname.value;
            $new_displayname.innerHTML = new_displayname;
            $new_displayname.disabled = true;
            $set_displayname.style.display = "none";
        })
    </script>
</body>
</html>