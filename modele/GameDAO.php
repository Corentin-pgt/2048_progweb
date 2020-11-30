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
            "pseudo" => $game->getPseudo(),
            "gagne" => 0,
            "score" => 0
        ));
    }

    public function inGame()
    {
        $pseudo = $_SESSION["pseudo"];
        $statement = $this->db->prepare("select id from PARTIES where pseudo=?;");
        $statement->bindParam(1, $pseudo);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result != null ? $result["id"] : null;
    }

    public function getScore($id){
        $statement = $this->db->prepare("select score from PARTIES where id=?;");
        $statement->bindParam(1, $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["score"];
    }

    public function setScore($id, $score){
        $statement = $this->db->prepare("update PARTIES set score=? where id=?;");
        $statement->bindParam(1, $score);
        $statement->bindParam(2, $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["score"];
    }

}