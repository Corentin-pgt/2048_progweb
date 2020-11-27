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
            <input type="text" name="pseudo" id="pseudo" required>
            <br>
            <label for="pwd">Entrer votre mot de passe : </label>
            <input type="password" name="pwd" id="pwd" required>
            <br>
            <br>
            <input type="submit" name="soumettre" value="envoyer"/>
        </form>
        <br>
        <br>
        </body>
        </html>
        <?php
    }

    //TODO: add method
    function salon($tab_messages, $pseudo)
    {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>TD6: Salon </title>
        </head>
        <body>
        <br>
        <br>
        <?php for ($cpt = sizeof($tab_messages); $cpt >= 0; $cpt--) {
            if (isset($tab_messages[$cpt])) {
                echo "\t<label>".$tab_messages[$cpt]->getPseudo()." : ".$tab_messages[$cpt]->getMessage()."</label><br>\n";
            };
        } ?>
        <form action="index.php" method="post">
            <input type="text" name="pseudo" value=<?php echo $pseudo ?> hidden>
            <input type="text" name="message" required>
            <input type="submit" name="soumettre" value="envoyer"/>
        </form>
        <br>
        <br>
        </body>
        </html>
        <?php
    }
}

?>