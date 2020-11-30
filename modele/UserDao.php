<?php
require_once PATH_METIER . "/User.php";
require_once "BDException.php";
require_once "SqliteConnexion.php";

class UserDao
{

    // ajouter le(s) attribut(s)
    private $connexion;


    /** le constructeur de la classe
     */
    public function __construct()
    {
        $this->connexion = SqliteConnexion::getInstance()->getConnexion();
    }

    /**
     * méthode qui retourne un tableau de User avec le pseudo renseigné
     * @return tabeau de User avec le pseudo renseigné
     * @throws TableAccesException si la requête SQL pose problème
     */
    public function findAllByPseudo(): array
    {
        try {
            $statement = $this->connexion->query("SELECT pseudo from JOUEURS;");
            $users = $statement->fetchAll(PDO::FETCH_CLASS, 'User');
            return ($users);
        } catch (PDOException $e) {
            throw new SQLException("problème requête SQL sur la table utilisateurs");


        }
    }

    /**
     * méthode qui détermine si un utilisateur avec un certain pseudo est dans la table pseudonyme
     * @param $pseudo un pseudo
     * @return true si le pseudo passé en pramètre correspond à un utilisateur dans la table utilisateur, false sinon
     * @throws TableAccesException si la requête SQL pose problème
     */
    public function exists(string $pseudo): bool
    {
        try {
            $statement = $this->connexion->prepare("select pseudo from JOUEURS where pseudo=?;");
            $statement->bindParam(1, $pseudo);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result != null;
        } catch (PDOException $e) {
            throw new SQLException("problème requête SQL sur la table utilisateurs");

        }
    }

    public function verifierMdp(string $pseudo, string $pwd): bool
    {
        try {
            $statement = $this->connexion->prepare("select password from JOUEURS where pseudo=?;");
            $statement->bindParam(1, $pseudo);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return password_verify($pwd, $result["password"]);
        } catch (PDOException $e) {
            throw new SQLException("problème requête SQL sur la table utilisateurs");

        }
    }

    public function add(string $pseudo, string $pwd): void
    {
        $req = $this->connexion->prepare("INSERT INTO JOUEURS(pseudo, password) VALUES (:pseudo, :password)");
        $req->execute(array(
            "pseudo" => $pseudo,
            "password" => $pwd
        ));
    }
}

?>