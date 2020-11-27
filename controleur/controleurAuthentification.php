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

    function connexion(string $pseudo)
    {/*
        $userDAO = new UserDao();
        $chatitemDAO = new ChatItemDao();
        if ($userDAO->exists($pseudo)) {
            $this->vue->salon($chatitemDAO->findMessages(10), $pseudo);
        } else $this->vue->demandePseudo();*/
    }


}