<?php
session_start();

require_once 'ControleurAuthentification.php';
require_once 'ControleurJeu.php';

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
        if (isset($_SESSION["idPlayer"])) {
            if (isset($_POST["connexion"])) {
                $this->ctrlAuthentification->connexion($_POST["pseudo"], $_POST["pwd"]);
            } else {
                $this->ctrlAuthentification->inscription($_POST["pseudo"], $_POST["pwd"]);
            }
        } else {
            $this->ctrlAuthentification->accueil();
        }
        /*
    if(isset($_POST["pseudo"], $_POST["pwd"]) && !empty($_POST["message"]) && !empty($_POST["pseudo"])){
        $this->ctrlAuthentification->connexion($_POST["pseudo"], $_POST["pwd"]);
    } else {
        $this->ctrlAuthentification->accueil();
    }
        */
    }
}