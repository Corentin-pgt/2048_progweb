<?php

class Vue
{

    //vue d'authentification
    function demandePseudo()
    {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>2048: Le jeu du futur </title>
            <link rel="icon" href="assets/icon.png">
            <link rel="stylesheet" content="text/css" href="css/style.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
                  integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp"
                  crossorigin="anonymous">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
        </head>
        <body>
        <div class="animation-wrapper">
            <div class="particle particle-1"></div>
            <div class="particle particle-2"></div>
            <div class="particle particle-3"></div>
            <div class="particle particle-4"></div>
        </div>
        <div id="title-screen"><img class="title-screen" src="assets/icon.svg"></div>
        <form class="login" action="index.php" method="post">
            <p>Veuillez vous connecter pour commencer le jeu.</p>
            <input type="text" name="pseudo" id="pseudo" placeholder="Username" required autofocus pattern="^[a-zA-Z0-9Øø_]{3,24}$">
            <input type="password" name="pwd" id="pwd" placeholder="Password" required>
            <input type="submit" name="connexion" value="Login" class="button"/>
            <input type="submit" name="inscription" value="Sign in" class="button"/>
        </form>
        </body>
        </html>
        <?php
    }

    //vue du jeu
    function game()
    {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>2048: Le jeu ! </title>
            <link rel="icon" href="assets/icon.png">
            <link rel="stylesheet" content="text/css" href="css/style.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
                  integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp"
                  crossorigin="anonymous">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
        </head>
        <body style="background-image: url('assets/background.png');">
        <?php
        //couper si le pseudo est trop long
        $grille = $_SESSION["grille"];
        $pseudo = $_SESSION["pseudo"];
        if (strlen($pseudo) > 25) {
            $pseudo = substr($pseudo, 0, 25);
            $pseudo = $pseudo . "...";
        }
        $score = $_SESSION["score"];
        $bestScore = $_SESSION["bestScore"];
        $rank = $_SESSION["rank"];
        ?>
        <div class="wrapper">
            <div class="content">
                <div class="id">
                    <img class="game-screen" src="assets/icon.svg">
                    <div class="info">
                        <div class="pseudo">
                            <p><strong><i class="fas fa-user"></i> : </strong><?php echo($pseudo) ?></p>
                        </div>
                        <div class="infoscore">
                            <p><strong><i class="fas fa-star"></i> : </strong><?php echo($score) ?></p>
                            <p><strong><i class="fas fa-crown"></i> : </strong><?php echo($bestScore) ?></p>
                            <p><strong><i class="fas fa-hashtag"></i> </strong><?php echo($rank) ?></p>
                        </div>
                    </div>
                </div>
                <div class="grid">
                    <?php
                    //couleur des cases en fonction de leur valeur
                    for ($i = 0; $i < 4; $i++) {
                        echo "<div class=\"row" . ($i + 1) . "\">\n";
                        for ($j = 0; $j < 4; $j++) {
                            if ($grille[$i][$j] == 0) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #f3f3f3; color: black\">\n";
                            else if ($grille[$i][$j] == 2) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #eee4da; color: black\">\n";
                            else if ($grille[$i][$j] == 4) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #ede0c8; color: black\">\n";
                            else if ($grille[$i][$j] == 8) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #f2b179; color: white\">\n";
                            else if ($grille[$i][$j] == 16) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #f59563; color: white\">\n";
                            else if ($grille[$i][$j] == 32) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #f67c5f; color: white\">\n";
                            else if ($grille[$i][$j] == 64) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #f65e3b; color: white\">\n";
                            else if ($grille[$i][$j] == 128) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #edcf72; color: white\">\n";
                            else if ($grille[$i][$j] == 256) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #edcc61; color: white\">\n";
                            else if ($grille[$i][$j] == 512) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #edc850; color: white\">\n";
                            else if ($grille[$i][$j] == 1024) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #edc53f; color: white\">\n";
                            else if ($grille[$i][$j] == 2048) echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #edc22e; color: white\">\n";
                            else echo "<div class=\"col" . ($j + 1) . "\" style=\"background: #3c3a32; color: white\">\n";
                            echo "<p>";
                            echo $grille[$i][$j] == 0 ? "" : $grille[$i][$j];
                            echo "</p>\n";
                            echo "</div>\n";
                        }
                        echo "</div>\n";
                    }
                    ?>
                </div>
                <div class="controls">
                    <div id="row1">
                        <div class="up">
                            <form action="index.php" method="GET">
                                <button name="direction" value="haut"><i class="fas fa-arrow-alt-circle-up"></i>
                                </button>
                            </form>
                        </div>
                        <div class="reset">
                            <form action="index.php" method="GET">
                                <button name="recommencer" value="true">NEW <i class="fas fa-sync-alt"></i></button>
                            </form>
                        </div>
                    </div>
                    <div id="row2">
                        <div class="left">
                            <form action="index.php" method="GET">
                                <button name="direction" value="gauche"><i class="fas fa-arrow-alt-circle-left"></i>
                                </button>
                            </form>
                        </div>
                        <div class="down">
                            <form action="index.php" method="GET">
                                <button name="direction" value="bas"><i class="fas fa-arrow-alt-circle-down"></i>
                                </button>
                            </form>
                        </div>
                        <div class="right">
                            <form action="index.php" method="GET">
                                <button name="direction" value="droite"><i class="fas fa-arrow-alt-circle-right"></i>
                                </button>
                            </form>
                        </div>
                        <div class="back">
                            <form action="index.php" method="GET">
                                <button name="precedent" value="true">
                                    <i class="fas fa-undo-alt"></i>
                                </button>
                            </form>
                        </div>
                        <div class="logout">
                            <form action="index.php" method="GET">
                                <button name="deconnexion" value="true">
                                    QUIT <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="leaderboard">
                <h1><i class="fas fa-trophy"></i> Leaderboard</h1>
                <ol style="list-style: none;">
                    <li>
                        <mark><?php
                            //couper si le pseudo est trop long
                            if (isset($_SESSION["leaderboard"][0][0])) {
                                $str = $_SESSION["leaderboard"][0][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][0]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][0] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][0][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][0][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][1][0])) {
                                $str = $_SESSION["leaderboard"][1][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][1]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][1] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][1][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][1][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][2][0])) {
                                $str = $_SESSION["leaderboard"][2][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][2]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][2] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][2][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][2][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][3][0])) {
                                $str = $_SESSION["leaderboard"][3][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][3]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][3] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][3][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][3][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][4][0])) {
                                $str = $_SESSION["leaderboard"][4][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][4]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][4] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][4][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][4][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][5][0])) {
                                $str = $_SESSION["leaderboard"][5][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][5]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][5] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][5][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][5][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][6][0])) {
                                $str = $_SESSION["leaderboard"][6][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][6]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][6] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][6][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][6][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][7][0])) {
                                $str = $_SESSION["leaderboard"][7][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][7]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][7] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][7][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][7][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][8][0])) {
                                $str = $_SESSION["leaderboard"][8][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][8]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][8] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][8][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][8][1]) : "-";
                            ?></small>
                    </li>
                    <li>
                        <mark><?php
                            if (isset($_SESSION["leaderboard"][9][0])) {
                                $str = $_SESSION["leaderboard"][9][0];
                                if (strlen($str) > 17) {
                                    $str = substr($str, 0, 17);
                                    $str = $str . "...";
                                }
                                echo $str;
                            } else {
                                echo "";
                            }
                            ?></mark>
                        <small><?php
                            echo isset($_SESSION["wonGamesOthers"][9]) ? ("<span><i class=\"fas fa-medal\"></i> " . $_SESSION["wonGamesOthers"][9] . "</span>") : " ";
                            echo isset($_SESSION["leaderboard"][9][1]) ? ("<i class=\"fas fa-star\"></i> " . $_SESSION["leaderboard"][9][1]) : "-";
                            ?></small>
                    </li>
                </ol>
            </div>
        </div>
        </body>
        </html>
        <?php
    }

    //vue des résultats
    function resultat()
    {
        ?>
        <!DOCTYPE html>
        <html>
        <?php
        $pseudo = $_SESSION["pseudo"];
        $score = $_SESSION["score"];
        $bestScore = $_SESSION["bestScore"];
        $rank = $_SESSION["rank"];
        ?>
        <head>
            <meta charset="utf-8">
            <title>2048: Résultats </title>
            <link rel="icon" href="assets/icon.png">
            <link rel="stylesheet" content="text/css" href="css/style.css">
            <link rel="stylesheet" content="text/css" href="css/game-end.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
                  integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp"
                  crossorigin="anonymous">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
        </head>
        <body>
        <div class="game-end-content">
            <div class="animation-wrapper">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
            </div>
            <div class="game-end-container">
                <div class="game-end">
                    <div class="left">
                        <img src="assets/icon.svg">
                        <p><?php echo($pseudo) ?></p>
                        <div class="winrate">
                            <p><strong><i class="fas fa-medal"></i> / <i class="fas fa-gamepad"></i>
                                    :</strong> <?php echo($_SESSION['wonGames']) ?> / <?php echo($_SESSION['Games']) ?>
                            </p>
                        </div>
                    </div>
                    <div class="right">
                        <h1><?php
                            echo($score < 2048 ? 'Défaite !' : 'Victoire !');
                            ?></h1>
                        <div class="stats">
                            <p><strong><i class="fas fa-star"></i> : </strong><?php echo($score) ?></p>
                            <p><strong><i class="fas fa-crown"></i> : </strong><?php echo($bestScore) ?></p>
                            <p><strong><i class="fas fa-hashtag"></i> </strong><?php echo($rank) ?></p>
                        </div>
                        <div class="buttons">
                            <div class="logout-endgame">
                                <form action="index.php" method="GET">
                                    <button name="game-end-deconnexion" value="true">
                                        QUIT <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="reset-endgame">
                                <form action="index.php" method="GET">
                                    <button name="game-end-recommencer" value="true">NEW <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="player-cards">
                <div class="player-row">
                    <div class="player-card" style="background: #e9d992">
                        <div class="top">
                            <p class="position"><strong><i class="fas fa-hashtag"></i> </strong> 1</p>
                            <p class="top-pseudo"><?php echo($_SESSION['leaderboard'][0][0]) ?></p>
                        </div>
                        <div class="player-stats">
                            <p><strong><i class="fas fa-crown"></i> :
                                </strong><?php echo($_SESSION['leaderboard'][0][1]) ?></p>
                            <div class="player-winrate">
                                <p><i class="fas fa-medal"></i> : <?php echo($_SESSION['wonGamesOthers'][0]) ?></p>
                                <p><i class="fas fa-gamepad"></i> : <?php echo($_SESSION['GamesOthers'][0]) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="player-card" style="background: #cacaca">
                        <div class="top">
                            <p class="position"><strong><i class="fas fa-hashtag"></i> </strong> 2</p>
                            <p class="top-pseudo"><?php echo($_SESSION['leaderboard'][1][0]) ?></p>
                        </div>
                        <div class="player-stats">
                            <p><strong><i class="fas fa-crown"></i> :
                                </strong><?php echo($_SESSION['leaderboard'][1][1]) ?></p>
                            <div class="player-winrate">
                                <p><i class="fas fa-medal"></i> : <?php echo($_SESSION['wonGamesOthers'][1]) ?></p>
                                <p><i class="fas fa-gamepad"></i> : <?php echo($_SESSION['GamesOthers'][1]) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="player-card" style="background: #e3b97c">
                        <div class="top">
                            <p class="position"><strong><i class="fas fa-hashtag"></i> </strong> 3</p>
                            <p class="top-pseudo"><?php echo($_SESSION['leaderboard'][2][0]) ?></p>
                        </div>
                        <div class="player-stats">
                            <p><strong><i class="fas fa-crown"></i> :
                                </strong><?php echo($_SESSION['leaderboard'][2][1]) ?></p>
                            <div class="player-winrate">
                                <p><i class="fas fa-medal"></i> : <?php echo($_SESSION['wonGamesOthers'][2]) ?></p>
                                <p><i class="fas fa-gamepad"></i> : <?php echo($_SESSION['GamesOthers'][2]) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="player-card">
                        <div class="top">
                            <p class="position"><strong><i class="fas fa-hashtag"></i> </strong> 4</p>
                            <p class="top-pseudo"><?php echo($_SESSION['leaderboard'][3][0]) ?></p>
                        </div>
                        <div class="player-stats">
                            <p><strong><i class="fas fa-crown"></i> :
                                </strong><?php echo($_SESSION['leaderboard'][3][1]) ?></p>
                            <div class="player-winrate">
                                <p><i class="fas fa-medal"></i> : <?php echo($_SESSION['wonGamesOthers'][3]) ?></p>
                                <p><i class="fas fa-gamepad"></i> : <?php echo($_SESSION['GamesOthers'][3]) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    }
}

?>