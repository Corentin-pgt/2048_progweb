<?php


class GameDAO
{
    private $db;

    public function __construct()
    {
        $this->db = SqliteConnexion::getInstance()->getConnexion();
    }

    public function insert(Game $game)
    {
        $req = $this->db->prepare("INSERT INTO PARTIES(pseudo, gagne, score) VALUES (:pseudo, :gagne, :score)");
        $req->execute(array(
            "pseudo" => $game->getUser()->getId(),
            "gagne" => 0,
            "score" => 0
        ));
    }
}