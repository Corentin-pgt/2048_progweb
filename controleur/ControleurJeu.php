<?php


class controleurJeu
{
    private $vue;

    function __construct()
    {
        $this->vue = new Vue();

    }

    function play(){
        $this->vue->jeu();
    }

    function createGame(User $user){
        $game = new Game($user);
    }

}