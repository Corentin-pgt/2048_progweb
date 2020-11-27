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
            $req = $this->db->prepare("INSERT INTO PARTIES(idPlayer, state) VALUES (:idPLayer, :state)");
            $req->execute(array(
                "idPlayer" => $game->getUser()->getId(),
                "state" => 0
            ));
    }
}