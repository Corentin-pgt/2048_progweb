<?php

class Vue
{

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
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
        </head>
        <body>
        <center><img class="title-screen" src="assets/icon.png"></center>
        <form class="login" action="index.php" method="post">
            <input type="text" name="pseudo" id="pseudo" placeholder="Username" required>
            <input type="password" name="pwd" id="pwd" placeholder="Password" required>
            <input type="submit" name="connexion" value="Login" class="button"/>
            <input type="submit" name="inscription" value="Sign in" class="button"/>
        </form>
        </body>
        </html>
        <?php
    }

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
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
        </head>
        <body>
            <?php
            $grille = $_SESSION["grille"];
            $pseudo = $_SESSION["pseudo"];
            $score = $_SESSION["score"];
            ?>
            <div class="content">
                <div class="id">
                    <img class="game-screen" src="assets/icon.png">
                    <div class="pseudo">
                        <p><strong><i class="fas fa-user"></i> : </strong><?php echo($pseudo) ?></p>
                    </div><div class="score">
                        <p><strong><i class="fas fa-star"></i> : </strong><?php echo($score) ?></p>
                    </div>
                </div>
                <div class="grid">
                    <div class="row1">
                        <div class="col1"><p><?php echo($grille[0][0]); ?></p></div>
                        <div class="col2"><p><?php echo($grille[0][1]); ?></p></div>
                        <div class="col3"><p><?php echo($grille[0][2]); ?></p></div>
                        <div class="col4"><p><?php echo($grille[0][3]); ?></p></div>
                    </div>
                    <div class="row2">
                        <div class="col1"><p><?php echo($grille[1][0]); ?></p></div>
                        <div class="col2"><p><?php echo($grille[1][1]); ?></p></div>
                        <div class="col3"><p><?php echo($grille[1][2]); ?></p></div>
                        <div class="col4"><p><?php echo($grille[1][3]); ?></p></div>
                    </div>
                    <div class="row3">
                        <div class="col1"><p><?php echo($grille[2][0]); ?></p></div>
                        <div class="col2"><p><?php echo($grille[2][1]); ?></p></div>
                        <div class="col3"><p><?php echo($grille[2][2]); ?></p></div>
                        <div class="col4"><p><?php echo($grille[2][3]); ?></p></div>
                    </div>
                    <div class="row4">
                        <div class="col1"><p><?php echo($grille[3][0]); ?></p></div>
                        <div class="col2"><p><?php echo($grille[3][1]); ?></p></div>
                        <div class="col3"><p><?php echo($grille[3][2]); ?></p></div>
                        <div class="col4"><p><?php echo($grille[3][3]); ?></p></div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }

    function resultat()
    {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>2048: Résultats </title>
        </head>
        <body>

        </body>
        </html>
        <?php
    }
}

?>