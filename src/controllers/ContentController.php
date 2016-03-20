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

    public function createContentFormAction(Request $request, Application $app)
    {
        $user = $app['session']->get('user');
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
        );
        $templateName = 'admin/contentForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    public function processContentAction(Request $request, Application $app)
    {
        $user = $app['session']->get('user');
        $pagename = $app['request']->get('pagename');
        $contenttype = $app['request']->get('contenttype');
        $contentitemtitle = $app['request']->get('contentitemtitle');
        $contentitem = $app['request']->get('contentitem');
        $db = new DbRepository('Content', 'content');
        $app['monolog']->addInfo('You just connected to the database');
        # get all pages currently stored in the db.
        # Used for building the navbar and setting page titles.
        $result = $db->createContent($pagename, $contenttype, $contentitemtitle, $contentitem);


        return $app->redirect('/admin/dashboard');
    }
}
