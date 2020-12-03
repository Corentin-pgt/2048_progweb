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

    public function delete()
    {
        $req = $this->db->prepare("DELETE from PARTIES");
        //$req->bindParam(1, $pseudo);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        echo $result;
    }

    public function getLeaderboard()
    {
        $req = $this->db->query("select pseudo, score from PARTIES ORDER BY score DESC LIMIT 0,5");
        return $req->fetchAll();
    }

    public function getId(): int
    {
        $pseudo = $_SESSION["pseudo"];
        $statement = $this->db->prepare("select id from PARTIES where pseudo=? and gagne=0;");
        $statement->bindParam(1, $pseudo);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result != null ? $result["id"] : 0;
    }

    public function getScore($id): int
    {
        $statement = $this->db->prepare("select score from PARTIES where id=?;");
        $statement->bindParam(1, $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["score"];
    }

    public function setScore($id, $score)
    {
        $statement = $this->db->prepare("update PARTIES set score=? where id=?;");
        $statement->bindParam(1, $score);
        $statement->bindParam(2, $id);
        $statement->execute();
        //$result = $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getEtat($id): int
    {
        $statement = $this->db->prepare("select gagne from PARTIES where id=?;");
        $statement->bindParam(1, $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["gagne"];
    }

    public function setEtat($etat, $id)
    {
        $statement = $this->db->prepare("update PARTIES set gagne=? where id=?;");
        $statement->bindParam(1, $etat);
        $statement->bindParam(2, $id);
        $statement->execute();
        //$result = $statement->fetch(PDO::FETCH_ASSOC);
    }
}