<?php

namespace CMS\Controllers;

use CMS\DbRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * The search controller for the livesearch feature.
 * 
 * @Class SearchController
 */
class SearchController
{
    public function searchAction(Request $request, Application $app, $q)
    {
        // the search script called by the AJAX function for the live search feature
        // gets the value being typed into the search box,
        // passes it to a model function,
        // recieves the result as an array of JSON objects
        // and decodes it to a php nested associative array.

        $db = new DbRepository($app['dbh']);

        $value = $db->search($q);

        // the true flag will set the array to be associative
        $value = json_decode($value, true);

        for ($row = 0; $row < sizeof($value); ++$row) {
            $contentId = $value[$row][$row]['contentId'];

            return "<a class='alt-link' href='/admin/view-single-content/{$contentId}'>".$value[$row][$row]['contentItemTitle'].'</a>';
        }
    }
}
