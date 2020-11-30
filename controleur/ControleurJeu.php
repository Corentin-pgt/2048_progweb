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
            if (isset($_SESSION["direction"]) && !empty($_SESSION["direction"])) {
                $grille = $_SESSION["grille"];
                $l = 0;

                $direction = $_SESSION["direction"];
                switch ($direction) {
                    case "haut":
                        $k1 = $this->retasseHaut($grille);
                        $k2 = $this->additionneHaut($grille);
                        $k3 = $this->retasseHaut($grille);
                        $id = $this->gameDAO->inGame();
                        $this->gameDAO->setScore($id, ($this->gameDAO->getScore($id) + $k2));
                        $l = $k1 + $k2 + $k3;
                        break;
                    case "gauche":
                        $k1 = $this->retasseGauche($grille);
                        $k2 = $this->additionneGauche($grille);
                        $k3 = $this->retasseGauche($grille);
                        $id = $this->gameDAO->inGame();
                        $this->gameDAO->setScore($id, ($this->gameDAO->getScore($id) + $k2));
                        $l = $k1 + $k2 + $k3;
                        break;
                    case "bas":
                        $k1 = $this->retasseBas($grille);
                        $k2 = $this->additionnebas($grille);
                        $k3 = $this->retasseBas($grille);
                        $id = $this->gameDAO->inGame();
                        $this->gameDAO->setScore($id, ($this->gameDAO->getScore($id) + $k2));
                        $l = $k1 + $k2 + $k3;
                        break;
                    case "droite":
                        $k1 = $this->retasseDroite($grille);
                        $k2 = $this->additionneDroite($grille);
                        $k3 = $this->retasseDroite($grille);
                        $id = $this->gameDAO->inGame();
                        $this->gameDAO->setScore($id, ($this->gameDAO->getScore($id) + $k2));
                        $l = $k1 + $k2 + $k3;
                        break;
                }
                if ($l > 0) {
                    $dispo = null;
                    $cpt = 0;
                    for ($row = 0; $row < 4; $row++) {
                        for ($col = 0; $col < 4; $col++) {
                            if ($grille[$row][$col] == "") {
                                $dispo[$cpt][0] = $row;
                                $dispo[$cpt][1] = $col;
                                $cpt++;
                            }
                        }
                    }
                    if (sizeof($dispo) == 0) {
                        $this->vue->resultat();
                    }
                    try {
                        $row_random = random_int(0, sizeof($dispo));
                        $col_random = random_int(0, sizeof($dispo));
                        $value_random = random_int(1, 2);
                        $dispo[$row_random][$col_random] = $value_random * 2;
                    } catch (Exception $e) {}
                }
                $_SESSION = $grille;
                $this->vue->game();
            } else $this->vue->game();
        } else {
            $grille = array(
                array("", "", "", ""),
                array("", "", "", ""),
                array("", "", "", ""),
                array("", "", "", "")
            );
            try {
                $row_random1 = random_int(0, 3);
                $col_random1 = random_int(0, 3);
                $row_random2 = random_int(0, 3);
                $col_random2 = random_int(0, 3);
                $grille[$row_random1][$col_random1] = 2;
                $grille[$row_random2][$col_random2] = 2;
            } catch (Exception $e) {}
            $_SESSION["grille"] = $grille;

            $game = new Game($pseudo);
            $this->gameDAO->insert($game);
            $this->vue->game();
        }
    }

    private function retasseDroite($grille)
    {
        $l = 0;
        for ($i = 0; $i < 4; $i++) {
            $k = 3;
            for ($j = 3; $j >= 0; $j--)
                if ($grille[$i][$j] != 0) {
                    $grille[$i][$k] = $grille[$i][$j];
                    if ($k > $j) {
                        $grille[$i][$j] = 0;
                        $l = 1;
                    }
                    $k--;
                }
        }
        return $l;
    }

    private function retasseGauche($grille)
    {
        $l = 0;
        for ($i = 0; $i < 4; $i++) {
            $k = 0;
            for ($j = 0; $j < 4; $j++)
                if ($grille[$i][$j] != 0) {
                    $grille[$i][$k] = $grille[$i][$j];
                    if ($k < $j) {
                        $grille[$i][$j] = 0;
                        $l = 1;
                    }
                    $k++;
                }
        }
        return $l;
    }

    private function retasseHaut($grille)
    {
        $l = 0;
        for ($j = 0; $j < 4; $j++) {
            $k = 0;
            for ($i = 0; $i < 4; $i++)
                if ($grille[$i][$j] != 0) {
                    $grille[$k][$j] = $grille[$i][$j];
                    if ($k < $i) {
                        $grille[$i][$j] = 0;
                        $l = 1;
                    }
                    $k++;
                }
        }
        return $l;
    }

    private function retasseBas($grille)
    {
        $l = 0;
        for ($j = 0; $j < 4; $j++) {
            $k = 3;
            for ($i = 3; $i >= 0; $i--)
                if ($grille[$i][$j] != 0) {
                    $grille[$k][$j] = $grille[$i][$j];
                    if ($k > $i) {
                        $grille[$i][$j] = 0;
                        $l = 1;
                    }
                    $k--;
                }
        }
        return $l;
    }

    private function additionneDroite($grille)
    {
        $score = 0;
        for ($i = 0; $i < 4; $i++)
            for ($j = 4; $j > 0; $j--)
                if ($grille[$i][$j] == $grille[$i][$j - 1]) {
                    $grille[$i][$j] = $grille[$i][$j] + $grille[$i][$j - 1];
                    $score += $grille[$i][$j];
                    $grille[$i][$j - 1] = 0;
                }
        return $score;
    }

    private function additionneGauche($grille)
    {
        $score = 0;
        for ($i = 0; $i < 4; $i++)
            for ($j = 0; $j < 4; $j++)
                if ($grille[$i][$j] == $grille[$i][$j + 1]) {
                    $grille[$i][$j] = $grille[$i][$j] + $grille[$i][$j + 1];
                    $score += $grille[$i][$j];
                    $grille[$i][$j + 1] = 0;
                }
        return $score;
    }

    private function additionneHaut($grille)
    {
        $score = 0;
        for ($i = 0; $i < 4; $i++)
            for ($j = 0; $j < 4; $j++)
                if ($grille[$i][$j] == $grille[$i + 1][$j]) {
                    $grille[$i][$j] = $grille[$i][$j] + $grille[$i + 1][$j];
                    $score += $grille[$i][$j];
                    $grille[$i + 1][$j] = 0;
                }
        return $score;
    }

    private function additionnebas($grille)
    {
        $score = 0;
        for ($i = 3; $i > 0; $i--)
            for ($j = 0; $j < 4; $j++)
                if ($grille[$i][$j] == $grille[$i - 1][$j]) {
                    $grille[$i][$j] = $grille[$i][$j] + $grille[$i - 1][$j];
                    $score += $grille[$i][$j];
                    $grille[$i - 1][$j] = 0;
                }
        return $score;
    }

}