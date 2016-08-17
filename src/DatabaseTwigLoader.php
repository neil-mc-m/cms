<?php

namespace CMS;

use Twig_LoaderInterface;
use Twig_ExistsLoaderInterface;
use Twig_Error_Loader;
use PDO;
use Doctrine\Dbal\Connection;

/**
 * A twig loader class to load templates from the database.
 */
class DatabaseTwigLoader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{
    /**
     * The PDO database connection.
     *
     * @var PDO connection instance.
     */
    protected $conn;

    /**
     * construct the class with the database connection.
     *
     * @param PDO $dbh .PDO connection.
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getSource($name)
    {
        if (false === $source = $this->getValue('source', $name)) {
            throw new Twig_Error_Loader(sprintf('Template "%s" does not exist.', $name));
        }

        return $source;
    }

    // Twig_ExistsLoaderInterface as of Twig 1.11
    public function exists($name)
    {
        return $name === $this->getValue('name', $name);
    }

    public function getCacheKey($name)
    {
        return $name;
    }

    public function isFresh($name, $time)
    {
        if (false === $lastModified = $this->getValue('last_modified', $name)) {
            return false;
        }

        return $lastModified <= $time;
    }

    protected function getValue($column, $name)
    {
        $sth = $this->conn->prepare('SELECT '.$column.' FROM templates WHERE name = :name');
        $sth->execute(array(':name' => $name));

        return $sth->fetchColumn();
    }
}
