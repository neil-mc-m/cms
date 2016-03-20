<?php

namespace LightCMS\controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use LightCMS\DbRepository;

class ContentController
{
    public function contentAction(Request $request, Application $app)
    {
        $user = $app['session']->get('user');
        $db = new DbRepository('Page', 'page');
        $app['monolog']->addInfo('You just connected to the database');
        # get all pages currently stored in the db.
        # Used for building the navbar and setting page titles.
        $pages = $db->showAll();
        $content = $db->getAllPagesContent();

        $args_array = array(
            'content' => $content,
            'pages' => $pages,
            'user' => $user,
            'id' => session_id(),

        );
        $templateName = 'admin/content';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
