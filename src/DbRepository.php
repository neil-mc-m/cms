<?php

namespace CMS;

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
     * PDO database connection object.
     * @var [type]
     */
    private $conn;
    /**
     * @param classname and tablename sent to the constructor as parameters
     */
    public function __construct(PDO $conn, $className, $tableName)
    {
        $this->conn = $conn;
        $this->className = __NAMESPACE__.'\\'.$className;
        $this->tableName = $tableName;
    }

    /**
     * @return an array of objects fetched into their classes.
     */
    public function getAll()
    {
        try {

            $stmt = $this->conn->prepare('SELECT * FROM '.$this->tableName);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $this->className);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getSingleRecord($page)
    {
        try {

            $stmt = $this->conn->prepare('SELECT * FROM '.$this->tableName.' WHERE pagename=:page');
            $stmt->bindParam(':page', $page);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);
            $stmt->execute();
            if ($result = $stmt->fetch()) {
                return $result;
            } else {
                return;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param an article id
     *
     * @return a bool for success/failure
     */
    public function showOne($contentid)
    {
        try {

            $stmt = $this->conn->prepare('SELECT * FROM content WHERE contentid =:contentid');
            $stmt->bindParam(':contentid', $contentid, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, __NAMESPACE__.'\\Content');
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
     * @param string $page a route
     *
     * @return twig template    a template for the route
     */
    public function getRoute($page)
    {
        try {

            $stmt = $this->conn->prepare('SELECT * FROM '.$this->tableName.' WHERE pagepath =:slug');
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
     * @param string $page a page
     *
     * @return twig template    template for the page.
     */
    public function getContent($page)
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $stmt = $conn->prepare('SELECT * FROM content WHERE pagename =:page');
            $stmt->bindParam(':page', $page, PDO::PARAM_STR, 5);
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

            $stmt = $this->conn->prepare('SELECT * FROM content');
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $this->className);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Creates a new web page fro m the parameters given.
     *
     * @param string $pageName     the pagename
     * @param string $pagePath     the page path/route
     * @param string $pageTemplate the page template
     *
     * @return twig template        the template for the page.
     */
    public function createPage($pageName, $pagePath, $pageTemplate)
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();

            $result = '';

            $stmtpage = $conn->prepare('INSERT IGNORE INTO page(pageid, pagename, pagepath, pagetemplate, created) VALUES (DEFAULT, :pagename, :pagepath, :pagetemplate, curdate())');
            $stmttemplate = $conn->prepare('INSERT IGNORE INTO templates(templateid, name, source, last_modified) VALUES (DEFAULT, :name, :source, curdate())');
            # a pdo transaction to execute two queries at the same time.
            # both have to execute without an error for each to work.
            # i.e if theres an error in the second statement, the first statement
            # wont execute either so its both or nothing.
            $conn->beginTransaction();
            $pageName = strtolower($pageName);
            $stmtpage->bindParam(':pagename', $pageName);
            $stmtpage->bindParam(':pagepath', $pagePath);
            $stmtpage->bindParam(':pagetemplate', $pageTemplate);
            $stmtpage->execute();

            $pageTemplate = $pageTemplate.'.html.twig';
            $templatecontent = "{% extends 'base.html.twig' %}{% block content %}{% endblock %}";
            $stmttemplate->bindParam(':name', $pageTemplate);
            $stmttemplate->bindParam(':source', $templatecontent);
            $stmttemplate->execute();

            if (!$conn->commit()) {
                $result .= 'We have a problem!';
            }

            return $result .= 'Well done! New Page created!';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove a page.
     *
     * Also removes a template from the database with the same page name.
     *
     * @param string $pageName the page to remove
     *
     * @return twig template
     */
    public function deletePage($pageName, $pageTemplate)
    {
        try {
            $stmtpage = $this->conn->prepare('DELETE FROM '.$this->tableName.' WHERE pagename =:pagename');
            $stmttemplate = $this->conn->prepare('DELETE FROM templates WHERE name =:pagetemplate');
            # begins a transaction for a multiple query
            $this->conn->beginTransaction();
            $stmtpage->bindParam(':pagename', $pageName);
            $stmtpage->execute();

            $pageTemplate = $pageTemplate.'.html.twig';
            $stmttemplate->bindParam(':pagetemplate', $pageTemplate);
            $stmttemplate->execute();
            $result = '';
            if (!$this->conn->commit()) {
                $result .= 'Heuston we have a problem!';
            }

            return $result .= 'well done. page deleted.';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createContent($pagename, $contenttype, $contentitemtitle, $contentitem)
    {
        try {
            $pdo = new DbManager();
            $conn = $pdo->getPdoInstance();
            $result = '';
            $stmt = $conn->prepare('INSERT INTO '.$this->tableName.'(contentid, pagename, contenttype, contentitemtitle, contentitem, created) VALUES (DEFAULT, :pagename, :contenttype, :contentitemtitle, :contentitem, curdate())');
            $stmt->bindParam(':pagename', $pagename);
            $stmt->bindParam(':contenttype', $contenttype);
            $stmt->bindParam(':contentitemtitle', $contentitemtitle);
            $stmt->bindParam(':contentitem', $contentitem);
            if (!$stmt->execute()) {
                $result .= 'Heuston we have a problem!';
            }
            return $result .= 'Nice. Some new content created';
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    public function deleteContent($id)
    {
        try {
            $stmt = $this->conn->prepare('DELETE FROM '.$this->tableName.' WHERE contentid=:id');
            $stmt->bindParam(':id', $id);
            if(!$stmt->execute()) {
                $result .= 'Heuston, we have a problem!';
            }
            return $result .= 'Well done, another post deleted!';
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
}
