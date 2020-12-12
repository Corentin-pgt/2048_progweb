<?php
require_once PATH_VUE . "/Vue.php";
require_once PATH_MODELE . "/UserDao.php";
require_once PATH_MODELE . "/GameDAO.php";
require_once PATH_METIER . "/User.php";
require_once PATH_CONTROLEUR . "/ControleurJeu.php";

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
        //joueur authentifié
        if ($userDAO->exists($pseudo) && $userDAO->verifierMdp($pseudo, $pwd)) {
            $ctrlJeu = new ControleurJeu();
            $ctrlJeu->play($pseudo, "rien");
        }
        //joueur non authentifié
        else $this->vue->demandePseudo();
    }

    function inscription(string $pseudo, string $pwd)
    {
        $userDAO = new UserDao();
        //le joueur peut s'inscrire
        if (!$userDAO->exists($pseudo)) {
            $userDAO->add($pseudo, password_hash($pwd, PASSWORD_DEFAULT));
            $ctrlJeu = new ControleurJeu();
            $ctrlJeu->play($pseudo, "rien");
        }
        //le joueur existe déjà
        else $this->vue->demandePseudo();
    }

    function deconnexion()
    {
        session_destroy();
        header("Location: index.php");
    }

    function recommencer()
    {
        $gameDAO = new GameDAO();
        $id = $gameDAO->getId($_SESSION["pseudo"]);
        //On change l'attribue "gagne" à 1 si la partie est perdue, 2 si elle est gagnée
        $gameDAO->getScore($id) < "2048" ? $gameDAO->setEtat(1, $id) : $gameDAO->setEtat(2, $id);
        $this->vue->resultat();
    }
}