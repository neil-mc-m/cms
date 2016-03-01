<?php

namespace LightCMS;

use PDO;

/**
 * database connection manager.
 *
 * @Class dbmodel
 */
class DbManager
{
    /**
    * @var an instance of th pdo connection
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
            $config = parse_ini_file('../config/config.ini');
            $this->pdo = new PDO(sprintf('%s:host=%s;dbname=%s;port=%s',
         $config['driver'],
         $config['host'],
         $config['dbname'],
         $config['port']),
        $config['username'],
        $config['password']);
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
