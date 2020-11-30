<?php
require_once PATH_VUE . "/Vue.php";
require_once PATH_MODELE . "/GameDAO.php";
require_once PATH_METIER . "/Game.php";

class ControleurJeu
{
    private $vue;
    private $gameDAO;

    function __construct()
    {
        $this->vue = new Vue();
        $this->gameDAO = new GameDAO();
    }

    function play(string $pseudo)
    {
        $_SESSION["pseudo"] = $pseudo;
        if ($this->gameDAO->inGame() != null) {
            if(isset($_SESSION["direction"]) && !empty($_SESSION["direction"])) {
                $grille = $_SESSION["grille"];

                $direction = $_SESSION["direction"];
                switch ($direction) {
                    case "haut":

                        break;
                    case "gauche":
                        break;
                    case "bas":
                        break;
                    case "droite":
                        break;
                }

                $dispo = null;
                $cpt = 0;
                for ($row = 0; $row < 3; $row++) {
                    for ($col = 0; $col < 3; $col++) {
                        if ($grille[$row][$col] == "") {
                            $dispo[$cpt][0] = $row;
                            $dispo[$cpt][1] = $col;
                            $cpt++;
                        }
                    }
                }
                if (sizeof($dispo = 0)) {
                    $this->vue->resultat();
                }
                $row_random = random_int(0, sizeof($dispo));
                $col_random = random_int(0, sizeof($dispo));
                $value_random = random_int(1, 2);
                $dispo[$row_random][$col_random] = $value_random * 2;
                $this->vue->game();
            } else $this->vue->game();
        } else {
            $grille = array(
                array("", "", "", ""),
                array("", "", "", ""),
                array("", "", "", ""),
                array("", "", "", "")
            );
            $row_random1 = random_int(0, 3);
            $col_random1 = random_int(0, 3);
            $row_random2 = random_int(0, 3);
            $col_random2 = random_int(0, 3);

            $grille[$row_random1][$col_random1] = 2;
            $grille[$row_random2][$col_random2] = 2;
            $_SESSION["grille"] = $grille;

            $game = new Game($pseudo);
            $this->gameDAO->insert($game);
            $this->vue->game();
        }
    }

}