<?php

namespace LightCMS;

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
        $this->className = __NAMESPACE__.'\\'.$className;
        $this->tableName = $tableName;
    }

    /**
     * @return an array of objects fetched into their classes.
     */
    public function showAll()
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();

            $stmt = $conn->prepare('SELECT * FROM '.$this->tableName);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $this->className);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param an article id
     *
     * @return a bool for success/failure
     */
    public function showOne($id)
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

    /**
     * get a route corresponding to the page variable.
     *
     * @param  string $page     a route
     * @return twig template    a template for the route
     */
    public function getRoute($page)
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $stmt = $conn->prepare('SELECT * FROM '.$this->tableName.' WHERE pagepath =:slug');
            $stmt->bindParam(':slug', $slug, PDO::PARAM_STR, 5);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $this->className);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllContent()
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();


            $stmt = $conn->prepare('SELECT page.pagename,content.contentitemtitle FROM page LEFT JOIN content ON page.pagename=content.pagename');

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /**
     * gets a pages content.
     *
     * @param  string $page     a page
     * @return twig template    template for the page.
     */
    public function getContent($page)
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $ucpage = ucfirst($page);
            var_dump($ucpage);
            $stmt = $conn->prepare('SELECT * FROM content WHERE pagename =:page');
            $stmt->bindParam(':page', $ucpage, PDO::PARAM_STR, 5);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllPagesContent()
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $stmt = $conn->prepare('SELECT * FROM content');
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    /**
     * Creates a new web page fro m the parameters given.
     *
     * @param  string $pageName     the pagename
     * @param  string $pagePath     the page path/route
     * @param  string $pageTemplate the page template
     * @return twig template        the template for the page.
     */
    public function createPage($pageName, $pagePath, $pageTemplate)
    {
        try{
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $page = ucfirst($pageName);
            $result = '';
            $stmt = $conn->prepare('INSERT IGNORE INTO page(pageid, pagename, pagepath, pagetemplate) VALUES (DEFAULT, :pagename, :pagepath, :pagetemplate)');
            $stmt->bindParam(':pagename', $pageName);
            $stmt->bindParam(':pagepath', $pagePath);
            $stmt->bindParam(':pagetemplate', $pageTemplate);
            if (!$stmt->execute()){
                $result .= 'oopss!';
            }
            return $result .= 'well done';
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    /**
     * Remove a page
     *
     * @param  string $pageName the page to remove
     * @return twig template
     */
    public function deletePage($pageName)
    {
        try{
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $page = ucfirst($pageName);
            $result = '';
            $stmt = $conn->prepare('DELETE FROM '.$this->tableName.' WHERE pagename =:pagename');
            $stmt->bindParam(':pagename', $pageName);

            if (!$stmt->execute()){
                $result .= 'oopss!';
            }
            return $result .= 'well done. page deleted.';
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
}
