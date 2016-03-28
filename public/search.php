
<?php 

// the search script called by the AJAX function for the live search feature
// gets the value being typed into the search box,
// passes it to a model function,
// recieves the result as an array of JSON objects
// and decodes it to a php nested associative array.
// Might be a more direct way?
use CMS\DbManager;
use CMS\DbRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Tests\A;
require_once __DIR__ . '../../vendor/autoload.php';
$db = new DbRepository($app['dbh'], 'Content', 'content');
$q = $_GET['q'];
$value = $db->search($q);
var_dump($value);
// the true flag will set the array to be associative
$value = json_decode($value, true);
for ($row = 0; $row < sizeof($value); $row++) {
    $id = $value[$row]["id"];
    echo "<a href='#'>" . $value[$row]['name'] . "</a>";
}