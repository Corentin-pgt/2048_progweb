<?php

require_once 'controleurAuthentification.php';

class routeur
{
    private $ctrlAuthentification;

    public function __construct()
    {
        $this->ctrlAuthentification = new ControleurAuthentification();
    }

    public function routerRequete()
    {

    }
}