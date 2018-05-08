<?php

namespace App;

use App\Utils\Date as Date;

/**
 * Classe d'accès aux données
 */
class Database {

    private static $dbh; // Objet dbh
    private $_host = 'localhost';
    private $_database = 'mdl';
    private $_user = 'root';
    private $_password = '';
    private $_port = 3306;
    private static $instance;

    /**
     * Constructeur avec la création de l'instance de base de données
     */
    private function __construct() {
        $user = $this->_user;
        $password = $this->_password;
        $options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
        $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";

        $dsn = 'mysql:host=' . $this->_host .
                ';dbname=' . $this->_database;
        // Au besoin :
        //';port='      . $this->_port .
        //';connect_timeout=15';
        // Création du pdo
        try {
            Database::$dbh = new \PDO($dsn, $user, $password, $options);
            Database::$dbh->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception('Impossible de se connecter à la base de données');
        }
    }

    /**
     * Méthode statique de récupération de l'instance
     * 
     * @return PDO Instance de base de données
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    /**
     * Retourne les ateliers
     * 
     * @return On retourne l'id, le libellé et le nombre de places maxi de chaque atelier sous la forme d'un tableau associatif
     */
    public function getAteliers() {
        $requetePrepare = Database::$dbh->query(
                'SELECT * FROM atelier'
        );
        return $requetePrepare->fetchAll();
    }

    /**
     * Retourne les types d'avis
     *
     * @return On retourne l'id, la désignation de chaque ttype d'avis sous la forme d'un tableau associatif
     */
    public function getTypesAvis() {
        $requetePrepare = Database::$dbh->query(
                'SELECT * FROM typeavis'
        );
        return $requetePrepare->fetchAll();
    }

    /**
     * Ajoute un avis à un atelier
     *
     * @param int $atelier Identifiant de l'atelier
     * @param string $type Type d'avis à ajouter
     * @return bool Requête executée ou non
     */
    public function ajoutAvis($atelier, $type) {
        $requetePrepare = Database::$dbh->prepare(
                'INSERT INTO avis(atelier, type) VALUES(:atelier, :type)'
        );
        return $requetePrepare->execute(compact('type', 'atelier'));
    }

    /**
     * Retourne les résultats des ateliers
     *
     * @param int $atelier Identifiant de l'atelier
     * @return On retourne le nombre d'avis' pour chaque types d'avis d'un atelier
     */
    public function resultatsAtelier($atelier) {
        $requetePrepare = Database::$dbh->prepare(
                'SELECT libelle, (SELECT COUNT(*) FROM avis WHERE atelier = :atelier AND type = typeavis.id) as total 
                 FROM typeavis ORDER BY typeavis.id DESC'
        );
        $requetePrepare->execute(compact('atelier'));
        return $requetePrepare->fetchAll();
    }

    /**
     * Retourne le nombre d'avis ajoutés à un atelier 
     *
     * @param int $atelier Identifiant de l'atelier
     * @return On retourne le nombre d'avis enregistrés
     */
    public function nbAvisAtelier($atelier) {
        $requetePrepare = Database::$dbh->prepare(
                'SELECT COUNT(*) as nombre FROM avis WHERE atelier = :atelier'
        );
        $requetePrepare->execute(compact('atelier'));
        return $requetePrepare->fetch();
    }
}
