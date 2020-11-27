<?php
require_once PATH_VUE . "/vue.php";
require_once PATH_MODELE . "/UserDao.php";
require_once PATH_MODELE . "/ChatItemDao.php";


class ControleurAuthentification
{

    private $vue;


    function __construct()
    {
        $this->vue = new Vue();

    }

    function accueil()
    {
        $this->vue->demandePseudo();
    }

    function connexion(string $pseudo, string $pwd)
    {
        $userDAO = new UserDao();
        if ($userDAO->exists($pseudo)) {
            //TODO
        } else $this->vue->demandePseudo();
    }


}