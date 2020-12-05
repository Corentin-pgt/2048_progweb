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

    function play(string $pseudo, string $direction)
    {
        $_SESSION["pseudo"] = $pseudo;
        $leaderboard = $this->gameDAO->getLeaderboard(10);
        $id = $this->gameDAO->getId($_SESSION["pseudo"]);
        $_SESSION["lostGames"] = $this->gameDAO->getLostGames($id);
        $_SESSION["wonGames"] = $this->gameDAO->getWinGames($id);
        if ($id == 0) {
            $grille = array(
                array(0, 0, 0, 0),
                array(0, 0, 0, 0),
                array(0, 0, 0, 0),
                array(0, 0, 0, 0)
            );
            try {
                $row_random1 = random_int(0, 3);
                $col_random1 = random_int(0, 3);
                do {
                    $row_random2 = random_int(0, 3);
                    $col_random2 = random_int(0, 3);
                } while ($row_random1 == $row_random2 && $col_random1 == $col_random2);
                $grille[$row_random1][$col_random1] = 2;
                $grille[$row_random2][$col_random2] = 2;
            } catch (Exception $e) {
            }
            $game = new Game($pseudo);
            $this->gameDAO->insert($game);

            $_SESSION["grille"] = $grille;
            $_SESSION["score"] = "0";
            $_SESSION["leaderboard"] = $leaderboard;
            $lost = null;
            $won = null;
            for ($cpt = 0; $cpt < sizeof($leaderboard); $cpt++) {
                $lost[$cpt] = $this->gameDAO->getLostGames($leaderboard[$cpt][0]);
                $won[$cpt] = $this->gameDAO->getWinGames($leaderboard[$cpt][0]);
                if ($this->gameDAO->getScore($this->gameDAO->getId($leaderboard[$cpt][0])) >= 2048) $won[$cpt]++;
            }
            $_SESSION["lostGamesOthers"] = $lost;
            $_SESSION["wonGamesOthers"] = $won;
            setcookie("grille", json_encode($_SESSION["grille"]), time() + 365 * 24 * 3600);
            setcookie("score", $_SESSION["score"], time() + 365 * 24 * 3600);
            setcookie("grille_precedente", json_encode($_SESSION["grille"]), time() + 365 * 24 * 3600);
            setcookie("score_precedent", $_SESSION["score"], time() + 365 * 24 * 3600);
            $this->vue->game();
        } else {
            $grille_precedente = json_decode($_COOKIE["grille_precedente"], true);
            $score_precedent = $_COOKIE["score_precedent"];
            if (!isset($_GET["precedent"]) || $_GET["precedent"] != true) {
                $_SESSION["grille"] = json_decode($_COOKIE["grille"], true);
                $_SESSION["score"] = $_COOKIE["score"];
                setcookie("grille_precedente", json_encode($_SESSION["grille"]), time() + 365 * 24 * 3600);
                setcookie("score_precedent", $_COOKIE["score"], time() + 365 * 24 * 3600);
                if ($direction == "rien") {
                    $this->vue->game();
                } else {
                    $l = 0;

                    switch ($direction) {
                        case "haut":
                            $k1 = $this->retasseHaut($_SESSION["grille"], 1);
                            $k2 = $this->additionneHaut($_SESSION["grille"], 1);
                            $k3 = $this->retasseHaut($_SESSION["grille"], 1);
                            $id = $this->gameDAO->getId($_SESSION["pseudo"]);
                            $this->gameDAO->setScore($id, ($this->gameDAO->getScore($id) + $k2));
                            $l = $k1 + $k2 + $k3;
                            break;
                        case "gauche":
                            $k1 = $this->retasseGauche($_SESSION["grille"], 1);
                            $k2 = $this->additionneGauche($_SESSION["grille"], 1);
                            $k3 = $this->retasseGauche($_SESSION["grille"], 1);
                            $id = $this->gameDAO->getId($_SESSION["pseudo"]);
                            $this->gameDAO->setScore($id, ($this->gameDAO->getScore($id) + $k2));
                            $l = $k1 + $k2 + $k3;
                            break;
                        case "bas":
                            $k1 = $this->retasseBas($_SESSION["grille"], 1);
                            $k2 = $this->additionnebas($_SESSION["grille"], 1);
                            $k3 = $this->retasseBas($_SESSION["grille"], 1);
                            $id = $this->gameDAO->getId($_SESSION["pseudo"]);
                            $this->gameDAO->setScore($id, ($this->gameDAO->getScore($id) + $k2));
                            $l = $k1 + $k2 + $k3;
                            break;
                        case "droite":
                            $k1 = $this->retasseDroite($_SESSION["grille"], 1);
                            $k2 = $this->additionneDroite($_SESSION["grille"], 1);
                            $k3 = $this->retasseDroite($_SESSION["grille"], 1);
                            $id = $this->gameDAO->getId($_SESSION["pseudo"]);
                            $this->gameDAO->setScore($id, ($this->gameDAO->getScore($id) + $k2));
                            $l = $k1 + $k2 + $k3;
                            break;
                    }
                    $dispo = null;
                    if ($l > 0) {
                        $cpt = 0;
                        for ($row = 0; $row < 4; $row++) {
                            for ($col = 0; $col < 4; $col++) {
                                if ($_SESSION["grille"][$row][$col] == 0) {
                                    $dispo[$cpt][0] = $row;
                                    $dispo[$cpt][1] = $col;
                                    $cpt++;
                                }
                            }
                        }
                        try {
                            $cell_random = random_int(0, sizeof($dispo) - 1);
                            $value_random = random_int(1, 2);
                            $_SESSION["grille"][$dispo[$cell_random][0]][$dispo[$cell_random][1]] = $value_random * 2;
                        } catch (Exception $e) {
                        }
                        if (sizeof($dispo) - 1 == 0) {

                            $h1 = $this->retasseHaut($_SESSION["grille"], 0);
                            $h2 = $this->additionneHaut($_SESSION["grille"], 0);
                            $h3 = $this->retasseHaut($_SESSION["grille"], 0);
                            $g1 = $this->retasseGauche($_SESSION["grille"], 0);
                            $g2 = $this->additionneGauche($_SESSION["grille"], 0);
                            $g3 = $this->retasseGauche($_SESSION["grille"], 0);
                            $b1 = $this->retasseBas($_SESSION["grille"], 0);
                            $b2 = $this->additionnebas($_SESSION["grille"], 0);
                            $b3 = $this->retasseBas($_SESSION["grille"], 0);
                            $d1 = $this->retasseDroite($_SESSION["grille"], 0);
                            $d2 = $this->additionneDroite($_SESSION["grille"], 0);
                            $d3 = $this->retasseDroite($_SESSION["grille"], 0);
                            if ($h1 + $h2 + $h3 + $g1 + $g2 + $g3 + $b1 + $b2 + $b3 + $d1 + $d2 + $d3 == 0) {
                                $_SESSION["leaderboard"] = $this->gameDAO->getLeaderboard(20);
                                $this->gameDAO->getScore($id) < "2048" ? $this->gameDAO->setEtat(1, $id) : $this->gameDAO->setEtat(2, $id);
                                $this->vue->resultat();
                            }
                        }
                    } else {
                        setcookie("grille_precedente", json_encode($grille_precedente), time() + 365 * 24 * 3600);
                        setcookie("score_precedent", $score_precedent, time() + 365 * 24 * 3600);
                    }
                    setcookie("grille", json_encode($_SESSION["grille"]), time() + 365 * 24 * 3600);
                    $score = $this->gameDAO->getScore($this->gameDAO->getId($_SESSION["pseudo"]));
                    $_SESSION["score"] = $score;
                    $leaderboard = $this->gameDAO->getLeaderboard(10);
                    $lost = null;
                    $won = null;
                    for ($cpt = 0; $cpt < sizeof($leaderboard); $cpt++) {
                        $lost[$cpt] = $this->gameDAO->getLostGames($leaderboard[$cpt][0]);
                        $won[$cpt] = $this->gameDAO->getWinGames($leaderboard[$cpt][0]);
                        if ($this->gameDAO->getScore($this->gameDAO->getId($leaderboard[$cpt][0])) >= 2048) $won[$cpt]++;
                    }
                    $_SESSION["leaderboard"] = $leaderboard;
                    $_SESSION["lostGamesOthers"] = $lost;
                    $_SESSION["wonGamesOthers"] = $won;
                    setcookie("score", $_SESSION["score"], time() + 365 * 24 * 3600);
                    $this->vue->game();
                }
            } else {
                $_SESSION["grille"] = $grille_precedente;
                $_SESSION["score"] = $score_precedent;
                $this->gameDAO->setScore($id, $score_precedent);
                $leaderboard = $this->gameDAO->getLeaderboard(10);
                $_SESSION["leaderboard"] = $leaderboard;
                setcookie("grille", json_encode($grille_precedente), time() + 365 * 24 * 3600);
                setcookie("score", $score_precedent, time() + 365 * 24 * 3600);
                setcookie("grille_precedente", json_encode($grille_precedente), time() + 365 * 24 * 3600);
                setcookie("score_precedent", $score_precedent, time() + 365 * 24 * 3600);
                $this->vue->game();
            }
        }
    }

    private function retasseDroite($grille, $retour)
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
        if ($retour == 1) {
            $_SESSION["grille"] = $grille;
        }
        return $l;
    }

    private function retasseGauche($grille, $retour)
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
        if ($retour == 1) {
            $_SESSION["grille"] = $grille;
        }
        return $l;
    }

    private function retasseHaut($grille, $retour)
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
        if ($retour == 1) {
            $_SESSION["grille"] = $grille;
        }
        return $l;
    }

    private function retasseBas($grille, $retour)
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
        if ($retour == 1) {
            $_SESSION["grille"] = $grille;
        }
        return $l;
    }

    private function additionneDroite($grille, $retour)
    {
        $score = 0;
        for ($i = 0; $i < 4; $i++) {
            for ($j = 3; $j > 0; $j--) {
                if ($grille[$i][$j] == $grille[$i][$j - 1]) {
                    $grille[$i][$j] = $grille[$i][$j] + $grille[$i][$j - 1];
                    $score += $grille[$i][$j];
                    $grille[$i][$j - 1] = 0;
                }
            }
        }
        if ($retour == 1) {
            $_SESSION["grille"] = $grille;
        }
        return $score;
    }

    private function additionneGauche($grille, $retour)
    {
        $score = 0;
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($grille[$i][$j] == $grille[$i][$j + 1]) {
                    $grille[$i][$j] = $grille[$i][$j] + $grille[$i][$j + 1];
                    $score += $grille[$i][$j];
                    $grille[$i][$j + 1] = 0;
                }
            }
        }
        if ($retour == 1) {
            $_SESSION["grille"] = $grille;
        }
        return $score;
    }

    private function additionneHaut($grille, $retour)
    {
        $score = 0;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 4; $j++) {
                if ($grille[$i][$j] == $grille[$i + 1][$j]) {
                    $grille[$i][$j] = $grille[$i][$j] + $grille[$i + 1][$j];
                    $score += $grille[$i][$j];
                    $grille[$i + 1][$j] = 0;
                }
            }
        }
        if ($retour == 1) {
            $_SESSION["grille"] = $grille;
        }
        return $score;
    }

    private function additionnebas($grille, $retour)
    {
        $score = 0;
        for ($i = 3; $i > 0; $i--) {
            for ($j = 0; $j < 4; $j++) {
                if ($grille[$i][$j] == $grille[$i - 1][$j]) {
                    $grille[$i][$j] = $grille[$i][$j] + $grille[$i - 1][$j];
                    $score += $grille[$i][$j];
                    $grille[$i - 1][$j] = 0;
                }
            }
        }
        if ($retour == 1) {
            $_SESSION["grille"] = $grille;
        }
        return $score;
    }

}