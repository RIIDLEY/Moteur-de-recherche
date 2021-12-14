<?php

class Model
{


    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;


    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;


    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {

        try {
            include 'Utils/credentials.php';
            $this->bd = new PDO($dsn, $login, $mdp);
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->query("SET nameS 'utf8'");
        } catch (PDOException $e) {
            die('Echec connexion, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }


    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {

        if (is_null(self::$instance)) {
            self::$instance = new Model();
        }
        return self::$instance;
    }

    public function getNbDoc()
    {

        try {
            $req = $this->bd->prepare('SELECT COUNT(*) FROM document');
            $req->execute();
            $tab = $req->fetch(PDO::FETCH_NUM);
            return $tab[0];
        } catch (PDOException $e) {
            die('Echec getNbDoc, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }

    public function getDocument()
    {

        try {
            $requete = $this->bd->prepare('Select name from document');
            $requete->execute();
            return $requete->fetchall(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            die('Echec getDocument, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }


    public function addDoc($name)
    {

        try {
            //Préparation de la requête
            $requete = $this->bd->prepare('INSERT INTO document (name) VALUES (:name)');

            //Remplacement des marqueurs de place par les valeurs
            $requete->bindValue(':name', $name, PDO::PARAM_STR);

            //Exécution de la requête
            return $requete->execute();
        } catch (PDOException $e) {
            die('Echec addDoc, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }

    public function removeDoc($name)
    {
        $requete = $this->bd->prepare("DELETE FROM document WHERE name = :name");
        $requete->bindValue(':name', $name, PDO::PARAM_STR);
        return $requete->execute();
    }



    //------------------------------------------MOT-----------------------------------
    
    public function getNbMot()
    {

        try {
            $req = $this->bd->prepare('SELECT COUNT(*) FROM listemot');
            $req->execute();
            $tab = $req->fetch(PDO::FETCH_NUM);
            return $tab[0];
        } catch (PDOException $e) {
            die('Echec getNbMot, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }

    public function getMot($mot)
    {

        try {
            $requete = $this->bd->prepare('Select * from listemot WHERE Mot = :mot');
            $requete->bindValue(':mot', $mot);
            $requete->execute();
            return $requete->fetchall(PDO::FETCH_NUM);
        } catch (PDOException $e) {
            die('Echec getMot, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }

    public function addMot($infos)
    {

        try {
            //Préparation de la requête
            $requete = $this->bd->prepare('INSERT INTO listemot (Mot, Occurence, Document) VALUES (:Mot, :Occurence, :Document)');

            //Remplacement des marqueurs de place par les valeurs
            $marqueurs = ['Mot', 'Occurence', 'Document'];
            foreach ($marqueurs as $value) {
                $requete->bindValue(':' . $value, $infos[$value]);
            }

            //Exécution de la requête
            return $requete->execute();
        } catch (PDOException $e) {
            die('Echec addMot, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }

    public function removeMot($name)
    {
        $requete = $this->bd->prepare("DELETE FROM listemot WHERE Document = :name");
        $requete->bindValue(':name', $name, PDO::PARAM_STR);
        return $requete->execute();
    }


}
