<?php
require_once PATH_VUE . "/Vue.php";
require_once PATH_MODELE . "/UserDao.php";
require_once PATH_METIER . "/User.php";


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
        if ($userDAO->exists($pseudo, password_hash($pwd))) {
            $this->vue->play();
        } else $this->vue->demandePseudo();
    }

    function inscription(string $pseudo, string $pwd)
    {
        $userDAO = new UserDao();
        $userDAO->add($pseudo, password_hash($pwd));
    }


}