<?php 
namespace CMS\Controllers;
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


class SearchController
{
	public function searchAction(Request $request, Application $app, $q)
	{
		$db = new DbRepository($app['dbh'], 'Content', 'content');
		
		$value = $db->search($q);
		
		// the true flag will set the array to be associative
		$value = json_decode($value, true);
		for ($row = 0; $row < sizeof($value); $row++) {
			return "<a href=''>" . $value[$row][$row]['contentitemtitle'] . "</a>";
		}

	}
	
}
