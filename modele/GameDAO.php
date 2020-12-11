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

    public function getLeaderboard($number)
    {
        $req = $this->db->prepare("select pseudo, max(score) as bestScore from PARTIES GROUP BY pseudo ORDER BY bestScore DESC LIMIT 0,?");
        $req->bindParam(1, $number);
        $req->execute();
        return $req->fetchAll();
    }

    public function getBestScore($pseudo)
    {
        $req = $this->db->prepare("select max(score) from PARTIES where pseudo=?");
        $req->bindParam(1, $pseudo);
        $req->execute();
        $result = $req->fetch();
        return $result != null ? $result[0] : 0;
    }

    public function getId($pseudo): int
    {
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
        return $result != null ? $result["score"] : 0;
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
    }

    public function getLostGames($pseudo){
        $statement = $this->db->prepare("select count(*) from PARTIES where pseudo=? and gagne=1");
        $statement->bindParam(1, $pseudo);
        $statement->execute();
        $result = $statement->fetch();
        return $result[0];
    }

    public function getWinGames($pseudo){
        $statement = $this->db->prepare("select count(*) from PARTIES where pseudo=? and gagne=2");
        $statement->bindParam(1, $pseudo);
        $statement->execute();
        $result = $statement->fetch();
        return $result[0];
    }
}