<?php

namespace CMS;

use PDO;

/**
 * database connection manager.
 *
 * @Class DbManager
 */
class DbManager
{
    /**
     * @var an instance of the pdo connection
     */
    private $pdo;

    /**
     * constructor which connects to the database each time the DbManager
     * object is created.
     *
     * @construct
     */
    public function __construct()
    {
        try {
            $config = parse_ini_file('../config/config.ini', true);
            $this->pdo = new PDO(sprintf('%s:host=%s;dbname=%s;port=%s',
         $config['database']['driver'],
         $config['database']['host'],
         $config['database']['dbname'],
         $config['database']['port']),
        $config['database']['username'],
        $config['database']['password']);
      # print 'connected to database<br/>';
      $this->pdo->setAttribute(
               PDO::ATTR_ERRMODE,
               PDO::ERRMODE_EXCEPTION
           );
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * @return an instance of the pdo connection
     */
    public function getPdoInstance()
    {
        return $this->pdo;
    }
}
