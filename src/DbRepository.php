<?php
namespace LightCMS;

use LightCMS\DbManager;
use PDO;
/**
 * A data access class.
 *
 * All data access for tables.
 */
class DbRepository
{
    /**
     * @var classname
     */
    private $classname;

    /**
     * @var tablename
     */
    private $tablename;

    /**
     * @param classname and tablename sent to the constructor as parameters
     */
    public function __construct($className, $tableName)
    {
        $this->className = $className;
        $this->tableName = $tableName;
    }

    /**
    * @return an array of objects fetched into their classes.
    *
    */
    public function showAllArticles()
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $stmt = $conn->prepare('SELECT * FROM '.$this->tableName);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
    * @param an article id
    * @return a bool for success/failure
    */
    public function showOneArticle($id)
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $stmt = $conn->prepare('SELECT * FROM '.$this->tableName.' WHERE id =:id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);
            $stmt->execute();
            if ($result = $stmt->fetch()) {
                return $result;
            } else {
                return;
            }

        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }
}
