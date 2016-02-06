<?php
namespace LightCMS;
use LightCMS\config;
class dbmodel
{
  public $pdo;

  public function __construct()
  {
    $this->pdo = new PDO(
      sprintf('mysql:host=%s;dbname=%s;port=%s;charset=%s',
        $settings['host'],
        $settings['name'],
        $settings['port'],
        $settings['charset']
      ),
      $settings['username'],
      $settings['password']
    );
  }

public function getCss($name)
{
  $sql = 'SELECT path FROM themes WHERE name = :name';
  try
  {
    $statement = $pdo->prepare($sql);
    $name = filter_input(INPUT_GET, 'name');
    $statement->bindValue(':name', $name);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $pe)
  {
     trigger_error('Could not connect to MySQL database. ' . $pe->getMessage() , E_USER_ERROR);
  }
  return $result;
}
