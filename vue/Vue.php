<?php

class Vue
{

    function demandePseudo()
    {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>2048: Le jeu du futur </title>
        </head>
        <body>
        <br>
        <br>
        <form action="index.php" method="post">
            <label for="pseudo">Entrer votre pseudo : </label>
            <br>
            <input type="text" name="pseudo" id="pseudo" required>
            <br>
            <br>
            <label for="pwd">Entrer votre mot de passe : </label>
            <br>
            <input type="password" name="pwd" id="pwd" required>
            <br>
            <br>
            <input type="submit" name="inscription" value="inscription"/>
            <input type="submit" name="connexion" value="connexion"/>
        </form>
        <br>
        <br>
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
            <title>2048: Le jeu ! </title>
        </head>
        <body>

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