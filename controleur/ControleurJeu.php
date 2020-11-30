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
        if ($this->gameDAO->inGame()) {
            $this->vue->game();
        } else {
            $game = new Game($pseudo);
            $this->gameDAO->insert($game);
            $this->vue->game();
        }
    }

}