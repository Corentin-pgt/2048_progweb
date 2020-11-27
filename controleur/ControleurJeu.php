<?php


class controleurJeu
{
    private $vue;
    private $gameDAO;

    function __construct()
    {
        $this->vue = new Vue();
        $this->gameDAO = new GameDAO();
    }

    function play()
    {
        $this->vue->game();
    }

    function createGame(User $user)
    {
        $game = new Game($user);
        $this->gameDAO->insert($game);
        $this->vue->game();
    }

}