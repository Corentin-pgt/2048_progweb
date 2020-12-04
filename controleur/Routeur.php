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
        if (isset($_GET["deconnexion"]) && $_GET["deconnexion"] == true) {
            $this->ctrlAuthentification->deconnexion();
        } else if (isset($_GET["recommencer"]) && $_GET["recommencer"] == true) {
            $this->ctrlAuthentification->recommencer();
        } else if (isset($_SESSION["pseudo"])) {
            $this->ctrlJeu->play($_SESSION["pseudo"], (isset($_GET["direction"])) ? $_GET["direction"] : "rien");
        } else if (isset($_POST["connexion"], $_POST["pseudo"], $_POST["pwd"]) && !empty($_POST["pseudo"]) && !empty($_POST["pwd"])) {
            $this->ctrlAuthentification->connexion($_POST["pseudo"], $_POST["pwd"]);
        } else if (isset($_POST["inscription"], $_POST["pseudo"], $_POST["pwd"]) && !empty($_POST["pseudo"]) && !empty($_POST["pwd"])) {
            $this->ctrlAuthentification->inscription($_POST["pseudo"], $_POST["pwd"]);
        } else {
            $this->ctrlAuthentification->accueil();
        }
    }
}