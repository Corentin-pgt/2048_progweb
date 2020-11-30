<?php
require_once 'ControleurAuthentification.php';
require_once 'ControleurJeu.php';
session_start();

class Routeur
{
    private $ctrlAuthentification;
    private $ctrlJeu;

    public function __construct()
    {
        $this->ctrlAuthentification = new ControleurAuthentification();
        $this->ctrlJeu = new controleurJeu();
    }

    public function routerRequete()
    {
        if (isset($_SESSION["pseudo"])) {
            $this->ctrlJeu->play($_SESSION["pseudo"]);
        } else if (isset($_POST["connexion"], $_POST["pseudo"], $_POST["pwd"]) && !empty($_POST["pseudo"]) && !empty($_POST["pwd"])) {
            $this->ctrlAuthentification->connexion($_POST["pseudo"], $_POST["pwd"]);
        } else if (isset($_POST["inscription"], $_POST["pseudo"], $_POST["pwd"]) && !empty($_POST["pseudo"]) && !empty($_POST["pwd"])) {
            $this->ctrlAuthentification->inscription($_POST["pseudo"], $_POST["pwd"]);
        } else {
            $this->ctrlAuthentification->accueil();
        }
    }
}